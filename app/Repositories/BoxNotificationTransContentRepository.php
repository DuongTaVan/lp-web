<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BoxNotificationTransContentRepository.
 *
 * @package namespace App\Repositories;
 */
interface BoxNotificationTransContentRepository extends RepositoryInterface
{
    /**
     * Get List Box Notification
     *
     * @param  mixed $request
     * @return void
     */
    public function getListBoxNotification($request);
}
