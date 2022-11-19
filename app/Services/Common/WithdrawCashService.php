<?php

declare(strict_types=1);

namespace App\Services\Common;

use App\Enums\DBConstant;
use App\Repositories\CashRepositoryEloquent;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class WithdrawCashService extends BaseService
{
    public $userRepository;

    /**
     * WithdrawCashService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->userRepository = app(UserRepository::class);
    }

    public function repository()
    {
        return CashRepositoryEloquent::class;
    }

    /**
     * Withdraw cash service.
     *
     * @param $userId
     * @param $withdrawalAmount
     * @param $withdrawalReason
     * @return array
     */
    public function withdrawalCash($userId, $withdrawalAmount, $withdrawalReason)
    {
        $currentCashBalance = $this->repository->getCurrentCashBalance($userId);

        $balance = $currentCashBalance['balance'] - $withdrawalAmount;
        $teacherProfit = $withdrawalReason === DBConstant::WITHDRAWAL_REASON_WITHDRAWAL_REQUEST ? 0 : ($currentCashBalance['teacher_profit'] - $withdrawalAmount);
        $saleTax = $withdrawalReason === DBConstant::WITHDRAWAL_REASON_WITHDRAWAL_REQUEST ? 0 : $currentCashBalance['sale_tax'];
        $cash = $this->repository->create([
            'user_id' => $userId,
            'deposit_amount' => null,
            'deposit_reason' => null,
            'withdrawal_amount' => $withdrawalAmount,
            'withdrawal_reason' => $withdrawalReason,
            'balance' => $balance,
            'teacher_profit' => $teacherProfit,
            'sale_tax' => $saleTax,
            'transacted_at' => now(),
        ]);

        $user = $this->userRepository->find($userId);
        $user->cash_balance = $cash->balance;
        $user->save();

        return [
            'cash_id' => $cash->cash_id,
            'teacher_profit' => $teacherProfit,
        ];
    }
}
