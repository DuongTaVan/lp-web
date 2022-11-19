<?php

declare(strict_types=1);

namespace App\Services\Common;

use App\Enums\DBConstant;
use App\Repositories\UserPointRepositoryEloquent;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class WithdrawPointService extends BaseService
{
    public $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = app(UserRepository::class);
    }

    /**
     * @return string|void
     */
    public function repository()
    {
        return UserPointRepositoryEloquent::class;
    }

    /**
     * Withdraw points service.
     *
     * @param $userId
     * @param mixed $withdrawalPoints
     * @param $withdrawalReason
     * @return array
     */
    public function withdrawPoint($userId, $withdrawalPoints, $withdrawalReason)
    {
        // Set variable.
        $userPointId = null;
        $points = $withdrawalPoints;

        // Check current points balance
        $currentPointBalance = $this->repository->getCurrentPointsBalance($userId);

        if (empty($currentPointBalance) || ($currentPointBalance['points_balance'] - $points) < 0) {
            return [
                'success' => false,
                'message' => __('message.not_enough_points'),
            ];
        }
        DB::beginTransaction();

        try {
            // Get all record have deposit_point != null.
            $userPoints = $this->repository->getTargetPoint($userId);

            if (count($userPoints) > 0) {
                $isInsert = false;

                foreach ($userPoints as $userPoint) {
                    $pt = $userPoint['deposit_points'] - $userPoint['consumed_points'] - $points; // Condition check

                    // Case record do not have point.
                    if ($pt < 0) {
                        $points -= $userPoint['deposit_points'] - $userPoint['consumed_points'];
                        $updateData = [
                            'consumed_points' => $userPoint['deposit_points'],
                            'is_consumed' => DBConstant::IS_CONSUMED,
                        ];

                        // Set status consumed
                        $this->repository->update($updateData, $userPoint['user_point_id']);
                    } elseif ($pt == 0) {
                        $updateData = [
                            'consumed_points' => $userPoint['consumed_points'] + $points,
                            'is_consumed' => DBConstant::IS_CONSUMED,
                        ];

                        // Set status consumed
                        $this->repository->update($updateData, $userPoint['user_point_id']);

                        $isInsert = true;
                        break;
                    } else {
                        $updateData = [
                            'consumed_points' => $userPoint['consumed_points'] + $points,
                            'is_consumed' => DBConstant::NOT_CONSUMED,
                        ];

                        // Set status consumed
                        $this->repository->update($updateData, $userPoint['user_point_id']);

                        $isInsert = true;
                        break;
                    }
                }

                // Insert data.
                if ($isInsert == true) {
                    $userPointId = $this->repository->create([
                        'user_id' => $userId,
                        'deposit_points' => null,
                        'deposit_reason' => null,
                        'withdrawal_points' => $withdrawalPoints,
                        'withdrawal_reason' => $withdrawalReason,
                        'points_balance' => $currentPointBalance['points_balance'] - $withdrawalPoints,
                        'transacted_at' => now(),
                        'consumed_points' => null,
                        'is_consumed' => null,
                        'expiration_date' => null,
                        'is_processed' => null,
                        'expired_user_point_id' => null,
                    ]);
                    // Update user_point in users table.
                    $user = $this->userRepository->find($userId);
                    if (!empty($user)) {
                        $pointBalance = $user['points_balance'] - $withdrawalPoints;
                        $this->userRepository->update(['points_balance' => $pointBalance], $userId);
                    }
                }
            }
            DB::commit();

            return [
                'success' => true,
                'user_point_id' => $userPointId['user_point_id'] ?? null,
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
