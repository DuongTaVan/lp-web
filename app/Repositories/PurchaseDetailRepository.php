<?php

declare(strict_types=1);

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PurchaseDetailRepository.
 */
interface PurchaseDetailRepository extends RepositoryInterface
{
    /**
     * Get Data Detail.
     *
     * @param $courseScheduleId
     * @return mixed
     */
    public function getDataDetail($courseScheduleId);

    /**
     * Get option sales.
     *
     * @param $request
     * @param mixed $courseScheduleId
     * @return mixed
     */
    public function getOptionSales($courseScheduleId);
}
