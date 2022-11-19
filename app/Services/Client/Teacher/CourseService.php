<?php

declare(strict_types=1);

namespace App\Services\Client\Teacher;

use App\AgoraDynamicKey\RtcTokenBuilder;
use App\Enums\DBConstant;
use App\Http\Requests\Client\Course\PublicCourseRequest;
use App\Mail\AdminSendSaleCommission;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\ImagePathRepository;
use App\Repositories\OptionalExtraMappingRepository;
use App\Repositories\OptionalExtraRepository;
use App\Services\BaseService;
use App\Services\Client\Common\CategoryService;
use App\Services\Client\Student\Course\CourseRestockService;
use App\Traits\CourseImageTrait;
use App\Traits\ManageFile;
use App\Traits\PromotionTrait;
use App\Traits\RealtimeTrait;
use Illuminate\Support\Facades\DB;
use Image;
use App\Repositories\CourseRepository;
use Tuupola\Base62Proxy as Base62;

class CourseService extends BaseService
{
    use ManageFile, RealtimeTrait, PromotionTrait, CourseImageTrait;

    private $courseScheduleRepository;
    private $imagePathRepository;
    private $optionalExtra;
    private $optionalExtraMapping;
    private $courseRestockService;
    private $courseRepository;
    private $categoryService;

    /**
     * CourseService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->courseScheduleRepository = app(CourseScheduleRepository::class);
        $this->imagePathRepository = app(ImagePathRepository::class);
        $this->optionalExtra = app(OptionalExtraRepository::class);
        $this->optionalExtraMapping = app(OptionalExtraMappingRepository::class);
        $this->courseRestockService = app(CourseRestockService::class);
        $this->courseRepository = app(CourseRepository::class);
        $this->categoryService = app(CategoryService::class);
    }

    public function repository()
    {
        return CourseRepository::class;
    }

    /**
     *  Remove img in database.
     *
     * @param $data
     * @param mixed $id
     *
     * @return int
     */
    public function removeImage($data, $id)
    {
        $imgIds = json_decode($data['image_id']);
        if (count($imgIds)) {
            $removeImg = $this->imagePathRepository->destroy($imgIds);

            $imgs = $this->imagePathRepository->where([
                'course_id' => $id,
                'user_id' => \auth('client')->id(),
            ])->get();

            foreach ($imgs as $index => $img) {
                $img->display_order = $index + 1;
                $img->save();
            }

            return $removeImg;
        }

        return 0;
    }

