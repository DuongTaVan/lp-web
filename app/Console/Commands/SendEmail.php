<?php

namespace App\Console\Commands;

use App\Services\Batch\EmailNotificationService;

class SendEmail extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail notification';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param EmailNotificationService $service
     * @return bool
     */
    public function handle(EmailNotificationService $service): bool
    {
        $data = $service->sendMail();

//        if ($data['success']) {
////            $this->logInfo('Batch 02 (Email sending batch)  run success');
//        } else {
//            $this->logError('Batch 02 (Email sending batch) run failed: ' . $data['message']);
//        }

        return true;
    }
}
