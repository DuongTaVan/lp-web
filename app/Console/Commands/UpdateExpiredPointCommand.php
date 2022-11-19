<?php

namespace App\Console\Commands;

use App\Services\Batch\UserPointService;

class UpdateExpiredPointCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expired-point:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expired points batch';

    private $service;

    /**
     * InsertBoxNotificationCommand constructor.
     */
    public function __construct(UserPointService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle(): bool
    {
        $data = $this->service->batch05();
//        if ($data['success']) {
//            $this->logInfo('Batch 05 (Credit card capture batch) run success');
//        } else {
//            $this->logError('Batch 05 (Credit card capture batch) run failed: ' . $data['message']);
//        }
        return true;
    }
}
