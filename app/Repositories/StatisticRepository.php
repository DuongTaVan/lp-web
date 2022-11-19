<?php

declare(strict_types=1);

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface StatisticRepository.
 */
interface StatisticRepository extends RepositoryInterface
{
    /**
     * Get data of statistics.
     *
     * @param $categoryId
     * @return mixed
     */
    public function getDataOfStatistics($categoryId);

    /**
     * Insert data into statistics.
     *
     * @param $data
     * @return mixed
     */
    public function insertStatistics($data);
}
