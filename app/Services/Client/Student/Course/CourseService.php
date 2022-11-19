<?php

namespace App\Services\Client\Student\Course;

use App\Repositories\CourseRepository;
use App\Services\BaseService;

class CourseService extends BaseService
{
    /**
     * @return string
     */
    public function repository()
    {
        return CourseRepository::class;
    }

    /**
     * Get course.
     *
     * @param Integer $id
     * @return mixed
     */
    public function getCourse($id)
    {
        return $this->repository
            ->join('course_schedules as cs', 'courses.course_id', '=', 'cs.course_id')
            ->where('courses.course_id', '=', $id)
            ->firstOrFail();
    }
}
