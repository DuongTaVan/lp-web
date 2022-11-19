<?php

namespace App\Services\Client\Teacher;

use App\Enums\DBConstant;
use App\Exceptions\NoAccountException;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\ImagePathRepository;
use App\Services\BaseService;
use App\Services\Client\Common\CategoryService;
use App\Traits\ManageFile;
use Illuminate\Http\Request;

class ShowCourseService extends BaseService
{
    private $categoryService;
    private $courseRepository;
    private $imagePathRepository;
    use ManageFile;

    public function __construct()
    {
        parent::__construct();
        $this->categoryService = app(CategoryService::class);
        $this->courseRepository = app(CourseRepository::class);
        $this->imagePathRepository = app(ImagePathRepository::class);
    }

    public function repository()
    {
        return CourseScheduleRepository::class;
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getDataGroup(int $courseId, Request $request)
    {
        $user = auth('client')->user();
        $course = $this->courseRepository->getCourseDataWithGroup($courseId, $request);
        $course->extensionPreview = $course->extensionsPreview;
        $image = $this->imagePathRepository->where('course_schedule_id', $course->course_schedule_id)->first();
        if (!empty($request->type) && $request->type === 'draft') {
            if (isset($course->subCourse)) {
                $course->subCourse->courseSchedulesSub = $course->subCourse->courseSchedules;
            }

        }
        if ($image) {
            $this->initPreviewScheduleFile($course->courseSchedules->first());
            $course->optionalExtras = $course->courseSchedules->first()->optionalExtras;
        } else {
            $this->initPreviewFile($course);
        }

        $countSubNotInGroup = $this->repository->getScheduleNotInGroup($courseId, $request);
        $countExtensionNotInGroup = $this->courseRepository->getScheduleExtensionNotInGroup($courseId, $request);
        $course->maxScheduleCanCreate = DBConstant::MAX_COURSE_SCHEDULE - $course->course_schedules_count;
        $course->maxOptionCanCreate = DBConstant::MAX_OPTION;
//        $course->maxSubCanCreate = DBConstant::MAX_SUB_COURSE - ($course->subCourse ? $course->subCourse->courseSchedulesNotClose->count() : 0);
        $course->maxSubCanCreate = DBConstant::MAX_SUB_COURSE - $countSubNotInGroup;
//        $course->maxExtensionCanCreate = DBConstant::MAX_EXTENSION - $course->extensions_count;
        $course->maxExtensionCanCreate = DBConstant::MAX_EXTENSION - $countExtensionNotInGroup + ($course->extensionPreview->count() ?? 0);
        if ($course->approval_status === DBConstant::COURSE_NOT_REVIEW) {
            $categories = $this->categoryService->getCategories($user->teacher_category);
        }
        return [
            'courseId' => $courseId,
            'course' => $course,
            'category' => $user->teacher_category,
            'categories' => $categories ?? null
        ];
    }

    /**
     * @param int $courseId
     * @param Request $request
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getData(int $courseId, Request $request)
    {
        $user = auth('client')->user();
        $isClone = $request->isClone;
        if (!$user) {
            throw new NoAccountException();
        }
        $course = $this->courseRepository
            ->where([
                'course_id' => $courseId,
                'user_id' => $user['user_id'],
            ])
            ->with(['imagePaths', 'category'])
            ->withCount(['courseSchedules' => function ($q) {
                $q->whereIn('status', [DBConstant::COURSE_SCHEDULES_STATUS_OPEN, DBConstant::COURSE_SCHEDULES_STATUS_DRAFT])
                    ->where('purchase_deadline', '>', now())
                    ->whereRaw('fixed_num > num_of_applicants');
            }])
            ->with(['courseSchedules' => function ($q) use ($isClone) {
                if ($isClone) {
                    $q->where('status', DBConstant::COURSE_SCHEDULES_STATUS_CLONE);
                }
            }])
            ->with(['subCourse' => function ($q) use ($isClone) {
                $q->with(['courseSchedules' => function ($q2) use ($isClone) {
                    if ($isClone) {
                        $q2->where('status', DBConstant::COURSE_SCHEDULES_STATUS_CLONE);
                    }
                }]);
            }])
            ->withCount('extensions')
            ->withCount('subCourse')
            ->firstOrFail();

        $firstSchedule = $course->courseSchedules->first();
        if ($isClone && $firstSchedule) {
            $this->initPreviewScheduleFile($firstSchedule);
            // map schedule to course
            $course->title = $firstSchedule->title;
            $course->subtitle = $firstSchedule->subtitle;
            $course->body = $firstSchedule->body;
            $course->flow = $firstSchedule->flow;
            $course->cautions = $firstSchedule->cautions;
            $course->minutes_required = $firstSchedule->minutes_required;
            $course->price = $firstSchedule->price;
            $course->is_mask_required = $firstSchedule->is_mask_required;
        } else {
            $this->initPreviewFile($course);
        }
        $course->maxScheduleCanCreate = DBConstant::MAX_COURSE_SCHEDULE - $course->course_schedules_count;
        $course->maxOptionCanCreate = DBConstant::MAX_OPTION - $course->extensions_count;
        $course->maxSubCanCreate = DBConstant::MAX_SUB_COURSE - ($course->subCourse ? $course->subCourse->courseSchedulesNotClose->count() : 0);
        if (!$isClone) {
            $course->maxExtensionCanCreate = DBConstant::MAX_EXTENSION;
        }
        if ($course->approval_status === DBConstant::COURSE_NOT_REVIEW) {
            $categories = $this->categoryService->getCategories($user->teacher_category);
        }

        return [
            'courseId' => $courseId,
            'course' => $course,
            'category' => $user->teacher_category,
            'categories' => $categories ?? null
        ];
    }
}
