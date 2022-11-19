<?php

namespace App\Services\Client\Student;

use Illuminate\Support\Facades\Auth;
use App\Repositories\NotificationSettingRepository;
use App\Services\BaseService;
use App\Enums\DBConstant;

class MyPageNotiSettingService extends BaseService
{
    /**
     * Follow repository class
     *
     * @return string
     */
    public function repository()
    {
        return NotificationSettingRepository::class;
    }

    /**
     * Get notification setting
     *
     * @return mixed
     */
    public function getNotifySetting($userId)
    {
        try {

            return $this->repository->where('user_id', $userId)->first();
        } catch (\Exception $exception) {

            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }

    /**
     * create or update notification setting
     *
     * @return mixed
     */
    public function settingNotify($data)
    {
        $userId = Auth::guard('client')->user()->user_id;
        try {
            $this->repository->updateOrCreate(['user_id' => $userId], $data);

            return [
                'success' => true
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }
}
