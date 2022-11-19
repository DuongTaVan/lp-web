<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Traits\ManageFile;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ImagePathRepository;
use App\Models\ImagePath;
use App\Validators\ImagePathValidator;

/**
 * Class ImagePathRepositoryEloquent.
 */
class ImagePathRepositoryEloquent extends BaseRepository implements ImagePathRepository
{
    use ManageFile;

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return ImagePath::class;
    }

    /**
     * Get identity verification image list.
     *
     * @param $request
     * @return mixed
     */
    public function getIdentityVerificationImage($request)
    {
        // Fixed condition
        $imagePaths = $this->model->join(
            'users as u', 'u.user_id', '=', 'image_paths.user_id'
        )->leftJoin(
            'bank_accounts as ba', 'ba.user_id', '=', 'image_paths.user_id'
        )->select(
            DB::raw('MAX(image_paths.id) AS id'),
            DB::raw('MAX(image_paths.user_id) AS user_id'),
            DB::raw('MAX(image_paths.status) AS status'),
            DB::raw('MAX(image_paths.created_at) AS created_at'),
            DB::raw('MAX(image_paths.updated_at) AS updated_at'),
            DB::raw('MAX(ba.account_name) AS account_name'),
            'u.teacher_category_skills',
            'u.teacher_category_consultation',
            'u.teacher_category_fortunetelling',
            'u.last_name_kanji',
            'u.first_name_kanji',
            'u.last_name_kana',
            'u.first_name_kana'
        )->with(['user' => function ($query) {
            $query->with('imagePathAllType');
        }])->where(
            'image_paths.type', DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION
        )->whereIn('image_paths.status', [
            DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_NOT_YET_APPLIED,
            DBConstant::IDENTITY_VERIFICATION_STATUS_APPLIED,
            DBConstant::IDENTITY_VERIFICATION_STATUS_REJECTED,
            DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED
        ])
            ->groupBy('image_paths.user_id');
        // Search terms if any
        if ($request->filled('userId')) {
            $imagePaths = $imagePaths->where('image_paths.user_id', $request->userId);
        }
        if ($request->option == \App\Enums\Constant::SORT_DATETIME_ASC) {
            $imagePaths = $imagePaths->orderBy('created_at', 'ASC');
        } elseif ($request->option == \App\Enums\Constant::SORT_DATETIME_DESC) {
            $imagePaths = $imagePaths->orderBy('created_at', 'DESC');
        }
        if ($request->filled('status')) {
            $imagePaths = $imagePaths->where('u.connect_verification_session', $request->status)->orderBy('created_at', 'DESC');
        } else {
            $imagePaths = $imagePaths->orderBy('created_at', 'DESC');
        }

        return $imagePaths->paginate($request->per_page);
    }

    /**
     * Get identity verification image list.
     * Get Images.
     *
     * @param $request
     * @return mixed
     */

    public function getImageData($request)
    {
        // Set variable
        $userId = $request->userId;
        $perPage = $request->per_page;

        $query = $this->model
            ->join('users as u', 'image_paths.user_id', '=', 'u.user_id')
            ->leftJoin('bank_accounts as ba', 'ba.user_id', '=', 'image_paths.user_id')
            ->where('image_paths.type', DBConstant::IMAGE_PATH_TYPE['business_verification'])
            ->whereIn('status', [
                DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_NOT_YET_APPLIED,
                DBConstant::IDENTITY_VERIFICATION_STATUS_APPLIED,
                DBConstant::IDENTITY_VERIFICATION_STATUS_REJECTED,
                DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED
            ])
            ->select('u.*', 'image_paths.id', 'dir_path', 'file_name', 'file_name', 'status',
                'image_paths.created_at as ip_created_at', 'image_paths.updated_at as verify', 'ba.account_name');

        if ($userId) {
            $query->where('image_paths.user_id', '=', $userId);
        }
        if ($request->option == \App\Enums\Constant::SORT_DATETIME_ASC) {
            $query->orderBy('image_paths.created_at', 'ASC');
        } elseif ($request->option == \App\Enums\Constant::SORT_DATETIME_DESC) {
            $query->orderBy('image_paths.created_at', 'DESC');
        }
        if ($request->filled('status')) {
            $query->where('image_paths.status', '=', $request->status)->orderBy('image_paths.created_at', 'DESC');
        } else {
            $query->orderBy('image_paths.created_at', 'DESC');
        }

        return $query->paginate($perPage ? $perPage : Constant::DEFAULT_LIMIT);
    }

    public function getDetail(int $id)
    {
        return $this->model
            ->join('users as u', 'image_paths.user_id', '=', 'u.user_id')
            ->leftJoin('bank_accounts as ba', 'ba.user_id', '=', 'image_paths.user_id')
            ->where([
                'image_paths.type' => DBConstant::IMAGE_PATH_TYPE['business_verification'],
                'image_paths.user_id' => $id
            ])
            ->whereIn('status', [
                DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_NOT_YET_APPLIED,
                DBConstant::IDENTITY_VERIFICATION_STATUS_APPLIED,
                DBConstant::IDENTITY_VERIFICATION_STATUS_REJECTED,
                DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED
            ])
            ->select('u.*', 'image_paths.id', 'dir_path', 'file_name', 'file_name', 'status',
                'image_paths.created_at as ip_created_at', 'image_paths.updated_at as verify', 'ba.account_name')
            ->first();
    }

    public function getIdentityDetail(int $id)
    {
        return $this->model
            ->join('users as u', 'u.user_id', '=', 'image_paths.user_id')
            ->leftJoin('bank_accounts as ba', 'ba.user_id', '=', 'image_paths.user_id')
            ->select(
                DB::raw('MAX(image_paths.id) AS id'),
                DB::raw('MAX(image_paths.user_id) AS user_id'),
                DB::raw('MAX(image_paths.file_name) AS file_name'),
                DB::raw('MAX(image_paths.dir_path) AS dir_path'),
                DB::raw('MAX(image_paths.status) AS status'),
                DB::raw('MAX(image_paths.created_at) AS created_at'),
                DB::raw('MAX(image_paths.updated_at) AS updated_at'),
                DB::raw('MAX(ba.account_name) AS account_name'),
                'u.teacher_category_skills',
                'u.teacher_category_consultation',
                'u.teacher_category_fortunetelling',
                'u.last_name_kanji',
                'u.first_name_kanji',
                'u.last_name_kana',
                'u.first_name_kana'
            )->with(['user' => function ($query) {
                $query->with('imagePathAllType');
            }])
            ->where([
                'image_paths.user_id' => $id,
                'image_paths.type' => DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION
            ])
            ->whereIn('image_paths.status', [
                DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_NOT_YET_APPLIED,
                DBConstant::IDENTITY_VERIFICATION_STATUS_APPLIED,
                DBConstant::IDENTITY_VERIFICATION_STATUS_REJECTED,
                DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED
            ])->groupBy('image_paths.user_id')->first();
    }

    /**
     * Get count image identity.
     */
    public function getCountImageIdentity()
    {
        return $this->model->join(
            'users as u',
            'image_paths.user_id',
            '=',
            'u.user_id'
        )->where([
            ['image_paths.status', '=', DBConstant::IMAGE_PATH_STATUS['applying']],
            ['image_paths.type', '=', DBConstant::IMAGE_PATH_TYPE['identity_verification']],
        ])->count();
    }

    /**
     * Get count image business.
     */
    public function getCountImageBusiness()
    {
        return $this->model->join(
            'users as u',
            'image_paths.user_id',
            '=',
            'u.user_id'
        )->where([
            ['image_paths.status', '=', DBConstant::IMAGE_PATH_STATUS['applying']],
            ['image_paths.type', '=', DBConstant::IMAGE_PATH_TYPE['business_verification']],
        ])->count();
    }

    /**
     * Get Course Images.
     *
     * @param $courseId
     * @return mixed|void
     */
    public function getCourseImages($courseId)
    {
        return $this->model
            ->selectRaw("*, CONCAT (dir_path, '/',file_name) AS img_url, id")
            ->where([
                'course_id' => $courseId,
                'type' => DBConstant::IMAGE_TYPE_COURSE,
                'status' => DBConstant::IMAGE_PATH_STATUS['approved'],
            ])
            ->orderBy('display_order', Constant::ORDER_BY_ASC)
            ->limit(4)
            ->get();
    }

    /**
     * Get Course Images.
     *
     * @param $userId
     * @return mixed|void
     */
    public function getUserImages($userId)
    {
        return $this->model
            ->selectRaw('CONCAT (dir_path,file_name) AS img_url, id')
            ->where([
                'user_id' => $userId,
                'type' => DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION,
                'status' => DBConstant::IMAGE_PATH_STATUS['approved'],
            ])
            ->get();
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param $course_id
     * @return mixed
     */
    public function imageCourse($course_id)
    {
        return $this->model->where("course_id", $course_id)->first();
    }

    /**
     * @param $file
     * @param $userId
     * @param $path
     * @param $type
     * @return array|false[]
     */
    public function uploadUserImage($file, $userId, $path, $type)
    {
        try {
            $data = [
                'user_id' => $userId,
                'type' => $type,
                'dir_path' => $path,
                'status' => DBConstant::IMAGE_PATH_STATUS['applying'],
                'display_order' => DBConstant::BUSINESS_DISPLAY
            ];
            $imageObj = $this->uploadFileToS3($file, $path, ['id' => $userId]);
            $data['image_url'] = $imageObj['urlPath'];
            $data['file_name'] = $imageObj['fileName'];
            $imageS3Url = $this->getS3FileUrl($imageObj['urlPath']);
            $this->model->create($data);
            return [
                'success' => true,
                'imageS3Url' => $imageS3Url
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false
            ];
        }
    }

    /**
     * @param $file
     * @param $userId
     * @param $path
     * @param $type
     * @param $displayOrder
     * @param null $status
     * @return array|false[]
     */
    public function uploadOrCreateUserImage($file, $userId, $path, $type, $displayOrder, $status = null)
    {
        try {
            $data = [
                'user_id' => $userId,
                'type' => $type,
                'dir_path' => $path,
                'status' => $status ?? 9,
                'display_order' => $displayOrder
            ];
            $imageObj = $this->uploadFileToS3($file, $path, ['id' => $userId]);
            $data['image_url'] = $imageObj['urlPath'];
            $data['file_name'] = $imageObj['fileName'];
            $imageS3Url = $this->getS3FileUrl($imageObj['urlPath']);
            $rs = $this->model->create($data);
            return [
                'success' => true,
                'imageS3Url' => $imageS3Url
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false
            ];
        }
    }

    /**
     * Remove user image.
     *
     * @param $path
     * @param $fileName
     * @return bool[]|false[]
     */
    public function removeUserImage($path, $fileName): array
    {
        try {
            $imageObj = $this->removeFileFromS3($path, $fileName);
            $rs = $this->model
                ->where('dir_path', $path)
                ->where('file_name', $fileName)
                ->delete();
            return [
                'success' => true
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false
            ];
        }
    }

    /**
     * Remove image.
     *
     * @param $userId
     * @return mixed|void
     */
    public function removeImage($userId)
    {
        $imagePath = ImagePath::where(['type' => DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION, 'user_id' => $userId])->first();

        if ($imagePath) {
            return $imagePath->delete();
        }
    }

    /**
     * Remove image course.
     *
     * @param $courseId
     * @return mixed|void
     */
    public function removeImageCourse($courseId)
    {
        return $this->model->where('course_id', $courseId)->delete();
    }

    /**
     * Count identity not verification image.
     *
     * @return mixed
     */
    public function countIdentityNotVerificationImage()
    {
        return $this->model->join(
            'users as u', 'u.user_id', '=', 'image_paths.user_id'
        )->leftJoin(
            'bank_accounts as ba', 'ba.user_id', '=', 'image_paths.user_id'
        )->select(
            DB::raw('MAX(image_paths.id) AS id'),
            DB::raw('MAX(image_paths.user_id) AS user_id'),
            DB::raw('MAX(image_paths.file_name) AS file_name'),
            DB::raw('MAX(image_paths.dir_path) AS dir_path'),
            DB::raw('MAX(image_paths.status) AS status'),
            DB::raw('MAX(image_paths.created_at) AS created_at'),
            DB::raw('MAX(image_paths.updated_at) AS updated_at'),
            DB::raw('MAX(ba.account_name) AS account_name'),
            'u.teacher_category_skills',
            'u.teacher_category_consultation',
            'u.teacher_category_fortunetelling',
            'u.last_name_kanji',
            'u.first_name_kanji',
            'u.last_name_kana',
            'u.first_name_kana'
        )->where(
            [
                'image_paths.type' => DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION,
                'image_paths.status' => DBConstant::IDENTITY_VERIFICATION_STATUS_NOT_YET_APPLIED
            ]
        )
            ->groupBy('image_paths.user_id')
            ->where('image_paths.status', 0)->get()->count();
    }

    /**
     * Business not verification image.
     *
     * @return mixed
     */
    public function businessNotVerificationImage()
    {
        return $this->model->join(
            'users as u',
            'image_paths.user_id',
            '=',
            'u.user_id'
        )->leftJoin(
            'bank_accounts as ba',
            'ba.user_id',
            '=',
            'image_paths.user_id'
        )->where([
            ['image_paths.type', '=', DBConstant::IMAGE_PATH_TYPE['business_verification']],
            ['image_paths.status', '=', DBConstant::IDENTITY_VERIFICATION_STATUS_NOT_YET_APPLIED]
        ])->get()->count();
    }

    /**
     * Remove image qualification.
     *
     * @param $userId
     * @return mixed
     */
    public function removeImageQualification($userId)
    {
        return $this->model->where([
            'user_id' => $userId,
            'type' => DBConstant::IMAGE_TYPE_BUSINESS_CARD
        ])->delete();
    }

    /**
     * Update status identity image
     *
     */
    public function identityImage(int $userId, int $status)
    {
        return $this->model->where([
            'user_id' => $userId,
            'type' => DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION
        ])->update([
            'status' => $status,
            'updated_at' => now()
        ]);
    }
}
