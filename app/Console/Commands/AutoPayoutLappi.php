<?php

namespace App\Console\Commands;

use App\Services\Batch\PurchaseService;

class AutoPayoutLappi extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payout-lappi:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto payout LAPPI';

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
     * @param PurchaseService $service
     * @return bool
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function handle(PurchaseService $service): bool
    {
        $service->tranferOutLappi();

        return true;
    }
}
