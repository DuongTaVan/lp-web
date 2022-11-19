<?php

namespace App\Console\Commands;

use App\Services\Batch\BoxNotificationTransContentService;

class InsertBoxNotificationCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'box-notification:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Box notification records creation batch';

    private $service;
    /**
     * InsertBoxNotificationCommand constructor.
     */
    public function __construct(BoxNotificationTransContentService $service)
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
        $data = $this->service->batch01();

//        if ($data['success']) {
////            $this->logInfo('Batch 01 (Box notification records creation batch) run success');
//        } else {
//            $this->logError('Batch 01 (Box notification records creation batch) run failed: ' . $data['message']);
//        }

        return true;
    }
}
