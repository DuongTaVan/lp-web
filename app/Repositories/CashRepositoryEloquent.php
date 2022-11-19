<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Models\Cash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CashRepositoryEloquent.
 */
class CashRepositoryEloquent extends BaseRepository implements CashRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Cash::class;
    }

    /**
     * Get Current Cash Balance.
     *
     * @param $userId
     * @return mixed|void
     */
    public function getCurrentCashBalance($userId)
    {
        $currentCashBalance = $this->model
            ->where('user_id', $userId)
            ->orderBy('cash_id', Constant::ORDER_BY_DESC)
            ->first();

        if (!$currentCashBalance) {
            $currentCashBalance = [
                'balance' => 0,
                'teacher_profit' => 0,
                'sale_tax' => 0,
            ];
        }

        return $currentCashBalance;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get total balance.
     *
     * @return mixed
     */
    public function getTotalBalance()
    {
        return $this->model->where('user_id', auth('client')->user()->user_id)->orderByDesc('cash_id')->first();
    }

    /**
     * @param $date
     * @return mixed
     */
    public function numberOfTransfer($date)
    {
        $time = now()->parse($date);

        return $this->model
            ->where([
                'user_id' => auth('client')->id(),
                [DB::raw('YEAR(DATE_SUB(transacted_at, INTERVAL 1 DAY))'), $time->year],
                [DB::raw('MONTH(DATE_SUB(transacted_at, INTERVAL 1 DAY))'), $time->month],
                'withdrawal_reason' => DBConstant::WITHDRAWAL_REASON_WITHDRAWAL_REQUEST
            ])
            ->count();
    }

    /**
     * @param Carbon $date
     * @return mixed
     */
    public function dataTransfer(Carbon $date)
    {
        $data = $this->model
//            ->join('sales', 'sales.cash_id', '=', 'cashes.cash_id')
            ->where([
                'cashes.user_id' => auth('client')->id(),
//                [DB::raw('YEAR(DATE_SUB(transacted_at, INTERVAL 1 DAY))'), $time->year],
//                [DB::raw('MONTH(DATE_SUB(transacted_at, INTERVAL 1 DAY))'), $time->month],
                [DB::raw('YEAR(transacted_at)'), $date->year],
                [DB::raw('MONTH(transacted_at)'), $date->month],
                'cashes.withdrawal_reason' => DBConstant::WITHDRAWAL_REASON_WITHDRAWAL_REQUEST
            ])
            ->selectRaw('COUNT(cash_id) as count, SUM(withdrawal_amount) as sum')
            ->first();

        return $data ? $data->toArray() : ['count' => 0, 'sum' => 0];
    }

    /**
     * @param string $date
     * @return mixed
     */
    public function dataTransferAll(string $date)
    {
        $time = now()->parse($date);

        $data = $this->model
            ->where([
                [DB::raw('YEAR(transferred_at)'), $time->year],
                [DB::raw('MONTH(transferred_at)'), $time->month],
                'cashes.withdrawal_reason' => DBConstant::WITHDRAWAL_REASON_WITHDRAWAL_REQUEST
            ])
            ->selectRaw('COUNT(cash_id) as count, SUM(withdrawal_amount) as sum')
            ->first();

        return $data ? $data->toArray() : ['count' => 0, 'sum' => 0];
    }

    public function getDataCashEndOfMonth(Carbon $date)
    {
        $data = $this->model
            ->leftJoin('sales', 'sales.cash_id', '=', 'cashes.cash_id')
            ->where([
                'cashes.user_id' => auth('client')->id(),
                [DB::raw('YEAR(CASE WHEN sales.target_date IS NULL THEN cashes.transacted_at ELSE sales.target_date END)'), $date->year],
                [DB::raw('MONTH(CASE WHEN sales.target_date IS NULL THEN cashes.transacted_at ELSE sales.target_date END)'), $date->month]
            ])
            ->orderBy('cashes.cash_id', Constant::ORDER_BY_DESC)
            ->select('cashes.balance', 'cashes.teacher_profit', 'cashes.sale_tax')
            ->first();

        return $data ? $data->toArray() : ['balance' => 0, 'teacher_profit' => 0, 'sale_tax' => 0];
    }

    public function getDataCashBeforeEndOfMonth(Carbon $date)
    {
        $data = $this->model
            ->leftJoin('sales', 'sales.cash_id', '=', 'cashes.cash_id')
            ->where([
                'cashes.user_id' => auth('client')->id(),
                [DB::raw('CASE WHEN sales.target_date IS NULL THEN cashes.transacted_at ELSE sales.target_date END'), '<', $date->lastOfMonth()->endOfDay()],
//                [DB::raw('MONTH(CASE WHEN sales.target_date IS NULL THEN cashes.transacted_at ELSE sales.target_date END)'), $date->month]
            ])
            ->orderBy('cashes.cash_id', Constant::ORDER_BY_DESC)
            ->select('cashes.balance', 'cashes.teacher_profit', 'cashes.sale_tax')
            ->first();

        return $data ? $data->toArray() : ['balance' => 0, 'teacher_profit' => 0, 'sale_tax' => 0];
    }

    public function getDataAllUserEndMonth(string $date)
    {
        $time = now()->parse($date);

        $cash = $this->model
            ->join('sales', 'sales.cash_id', '=', 'cashes.cash_id')
            ->where([
                [DB::raw('YEAR(CASE WHEN sales.target_date IS NULL THEN cashes.transacted_at ELSE sales.target_date END)'), $time->year],
                [DB::raw('MONTH(CASE WHEN sales.target_date IS NULL THEN cashes.transacted_at ELSE sales.target_date END)'), $time->month]
            ])
            ->selectRaw('ROW_NUMBER() OVER(PARTITION BY cashes.user_id ORDER BY cashes.cash_id DESC) rowNumber, cashes.balance, cashes.cash_id, cashes.teacher_profit, cashes.user_id')
            ->get();
        $data = $cash->filter(function($item) {
            return $item->rowNumber === 1;
        });

        return [
            'balance' => $data->sum('balance'),
            'teacher_profit' => $data->sum('teacher_profit')
        ];
    }

    public function getProfitMonth(string $date)
    {
        $time = now()->parse($date);

        $data = $this->model
            ->join('sales', 'sales.cash_id', '=', 'cashes.cash_id')
            ->where([
                'cashes.user_id' => auth('client')->id(),
//                [DB::raw('YEAR(DATE_SUB(cashes.transacted_at, INTERVAL 1 DAY))'), $time->year],
//                [DB::raw('MONTH(DATE_SUB(cashes.transacted_at, INTERVAL 1 DAY))'), $time->month]
                [DB::raw('YEAR(sales.target_date)'), $time->year],
                [DB::raw('MONTH(sales.target_date)'), $time->month]
            ])
            ->selectRaw('SUM(sales.teacher_profit) as profit, SUM(sales.cash_balance) as balance, SUM(sales.cancellation_fee) as cancel_fee')
            ->first();

        return $data ? $data->toArray() : ['profit' => 0, 'balance' => 0];
    }

    public function getProfitAllMonth(string $date)
    {
        $time = now()->parse($date);

        $data = $this->model
            ->join('sales', 'sales.cash_id', '=', 'cashes.cash_id')
            ->where([
                [DB::raw('YEAR(sales.target_date)'), $time->year],
                [DB::raw('MONTH(sales.target_date)'), $time->month]
            ])
            ->selectRaw('SUM(sales.teacher_profit) as profit, SUM(sales.cash_balance) as balance, SUM(sales.cancellation_fee) as cancel_fee')
            ->first();

        return $data ? $data->toArray() : ['profit' => 0, 'balance' => 0];
    }

    public function getTimeTransferLastInMonth(string $date)
    {
        $time = now()->parse($date);

        return $this->model
            ->where([
                'user_id' => auth('client')->id(),
                [DB::raw('YEAR(transacted_at)'), $time->year],
                [DB::raw('MONTH(transacted_at)'), $time->month],
                'withdrawal_reason' => DBConstant::WITHDRAWAL_REASON_WITHDRAWAL_REQUEST
            ])
            ->orderBy('cash_id', Constant::ORDER_BY_DESC)
            ->pluck('created_at')->first();
    }

    /**
     * Get transfer record.
     *
     * @param $data
     * @return mixed
     */
    public function transferRecord($data)
    {
        return $this->model
            ->where([
                'user_id' => auth('client')->id(),
                'withdrawal_reason' => DBConstant::WITHDRAWAL_REASON_WITHDRAWAL_REQUEST
            ])
            ->whereBetween('transacted_at', [$data['startDate'], $data['endDate']])
            ->where('withdrawal_reason', DBConstant::WITHDRAWAL_REASON_WITHDRAWAL_REQUEST)
            ->sum('withdrawal_amount');
    }

    /**
     * Transfer record last day.
     *
     * @return mixed
     */
    public function transferRecordLastDay()
    {
        return $this->model
            ->where([
                'user_id' => auth('client')->id(),
                'withdrawal_reason' => DBConstant::WITHDRAWAL_REASON_WITHDRAWAL_REQUEST
            ])
            ->whereBetween('transacted_at', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])
            ->orderby('transacted_at', 'DESC')
            ->pluck('transacted_at')->first();
    }

    /**
     * Transfer record last month.
     *
     * @return bool
     */
    public function transferRecordLastMonth($startDate, $endDate)
    {
        return !$this->model
            ->where([
                'user_id' => auth('client')->id(),
                'withdrawal_reason' => DBConstant::WITHDRAWAL_REASON_WITHDRAWAL_REQUEST
            ])
            ->whereBetween('transacted_at', [$startDate, $endDate])
            ->count();
    }

    /**
     * Transfer record user.
     *
     * @return mixed
     */
    public function transferRecordUser($startDate, $endDate)
    {
        return $this->model
            ->where([
                'user_id' => auth('client')->id(),
                'withdrawal_reason' => DBConstant::WITHDRAWAL_REASON_WITHDRAWAL_REQUEST
            ])
            ->whereBetween('transacted_at', [$startDate, $endDate])
            ->orderby('transacted_at', 'DESC')
            ->pluck('transacted_at')->first();
    }

    /**
     * Transfer record user last month.
     *
     * @return mixed
     */
    public function transferRecordUserLastMonth()
    {
        return $this->model
            ->where([
                'user_id' => auth('client')->id(),
                'withdrawal_reason' => DBConstant::WITHDRAWAL_REASON_WITHDRAWAL_REQUEST
            ])
            ->where('transacted_at', '<', now()->startOfMonth()->toDateString())
            ->orderby('transacted_at', 'DESC')
            ->pluck('transacted_at')->first();
    }
}
