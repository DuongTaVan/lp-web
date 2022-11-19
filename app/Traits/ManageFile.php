<?php

namespace App\Traits;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Models\Course;
use App\Models\CourseSchedule;
use Illuminate\Support\Facades\Storage;
use Log;
use Image;

trait ManageFile
{
    /**
     * Get file's signed URL from amazon s3
     *
     * @param mixed $path
     * @param mixed $defaultImage
     * @return string
     */
    public function getS3FileUrl($path, $defaultImage = null)
    {
        return config('filesystems.disks.s3.url') . '/' . $path;
//        try {
//            $disk = Storage::disk(config('filesystems.default'));
//            if ($disk->exists($path)) {
//                // public s3 image
//                return config('filesystems.disks.s3.url') . '/' . $path;
////                $s3Client = $disk->getDriver()->getAdapter()->getClient();
////                $expiry = '+' . config('filesystems.disks.s3.expiry') . ' minutes';
////
////                $command = $s3Client->getCommand(
////                    'GetObject',
////                    [
////                        'Bucket' => config('filesystems.disks.s3.bucket'),
////                        'Key' => $path,
////                        'ResponseContentDisposition' => 'attachment;',
////                    ]
////                );
////                $request = $s3Client->createPresignedRequest($command, $expiry);
////                return (string)$request->getUri();
//            }
//            return $defaultImage;
//        } catch (S3Exception $e) {
////            Log::error($e->getMessage() . $e->getTraceAsString());
//            return $defaultImage;
//        }
    }

