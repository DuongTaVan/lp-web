<?php

namespace App\Repositories;

use App\Enums\DBConstant;
use App\Enums\Constant;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\TransferHistory;

/**
 * Class TransferHistoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TransferHistoryRepositoryEloquent extends BaseRepository implements TransferHistoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TransferHistory::class;
    }

    /**
     * Get withdrawal request list.
     *
     * @param $params
     * @return mixed
     */
    public function getWithdrawalRequest($params)
    {
        // set Value
        $startCreatedAt = $params->start_created_at;
        $endCreatedAt = $params->end_created_at;
        $userId = $params->userId;
        $userNickname = $params->user_nickname;
        $status = $params->status;
        $statusTransfer = $params->status_transfer;
        $perPage = Constant::DEFAULT_LIMIT;
        $sortColumn = $params->input('sort_column', Constant::TRANSFER_HISTORY_SORT_BY_DEFAULT);
        $sortType = $params->input('sort_by', Constant::ORDER_BY_DESC);
        if (isset($params['per_page'])) {
            $perPage = $params['per_page'];
        }

        $query = $this->model->leftJoin(
            'cashes as c', 'transfer_histories.cash_id', '=', 'c.cash_id'
        )->leftJoin(
            'users as u', 'c.user_id', '=', 'u.user_id'
        )->leftJoin(
            'bank_account_histories as bah', 'transfer_histories.bank_id', '=', 'bah.id'
        )->select(
            'transfer_histories.id',
            'transfer_histories.created_at',
            'c.user_id',
            'u.nickname',
            'u.last_name_kanji',
            'u.first_name_kanji',
            DB::raw("CONCAT(u.last_name_kanji,u.first_name_kanji) AS full_name_kanji"),
            'u.user_type',
            'transfer_histories.status',
            'transfer_histories.failure_code',
            'transfer_histories.transfer_amount',
            'bah.bank_name',
            'bah.branch_name',
            'bah.account_type',
            'bah.account_number',
            'bah.account_name',
            'transfer_histories.approved_at',
            'transfer_histories.transferred_at',
            'transfer_histories.failed_at',
            'transfer_histories.scheduled_date',
            'transfer_histories.transferred_at'
        );

        if ($startCreatedAt) {
            $query = $query->whereDate('transfer_histories.created_at', '>=', $startCreatedAt);
        }
        if ($endCreatedAt) {
            $query = $query->whereDate('transfer_histories.created_at', '<=', $endCreatedAt);
        }
        if ($userId) {
            $query = $query->where('u.user_id', $userId);
        }
        if ($userNickname) {
            $query = $query->where('u.nickname', 'like', $userNickname . '%');
        }

        if ($status !== null) {
            if ((int)$status) {
                if ($statusTransfer !== null && !(int)$statusTransfer) {
                    $query = $query->whereNotIn('transfer_histories.status', [
                        DBConstant::TRANSFER_HISTORIES_STATUS_PENDING,
                        DBConstant::TRANSFER_HISTORIES_STATUS_PAID,
                        DBConstant::TRANSFER_HISTORIES_STATUS_FAIL,
                    ]);
                } else if ($statusTransfer !== null && (int)$statusTransfer === DBConstant::TRANSFER_HISTORIES_STATUS_PAID) {
                    $query = $query->where('transfer_histories.status', DBConstant::TRANSFER_HISTORIES_STATUS_PAID);
                } else if ($statusTransfer !== null && (int)$statusTransfer === DBConstant::TRANSFER_HISTORIES_STATUS_FAIL) {
                    $query = $query->where('transfer_histories.status', DBConstant::TRANSFER_HISTORIES_STATUS_FAIL);
                } else {
                    $query = $query->where('transfer_histories.status', '!=', DBConstant::TRANSFER_HISTORIES_STATUS_PENDING);
                }
            } else {
                $query = $query->where('transfer_histories.status', DBConstant::TRANSFER_HISTORIES_STATUS_PENDING);
                if ($statusTransfer) {
                    $query = $query->where('transfer_histories.status', $statusTransfer);
                }
            }
        } else {
            if ($statusTransfer !== null) {
                if ((int)$statusTransfer) {
                    if ((int)$statusTransfer === DBConstant::TRANSFER_HISTORIES_STATUS_FAIL) {
                        $query = $query->whereIn('transfer_histories.status', [$statusTransfer, DBConstant::TRANSFER_HISTORIES_STATUS_REPORT_TEACHER])
                            ->where(function ($query){
                                $query->where('transfer_histories.failure_code', '<>', DBConstant::TRANSFER_HISTORIES_FAILURE_CODE['balance_insufficient'])
                                    ->orWhereNull('transfer_histories.failure_code');
                            });
                    } elseif ((int)$statusTransfer === DBConstant::TRANSFER_HISTORIES_STATUS_FAIL_BALANCE) {
                        $query = $query->whereIn('transfer_histories.status', [DBConstant::TRANSFER_HISTORIES_STATUS_FAIL, DBConstant::TRANSFER_HISTORIES_STATUS_REPORT_TEACHER])
                            ->where('transfer_histories.failure_code', DBConstant::TRANSFER_HISTORIES_FAILURE_CODE['balance_insufficient']);
                    } else {
                        $query = $query->where('transfer_histories.status', $statusTransfer);
                    }
                } else {
                    $query = $query->whereNotIn('transfer_histories.status', [
                        DBConstant::TRANSFER_HISTORIES_STATUS_PAID,
                        DBConstant::TRANSFER_HISTORIES_STATUS_FAIL,
                        DBConstant::TRANSFER_HISTORIES_STATUS_REPORT_TEACHER
                    ]);
                }
            }
        }

        return $query->orderBy($sortColumn, $sortType)->paginate($perPage);
    }

    /**
     * Get Count Transfer Histories
     *
     * @return void
     */
    public function getCountTransferHistories()
    {
        return $this->model->leftJoin(
            'cashes as c', 'transfer_histories.cash_id', '=', 'c.cash_id'
        )->leftJoin(
            'users as u', 'c.user_id', '=', 'u.user_id'
        )->leftJoin(
            'bank_accounts as ba', 'c.user_id', '=', 'ba.user_id'
        )->where(
            'transfer_histories.status', DBConstant::TRANSFER_HISTORY_STATUS['applied']
        )->count();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

//    /**
//     * Amount transferred of month.
//     *
//     * @param $startDate
//     * @param $endDate
//     * @return mixed
//     */
//    public function amountTransferredOfMonth($startDate, $endDate)
//    {
//        return $this->model
//            ->where('transfer_histories.status', DBConstant::TRANSFER_HISTORIES_STATUS_APPROVED)
//            ->whereNotNull('transfer_histories.transferred_at')
//            ->whereBetween('transfer_histories.transferred_at', [$startDate, $endDate])
//            ->sum('transfer_histories.transfer_amount');
//    }

//    /**
//     * Amount not transferred of month.
//     *
//     * @param $startDate
//     * @param $endDate
//     * @return mixed
//     */
//    public function amountNotTransferredOfMonth($startDate, $endDate)
//    {
//        return $this->model
//            ->where('transfer_histories.status', DBConstant::TRANSFER_HISTORIES_STATUS_PENDING)
//            ->whereNull('transfer_histories.transferred_at')
//            ->whereBetween('transfer_histories.created_at', [$startDate, $endDate])
//            ->sum('transfer_histories.transfer_amount');
//    }

    public function transferHistoryNotApprove()
    {
        return $this->model->where('status', DBConstant::TRANSFER_HISTORY_STATUS['applied'])->count();
    }

    public function tranferHistoryError()
    {
        return $this->model->whereIn('status', [
            DBConstant::TRANSFER_HISTORIES_STATUS_FAIL,
            DBConstant::TRANSFER_HISTORIES_STATUS_REPORT_TEACHER
        ])->count();
    }

    public function tranferHistoryErrorBalance()
    {
        return $this->model
            ->where([
                'status' => DBConstant::TRANSFER_HISTORIES_STATUS_FAIL,
                'failure_code' => DBConstant::TRANSFER_HISTORIES_FAILURE_CODE['balance_insufficient']
            ])
            ->count();
    }

    /**
     * @param string $date
     * @return mixed
     */
    public function dataTransferAll(string $date)
    {
        $time = now()->parse($date);

        return (int)$this->model
            ->where([
                [DB::raw('YEAR(transferred_at)'), $time->year],
                [DB::raw('MONTH(transferred_at)'), $time->month],
                'status' => DBConstant::TRANSFER_HISTORIES_STATUS_PAID
            ])
            ->sum('withdrawal_amount');
    }

    /**
     * @param string $date
     * @return mixed
     */
    public function dataNotTransferAll(string $date)
    {
        $time = now()->parse($date);

        return (int)$this->model
            ->where([
                [DB::raw('YEAR(created_at)'), $time->year],
                [DB::raw('MONTH(created_at)'), $time->month],
                ['status', '!=', DBConstant::TRANSFER_HISTORIES_STATUS_PAID]
            ])
            ->sum('withdrawal_amount');
    }

    public function getErrorLappi()
    {
        return $this->model
            ->where([
                'status' => DBConstant::TRANSFER_HISTORIES_STATUS_FAIL,
                'failure_code' => DBConstant::TRANSFER_HISTORIES_FAILURE_CODE['balance_insufficient']
            ])
            ->selectRaw('sum(transfer_amount) as sum, MAX(failed_at) as failed_at')
            ->first()
            ->toArray();
    }
}
