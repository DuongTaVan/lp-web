<?php

declare(strict_types=1);

namespace App\Services\Client\BoxNotification;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Repositories\BoxNotificationRepositoryEloquent;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;

class BoxNotificationService extends BaseService
{
    /**
     * @return string
     */
    public function repository()
    {
        return BoxNotificationRepositoryEloquent::class;
    }

    /**
     * Get List Box Notification.
     *
     * @return array
     */
    public function getListBoxNotification($request)
    {
        // Check user exist.
        if (!Auth::guard('client')->check()) {
            return __('errors.MSG_5023');
        }

        $user = auth()->guard('client')->user()->user_id;

        // Get box notification list
        $boxNotifications = $this->repository->getBoxNotificationList($user);

        return $boxNotifications;

    }

    /**
     * Get Notification Unread
     *
     * @return mixed
     */
    public function listNotificationUnread()
    {
        return $this->repository->getBoxNotificationUnRead();
    }

    /**
     * Get box notification detail
     *
     * @param $boxNotificationId
     * @return array
     */
    public function show($boxNotificationId)
    {
        $notice = $this->repository->getBoxNotificationById($boxNotificationId);
        // Update read flag
        $this->repository->update(['is_read' => DBConstant::BOX_NOTIFICATION_IS_READ['read']], $boxNotificationId);

        return $notice;
    }

    /**
     * Update read flag.
     *
     * @return mixed
     */
    public function updateReadBoxNotice($request)
    {
        if (!empty($request->noticeId)) {

            $noticeId = explode(',', $request->noticeId);

            return $this->repository->updateReadFlag($noticeId);
        } else{
            return $this->repository->updateReadFlag([]);
        }
    }


}
