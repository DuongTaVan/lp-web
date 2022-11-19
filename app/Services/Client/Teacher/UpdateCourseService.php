<?php

namespace App\Services\Client\Teacher;

use App\Enums\DBConstant;
use App\Http\Requests\Client\Course\UpdateCourseRequest;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\ImagePathRepository;
use App\Repositories\OptionalExtraMappingRepository;
use App\Repositories\OptionalExtraRepository;
use App\Services\BaseService;
use App\Services\Client\Student\Course\CourseRestockService;
use App\Traits\CourseTrait;
use App\Traits\ManageFile;
use Illuminate\Support\Facades\DB;
use Tuupola\Base62Proxy as Base62;

class UpdateCourseService extends BaseService
{
    private $imagePathRepository;
    private $courseRestockService;
    private $courseScheduleRepository;
    private $optionalExtra;
    private $optionalExtraMapping;
    use ManageFile, CourseTrait;

    public function __construct()
    {
        parent::__construct();
        $this->imagePathRepository = app(ImagePathRepository::class);
        $this->courseRestockService = app(CourseRestockService::class);
        $this->courseScheduleRepository = app(CourseScheduleRepository::class);
        $this->optionalExtra = app(OptionalExtraRepository::class);
        $this->optionalExtraMapping = app(OptionalExtraMappingRepository::class);
    }

    public function repository()
    {
        return CourseRepository::class;
    }

    /**
     * @param UpdateCourseRequest $request
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function update(UpdateCourseRequest $request, int $id)
    {
        DB::beginTransaction();
        try {
            if ($request->start_day && $request->start_time && $request->minutes_required) {
                //Get list course schedules opening of user .
                $start = [];
                foreach ($request->start_day as $key => $value) {
                    $start[] = $value . ' ' . $request->start_time[$key] . ':00';
                }
                $existTime = $this->courseScheduleRepository->checkTimeExist($start, (int)$request->minutes_required);
                if ($existTime) {
                    return [
                        'success' => false,
                        'errors' => ['start_day' => __('errors.MSG_5050')],
                    ];
                }
            }

            if ($request->sub_start_day && $request->sub_start_time && $request->sub_minutes_required) {
                //Get list course schedules opening of user .
                $start = [];
                foreach ($request->sub_start_day as $key => $value) {
                    if ($value) {
                        $start[] = $value . ' ' . $request->sub_start_time[$key] . ':00';
                    }
                }
                if (count($start) > 0) {
                    $existTime = $this->courseScheduleRepository->checkTimeExist($start, (int)$request->sub_minutes_required);
                    if ($existTime) {
                        return [
                            'success' => false,
                            'errors' => [
                                'sub_start_day' => __('errors.MSG_5050')
                            ]
                        ];
                    }
                }
            }
            // update main course
            $course = $this->updateMainCourse($request, $id);
            if ((int)$request->status === DBConstant::COURSE_STATUS_OPEN) {
                $course->updated_at = now();
                $course->status = DBConstant::COURSE_STATUS_OPEN;
                if ($course->approval_status === DBConstant::COURSE_APPROVED) {
                    ++$course->count_public;
                    $course->last_public_datetime = now();
                }
                // update course by course schedule new public
                if ((int)$request->is_clone || $request->group) {
                    $course->title = $request->title;
                    $course->subtitle = $request->subtitle;
                    $course->body = $request->body;
                    $course->flow = $request->flow;
                    $course->cautions = $request->cautions;
                    $course->price = $request->price;
                    $course->minutes_required = $request->minutes_required;
                    $course->is_mask_required = $request->is_mask_required;
                }
                $this->saveImage($request, $id);
                $course->save();
            }
            $tempGroup = $request->group;
            // Create group of course schedule and course extend.
            $request->merge(['group' => $request->group ?? strtoupper(Base62::encode(random_bytes(5)))]);
            $createCs = $this->createCourseSchedule($request, $course, true);
            if (!$createCs['success']) {
                return [
                    'success' => false,
                    'errors' => ['start_day' => __('errors.MSG_5050')],
                ];
            }
            $createCsNew = $createCs['new'];
            if (count($createCsNew)) {
                $this->courseRestockService->restockCourse($course->parent_course_id, $course->course_id);
            }

            // update subCourse
            if ((int)$request->status === DBConstant::COURSE_STATUS_OPEN) {
                $this->repository->where([
                    'parent_course_id' => $course->course_id,
                    'type' => DBConstant::COURSE_TYPE_SUB
                ])->where('status', DBConstant::COURSE_STATUS_DRAFT)
                    ->update(['status' => (int)$request->status]);
            }

            $this->createExtension($request, $course);

            $this->createOption($request, $course, $createCs);

            $subCourse = $this->createSubCourse($course, $request, $createCs['group']);
            if (isset($subCourse['success']) && !$subCourse['success']) {
                return [
                    'success' => false,
                    'errors' => ['start_day' => __('errors.MSG_5050')],
                ];
            }
            if (!$tempGroup) {
                $request->except('group');
            }
            // save image
            if (($request->is_clone || $request->group) && $course->approval_status === DBConstant::COURSE_APPROVED) {
                $allCourseSchedule = $createCsNew;
                if ($subCourse) {
                    $allCourseSchedule = array_merge($createCsNew, $subCourse['new']);
                }
                $this->saveImageSchedules($request, $allCourseSchedule);
            } else {
                $this->saveImage($request, $id);
            }

            DB::commit();
            // send event realtime
            if ((int)$course->approval_status === DBConstant::COURSE_APPROVED_STATUS_PENDING && (int)$course->status === DBConstant::COURSE_STATUS_OPEN) {
                \Log::info("Send event create course " . $course->course_id);
                $this->sendEvent('realtime', [
                    'url' => '/portal/courses',
                    'screen' => 'COURSE',
                    'id' => $course->course_id
                ]);
            }

            return [
                'success' => true,
                'course' => $course,
                'group' => $createCs['group'],
                'preview' => (int)$request->status === DBConstant::COURSE_STATUS_PREVIEW,
                'message' => trans('message.update_success'),
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function cleanCloneData(int $courseId)
    {
        DB::beginTransaction();
        try {

            // remove sub course with status = 10
            $subId = null;
            $sub = $this->repository
                ->where([
                    'parent_course_id' => $courseId,
                    'type' => DBConstant::COURSE_TYPE_SUB
                ])->first();
            if ($sub) {
                $subId = $sub->course_id;
            }

            // remove main schedule and sub course with status = 10
            $schedule = $this->courseScheduleRepository->whereIn('course_id', [$courseId, $subId])
                ->where('status', DBConstant::COURSE_SCHEDULES_STATUS_CLONE);
            $scheduleIds = $schedule->get()->pluck('course_schedule_id')->toArray();
            $schedule->delete();

            // remove image_paths of main schedule
            $this->imagePathRepository->whereIn('course_schedule_id', $scheduleIds)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}
