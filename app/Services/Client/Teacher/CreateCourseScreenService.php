<?php

namespace App\Services\Client\Teacher;

use App\Enums\DBConstant;
use App\Exceptions\NoAccountException;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Services\BaseService;
use App\Services\Client\Common\CategoryService;
use App\Traits\ManageFile;

class CreateCourseScreenService extends BaseService
{
    private $categoryService;
    private $courseRepository;
    use ManageFile;

    public function __construct()
    {
        parent::__construct();
        $this->categoryService = app(CategoryService::class);
        $this->courseRepository = app(CourseRepository::class);
    }

    public function repository()
    {
        return CourseScheduleRepository::class;
    }

    /**
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed|null
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function redirectScreenCreate()
    {
        $user = auth()->guard('client')->user();
        if (!$user) {
            throw new NoAccountException();
        }
        $categories = $this->categoryService->getCategories($user->teacher_category);
        $qualifications = null;

        switch ($user->teacher_category) {
            case DBConstant::CATEGORY_TYPE_SKILLS:
                $screen = 'LIVESTREAM-1';
                break;
            case DBConstant::CATEGORY_TYPE_CONSULTATION:
                $screen = 'CONSULTATION';
                if ($user->qualifications) {
                    $qualifications = $categories->first();
                } else {
                    $categories = $categories->slice(1);
                }
                break;
            default:
                $screen = 'FORTUNE';
                break;
        }

        $this->initPreviewFile();

        return [
            'course' => null,
            'category' => $user->teacher_category,
            'screen' => $screen,
            'categories' => $categories,
            'qualifications' => $qualifications,
        ];
    }
}