    /**
     * Get course.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getCourse(int $id)
    {
        return $this->repository->with('courseSchedules')->findOrFail($id);
    }

    /**
     * Public course.
     *
     * @param int $courseId
     * @param PublicCourseRequest $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function publicCourse(int $courseId, PublicCourseRequest $request)
    {
        $status = (int)$request->status;
//        $isClone = (bool)$request->isClone;
        $group = $request->group;
        if (!$group) {
            return back()->with('error', __('errors.MSG_5000'));
        }

        DB::beginTransaction();
        try {
            $course = $this->repository->where([
                'user_id' => auth('client')->id(),
                'course_id' => $courseId
            ])->firstOrFail();

            // check when has cs public
//            $courseSchedules = $this->courseScheduleRepository->getCourseScheduleList([$courseId]);
//            $courseIsPublic = $courseSchedules->filter(function ($item) {
//                return $item->status === DBConstant::COURSE_SCHEDULES_STATUS_OPEN;
//            });
//            // if has cs public -> course status = 0
//            if ($courseIsPublic->count() > 0) {
//                $course->status = DBConstant::COURSE_STATUS_OPEN;
//            } else {
//                $course->status = $status;
//            }
            if ($course->status !== DBConstant::COURSE_STATUS_OPEN) {
                $course->status = $status;
            }

            if ($status === DBConstant::COURSE_STATUS_OPEN) {
                $course->updated_at = now();
                if ($course->approval_status === DBConstant::COURSE_APPROVED) {
                    ++$course->count_public;
                    $course->last_public_datetime = now();
                }
            }
            $course->save();

//            if ($isClone) {
//                $statusUpdate = DBConstant::COURSE_SCHEDULES_STATUS_CLONE;
//            } else {
//                $statusUpdate = DBConstant::COURSE_SCHEDULES_STATUS_PREVIEW;
//            }

            // course schedule
            $update = [
                'status' => $status
            ];
            if ($status === DBConstant::COURSE_SCHEDULES_STATUS_OPEN) {
                $update['created_at'] = now()->format('Y-m-d H:i:s');
                // Change title course when public course schedule
                $courseScheduleClone = $this->courseScheduleRepository->getCourseScheduleClone($courseId, $group);
                if ($courseScheduleClone) {
                    $this->repository
                        ->where('course_id', $courseId)
                        ->update([
                            'title' => $courseScheduleClone->title,
                            'subtitle' => $courseScheduleClone->subtitle,
                            'body' => $courseScheduleClone->body,
                            'flow' => $courseScheduleClone->flow,
                            'cautions' => $courseScheduleClone->cautions,
                            'price' => $courseScheduleClone->price,
                            'minutes_required' => $courseScheduleClone->minutes_required,
                            'is_mask_required' => $courseScheduleClone->is_mask_required
                        ]);

                    $newImages = [];
                    foreach ($courseScheduleClone->imagePaths as $key => $item) {
                        $newImages[] = [
                            'type' => DBConstant::IMAGE_TYPE_COURSE,
                            'course_id' => $courseId,
                            'course_schedule_id' => null,
                            'file_name' => $item->getOriginal('file_name'),
                            'dir_path' => $item->getOriginal('dir_path'),
                            'image_url' => $item->getOriginal('image_url'),
                            'status' => DBConstant::IMAGE_PATH_STATUS['approved'],
                            'display_order' => $key + 1
                        ];
                    }
                    // update image schedule to course (issues 4294)
                    if (count($newImages)) {
                        $this->imagePathRepository
                            ->where([
                                'course_id' => $courseId,
                                'type' => DBConstant::IMAGE_TYPE_COURSE
                            ])
                            ->delete();
                        $this->imagePathRepository->insert($newImages);
                    }
                }
            }

            $csUpdate = $this->courseScheduleRepository
                ->where([
                    'course_id' => $courseId,
//                    'status' => $statusUpdate
                ])->whereIn('status', [
                    DBConstant::COURSE_SCHEDULES_STATUS_PREVIEW,
                    DBConstant::COURSE_SCHEDULES_STATUS_DRAFT,
                    DBConstant::COURSE_SCHEDULES_STATUS_CLONE
                ]);
            $csUpdate->where('group', $group);
            $csUpdate->update($update);

            // sub course
            if ($status === DBConstant::COURSE_STATUS_OPEN) {
                $this->repository->where([
                    'parent_course_id' => $course->course_id
                ])->where('status', DBConstant::COURSE_STATUS_PREVIEW)
                    ->update(['status' => $status]);
            } else {
                $this->repository->where([
                    'parent_course_id' => $course->course_id
                ])
                    ->whereIn('status', [DBConstant::COURSE_STATUS_WAIT_APPROVAL, DBConstant::COURSE_STATUS_PREVIEW])
                    ->update(['status' => $status]);
            }

            // sub course schedule
            if ($course->subCourse) {
                $this->courseScheduleRepository
                    ->where([
                        'course_id' => $course->subCourse->course_id,
//                        'status' => $statusUpdate
                        'group' => $group
                    ])
                    ->update($update);
            }
            $this->courseRestockService->restockCourse($course->parent_course_id, $course->course_id);
            DB::commit();
            // send event realtime
            if ($course->approval_status === DBConstant::COURSE_APPROVED_STATUS_PENDING && $course->status === DBConstant::COURSE_STATUS_OPEN) {
                $this->sendEvent('realtime', [
                    'url' => '/portal/courses',
                    'screen' => 'COURSE',
                    'id' => $course->course_id
                ]);
            }
            // check course public first & send mail.
            if ($status === DBConstant::COURSE_STATUS_OPEN && $course->approval_status === DBConstant::COURSE_APPROVED) {
                $this->checkPromotion(auth('client')->id(), $course->course_id, true);
            }

            if ($status === DBConstant::COURSE_SCHEDULES_STATUS_DRAFT) {
                return redirect()->route('client.teacher.my-page.service-list', ['tab' => 'draft'])->with('success', __('message.add_success'));
            }

            if (auth('client')->user()->teacher_category_skills === DBConstant::TEACHER_CATEGORY_SKILLS) {
                if (isset($course) && $course->approval_status === DBConstant::APPROVAL_STATUS_COURSE) {
                    return redirect()->route('client.teacher.my-page.service-list', ['tab' => 'new'])->with('success', __('message.request_step_one_course'));
                }

                return redirect()->route('client.teacher.my-page.service-list', ['tab' => 'new'])->with('success', __('message.request_approval_course'));
            }
            return redirect()->route('client.teacher.my-page.service-list')->with('success', __('message.request_approval_course'));
        } catch (\Exception $exception) {
            DB::rollBack();
//            Log::error($exception->getMessage());
            return back()->with('error', __('errors.MSG_5000'));
        }
    }

    /**
     * Public course.
     *
     * @param int $id
     * @param PublicCourseRequest $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function publicCourseSchedule(int $id, PublicCourseRequest $request)
    {
        $status = (int)$request->status;
        $isPublic = (int)$request->isPublic;
        DB::beginTransaction();
        try {
            $courseSchedule = $this->courseScheduleRepository->find($id);
            // course schedule
            $update = [
                'course_schedules.status' => $status
            ];
            if ($status === DBConstant::COURSE_SCHEDULES_STATUS_OPEN) {
                $update['course_schedules.created_at'] = now()->format('Y-m-d H:i:s');
            }
            $this->courseScheduleRepository
                ->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
                ->where([
                    'course_schedules.course_schedule_id' => $id,
                    'courses.user_id' => auth('client')->id()
                ])
                ->update($update);
            if ($courseSchedule) {
                // check when has cs public
                $courseSchedules = $this->courseScheduleRepository->getCourseScheduleList([$courseSchedule->course_id]);
                $courseIsPublic = $courseSchedules->filter(function ($item) {
                    return $item->status === DBConstant::COURSE_SCHEDULES_STATUS_OPEN;
                });
                // if has cs public -> course status = 0
                $courseStatus = $status;
                if ($courseIsPublic->count() > 0) {
                    $courseStatus = DBConstant::COURSE_STATUS_OPEN;
                }

                $course = $this->courseRepository->where([
                    'course_id' => $courseSchedule->course_id,
                    'user_id' => auth('client')->id()
                ])->first();
                $course->status = $courseStatus;
                if (!$isPublic && $status === DBConstant::COURSE_SCHEDULES_STATUS_OPEN && $courseSchedule->status) {
                    $course->count_public++;
                    $course->last_public_datetime = now();
                }
                $course->save();

                // update course extent status === open .
                $this->courseRepository->where([
                    'parent_course_id' => $courseSchedule->course_id,
                    'user_id' => auth('client')->id(),
                    'type' => DBConstant::COURSE_TYPE_EXTENSION,
                    'status' => DBConstant::COURSE_STATUS_PREVIEW
                ])->update(['status' => $status]);

            }

            // check course public first & send mail.
            if ($status === DBConstant::COURSE_STATUS_OPEN) {
                $this->checkPromotion(auth('client')->id(), $courseSchedule->course_id, true);
            }

            DB::commit();
            if ($status === DBConstant::COURSE_SCHEDULES_STATUS_DRAFT) {
                return redirect()->route('client.teacher.my-page.service-list', ['tab' => 'draft'])->with('success', __('message.add_success'));
            }

            return redirect()->route('client.teacher.my-page.service-list')->with('success', __('message.request_approval_course'));
        } catch (\Exception $exception) {
            DB::rollBack();
//            Log::error($exception->getMessage());
            return back()->with('error', __('errors.MSG_5000'));
        }
    }

    /**
     * Check course schedule coincident old course schedule (status = open).
     *
     * @param $listCourseSchedule
     * @param $startDate
     * @param $endDate
     *
     * @return bool
     */
    private function checkCourseSchedule($listCourseSchedule, $startDate, $endDate)
    {
        foreach ($listCourseSchedule as $courseSchedule) {
            $oldStart = now()->parse($courseSchedule['start_datetime']);
            $oldEnd = now()->parse($courseSchedule['end_datetime']);
            if (($startDate->gte($oldStart) && $startDate->lte($oldEnd)) || ($endDate->gte($oldStart) && $endDate->lte($oldEnd))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Generate rtc token live stream.
     *
     * @param $channel
     *
     * @return string
     */
    private function rtcToken($channel)
    {
        $appID = config('app.agora_app_id');
        $appCertificate = config('app.agora_app_certificate');
        $channelName = $channel;
        $user = null;
        $role = RtcTokenBuilder::RoleAttendee;
        $expireTimeInSeconds = 3600 * 24 * 365 * 10; // exp 10 year
        $currentTimestamp = now()->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

        return RtcTokenBuilder::buildTokenWithUserAccount($appID, $appCertificate, $channelName, $user, $role, $privilegeExpiredTs);
    }

    public function preview(int $courseId, string $type = null, bool $isClone = false, string $group = null)
    {
        $userId = auth('client')->id();

        if ($type !== 'COURSE_SCHEDULE') {
            $course = $this->repository
                ->with(['courseSchedules' => function ($q) use ($group) {
                    if ($group) {
                        $q->where('group', $group);
                    }
                }])
                ->with('extensions')
                ->with(['subCourse' => function ($q) use ($group) {
                    $q->with(['courseSchedules' => function ($q2) use ($group) {
                        $q2->where('status', DBConstant::COURSE_SCHEDULES_STATUS_OPEN);
                        if ($group) {
                            $q2->orWhere('group', $group);
                        }
                    }]);
                }])
                ->find($courseId);
            $csCloneIds = $course->courseSchedules->pluck('course_schedule_id')->toArray();
            $optionalExtras = [];
            if (count($csCloneIds)) {
                $oemIds = $this->optionalExtraMapping->whereIn('course_schedule_id', $csCloneIds)
                    ->pluck('optional_extra_id')
                    ->toArray();
                if ($oemIds) {
                    $optionalExtras = $this->optionalExtra->whereIn('optional_extra_id', $oemIds)->get();
                }
            }
            $course->optionalExtras = $optionalExtras;

            if (!$course || !$course->courseSchedules) {
                return redirect()->route('client.teacher.my-page.service-list', ['tab' => 'new'])->with('error', __('errors.MSG_8008'));
            }
            $course->course_schedule_id = $course->courseSchedules->first()->course_schedule_id ?? null;
        } else {
            $course = $this->courseScheduleRepository
                ->find($courseId);
        }
        $firstSchedule = $course->courseSchedules ? $course->courseSchedules->first() : null;
        if ($group && $firstSchedule) {
            $course->title = $firstSchedule->title;
            $course->subtitle = $firstSchedule->subtitle;
            $course->body = $firstSchedule->body;
            $course->flow = $firstSchedule->flow;
            $course->cautions = $firstSchedule->cautions;
            $course->minutes_required = $firstSchedule->minutes_required;
            $course->price = $firstSchedule->price;
            $course->is_mask_required = $firstSchedule->is_mask_required;
        }
        $rating = $this->repository->getTheRatingOfCourse($course->course_id);
        $avgRating = $rating->avg('rating') ?? 0;
        $sumRating = $rating->sum('num_of_ratings') ?? 0;
        $this->getImagesOfSchedule($course);

        return [
            'course' => $course,
            'isSchedule' => $type === 'COURSE_SCHEDULE',
            'user' => auth('client')->user(),
            'avgRating' => $avgRating,
            'sumRating' => $sumRating,
            'isClone' => $isClone,
            'group' => $group
        ];
    }


    /**
     * @param $request
     * @param $courseId
     * @return array|false[]|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function previewCloneCourse($request, $courseId)
    {
        $formData = $request->all();
        $user = auth()->guard('client')->user();
        try {
            $formData['dist_method'] = $user->teacher_category === DBConstant::CATEGORY_TYPE_SKILLS ? DBConstant::DIST_METHOD_LIVE_STREAMING : DBConstant::DIST_METHOD_LIVE_VIDEO_CALL;
            $course = $this->repository
                ->withCount(['courseSchedules' => function ($q) {
                    $q->whereIn('status', [DBConstant::COURSE_SCHEDULES_STATUS_OPEN, DBConstant::COURSE_SCHEDULES_STATUS_DRAFT])
                        ->where('purchase_deadline', '>', now())
                        ->whereRaw('fixed_num > num_of_applicants');
                }])
                ->with(['subCourse', 'subCourse.courseSchedules' => function($query) {
                    $query->where('purchase_deadline', '>', now())
                        ->whereIn('status', [DBConstant::COURSE_SCHEDULES_STATUS_OPEN]);
                }])
                ->find($courseId);
            $start = [];
            $courseSchedules = [];
            // course schedule new
            if ($request->start_day && $request->start_time && $request->minutes_required) {
                //Get list course schedules opening of user .
                foreach ($request->start_day as $key => $value) {
                    $start[] = $value . ' ' . $request->start_time[$key] . ':00';
                }
                $existTime = $this->courseScheduleRepository->checkTimeExist($start, (int)$request->minutes_required);
                if ($existTime) {
                    return response()->json(
                        [
                            'data' => [
                                'errors' => [
                                    [
                                        'key' => 'start_day',
                                        'error' => __('errors.MSG_5050')
                                    ]
                                ]
                            ]
                        ], 422
                    );
                }
            } else {
                $request->merge(['minutes_required' => 0]);
            }
            if (count($start)) {
                foreach ($start as $time) {
                    $channel = Base62::encode(random_bytes(10));
                    $startDate = now()->parse($time);
                    $endDate = now()->parse($startDate)->addMinutes((int)$request->minutes_required);
                    $purchaseDeadline = now()->parse($startDate)->subHour();
                    $courseSchedules[] = [
                        'course_id' => '',
                        'type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                        'status' => $request->is_clone && (int)$request->status === DBConstant::COURSE_SCHEDULES_STATUS_PREVIEW ? DBConstant::COURSE_SCHEDULES_STATUS_CLONE : $request->status,
                        'title' => $request->title,
                        'subtitle' => $request->subtitle,
                        'body' => $request->body,
                        'flow' => $request->flow,
                        'cautions' => $request->cautions,
                        'minutes_required' => $request->minutes_required ?? "",
                        'price' => $request->price,
                        'fixed_num' => $user->teacher_category === DBConstant::CATEGORY_TYPE_SKILLS ? DBConstant::FIXED_NUM_MAX : DBConstant::FIXED_NUM_MIN,
                        'num_of_applicants' => DBConstant::NUM_OF_APPLICANT,
                        'purchase_deadline' => $purchaseDeadline,
                        'start_datetime' => $startDate,
                        'end_datetime' => $endDate,
                        'agora_channel' => $channel,
                        'agora_token' => null,
                        'group' => '',
                        'created_at' => now(),
                        'updated_at' => now(),
                        'is_mask_required' => $request->is_mask_required ?? "",
                        'dist_method' => $formData['dist_method'],
                        'hour_minute' => $startDate->format('H:i') . ' - ' . $endDate->format('H:i')
                    ];
                }
            }
            $course['courseSchedules'] = $courseSchedules;


            // sub course
            $subCourse = null;
            if ($request->screen === 'LIVESTREAM-3' &&
                !empty($request->sub_start_time) &&
                !(!count($request->sub_start_day) || !count($request->sub_start_time) || !$request->sub_minutes_required || !$request->price_sub_course)
            ) {
                $subStartDay = collect($request->sub_start_day)->filter(function ($item) {
                    return $item !== null;
                })->toArray();

                $subStartTime = collect($request->sub_start_time)->filter(function ($item) {
                    return $item !== null;
                })->toArray();
                $subCourse = $course->subCourse;
                $courseSchedulesSub = [];
                if ($subCourse) {
                    $courseSchedulesSub = $subCourse->courseSchedules->toArray();
                    $subCourse->minutes_required = $request->sub_minutes_required;
                    $subCourse->price = $request->price_sub_course;
                }
                if (!$subCourse && count($subStartDay) !== 0 && count($subStartTime) !== 0) {
                    $subCourse = [
                        'user_id' => auth('client')->id(),
                        'type' => DBConstant::COURSE_TYPE_SUB,
                        'category_id' => $course->category_id,
                        'status' => $request->status,
                        'title' => $course->title,
                        'subtitle' => $request->subtitle,
                        'body' => $request->body,
                        'flow' => $request->flow,
                        'parent_course_id' => $course->course_id,
                        'cautions' => $request->cautions,
                        'minutes_required' => $request->sub_minutes_required,
                        'price' => $request->price_sub_course,
                        'approval_status' => DBConstant::COURSE_APPROVED,
                        'fixed_num' => DBConstant::FIXED_NUM_MIN,
                        'dist_method' => DBConstant::DIST_METHOD_LIVE_VIDEO_CALL,
                        'rating' => DBConstant::RATING_DEFAULT,
                        'num_of_ratings' => DBConstant::NUM_OF_RATING_DEFAULT,
                        'is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
                        'is_mask_required' => $request->is_mask_required,
                        'courseSchedules' => []
                    ];
                }
                if ($subCourse) {
                    $start = [];
                    foreach ($subStartDay as $key => $startTime) {
                        $start[] = $startTime . ' ' . $request->sub_start_time[$key] . ':00';
                    }
                    if (count($start)) {
                        foreach ($start as $time) {
                            $channel = Base62::encode(random_bytes(10));
                            $startDate = now()->parse($time);
                            $endDate = now()->parse($startDate)->addMinutes((int)$request->sub_minutes_required);
                            $purchaseDeadline = now()->parse($startDate)->subHour();
                            $courseSchedulesSub[] = [
                                'course_id' => '',
                                'type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                                'status' => $request->is_clone && (int)$request->status === DBConstant::COURSE_SCHEDULES_STATUS_PREVIEW ? DBConstant::COURSE_SCHEDULES_STATUS_CLONE : $request->status,
                                'title' => $course->title,
                                'subtitle' => $course->subtitle,
                                'body' => $course->body,
                                'flow' => $course->flow,
                                'cautions' => $request->cautions,
                                'minutes_required' => $request->sub_minutes_required ?? $course->minutes_required,
                                'price' => $request->price_sub_course ?? $course->price,
                                'fixed_num' => $course->fixed_num,
                                'num_of_applicants' => DBConstant::NUM_OF_APPLICANT,
                                'purchase_deadline' => $purchaseDeadline,
                                'start_datetime' => $startDate,
                                'end_datetime' => $endDate,
                                'agora_channel' => $channel,
                                'agora_token' => null,
                                'group' => '',
                                'created_at' => now(),
                                'updated_at' => now(),
                                'is_mask_required' => $request->is_mask_required,
                            ];
                        }
                    }
                    $subCourse['courseSchedules'] = collect($courseSchedulesSub)->sortBy('start_datetime')->toArray();
                    $course['subCourse'] = $subCourse;
                }
            }

            // image
            $paths = [];
            if (isset($formData['previewOld'])) {
                foreach ($formData['previewOld'] as $oldPreview) {
                    $val = json_decode($oldPreview, true);
                    $paths[] = [
                        'image_url' => $val['fullPath']
                    ];
                }
            }

            if ($request->file('preview')) {
                $imagePaths = $this->saveTmpFile($request->file('preview'));
                if (count($imagePaths) > 0) {
                    $course['imagePaths'] = [];
                    foreach ($imagePaths as $image) {
                        $paths[] = [
                            'image_url' => $image['fullPath']
                        ];
                    }
                }
            }
            $course['imagePaths'] = $paths;

            // extension
            $extensionCourses = [];
            if (isset($formData['time'])) {
                foreach ($formData['time'] as $key => $time) {
                    if ($time && $formData['money'][$key]) {
                        $extensionCourses[] = [
                            'user_id' => $user->user_id,
                            'status' => '',
                            'is_mask_required' => $request->is_mask_required ?? '',
                            'type' => DBConstant::COURSE_TYPE_EXTENSION,
                            'parent_course_id' => "",
                            'minutes_required' => $time,
                            'price' => $formData['money'][$key],
                            'fixed_num' => $user->teacher_category === DBConstant::CATEGORY_TYPE_SKILLS ? DBConstant::FIXED_NUM_MAX : DBConstant::FIXED_NUM_MIN,
                            'dist_method' => DBConstant::DIST_METHOD_LIVE_VIDEO_CALL,
                            'rating' => DBConstant::RATING_DEFAULT,
                            'num_of_ratings' => DBConstant::NUM_OF_RATING_DEFAULT,
                            'is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
                            'approval_status' => DBConstant::COURSE_APPROVED,
                            'group' => '',
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                }
            }
            $courseExtensions = $course->extensionsOpen->toArray();
            $course['extensionsOpen'] = array_merge($courseExtensions, $extensionCourses);

            // option extra
            $optionalExtras = [];
            if (isset($formData['extra_title'])) {
                for ($i = 0, $iMax = count($formData['extra_title']); $i < $iMax; $i++) {
                    if ($formData['extra_title'][$i]) {
                        $optionalExtras[] = [
                            'title' => $formData['extra_title'][$i],
                            'price' => $formData['extra_price'][$i],
                            'course_id' => '',
                        ];
                    }
                }
            }
            $course['optionalExtras'] = $optionalExtras;

            // update course
            $course['title'] = $formData['title'];
            $course['subtitle'] = $formData['subtitle'];
            $course['body'] = $formData['body'];
            $course['flow'] = $formData['flow'];
            $course['cautions'] = $formData['cautions'];
            $course['is_mask_required'] = isset($formData['is_mask_required']) ? (int)$formData['is_mask_required'] : 0;
            $course['price'] = $formData['price'];

            if ($request->screen === 'LIVESTREAM-1') {
                $course['minutes_required'] = 0;
            } else {
                $course['minutes_required'] = $formData['minutes_required'] ?? (int)filter_var($course['minutes_required'], FILTER_SANITIZE_NUMBER_INT);
            }
            $course['dist_method'] = ($user->teacher_category === DBConstant::CATEGORY_TYPE_SKILLS)
                ? DBConstant::DIST_METHOD_LIVE_STREAMING : DBConstant::DIST_METHOD_LIVE_VIDEO_CALL;

            $data = [
                'isSchedule' => false,
                'course' => $course,
                'user' => $user,
                'avgRating' => 0,
                'sumRating' => 0,
                'isClone' => true,
                'group' => ''
            ];
            $subCourse = $this->repository->getModel()->where([
                'parent_course_id' => $courseId,
                'type' => DBConstant::COURSE_TYPE_SUB,
                'status' => DBConstant::COURSE_STATUS_OPEN
            ])->first();
            $countSubCourseSchedule = 0;
            if ($subCourse) {
                $countSubCourseSchedule = $this->courseScheduleRepository
                    ->getModel()->where([
                        'course_id' => $subCourse->course_id
                    ])->whereIn('status', [DBConstant::COURSE_SCHEDULES_STATUS_OPEN, DBConstant::COURSE_SCHEDULES_STATUS_DRAFT])->count();
            }
            $course['maxSubCanCreate'] = DBConstant::MAX_SUB_COURSE - $countSubCourseSchedule;

            if ($formData['screen'] === 'LIVESTREAM-2') {
                $data['label'] = [
                    'screen' => 'LIVESTREAM-3',
                    'step' => 'STEP 3',
                    'title' => '開催日程の設定',
                    'deg' => 360
                ];
                $data['isClone'] = $request->is_clone ?? false;
                $data['courseId'] = $courseId;
                $data['MAX_COURSE'] = DBConstant::MAX_COURSE_SCHEDULE - $course->course_schedules_count;
                $data['category'] = $user->teacher_category;
                $categories = null;
                if ($course->approval_status === DBConstant::COURSE_NOT_REVIEW) {
                    $categories = $this->categoryService->getCategories($user->teacher_category);
                }
                $data['categories'] = $categories;
                $data['label']['clone'] = $request->is_clone ?? false;
                $data['course']['maxScheduleCanCreate'] = $data['MAX_COURSE'];
                return response([
                    'success' => true,
                    'type' => 'livestream-preview',
                    'html' => view('client.screen.teacher.my-page.course.edit-livestream-preview')->with($data)->render()
                ]);
            }

            return response([
                'success' => true,
                'html' => view('client.screen.teacher.my-page.course.course-preview')->with($data)->render(),
            ]);
        } catch (\Exception $exception) {
            report($exception);

            return response([
                'success' => false
            ], 500);
        }
    }
}
