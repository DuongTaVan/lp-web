<?php

declare(strict_types=1);

namespace App\Services\Common;

use App\Enums\Constant;
use App\Repositories\UserPointRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;

class DepositPointsService extends BaseService
{
    public $userRepository;
    public $userPointRepository;

    /**
     * DepositPointsService constructor.
     */
    public function __construct()
    {
        $this->userRepository = app(UserRepository::class);
        $this->userPointRepository = app(UserPointRepository::class);
    }

    /**
     * @return string
     */
    public function repository(): string
    {
        return UserPointRepository::class;
    }

    /**
     * Deposit points service.
     *
     * @param $userId
     * @param $depositPoints
     * @param $depositReason
     * @return array
     */
    public function depositPoints($userId, $depositPoints, $depositReason, $reviewId =null)
    {
        $currentPointBalance = $this->userPointRepository->getCurrentPointsBalance($userId);
        // Deposit points.
        $pointBalance = $currentPointBalance ? $currentPointBalance['points_balance'] + $depositPoints : $depositPoints;
        $this->userPointRepository->create([
            'user_id' => $userId,
            'deposit_points' => $depositPoints,
            'deposit_reason' => $depositReason,
            'points_balance' => $pointBalance,
            'transacted_at' => now(),
            'consumed_points' => 0,
            'is_consumed' => 0,
            'expiration_date' => now()->addMonths(Constant::POINT_EXPIRATION),
            'is_processed' => 0,
            'expired_user_point_id' => null,
            'review_id' => $reviewId
        ]);

        // Update user_point in users table
        $user = $this->userRepository->find($userId);
        if ($user) {
            $userPointBalance = $user['points_balance'] + $depositPoints;
            $this->userRepository->update(['points_balance' => $userPointBalance], $userId);
        }
    }
}
