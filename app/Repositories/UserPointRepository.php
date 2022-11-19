<?php

declare(strict_types=1);

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserPointRepository.
 */
interface UserPointRepository extends RepositoryInterface
{
    /**
     * Get Current Points Balance.
     *
     * @param $userId
     * @return mixed
     */
    public function getCurrentPointsBalance($userId);

    /**
     * Get target point data.
     *
     * @param $userId
     * @return mixed
     */
    public function getTargetPoint($userId);

    /**
     * Get my page point data.
     *
     *
     * @return mixed
     */
    public function getMyPagePoint($params);
}
