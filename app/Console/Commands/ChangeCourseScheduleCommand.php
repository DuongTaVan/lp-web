<?php

namespace App\Console\Commands;

use App\Services\Batch\CourseScheduleService;

class ChangeCourseScheduleCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'courses-schedule:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change course schedule status';

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
     * @param CourseScheduleService $service
     * @return mixed
     */
    public function handle(CourseScheduleService $service)
    {
        $data = $service->changeCourseSchedule();

//        if ($data['success']) {
////            $this->logInfo('Batch 04  success');
//        } else {
//            $this->logError('Batch 04  run failed: ' . $data['message']);
//        }

        return true;
    }
}
