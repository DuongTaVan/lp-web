<?php

namespace App\Repositories;

use App\Enums\DBConstant;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\NotificationSettingRepository;
use App\Models\NotificationSetting;
// use App\Validators\GiftValidator;

/**
 * Class NotificationSettingRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class NotificationSettingRepositoryEloquent extends BaseRepository implements NotificationSettingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return NotificationSetting::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Create default notification_setting of user
     *
     * @param $userId
     * @return mixed
     */
    public function createDefaultNotificationSetting($userId)
    {
        return $this->model->create([
           'user_id' => $userId,
           'message' => DBConstant::NOTIFICATION_SETTING_ENABLED,
           'followed_or_faved' => DBConstant::NOTIFICATION_SETTING_ENABLED,
           'special_offers' => DBConstant::NOTIFICATION_SETTING_ENABLED,
           'maintenance' => DBConstant::NOTIFICATION_SETTING_ENABLED
        ]);
    }
}
