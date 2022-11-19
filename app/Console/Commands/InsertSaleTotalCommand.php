<?php

namespace App\Console\Commands;

use App\Services\Batch\SaleService;

class InsertSaleTotalCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sale-total:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sales total batch';

    /**
     * Execute the console command.
     *
     * @param SaleService $service
     * @return bool
     */
    public function handle(SaleService $service): bool
    {
        $data = $service->batch07();

//        if ($data['success']) {
//            $this->logInfo('Batch 07 (Sales total batch) run success');
//        } else {
//            $this->logError('Batch 07 (Sales total batch) run failed: ' . $data['message']);
//        }

        return true;
    }
}
