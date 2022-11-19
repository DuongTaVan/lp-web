<?php

declare(strict_types=1);

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CashRepository.
 */
interface CashRepository extends RepositoryInterface
{
    /**
     * Get Current Cash Balance.
     *
     * @param $userId
     * @return mixed
     */
    public function getCurrentCashBalance($userId);

    /**
     * Get total balance.
     *
     * @return mixed
     */
    public function getTotalBalance();

    /**
     * Get transfer record.
     *
     * @param $data
     * @return mixed
     */
    public function transferRecord($data);

    /**
     * Get transfer record last day.
     *
     * @return mixed
     */
    public function transferRecordLastDay();

    /**
     * Get transfer record user.
     *
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    public function transferRecordUser($startDate, $endDate);

    /**
     * Get transfer record user last month.
     *
     * @return mixed
     */
    public function transferRecordUserLastMonth();

    /**
     * Get transfer record last month.
     *
     * @return mixed
     */
    public function transferRecordLastMonth($startDate, $endDate);
}
