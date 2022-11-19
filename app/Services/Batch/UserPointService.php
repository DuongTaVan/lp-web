<?php

namespace App\Services\Batch;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Repositories\UserPointRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;

class UserPointService extends BaseService

{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    public $userRepository;

    /**
     * HomeService constructor. 
     */
    public function __construct()
    {
        // add repository
        parent::__construct();
        $this->userRepository = app(UserRepository::class);
    }

    /**
     * User repository class
     *
     * @return string
     */
    public function repository(): string
    {
        return UserPointRepository::class;
    }

    /**
     * Batch 04 Expired points batch																			
     *
     * @return array
     */
    public function batch05(): array
    {
        DB::beginTransaction();
        try {
            $runBatchCompleted = false;
            while (!$runBatchCompleted) {
                // 1-1) Get the target data every 1,000 records from DB.
                $userPoints = $this->repository->getDecreaseExpiredPoint()->limit(Constant::BATCH_RECORD_LIMIT)->get();

                // Break when no target.
                if (!count($userPoints)) {
                    $runBatchCompleted = true;

                    break;
                }

                // 1-2) Loop as many times as the number of data at 1-1).
                foreach ($userPoints as $userPoint) {
                    // 1-2-2) Expire points.
                    $this->repository->update([
                        'is_consumed' => DBConstant::USER_POINT_IS_CONSUMED['consumed'],
                        'is_processed' => DBConstant::USER_POINT_IS_PROCESSED['processed'],
                    ], $userPoint->user_point_id);

                    // 1-2-3) Check the current points balance.
                    $currentPoint = $this->repository->getCurrentPointByUserId($userPoint->user_id);

                    // 1-2-4) Create withdrawal record.
                    $this->repository->create([
                        'user_id' => $userPoint->user_id,
                        'withdrawal_points' => $userPoint->deposit_points - $userPoint->consumed_points,
                        'points_balance' => $currentPoint->points_balance - ($userPoint->deposit_points - $userPoint->consumed_points),
                        'withdrawal_reason' => DBConstant::WITHDRAWAL_REASON_POINTS_EXPIRED,
                        'transacted_at' => now()->format('Y-m-d'),
                        'expired_user_point_id' => $userPoint->user_point_id,
                    ]);

                    // 1-2-5) Get user.
                    $user = $this->userRepository->find($userPoint->user_id);

                    // 1-2-6) Update user.
                    $user->fill([
                        'points_balance' => $user->points_balance - ($userPoint->deposit_points - $userPoint->consumed_points),
                    ]);
                    $user->save();
                }
            }
            DB::commit();

            return [
                'success' => true
            ];
        } catch (Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
