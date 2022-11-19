<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface EmailNotificationRepository.
 *
 * @package namespace App\Repositories;
 */
interface EmailNotificationRepository extends RepositoryInterface
{
    /**
     *  Get records to be sent.
     *
     * @return mixed
     */
    public function getRecordsToBeSent();
}
