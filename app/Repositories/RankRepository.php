<?php

declare(strict_types=1);

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface RankRepository.
 */
interface RankRepository extends RepositoryInterface
{
    /**
     * Get Rank Data.
     *
     * @return mixed
     */
    public function getRankData();
}
