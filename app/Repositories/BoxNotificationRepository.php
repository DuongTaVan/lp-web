<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BoxNotificationRepository.
 *
 * @package namespace App\Repositories;
 */
interface BoxNotificationRepository extends RepositoryInterface
{
    /**
     * Get data box notification
     *
     * @param $data
     * @return array
     */
    public function getBoxNotificationList($data);

    /**
     *  Get box notification.
     * @return mixed
     */
    public function getBoxNotificationUnRead();

    /**
     * update read flag
     *
     * @param $boxNoticeIds
     * @return array
     */
    public function updateReadFlag(array $boxNoticeIds);

    /**
     * Get box notification
     *
     * @param $boxNotificationId
     * @return mixed
     */
    public function getBoxNotificationById($boxNotificationId);

    /**
     * Get notification list by option request
     *
     * @param $request
     *
     * @return mixed
     */
    public function getNotificationList($request);

    /**
     * Count unread notification.
     *
     * @return mixed
     */
    public function getUnReadNotification();
}
