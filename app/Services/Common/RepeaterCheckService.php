<?php

declare(strict_types=1);

namespace App\Services\Common;

use App\Enums\DBConstant;
use App\Repositories\ApplicantRepository;
use App\Repositories\ApplicantRepositoryEloquent;
use App\Repositories\CourseRepository;
use App\Services\BaseService;

class RepeaterCheckService extends BaseService
{
    public $courseRepository;

    public $applicantRepository;

    /**
     * RepeaterCheckService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->courseRepository = app(CourseRepository::class);
        $this->applicantRepository = app(ApplicantRepository::class);
    }

    /**
     * @return string
     */
    public function repository()
    {
        return ApplicantRepositoryEloquent::class;
    }

    /**
     * Service check repeater.
     *
     * @param $userId
     * @param $courseScheduleId
     */
    public function checkRepeater($userId, $courseScheduleId)
    {
        $isLappiNew = DBConstant::IS_LAPPI_NEW;
        $isLappiRepeater = DBConstant::IS_NOT_LAPPI_REPEATER;
        $lappiRepeaterCount = 0;

        $isTeacherNew = DBConstant::IS_TEACHER_NEW;
        $isTeacherRepeater = DBConstant::IS_NOT_TEACHER_REPEATER;
        $lappiTeacherCount = 0;

        $countLappiRepeater = $this->repository->countApplicantByUserId($userId);

        // Check lappi repeater.
        if (!empty($countLappiRepeater) && $countLappiRepeater['count'] > 0) {
            $isLappiNew = DBConstant::IS_NOT_LAPPI_NEW;
            $isLappiRepeater = DBConstant::IS_LAPPI_REPEATER;
            $lappiRepeaterCount = $countLappiRepeater['count'];
        }

        //Get teacher of course schedule.
        $teacher = $this->courseRepository->getTeacherOfCourseSchedule($courseScheduleId);

        if ($teacher) {
            // Check teacher repeater.
            $countTeacherRepeater = $this->repository->countTeacherByUserId($userId, $teacher['teacher']);

            if (!empty($countTeacherRepeater) && $countTeacherRepeater['count'] > 0) {
                $isTeacherNew = DBConstant::IS_NOT_TEACHER_NEW;
                $isTeacherRepeater = DBConstant::IS_TEACHER_REPEATER;
                $lappiTeacherCount = $countTeacherRepeater['count'];
            }
        }

        return [
            'is_lappi_new' => $isLappiNew,
            'is_lappi_repeater' => $isLappiRepeater,
            'lappi_repeat_count' => $lappiRepeaterCount,
            'is_teacher_new' => $isTeacherNew,
            'is_teacher_repeater' => $isTeacherRepeater,
            'lappi_teacher_count' => $lappiTeacherCount,
        ];
    }
}
