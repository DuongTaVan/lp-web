<?php

namespace App\Services\Client\Common;

use App\Repositories\CourseScheduleRepository;
use Carbon\Carbon;

class CourseScheduleService
{
    private $csRepository;

    public function __construct()
    {
        $this->csRepository = app(CourseScheduleRepository::class);
    }

    public function addTimeActual($courseScheduleId)
    {
        $cs = $this->csRepository
            ->select(
                'courses.user_id',
                'course_schedules.course_schedule_id',
                'course_schedules.minutes_required',
                'course_schedules.start_datetime',
                'course_schedules.end_datetime',
                'course_schedules.actual_start_date',
                'course_schedules.actual_end_date'
            )
            ->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->where('course_schedule_id', $courseScheduleId)
            ->first();
        if (!$cs) {
            return false;
        }
        if (!$cs->actual_start_date && ($cs->start_datetime < now()->subMinutes(15))) {
            return [
                'isCancel' => true
            ];
        }

        //update actual start date when teacher join course
        \Log::info('Log time', ['now' => now(), 'start' => $cs->start_datetime, 'if' => now()->gt(now()->parse($cs->start_datetime))]);
        if (!$cs->actual_start_date &&
            $cs->user_id === auth('client')->id() &&
            now()->addSecond()->gte(now()->parse($cs->start_datetime))
        ) {
            $this->csRepository->update([
                'actual_start_date' => now(),
                'actual_end_date' => now()->addMinutes($cs->minutes_required)
            ], $cs->course_schedule_id);
            $cs->actual_start_date = now();
            $cs->actual_end_date = now()->addMinutes($cs->minutes_required);
        }

        return [
            'start' => $cs->actual_start_date ?: $cs->start_datetime,
            'end' => $cs->actual_end_date ?: $cs->end_datetime,
            'isCancel' => !$cs->actual_start_date && ($cs->start_datetime < now()->subMinutes(15)),
            'tokenOk' => (bool)$cs->actual_start_date
        ];
    }
}
