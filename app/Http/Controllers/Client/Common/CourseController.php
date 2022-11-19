<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Course\CourseCommonRequest;
use App\Services\Client\Common\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Search courses.
     *
     * @param Request $request
     * @param CourseService $service
     * @return array
     */
    public function listCourse(CourseCommonRequest $request, CourseService $service)
    {
        return $result = $service->searchCourse($request);
    }
}
