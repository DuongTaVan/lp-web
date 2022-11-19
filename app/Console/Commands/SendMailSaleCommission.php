<?php

namespace App\Console\Commands;

use App\Services\Client\Teacher\UserService;
use Illuminate\Console\Command;

class SendMailSaleCommission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-mail-sale-commission:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically send an email when the first course is more than 60 days';

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
    public function handle(UserService $service)
    {
        $service->autoSendMailUser();
        return true;
    }
}
