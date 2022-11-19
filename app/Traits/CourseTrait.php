<?php

namespace App\Traits;


use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Exceptions\NoAccountException;
use App\Http\Requests\Client\Course\CreateCourseRequest;
use App\Http\Requests\Client\Course\UpdateCourseRequest;
use App\Http\Requests\Client\Course\UpdateCourseSchedule;
use App\Models\Course;
use App\Models\CourseSchedule;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\OptionalExtraMappingRepository;
use App\Repositories\OptionalExtraRepository;
use Tuupola\Base62Proxy as Base62;

/**
 * Trait EloquentTrait
 * @package App\Traits
 */
trait CourseTrait
{
    use RealtimeTrait;

    private $courseRepository;
    private $courseScheduleRepository;
    private $oeRepository;
    private $oemRepository;

    private function getUserLogin()
    {
        if (auth('client')->check()) {
            return auth('client')->user();
        }

        throw new NoAccountException();
    }

    /**
     * @param CreateCourseRequest $request
     * @return mixed
     */
    protected function createMainCourse(CreateCourseRequest $request)
    {
        $this->courseRepository = $this->courseRepository ?? app(CourseRepository::class);
        $user = $this->getUserLogin();
        $fixedNum = $user->teacher_category === DBConstant::CATEGORY_TYPE_SKILLS ? DBConstant::FIXED_NUM_MAX : DBConstant::FIXED_NUM_MIN;
        $approvalStatus = (!$request->parent_course_id && $user->teacher_category === DBConstant::CATEGORY_TYPE_SKILLS && $request->screen === 'LIVESTREAM-1') ?
            DBConstant::COURSE_NOT_REVIEW : DBConstant::COURSE_APPROVED;
        $lastPublicDatetime = null;
        $countPublic = 0;
        if ((int)$request->status === DBConstant::COURSE_STATUS_OPEN) {
            if ($approvalStatus === DBConstant::COURSE_APPROVED) {
                $lastPublicDatetime = now();
                $countPublic = 1;
            }
        }
        return $this->courseRepository->create([
            'user_id' => $user->user_id,
            'type' => DBConstant::COURSE_TYPE_MAIN,
            'category_id' => $request->category_id,
            'status' => $request->status,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'body' => $request->body,
            'flow' => $request->flow,
            'parent_course_id' => $request->parent_course_id ?? null,
            'cautions' => $request->cautions,
            'minutes_required' => $request->minutes_required,
            'price' => $request->price,
            'approval_status' => $approvalStatus,
            'last_public_datetime' => $lastPublicDatetime,
            'count_public' => $countPublic,
            'fixed_num' => $fixedNum,
            'dist_method' => $user->teacher_category === DBConstant::CATEGORY_TYPE_SKILLS ? DBConstant::DIST_METHOD_LIVE_STREAMING : DBConstant::DIST_METHOD_LIVE_VIDEO_CALL,
            'rating' => DBConstant::RATING_DEFAULT,
            'num_of_ratings' => DBConstant::NUM_OF_RATING_DEFAULT,
            'is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
            'is_mask_required' => $request->is_mask_required
        ]);
    }

    /**
     * @param UpdateCourseRequest $request
     * @param int $id
     * @return mixed
     */
    protected function updateMainCourse(UpdateCourseRequest $request, int $id)
    {
        $this->courseRepository = $this->courseRepository ?? app(CourseRepository::class);
        if ($request->is_clone || $request->group) {
            return $this->courseRepository->find($id);
        }
        $this->courseScheduleRepository = $this->courseScheduleRepository ?? app(CourseScheduleRepository::class);
        $user = $this->getUserLogin();

        // Update main course.
        $data = $request->except('parent_course_id');
        $course = $this->courseRepository->where('course_id', $id)->first();
        if ($course && $course->status === DBConstant::COURSE_STATUS_OPEN) {
            $data = $request->except('status');
        }
        if ($request->screen === 'LIVESTREAM-1') {
            if ((int)$data['status'] === DBConstant::COURSE_STATUS_OPEN) {
                $this->sendEvent('realtime', [
                    'url' => '/portal/courses',
                    'screen' => 'COURSE',
                    'id' => $id
                ]);
            }
            $data['minutes_required'] = 0;
        } else {
            $data['minutes_required'] = (int)filter_var($data['minutes_required'], FILTER_SANITIZE_NUMBER_INT);
        }

        // check when has cs public
        $courseSchedules = $this->courseScheduleRepository->getCourseScheduleList([$data['course_id']]);
        $courseIsPublic = $courseSchedules->filter(function ($item) {
            return $item->status === DBConstant::COURSE_SCHEDULES_STATUS_OPEN;
        });
        // if has cs public -> course status = 0
        if ($courseIsPublic->count() > 0) {
            $data['status'] = DBConstant::COURSE_STATUS_OPEN;
        }

        $data['dist_method'] = ($user->teacher_category === DBConstant::CATEGORY_TYPE_SKILLS)
            ? DBConstant::DIST_METHOD_LIVE_STREAMING : DBConstant::DIST_METHOD_LIVE_VIDEO_CALL;

//        if ($request->status === DBConstant::COURSE_STATUS_OPEN) {
        $data['updated_at'] = now();
//        }

        return $this->courseRepository->update($data, $id);
    }

