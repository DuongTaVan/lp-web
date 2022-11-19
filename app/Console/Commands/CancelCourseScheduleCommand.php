<?php

namespace App\Console\Commands;

use App\Services\Client\Student\CourseScheduleService;
use Illuminate\Console\Command;

class CancelCourseScheduleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel-courses-schedules:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically cancel the class schedule when the teacher joins the course after 15 minutes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param CourseScheduleService $courseSchedule
     * @return bool
     */
    public function handle(CourseScheduleService $courseSchedule)
    {
        $courseSchedule->autoCancelCourseSchedule();
        return true;
    }
}
