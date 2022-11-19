<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SettlementRepository.
 *
 * @package namespace App\Repositories;
 */
interface SettlementRepository extends RepositoryInterface
{
    /**
     * Get Settlements Info.
     *
     * @param $courseScheduleId
     * @return mixed
     */
    public function getSettlementsInfo($courseScheduleId);

    /**
     * Update settlements.
     *
     * @param $str_payment_id
     * @param $amount
     * @return mixed
     */
    public function updateSettlements($strPaymentId, $amount);
}
