<?php

namespace App\Console\Commands;

use App\Services\Batch\PurchaseService;

class CaptureCreditCardCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credit-card:capture';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Credit card capture batch';

    /**
     * Execute the console command.
     *
     * @param PurchaseService $service
     * @return bool
     */
    public function handle(PurchaseService $service): bool
    {
        $data = $service->batch03();

//        if ($data['success']) {
////            $this->logInfo('Batch 03 (Credit card capture batch) run success');
//        } else {
//            $this->logError('Batch 03 (Credit card capture batch) run failed: ' . $data['message']);
//        }

        return true;
    }
}
