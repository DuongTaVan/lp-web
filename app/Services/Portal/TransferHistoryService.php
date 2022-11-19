<?php

namespace App\Services\Portal;

use App\Enums\DBConstant;
use App\Mail\SendMailLappiResendStripe;
use App\Mail\SendMailReportTransferHistory;
use App\Mail\TransferHistoryMail;
use App\Repositories\StripeLogRepository;
use App\Repositories\TransferHistoryRepository;
use App\Services\Common\StripePaymentService;
use App\Traits\RealtimeTrait;
use App\Traits\StripeTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Stripe\StripeClient;

class TransferHistoryService extends BaseService
{
    use StripeTrait, RealtimeTrait;

//    private $stripePayment;
    private $stripeLogRepository;

    public function __construct()
    {
        parent::__construct();
        $this->stripeClient = new StripeClient(config('app.stripe_secret'));
//        $this->stripePayment = app(StripePaymentService::class);
        $this->stripeLogRepository = app(StripeLogRepository::class);
    }

    /**
     * User repository class
     *
     * @return string
     */
    public function repository()
    {
        return TransferHistoryRepository::class;
    }

    /**
     * Get data to show on statistics
     *
     * @param $request
     * @return array
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getTransferHistoryList($request)
    {
        // 1-1 Show withdrawal request list
        $withdrawalRequests = $this->repository->getWithdrawalRequest($request);
        $errorInfo = $this->repository->getErrorLappi();
        if ($errorInfo['sum']) {
            $balance = $this->stripeClient->balance->retrieve();
            $balance = array_filter($balance->available, function ($item) {
                return $item->currency === 'jpy';
            });
            $errorInfo['balance'] = $balance[0]->amount ?? 0;
            $errorInfo['missing_amount'] = $errorInfo['sum'] - $errorInfo['balance'];
        } else {
            $errorInfo = null;
        }

        return [
            'withdrawalRequests' => $withdrawalRequests,
            'errorTransfer' => $errorInfo
        ];
    }

    public function getTransferHistoryCount()
    {
        return [
            'count' => $this->repository->tranferHistoryError(),
            'errorBalance' => $this->repository->tranferHistoryErrorBalance()
        ];
    }

    /**
     * Get data to show on statistics
     *
     * @param $request
     * @return array
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getTransferHistoryError()
    {
        $errorInfo = $this->repository->getErrorLappi();
        if ($errorInfo['sum']) {
            $balance = $this->stripeClient->balance->retrieve();
            $balance = array_filter($balance->available, function ($item) {
                return $item->currency === 'jpy';
            });
            $errorInfo['balance'] = $balance[0]->amount ?? 0;
            $errorInfo['missing_amount'] = $errorInfo['sum'] - $errorInfo['balance'];
            $errorInfo['failed_at_date'] = now()->parse($errorInfo['failed_at'])->format('Y-m-d');
            $errorInfo['failed_at_time'] = now()->parse($errorInfo['failed_at'])->format('H:i:s');
            $errorInfo['missing_amount'] = $errorInfo['missing_amount'] < 0 ? 0 : number_format($errorInfo['missing_amount']);
        } else {
            $errorInfo = null;
        }

        return $errorInfo;
    }

    public function getDetail($id)
    {
        return $this->repository->where('transfer_histories.id', $id)
            ->leftJoin(
                'cashes as c', 'transfer_histories.cash_id', '=', 'c.cash_id'
            )->leftJoin(
                'users as u', 'c.user_id', '=', 'u.user_id'
            )->leftJoin(
                'bank_account_histories as bah', 'transfer_histories.bank_id', '=', 'bah.id'
            )->select(
                'transfer_histories.id',
                'transfer_histories.created_at',
                'transfer_histories.failure_code',
                'c.user_id',
                'u.nickname',
                'u.last_name_kanji',
                'u.first_name_kanji',
                'u.user_type',
                'transfer_histories.status',
                'transfer_histories.transfer_amount',
                'bah.bank_name',
                'bah.branch_name',
                'bah.account_type',
                'bah.account_number',
                'bah.account_name',
                'transfer_histories.approved_at',
                'transfer_histories.transferred_at',
                'transfer_histories.failed_at',
                'transfer_histories.scheduled_date'
            )->first();
    }

    /**
     * Put update register transfer.
     *
     * @param $id
     * @return bool
     */
    public function registerTransfer($id)
    {
        try {
            $transferHistory = $this->repository->join('cashes', 'transfer_histories.cash_id', '=', 'cashes.cash_id')
                ->join('users', 'users.user_id', '=', 'cashes.user_id')
                ->where('id', $id)
                ->with('user')
                ->select('email', 'transfer_histories.withdrawal_amount', 'transfer_fee', 'transfer_amount', 'id', 'users.user_id as user_id')
                ->firstOrFail();
            Mail::to($transferHistory->email)->queue(new TransferHistoryMail($transferHistory, $transferHistory->user->full_name));

            // 1-1 Register transfer.
            $transferHistory->status = DBConstant::TRANSFER_HISTORIES_STATUS_APPROVED;
            $transferHistory->scheduled_date = schedule_payout();
            $transferHistory->approved_at = now();
            $transferHistory->save();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }

    /**
     * Put update register transfer.
     *
     * @param $id
     * @return bool
     */
    public function sendmailTransfer($id)
    {
        try {
            $transferHistory = $this->repository
                ->join('cashes', 'transfer_histories.cash_id', '=', 'cashes.cash_id')
                ->join('users', 'users.user_id', '=', 'cashes.user_id')
                ->where('id', $id)
                ->with('user')
                ->select('users.email', 'users.user_id as user_id', 'transfer_histories.id')->firstOrFail();
            Mail::to($transferHistory->email)->queue(new SendMailReportTransferHistory($transferHistory->user->full_name));

            // 1-1 Register transfer.
            $transferHistory->status = DBConstant::TRANSFER_HISTORIES_STATUS_REPORT_TEACHER;
            $transferHistory->save();
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            return false;
        }
    }

    /**
     * Transfer history not approve.
     *
     * @return mixed
     */
    public function transferHistoryNotApprove()
    {
        return $this->repository->transferHistoryNotApprove();
    }

    public function tranferHistoryError()
    {
        return $this->repository->tranferHistoryError();
    }

    public function tranferHistoryErrorBalance()
    {
        return $this->repository->tranferHistoryErrorBalance();
    }

    public function tryAgainTransfer()
    {
        $payouts = $this->repository
            ->join('cashes', 'cashes.cash_id', '=', 'transfer_histories.cash_id')
            ->join('users', 'users.user_id', '=', 'cashes.user_id')
            ->where([
                'status' => DBConstant::TRANSFER_HISTORIES_STATUS_FAIL,
                'failure_code' => DBConstant::TRANSFER_HISTORIES_FAILURE_CODE['balance_insufficient']
            ])
            ->select('users.str_connect_id', 'users.user_id', 'transfer_histories.*', 'users.email')
            ->get();

        foreach ($payouts as $payout) {
            try {
                $this->stripeClient->transfers->create([
                    'amount' => $payout->transfer_amount,
                    'currency' => 'jpy',
                    'description' => 'transfer to connect account: ' . $payout->str_connect_id . ' to payout',
                    'destination' => $payout->str_connect_id
                ]);
                $po = $this->tranferOut($payout);

//                $this->stripeLogRepository->whenPayout($payout->transfer_amount);

                $payout->update([
                    'status' => DBConstant::TRANSFER_HISTORIES_STATUS_SENDING,
                    'str_payout_id' => $po->id ?? 'FAIL',
                ]);

                Mail::to($payout->email)->queue(new TransferHistoryMail($payout, $payout->user->full_name));
            } catch (\Exception $e) {
                $this->errorPayoutLappi($e, $payout);
            }
        }
    }
}