    /**
     * @param $file
     * @param $path
     * @param null $data
     * @param bool $thumbnail
     * @param bool $extensionBase64
     * @return string[]
     */
    public function uploadFileToS3($file, $path, $data = null, $thumbnail = false, $extensionBase64 = false)
    {
        if ($file) {
            if ($extensionBase64) {
                $extension = $extensionBase64;
            } else {
                $extension = $file->getClientOriginalExtension('file_url');
            }
            $key = $data['key'] ?? null;

//            $fileName = str_pad((string)$data['id'], 11, '0', STR_PAD_LEFT) . rand() . $key . '.' . $extension;
            $fileName = time() . $file->getClientOriginalName();
            $urlPath = rtrim($path, "/") . '/' . $fileName;

            Storage::disk(config('filesystems.default'))->putFileAs($path, $file, $fileName);

            if ($thumbnail) {
                $thumbnailImage = Image::make($file);
                $resize = explode(",", Constant::IMAGE_OPTION_SCREEN['thumbnail']);
                $thumbnailImage->resize($resize[0], $resize[1], function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $thumbnailImage->stream();


                $nameExt = explode(".", $fileName);
                if (isset($nameExt[0])) {
                    Storage::disk(config('filesystems.default'))->put('thumbnails/' . rtrim($path, "/") . '/' . $nameExt[0] . '.jpg', $thumbnailImage);
                }
            }
            return [
                'urlPath' => $urlPath,
                'fileName' => $fileName
            ];
        }
    }

    /**
     * @param $path
     * @param $fileName
     * @return bool[]|false[]
     */
    public function removeFileFromS3($path, $fileName)
    {
        try {
            if (Storage::disk(config('filesystems.default'))->exists($path . $fileName)) {
                Storage::disk(config('filesystems.default'))->delete($path . $fileName);
            }
            return [
                'success' => true
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false
            ];
        }
    }

    public function makeSessionUpdateAccount($that, &$rules)
    {
        $userId = auth('client')->id();
        $previewFile = null;
        session()->forget('profile_image_' . $userId);
        if (isset($that->profile_image_old)) {
            $previewFile = json_decode($that->profile_image_old, true);
            $rules['profile_image'] = 'nullable';
        } else {
            $rules['profile_image'] = 'required';
            if (request()->file('profile_image')) {
                $previewFile = $this->saveTmpFile([request()->file('profile_image')])[0];
            }
        }

        if ($previewFile) {
            session()->put('profile_image_' . $userId, $previewFile);
        }
    }

    public function makeSessionIdentity($that, &$rules)
    {
        $userId = auth('client')->id();
        session()->forget('identity_image_' . $userId);
        if (isset($that->identity_image_old)) {
            $previewFile = json_decode($that->identity_image_old, true);
            $rules['file'] = 'nullable|mimetypes:image/png,image/jpg,image/jpeg,image/gif';
        } else {
            $rules['file'] = 'required|mimetypes:image/png,image/jpg,image/jpeg,image/gif';
            $previewFile = $this->saveTmpFile([request()->file('file')])[0];
        }

        if ($previewFile) {
            session()->put('identity_image_' . $userId, $previewFile);
        }
    }

    public function makeSessionPreviewFile($that, &$rules)
    {
        $previewFiles = [];
        $userId = auth('client')->id();
        session()->forget('preview_file_' . $userId);
        if (isset($that->previewOld)) {
            foreach ($that->previewOld as $item) {
                $previewFiles[] = json_decode($item, true);
            }
            $rules['preview'] = 'nullable|array';
        } else {
            $rules['preview'] = 'required|array';
        }
        if (isset($that->preview)) {
            $new = $this->saveTmpFile(request()->file('preview')) ?? [];
            $previewFiles = array_merge($previewFiles, $new);
        }
        if (count($previewFiles)) {
            session()->put('preview_file_' . $userId, $previewFiles);
        }
    }

    /**
     * Save temp file
     */
    public function saveTmpFile(array $files)
    {
        $filePaths = [];
        $tempPath = 'tmp/' . Auth('client')->id();
        foreach ($files as $key => $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $tempPath . "/$fileName";
            Storage::disk(config('filesystems.public'))->putFileAs(
                $tempPath,
                $file,
                $fileName
            );
            $filePaths[] = [
                'index' => $key,
                'path' => $filePath,
                'originalName' => $file->getClientOriginalName(),
                'fullPath' => $this->getFullPath($filePath)
            ];
        }

        return $filePaths;
    }

    /**
     * @return string
     */
    public function getFullPath($relativePath)
    {
        if (Storage::disk(config('filesystems.public'))->exists($relativePath)) {
            return Storage::disk(config('filesystems.public'))->url($relativePath);
        }

        return '';
    }

    public function uploadProfileImage($file, $path, $name)
    {
        $inputStream = Storage::disk(config('filesystems.public'))->path($file);
        $fileName = time() . $name;
        $urlPath = rtrim($path, "/") . '/' . $fileName;
        Storage::disk(config('filesystems.default'))->putFileAs($path, $inputStream, $fileName);

        return $urlPath;
    }

    public function uploadFilePublicToS3($file, $path, $data = null, $thumbnail = false)
    {
        $inputStream = Storage::disk(config('filesystems.public'))->path($file);
        $key = $data['key'] ?? null;
        $extension = pathinfo($file)['extension'];
        $fileName = str_pad((string)$data['id'], 11, '0', STR_PAD_LEFT) . time() . $key . '.' . $extension;
        $urlPath = rtrim($path, "/") . '/' . $fileName;
        Storage::disk(config('filesystems.default'))->putFileAs($path, $inputStream, $fileName);

        if ($thumbnail) {
            $thumbnailImage = Image::make($inputStream);
            $resize = explode(",", Constant::IMAGE_OPTION_SCREEN['thumbnail']);
            $thumbnailImage->resize($resize[0], $resize[1], function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $thumbnailImage->stream();


            $nameExt = explode(".", $fileName);
            if (isset($nameExt[0])) {
                Storage::disk(config('filesystems.default'))->put('thumbnails/' . rtrim($path, "/") . '/' . $nameExt[0] . '.jpg', $thumbnailImage);
            }
        }

        return [
            'urlPath' => $urlPath,
            'fileName' => $fileName
        ];
    }

    public function saveImage($request, $courseId)
    {
        $images = [];
        $uid = auth('client')->id();
        $i = 0;
        if ($request->previewOld) {
            $disk = Storage::disk(config('filesystems.public'));
            $diskS3 = Storage::disk(config('filesystems.cloud'));
            foreach ($request->previewOld as $item) {
                $image = json_decode($item, true);
                $dirPath = "courses/$courseId";
                if (isset($image['type']) && $image['type'] === 'FILE_OLD') {
                    $content = $diskS3->exists($image['path']);
                } else {
                    $content = $disk->exists($image['path']);
                }

                if ($content) {
                    if (isset($image['type']) && $image['type'] === 'FILE_OLD') {
                        $data = [
                            'fileName' => $image['originalName'],
                            'dir_path' => $image['dir_path'],
                            'urlPath' => $image['path'],
                        ];
                        $imageThumbnail = 'thumbnails/' . explode('.', $image['path'])[0] . '.jpg';
                        if ($i === 0 && !$diskS3->exists($imageThumbnail)) {
                            $thumbnailImage = Image::make($this->getS3FileUrl($image['path']));
                            $resize = explode(",", Constant::IMAGE_OPTION_SCREEN['thumbnail']);
                            $thumbnailImage->resize($resize[0], $resize[1], function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });

                            $thumbnailImage->stream();
                            $diskS3->put($imageThumbnail, $thumbnailImage);
                        }
                    } else {
                        $data = [
                            'id' => $courseId,
                            'key' => $i
                        ];
                        $data = $this->uploadFilePublicToS3($image['path'], $dirPath, $data, $i === 0);
                    }

                    $images[] = [
                        'type' => DBConstant::IMAGE_PATH_TYPE['course'],
                        'user_id' => $uid,
                        'course_id' => $courseId,
                        'status' => DBConstant::IMAGE_PATH_STATUS['approved'],
                        'file_name' => $data['fileName'],
                        'dir_path' => $data['dir_path'] ?? $dirPath,
                        'image_url' => $data['urlPath'],
                        'display_order' => $i + 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];

                    $i++;
                }
            }

            // clear data temp
            $disk->deleteDirectory('tmp/' . $uid);
            session()->forget('preview_file_' . $uid);
        }
        if ($request->file('preview')) {
            foreach ($request->file('preview') as $key => $image) {
                $dirPath = "courses/$courseId";
                $data = [
                    'id' => $courseId,
                    'key' => $i,
                ];

                $data = $this->uploadFileToS3($image, $dirPath, $data, $i === 0);
                $images[] = [
                    'type' => DBConstant::IMAGE_PATH_TYPE['course'],
                    'user_id' => $uid,
                    'course_id' => $courseId,
                    'status' => DBConstant::IMAGE_PATH_STATUS['approved'],
                    'file_name' => $data['fileName'],
                    'dir_path' => $dirPath,
                    'image_url' => $data['urlPath'],
                    'display_order' => $i + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $i++;
            }
        }

        $this->imagePathRepository->where('course_id', $courseId)->delete();

        $this->imagePathRepository->insert($images);
    }

    public function saveImageSchedule($request, int $courseScheduleId)
    {
        $images = [];
        $uid = auth('client')->id();
        $i = 0;
        if ($request->previewOld) {
            $disk = Storage::disk(config('filesystems.public'));
            $diskS3 = Storage::disk(config('filesystems.cloud'));
            foreach ($request->previewOld as $item) {
                $image = json_decode($item, true);
                $dirPath = "course_schedules/$courseScheduleId";
                if (isset($image['type']) && $image['type'] === 'FILE_OLD') {
                    $content = $diskS3->exists($image['path']);
                } else {
                    $content = $disk->exists($image['path']);
                }
                if ($content) {
                    if (isset($image['type']) && $image['type'] === 'FILE_OLD') {
                        $data = [
                            'fileName' => $image['originalName'],
                            'dir_path' => $image['dir_path'],
                            'urlPath' => $image['path'],
                        ];
//                        $imageThumbnail = 'thumbnails/' . explode('.', $image['path'])[0] . '.jpg';
//                        if ($i === 0 && !$diskS3->exists($imageThumbnail)) {
//                            dd(Image::make($this->getS3FileUrl($image['path'])));
//                            $thumbnailImage = Image::make($this->getS3FileUrl($image['path']));
//                            $resize = explode(",", Constant::IMAGE_OPTION_SCREEN['thumbnail']);
//                            $thumbnailImage->resize($resize[0], $resize[1], function ($constraint) {
//                                $constraint->aspectRatio();
//                                $constraint->upsize();
//                            });
//
//                            $thumbnailImage->stream();
//                            $pathCourseSchedule = preg_replace('/courses\/\d+/', 'course_schedules/' . $courseScheduleId, $imageThumbnail);
//                            $diskS3->put($pathCourseSchedule, $thumbnailImage);
//                        }
                    } else {
                        $data = [
                            'id' => $courseScheduleId,
                            'key' => $i
                        ];
                        $data = $this->uploadFilePublicToS3($image['path'], $dirPath, $data, $i === 0);
                    }

                    $images[] = [
                        'type' => DBConstant::IMAGE_PATH_TYPE['course'],
                        'user_id' => $uid,
                        'course_id' => null,
                        'course_schedule_id' => $courseScheduleId,
                        'status' => DBConstant::IMAGE_PATH_STATUS['approved'],
                        'file_name' => $data['fileName'],
                        'dir_path' => $data['dir_path'] ?? $dirPath,
                        'image_url' => $data['urlPath'],
                        'display_order' => $i + 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];

                    $i++;
                }
            }

            // clear data temp
//            $disk->deleteDirectory('tmp/' . $uid);
//            session()->forget('preview_file_' . $uid);
        }
        if ($request->file('preview')) {
            foreach ($request->file('preview') as $image) {
                $dirPath = "course_schedules/$courseScheduleId";
                $data = [
                    'id' => $courseScheduleId,
                    'key' => $i,
                ];

                $data = $this->uploadFileToS3($image, $dirPath, $data, $i === 0);
                $images[] = [
                    'type' => DBConstant::IMAGE_PATH_TYPE['course'],
                    'user_id' => $uid,
                    'course_id' => null,
                    'course_schedule_id' => $courseScheduleId,
                    'status' => DBConstant::IMAGE_PATH_STATUS['approved'],
                    'file_name' => $data['fileName'],
                    'dir_path' => $dirPath,
                    'image_url' => $data['urlPath'],
                    'display_order' => $i + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $i++;
            }
        }
        $this->imagePathRepository->where('course_schedule_id', $courseScheduleId)->delete();
        $this->imagePathRepository->insert($images);
    }

    public function saveImageSchedules($request, array $courseScheduleIds, $create = false)
    {
        foreach ($courseScheduleIds as $schedule) {
            $this->saveImageSchedule($request, $schedule);
        }
        if (!$create) {
            // clear data temp
            $uid = auth('client')->id();
            $disk = Storage::disk(config('filesystems.public'));
            $disk->deleteDirectory('tmp/' . $uid);
            session()->forget('preview_file_' . $uid);
        }
    }

    /**
     * @param Course|null $course
     * @return bool
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function initPreviewFile(Course $course = null)
    {
        try {
            $userId = auth('client')->id();
            $previewFiles = [];

            switch (true) {
                case session()->get('errors'):
//                case request()->backFrom === 'preview':
                    break;
                default:
                    session()->forget('preview_file_' . $userId);
                    if ($course && $course->imagePaths) {
                        foreach ($course->imagePaths as $key => $file) {
                            $previewFiles[] = [
                                'index' => $key,
                                'path' => $file->dir_path . '/' . $file->file_name,
                                'type' => 'FILE_OLD',
                                'dir_path' => $file->dir_path,
                                'originalName' => $file->file_name,
                                'fullPath' => $file->image_url
                            ];
                        }
                        if (count($previewFiles)) {
                            session()->put('preview_file_' . $userId, $previewFiles);
                        }
                    }
                    break;
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param Course|null $course
     * @return bool
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function initPreviewScheduleFile(CourseSchedule $schedule = null)
    {
        try {
            $userId = auth('client')->id();
            $previewFiles = [];

            switch (true) {
                case session()->get('errors'):
//                case request()->backFrom === 'preview':
                    break;
                default:
                    session()->forget('preview_file_' . $userId);
                    if ($schedule && $schedule->imagePaths) {
                        foreach ($schedule->imagePaths as $key => $file) {
                            $previewFiles[] = [
                                'index' => $key,
                                'path' => $file->dir_path . '/' . $file->file_name,
                                'type' => 'FILE_OLD',
                                'dir_path' => $file->dir_path,
                                'originalName' => $file->file_name,
                                'fullPath' => $file->image_url
                            ];
                        }
                        if (count($previewFiles)) {
                            session()->put('preview_file_' . $userId, $previewFiles);
                        }
                    }
                    break;
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
