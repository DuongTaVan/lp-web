<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\Batch\StatisticsService;
use Illuminate\Console\Command;

class CreateStatisticsCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistics:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating data for statistics batch';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param StatisticsService $service
     * @return bool
     */
    public function handle(StatisticsService $service)
    {
        $data = $service->createStatistics();

//        if ($data['success']) {
//            $this->logInfo('Batch 08 (Statistics batch)  run success');
//        } else {
//            $this->logError('Batch 08 (Statistics batch) run failed: ' . $data['message']);
//        }

        return true;
    }
}
