<?php

declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\InsertBoxNotificationCommand',
        'App\Console\Commands\UpdateExpiredPointCommand',
        'App\Console\Commands\InsertRankingCommand',
        'App\Console\Commands\ChangeCourseScheduleCommand',
        'App\Console\Commands\CreateStatisticsCommand',
        'App\Console\Commands\SendEmail',
        'App\Console\Commands\ChangeTeacherRankCommand',
        'App\Console\Commands\RemindConFirmCourseScheduleCommand',
        'App\Console\Commands\InsertSaleTotalCommand',
        'App\Console\Commands\CancelCourseScheduleCommand',
        'App\Console\Commands\SendMailSaleCommission',
        'App\Console\Commands\AutoPayoutTeacher',
        'App\Console\Commands\AutoPayoutLappi',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('payout-teacher:run')->cron('0 0 1,16 * *');
        $schedule->command('payout-lappi:run')->cron('0 0 10,22 * *');
        $schedule->command('telescope:prune --hours=24')->daily();
        $schedule->command('box-notification:insert')->everyMinute(); // batch 1
        $schedule->command('send:mail')->everyMinute(); // batch 2
        $schedule->command('credit-card:capture')->everyMinute(); //batch 3
        $schedule->command('courses-schedule:change')->everyMinute(); // batch 4
        $schedule->command('expired-point:update')->dailyAt('00:30'); // batch 5
        $schedule->command('ranking:insert')->dailyAt('05:00'); // batch 6
        $schedule->command('sale-total:insert')->dailyAt('03:00'); // batch 7
        $schedule->command('statistics:create')->dailyAt('04:00'); //batch 8
        $schedule->command('teacher-rank:change')->monthlyOn(1, '00:00'); // batch 9
        $schedule->command('confirm-mail:change')->dailyAt('13:00'); // remind confirm email course-schedule
        $schedule->command('cancel-courses-schedules:change')->everyMinute(); // automatic cancel course schedules when teacher join later.
        $schedule->command('send-mail-sale-commission:change')->dailyAt('00:00'); //automatically sent at 00:00 o'clock
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
