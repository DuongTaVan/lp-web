<?php

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Settlement;

/**
 * Class SettlementRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SettlementRepositoryEloquent extends BaseRepository implements SettlementRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Settlement::class;
    }

    /**
     * Get Stripe settlements which haven't been captured.
     *
     * @param $courseScheduleId
     * @return mixed
     */
    public function getDataNotCapture($courseScheduleId)
    {
        return $this->model->join(
            'purchases as p', 'settlements.purchase_id', '=', 'p.purchase_id'
        )->where([
            'settlements.status' => DBConstant::PAYMENT_STATUS_APPROVED, // 1631
            'p.course_schedule_id' => $courseScheduleId,
            'p.status' => DBConstant::PURCHASES_STATUS_NOT_CAPTURED,
            'p.canceled_at' => null
        ])->get();
    }

    /**
     * Get Settlements Info.
     *
     * @param $courseScheduleId
     * @return mixed|void
     */
    public function getSettlementsInfo($courseScheduleId)
    {
        return $this->model
            ->join('purchases as p', 'settlements.purchase_id', '=', 'p.purchase_id')
            ->where([
                'p.user_id' => auth('client')->user()->user_id,
                'p.course_schedule_id' => $courseScheduleId,
                'settlements.status' => DBConstant::SETTLEMENT_STATUS_APPROVED,
            ])->first();
    }

    /**
     * Update settlements
     *
     * @param $str_payment_id
     * @param $timestamp
     * @return mixed
     */
    public function updateSettlements($strPaymentId, $amount)
    {
        return $this->model->where('str_payment_id', $strPaymentId)->first()->update([
            'status' => Constant::STATUS_CARD_CANCEL,
            'canceled_at' => now(),
            'canceled_amount' => $amount
        ]);
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
