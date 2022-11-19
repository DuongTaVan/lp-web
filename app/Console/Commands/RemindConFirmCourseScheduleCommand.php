<?php

namespace App\Console\Commands;

use App\Services\Client\Student\CourseScheduleService;
use Illuminate\Console\Command;

class RemindConFirmCourseScheduleCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'confirm-mail:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'mail notification of upcoming courses';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(CourseScheduleService $courseSchedule)
    {
        $courseSchedule->remindConFirmCourseSchedule();
        return true;
    }
}
