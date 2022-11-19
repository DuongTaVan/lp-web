<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface NotificationSettingRepository.
 *
 * @package namespace App\Repositories;
 */
interface NotificationSettingRepository extends RepositoryInterface
{
    /**
     * Create default notification_setting of user
     *
     * @param $userId
     * @return mixed
     */
    public function createDefaultNotificationSetting($userId);
}