    /**
     * @param $request
     * @param Course $course
     * @param bool $isBackUpdate
     * @return array
     * @throws \Exception
     */
    protected function createCourseSchedule($request, Course $course, $isBackUpdate = false)
    {
        $this->courseScheduleRepository = $this->courseScheduleRepository ?? app(CourseScheduleRepository::class);
        $courseSchedules = [];
        $start = [];
        $csD = [];
        $group = $request->group ?? strtoupper(Base62::encode(random_bytes(5)));
        // remove old course schedules
        if (!$request->is_clone) {
            $csDelete = $this->courseScheduleRepository
                ->where('course_id', $course->course_id);
            if ($request->group) {
                $csDelete->where('group', $group)
                    ->whereIn('status', [
                        DBConstant::COURSE_SCHEDULES_STATUS_DRAFT,
                        DBConstant::COURSE_SCHEDULES_STATUS_CLONE,
                        DBConstant::COURSE_SCHEDULES_STATUS_PREVIEW
                    ]);
            }
            $csD = $csDelete->pluck('course_schedule_id')->toArray();
            $csDelete->delete();
        }
        if ($request->start_day && $request->start_time && $request->minutes_required) {
            //Get list course schedules opening of user .
            foreach ($request->start_day as $key => $value) {
                $start[] = $value . ' ' . $request->start_time[$key] . ':00';
            }
            $existTime = $this->courseScheduleRepository->checkTimeExist($start, (int)$request->minutes_required);
            if ($existTime) {
                if ($isBackUpdate) {
                    return [
                        'success' => false,
                        'error' => 'start_day'
                    ];
                } else {
                    return back()->withInput()->withErrors(['start_day' => __('errors.MSG_5050')]);
                }
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
                    'course_id' => $course->course_id,
                    'type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                    'status' => $request->is_clone && (int)$request->status === DBConstant::COURSE_SCHEDULES_STATUS_PREVIEW ? DBConstant::COURSE_SCHEDULES_STATUS_CLONE : $request->status,
                    'title' => $request->title,
                    'subtitle' => $request->subtitle,
                    'body' => $request->body,
                    'flow' => $request->flow,
                    'cautions' => $request->cautions,
                    'minutes_required' => $request->minutes_required ?? $course->minutes_required,
                    'price' => $request->price,
                    'fixed_num' => $course->fixed_num,
                    'num_of_applicants' => DBConstant::NUM_OF_APPLICANT,
                    'purchase_deadline' => $purchaseDeadline,
                    'start_datetime' => $startDate,
                    'end_datetime' => $endDate,
                    'agora_channel' => $channel,
                    'agora_token' => null,
                    'group' => $group,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'is_mask_required' => $request->is_mask_required,
                ];
            }
        }
        $ids = [];
        if (count($courseSchedules)) {
            foreach ($courseSchedules as $schedule) {
                $ids[] = $this->courseScheduleRepository->create($schedule)->course_schedule_id;
            }
        }

