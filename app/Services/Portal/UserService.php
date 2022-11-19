<?php

namespace App\Services\Portal;

use App\Enums\DBConstant;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService
{
    /**
     * User repository class
     *
     * @return string
     */
    public function repository()
    {
        return UserRepository::class;
    }

    /**
     * Get list user
     *
     * @param $request
     * @return mixed
     */
    public function getData($request)
    {
        $users = $this->repository->showUserList($request);
        $total['sum_cash_balance'] = 0;
        $total['sum_points_balance'] = 0;
        foreach ($users as $user) {
            $total['sum_cash_balance'] += $user->cash_balance;
            $total['sum_points_balance'] += $user->points_balance;
        }

        return [
            'users' => $users,
            'total' => $total
        ];
    }

    /**
     * Get user detail.
     *
     * @param $userId
     * @return mixed
     */
    public function getUserDetail($userId)
    {
        $user = $this->repository->getUserDetail($userId);

        // Set appends attribute in model
        if ($user) {
            $user->setAppends([
                'user_type_text',
                'teacher_category_text',
                'sex_text',
                'login_type_text',
                'identity_verification_status_text',
                'business_card_verification_status_text',
                'year_of_birth',
                'account_type_text',
                'nda_status_text'
            ]);
        }

        return $user;
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        if ($this->user_type == DBConstant::USER_TEACHER && $this->name_use == DBConstant::USER_REALNAME) {
            return "{$this->last_name_kanji} {$this->first_name_kanji}";
        }

        return $this->nickname;
    }

    /**
     * Get user not approve.
     *
     * @return mixed
     */
    public function getUserNotApprove()
    {
        return $this->repository->getUserNotApprove();
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function readConnectVerification(int $userId) {
        return $this->repository->where('user_id', $userId)
            ->update(['connect_verification_read' => DBConstant::CONNECT_VERIFICATION_READ]);
    }

    /**
     * Count identity not verification image.
     *
     * @return mixed
     */
    public function countIdentityNotVerificationImage()
    {
        return $this->repository
            ->join('image_paths', function($query) {
                $query->on('users.user_id', '=', 'image_paths.user_id')
                    ->where('image_paths.type', DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION);
            })
            ->where([
                'user_type' => DBConstant::USER_TYPE_TEACHER,
                'connect_verification_read' => DBConstant::CONNECT_VERIFICATION_NOT_READ,
//                'is_archived' => DBConstant::NOT_ARCHIVED_FLAG
            ])
            ->whereIn('image_paths.status', [
                DBConstant::BUSINESS_CARD_VERIFICATION_STATUS_NOT_YET_APPLIED,
                DBConstant::IDENTITY_VERIFICATION_STATUS_APPLIED,
                DBConstant::IDENTITY_VERIFICATION_STATUS_REJECTED,
                DBConstant::IDENTITY_VERIFICATION_STATUS_APPROVED
            ])
            ->count(DB::raw('distinct (users.user_id)'));
    }
}
