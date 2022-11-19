<?php

declare(strict_types=1);

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface FollowRepository.
 */
interface FollowRepository extends RepositoryInterface
{
    /**
     * Get list follow.
     * @param  $param
     * @return mixed
     */
    public function myPageFollowList($param);

    /**
     * Get Follow By UserId.
     * @return mixed
     */
    public function getFollowByUserId($request);

    /**
     * Get totalFollow By UserId.
     * @return mixed
     */
    public function getTotalFollowByUserId();

    /**
     * Get Count Follow.
     *
     * @param $userId
     * @return mixed
     */
    public function getCountFollow($userId);

    /**
     * Get follow in month.
     *
     * @param $userId
     * @param $data
     * @return mixed
     */
    public function getCountFollowInMonth($userId, $data);
}
