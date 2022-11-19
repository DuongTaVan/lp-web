<?php

namespace App\Services\Client\Teacher;

use App\Enums\DBConstant;
use App\Exceptions\NoAccountException;
use App\Repositories\CourseScheduleRepository;
use App\Services\BaseService;
use App\Services\Client\Common\CategoryService;
use App\Traits\CourseImageTrait;
use App\Traits\ManageFile;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class UpdateCourseScheduleViewService extends BaseService
{
    private $categoryService;
    private $courseService;
    private $imagePathRepository;
    use ManageFile, CourseImageTrait;

    public function __construct()
    {
        parent::__construct();
        $this->categoryService = app(CategoryService::class);
    }

    public function repository()
    {
        return CourseScheduleRepository::class;
    }

    /**
     * @param int|null $id
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed|null
     */
    public function show(int $id)
    {
        $user = auth('client')->user();
        if (!$user) {
            throw new NoAccountException();
        }
        $courseSchedule = $this->repository->getDetail($id);
        $course = $courseSchedule->course;
        if ($courseSchedule->course->type === DBConstant::COURSE_TYPE_SUB) {
            $course = $courseSchedule->course->courseParent;
            $isSubCourse = true;
        }
        $this->getImagesOfSchedule($courseSchedule);

        try {
            $this->initPreviewScheduleFile($courseSchedule);
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
        }
        $countExtensionPublic = $course->extensions->where('status', DBConstant::COURSE_STATUS_DRAFT)->count();
        $maxExtension = DBConstant::MAX_EXTENSION - $countExtensionPublic;
        return [
            'courseSchedule' => $courseSchedule,
            'subCourse' => $isSubCourse ?? false,
            'category' => $course->category,
            'course' => $course,
            'categories' => $this->categoryService->getCategories($user->teacher_category),
            'maxExtension' => $maxExtension
        ];
    }
}
