<?php

declare(strict_types=1);

namespace App\Services\Common;

use App\Repositories\CashRepositoryEloquent;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

/**
 * Class DepositCashService.
 */
class DepositCashService extends BaseService
{
    public $userRepository;

    /**
     * DepositCashService constructor.
     */
    public function __construct()
    {
        $this->userRepository = app(UserRepository::class);
    }

    /**
     * @return string
     */
    public function repository(): string
    {
        return CashRepositoryEloquent::class;
    }

    /**
     * Deposit Cash Service.
     *
     * @param $userId
     * @param $depositAmount
     * @param $depositReason
     * @return array
     */
    public function depositCash($userId, $depositAmount, $depositReason): array
    {
        $cashId = null;

        $currentCashBalance = $this->repository->getCurrentCashBalance($userId);
        $balance = $currentCashBalance['balance'] ? $currentCashBalance['balance'] + $depositAmount : $depositAmount;

        DB::beginTransaction();

        try {
            // Create a record when deposit cash.
            $cashes = $this->repository->create([
                'user_id' => $userId,
                'deposit_amount' => $depositAmount,
                'deposit_reason' => $depositReason,
                'withdrawal_amount' => null,
                'withdrawal_reason' => null,
                'balance' => $balance,
                'transacted_at' => now(),
            ]);

            $user = $this->userRepository->find($userId);

            if (!empty($user)) {
                $cashBalance = $user['cash_balance'] + $depositAmount;
                $this->userRepository->update(['cash_balance' => $cashBalance], $userId);
            }
            DB::commit();

            return [
                'success' => true,
                'cash_id' => $cashes['cash_id'] ?? $cashId,
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