        return ['new' => $ids, 'delete' => $csD, 'group' => $group, 'success' => true];
    }

    /**
     * @throws \Exception
     */
    public function createSubCourse(Course $course, UpdateCourseRequest $request, string $group)
    {
        $this->courseRepository = $this->courseRepository ?? app(CourseRepository::class);
        if ($request->screen !== 'LIVESTREAM-3') {
            return;
        }
        if (empty($request->sub_start_time)) {
            return;
        }
        if (!count($request->sub_start_day) || !count($request->sub_start_time) || !$request->sub_minutes_required || !$request->price_sub_course) {
            return;
        }

        $subStartDay = collect($request->sub_start_day)->filter(function ($item) {
            return $item !== null;
        })->toArray();

        $subStartTime = collect($request->sub_start_time)->filter(function ($item) {
            return $item !== null;
        })->toArray();

        if (count($subStartDay) === 0 || count($subStartTime) === 0) return;

        // Update sub_course
        $subCourse = $this->courseRepository->where([
            'parent_course_id' => $course->course_id,
            'user_id' => auth('client')->id(),
            'type' => DBConstant::COURSE_TYPE_SUB
        ])->first();

        if (!$subCourse) {
            $subCourse = $this->courseRepository->create([
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
                'is_mask_required' => $request->is_mask_required
            ]);
        } elseif ((int)$request->status === DBConstant::COURSE_STATUS_OPEN) {
            $subCourse->price = $request->price_sub_course;
            $subCourse->minutes_required = $request->sub_minutes_required;
            $subCourse->save();
        }

        // create course schedule
        $request->merge([
            'start_day' => $request->sub_start_day,
            'start_time' => $request->sub_start_time,
            'minutes_required' => $request->sub_minutes_required,
            'price' => $request->price_sub_course,
            'group' => $group,
        ]);

        return $this->createCourseSchedule($request, $subCourse, true);
    }

    /**
     * @param UpdateCourseSchedule $request
     * @return CourseSchedule
     */
    public function updateCourseSchedule(UpdateCourseSchedule $request)
    {
        $this->courseScheduleRepository = $this->courseScheduleRepository ?? app(CourseScheduleRepository::class);
        $courseSchedule = $this->courseScheduleRepository
            ->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->where([
                'course_schedule_id' => $request->course_schedule_id,
                'courses.user_id' => auth('client')->id()
            ])
            ->select('course_schedules.*')
            ->firstOrFail();

        $courseSchedule->update($request->all());

        return $courseSchedule;
    }

    /**
     * create option when create course
     *
     * @param $request
     * @param Course $course
     * @param array|null $csIds
     */
    public function createOption($request, Course $course, array $csIds = null)
    {
        $csIdsNew = $csIds['new'] ?? null;
        $this->oeRepository = $this->oemRepository ?? app(OptionalExtraRepository::class);
        $this->oemRepository = $this->oemRepository ?? app(OptionalExtraMappingRepository::class);
        if (!$request->is_clone) {
            if ($request->group) {
                if ($csIds && $csIds['delete']) {
                    $listOld = $this->oemRepository->whereIn('course_schedule_id', $csIds['delete']);
                    $opIds = $listOld->pluck('optional_extra_id')->unique()->toArray();
                    $listOld->delete();
                    $this->oeRepository->whereIn('optional_extra_id', $opIds)->delete();
                }
            } else {
                $listOld = $this->oeRepository->where('course_id', $course->course_id);
                $opIds = $listOld->pluck('optional_extra_id')->toArray();
                $listOld->delete();
                $this->oemRepository->whereIn('optional_extra_id', $opIds)->delete();
            }
        }
        $optionalExtras = [];
        if ($request->extra_title) {
            for ($i = 0, $iMax = count($request->extra_title); $i < $iMax; $i++) {
                if ($request->extra_title[$i]) {
                    $optionalExtras[] = $this->oeRepository->create([
                        'title' => $request->extra_title[$i],
                        'price' => $request->extra_price[$i],
                        'course_id' => $course->course_id,
                    ]);
                }
            }
        }

        if (!$csIdsNew) {
            $csIdsNew = $course->courseSchedulesMain->pluck('course_schedule_id')->toArray();
        }

        if (count($optionalExtras) > 0) {
            $optionalExtraMappings = [];
            foreach ($optionalExtras as $optionalExtra) {
                foreach ($csIdsNew as $scheduleId) {
                    $optionalExtraMappings[] = [
                        'course_schedule_id' => $scheduleId,
                        'optional_extra_id' => $optionalExtra->optional_extra_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            $this->oemRepository->insert($optionalExtraMappings);
        }
    }

    /**
     * create option when edit courseSchedule
     *
     * @param UpdateCourseSchedule $request
     * @param CourseSchedule $schedule
     * @param array|null $csIds
     */
    public function createOptionSchedule(UpdateCourseSchedule $request, CourseSchedule $schedule, array $csIds = null)
    {
        $this->oeRepository = $this->oemRepository ?? app(OptionalExtraRepository::class);
        $this->oemRepository = $this->oemRepository ?? app(OptionalExtraMappingRepository::class);
        // remove old oem of schedule
        $this->oemRepository->where('course_schedule_id', $schedule->course_schedule_id)->delete();
        $optionalExtras = [];
        if ($request->extra_title) {
            for ($i = 0, $iMax = count($request->extra_title); $i < $iMax; $i++) {
                if ($request->extra_title[$i]) {
                    $optionalExtras[] = $this->oeRepository->create([
                        'title' => $request->extra_title[$i],
                        'price' => $request->extra_price[$i],
                        'course_id' => $schedule->course_id,
                    ]);
                }
            }
        }

        if (count($optionalExtras) > 0) {
            $optionalExtraMappings = [];
            foreach ($optionalExtras as $optionalExtra) {
                $optionalExtraMappings[] = [
                    'course_schedule_id' => $schedule->course_schedule_id,
                    'optional_extra_id' => $optionalExtra->optional_extra_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $this->oemRepository->insert($optionalExtraMappings);
        }
    }

    public function createExtension($request, Course $course, $currentCsStatus = null, $groupCs = null)
    {
        $this->courseRepository = $this->courseRepository ?? app(CourseRepository::class);
        $group = isset($groupCs) ? $groupCs : ($request->group ?? strtoupper(Base62::encode(random_bytes(5))));
        if (!(bool)$request->is_clone) {
            //course schedule is public
            if ((int)$currentCsStatus == DBConstant::COURSE_STATUS_OPEN) {
                $query = $this->courseRepository
                    ->where([
                        'parent_course_id' => $course->course_id,
                        'type' => DBConstant::COURSE_TYPE_EXTENSION,
                        'is_hidden' => DBConstant::COURSE_IS_HIDDEN_OPEN
                    ]);
                if ($request->group) {
                    $query->where('status', '!=', DBConstant::COURSE_STATUS_OPEN);
                    $query->where('group', $group);
                }
                if (isset($request->isPublic)) {
                    $query->where('status', '!=', DBConstant::COURSE_STATUS_DRAFT);
                }
                $query->delete();
            } else {
                $query = $this->courseRepository
                    ->where('status', '!=', DBConstant::COURSE_STATUS_OPEN)
                    ->where([
                        'parent_course_id' => $course->course_id,
                        'is_hidden' => DBConstant::COURSE_IS_HIDDEN_OPEN
                    ]);
                if (!isset($request->isPublic)) {
                    $query->where('group', $group);
                } else {
                    //If isset is public to url => not remove course extension.
                    $query->where('status', '!=', DBConstant::COURSE_STATUS_DRAFT);
                }

                $query->delete();
            }
        }
        if (!$request->money || !$request->time || !count(array_filter($request->money)) || !count(array_filter($request->time))) {
            return;
        }

        $user = $this->getUserLogin();
        $fixedNum = $user->teacher_category === DBConstant::CATEGORY_TYPE_SKILLS ? DBConstant::FIXED_NUM_MAX : DBConstant::FIXED_NUM_MIN;
        //If there are already 3 extensions, no more will be created.
        $countExtensions = $course->extensionOpenAndDraft;
        if ($countExtensions && $course->extensionOpenAndDraft->count() === DBConstant::MAX_EXTENSION) {
            return;
        }

        $extensionCourses = [];
        foreach ($request->time as $key => $time) {
            if ($time && $request->money[$key]) {
                $extensionCourses[] = [
                    'user_id' => $user->user_id,
                    'status' => $request->status,
                    'is_mask_required' => $request->is_mask_required,
                    'type' => DBConstant::COURSE_TYPE_EXTENSION,
                    'parent_course_id' => $course->course_id,
                    'minutes_required' => $time,
                    'price' => $request->money[$key],
                    'fixed_num' => $fixedNum,
                    'dist_method' => DBConstant::DIST_METHOD_LIVE_VIDEO_CALL,
                    'rating' => DBConstant::RATING_DEFAULT,
                    'num_of_ratings' => DBConstant::NUM_OF_RATING_DEFAULT,
                    'is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
                    'approval_status' => DBConstant::COURSE_APPROVED,
                    'group' => $group,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        if (count($extensionCourses)) {
            $this->courseRepository->insert($extensionCourses);
        }
    }
}
