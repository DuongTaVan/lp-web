<?php

declare(strict_types=1);

namespace App\Services\Common;

use App\Enums\DBConstant;
use App\Repositories\SaleRepository;
use App\Repositories\StripeLogRepository;
use App\Services\BaseService;
use Stripe\StripeClient;

class StripeLogService extends BaseService
{
    private $stripeClient;
    private $saleRepository;
    /**
     * RepeaterCheckService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->stripeClient = new StripeClient(config('app.stripe_secret'));
        $this->saleRepository = app(SaleRepository::class);
    }
    /**
     * @return string
     */
    public function repository()
    {
        return StripeLogRepository::class;
    }

    /**
     * @param $payload
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function addAmount($payload)
    {
        $fee = $this->stripeClient->balanceTransactions->retrieve($payload->charges->data[0]->balance_transaction);
        if ($fee && $fee->net) {
            $this->repository->create([
                'balance' => $this->repository->getLastBalance() + $fee->net,
                'type' => DBConstant::STRIPE_LOG_TYPE_IN
            ]);
        }
    }

    /**
     * @param $payload
     */
    public function payout($payload)
    {
        $lastDatePayout = now()->day >= 22 ? now()->setDay(16) : now()->setDay(1);
        $this->repository->create([
            'payout_id' => $payload->id,
            'balance' => $this->repository->getLastBalance() - $this->repository->getLastBalance($lastDatePayout->subDays()),
            'type' => DBConstant::STRIPE_LOG_TYPE_OUT
        ]);
        $this->saleRepository
            ->where('payout_id', $payload->id)
            ->update(['payout_status' => DBConstant::SALE_PAYOUT]);
    }
}
