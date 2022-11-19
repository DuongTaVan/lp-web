<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\DBConstant;
use App\Models\StripeLog;
use Carbon\Carbon;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PromotionRepositoryEloquent.
 */
class StripeLogRepositoryEloquent extends BaseRepository implements PromotionRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return StripeLog::class;
    }

    /**
     * @return int
     */
    public function getLastBalance(Carbon $date = null)
    {
        $balance = $this->model->orderBy('id', 'desc');
        if ($date) {
            $balance = $balance->where('created_at', '<=', $date->endOfDay());
        }
        $balance = $balance->first('balance');

        return $balance ? (int)$balance->balance : 0;
    }

    /**
     * @param int $amount
     * @param string $poId
     */
    public function whenPayout(int $amount, string $poId)
    {
        $this->model->create([
            'payout_id' => $poId,
            'balance' => $this->getLastBalance() - $amount,
            'type' => DBConstant::STRIPE_LOG_TYPE_OUT
        ]);
    }

    /**
     * @param int $amount
     */
    public function whenRefund(int $amount)
    {
        $this->model->create([
            'balance' => $this->getLastBalance() - $amount,
            'type' => DBConstant::STRIPE_LOG_TYPE_OUT
        ]);
    }
}
