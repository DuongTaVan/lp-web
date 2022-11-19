<?php

declare(strict_types=1);

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface FavoriteRepository.
 */
interface FavoriteRepository extends RepositoryInterface
{
    /**
     * Get Count Course Schedule.
     *
     * @return mixed
     */
    public function getCountCourseSchedule();

    /**
     * Get like sub courses.
     *
     * @return mixed
     */
    public function getLikeSubCourse($listCourseScheduleId, $data);
}
