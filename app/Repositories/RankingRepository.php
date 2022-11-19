<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface RankingRepository.
 *
 * @package namespace App\Repositories;
 */
interface RankingRepository extends RepositoryInterface
{
    /**
     * Get course popular in category
     *
     * @param $category
     * @return mixed
     */
    public function getPopularCoursesInCategory($category);
}
