<?php

namespace App\Services\Client\Teacher;

use App\Enums\DBConstant;
use App\Exceptions\NoAccountException;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\ImagePathRepository;
use App\Repositories\OptionalExtraMappingRepository;
use App\Repositories\OptionalExtraRepository;
use App\Services\BaseService;
use App\Services\Client\Common\CategoryService;
use App\Traits\ManageFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CloneCourseScreenService extends BaseService
{
    private $categoryService;
    private $imagePathRepository;
    private $courseRepository;
    private $oemRepository;
    private $oeRepository;
    use ManageFile;

    public function __construct()
    {
        parent::__construct();
        $this->categoryService = app(CategoryService::class);
        $this->courseRepository = app(CourseRepository::class);
        $this->imagePathRepository = app(ImagePathRepository::class);
        $this->oemRepository = app(OptionalExtraMappingRepository::class);
        $this->oeRepository = app(OptionalExtraRepository::class);
    }

    public function repository()
    {
        return CourseScheduleRepository::class;
    }

    public function cleanCloneData(int $courseId)
    {
        DB::beginTransaction();
        try {

            // remove sub course with status = 10
            $subId = null;
            $sub = $this->courseRepository
                ->where([
                    'parent_course_id' => $courseId,
                    'type' => DBConstant::COURSE_TYPE_SUB
                ])->first();
            if ($sub) {
                $subId = $sub->course_id;
            }

            // remove main schedule and sub course with status = 10
            $schedule = $this->repository->whereIn('course_id', [$courseId, $subId])
                ->where('status', DBConstant::COURSE_SCHEDULES_STATUS_CLONE);
            $scheduleIds = $schedule->get()->pluck('course_schedule_id')->toArray();
            $schedule->delete();

            // remove image_paths of main schedule
            $this->imagePathRepository->whereIn('course_schedule_id', $scheduleIds)->delete();

            // remove extension with status = 10
            $this->courseRepository
                ->where([
                    'parent_course_id' => $courseId,
                    'type' => DBConstant::COURSE_TYPE_EXTENSION,
                    'status' => DBConstant::COURSE_SCHEDULES_STATUS_CLONE
                ])->delete();

            // remove option with status = 10
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    /**
     * @param int|null $courseId
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed|null
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getData(int $courseId)
    {
        $user = auth('client')->user();
        if (!$user) {
            throw new NoAccountException();
        }
        $course = $this->courseRepository
            ->where([
                'course_id' => $courseId,
                'user_id' => $user['user_id'],
            ])
            ->with(['imagePaths', 'category'])
            ->with(['courseSchedules' => function ($q) {
//                if (isset($createdAt)) {
//                    $q->where([
//                        'status' => DBConstant::COURSE_SCHEDULES_STATUS_DRAFT,
//                        'created_at' => $createdAt
//                    ]);
//                } else {
                $q->where('status', DBConstant::COURSE_SCHEDULES_STATUS_CLONE);
//                }
            }])
            ->withCount(['courseSchedules' => function ($q) {
                $q->whereIn('status', [DBConstant::COURSE_SCHEDULES_STATUS_OPEN, DBConstant::COURSE_SCHEDULES_STATUS_DRAFT])
                    ->where('purchase_deadline', '>', now())
                    ->whereRaw('fixed_num > num_of_applicants');
            }])
            ->withCount(['subCourse' => function ($q) {
                $q->where('status', DBConstant::COURSE_SCHEDULES_STATUS_OPEN)
                    ->where('is_hidden', DBConstant::COURSE_IS_HIDDEN_OPEN);
            }])
            ->with('subCourse')
            ->with(['extensions' => function ($q) {
//                if (isset($createdAt)) {
//                    $q->where([
//                        'status' => DBConstant::COURSE_SCHEDULES_STATUS_DRAFT,
//                        'created_at' => $createdAt
//                    ]);
//                } else {
                $q->where(function ($query) {
                    $query->where('status', DBConstant::COURSE_SCHEDULES_STATUS_CLONE)
                        ->orWhere('status', DBConstant::COURSE_SCHEDULES_STATUS_OPEN);
                })
                    ->where('is_hidden', DBConstant::COURSE_IS_HIDDEN_OPEN);
//                }
            }])
            ->withCount(['extensions' => function ($q) {
//                if (isset($createdAt)) {
//                    $q->where('status', DBConstant::COURSE_SCHEDULES_STATUS_OPEN);
//                    $q->where('is_hidden', DBConstant::COURSE_IS_HIDDEN_OPEN);
//                } else {
                $q->where('status', DBConstant::COURSE_SCHEDULES_STATUS_DRAFT);
                $q->where('is_hidden', DBConstant::COURSE_IS_HIDDEN_OPEN);
//                }
            }])
            ->firstOrFail();
        $csCloneIds = $course->courseSchedules->pluck('course_schedule_id')->toArray();
        $optionalExtras = [];
        if (count($csCloneIds)) {
            $oemIds = $this->oemRepository->whereIn('course_schedule_id', $csCloneIds)
                ->pluck('optional_extra_id')
                ->toArray();
            if ($oemIds) {
                $optionalExtras = $this->oeRepository->whereIn('optional_extra_id', $oemIds)->get();
            }
        }
        // count subcourse
        $subCourse = $this->courseRepository->getModel()->where([
            'parent_course_id' => $courseId,
            'type' => DBConstant::COURSE_TYPE_SUB,
            'status' => DBConstant::COURSE_STATUS_OPEN
        ])->first();
        $countSubCourseSchedule = 0;
        if ($subCourse) {
            $countSubCourseSchedule = $this->repository
                ->getModel()->where([
                    'course_id' => $subCourse->course_id
                ])->whereIn('status', [DBConstant::COURSE_SCHEDULES_STATUS_OPEN, DBConstant::COURSE_SCHEDULES_STATUS_DRAFT])->count();
        }
        $course->maxSubCanCreate = DBConstant::MAX_SUB_COURSE - $countSubCourseSchedule;
        $course->optionalExtras = $optionalExtras;
        $course->extensionPreview = $course->extensions;
        $this->initPreviewFile($course);
        $course->maxScheduleCanCreate = DBConstant::MAX_COURSE_SCHEDULE - $course->course_schedules_count;
        $course->maxOptionCanCreate = DBConstant::MAX_OPTION;
        $course->maxExtensionCanCreate = $course->extensions_count > DBConstant::MAX_EXTENSION ? 0 : (DBConstant::MAX_EXTENSION - $course->extensions_count);

        return [
            'courseId' => $courseId,
            'course' => $course,
            'category' => $user->teacher_category,
        ];
    }
}
