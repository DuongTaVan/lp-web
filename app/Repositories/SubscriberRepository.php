<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface SubscriberRepository.
 *
 * @package namespace App\Repositories;
 */
interface SubscriberRepository extends RepositoryInterface
{
    /**
     * Insert data subscriber
     *
     * @param $authUserId
     * @param $userId
     * @return mixed
     */
    public function insertDataSubscriber($authUserId, $userId);
}
