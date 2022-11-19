<?php

declare(strict_types=1);

namespace App\Services\Common;

use App\Enums\DBConstant;
use App\Mail\SendMailLappiReportTransferHistory;
use App\Repositories\SettlementRepository;
use App\Repositories\TransferHistoryRepository;
use App\Services\BaseService;
use App\Traits\RealtimeTrait;
use Illuminate\Support\Facades\Mail;

class TransferHistoryService extends BaseService
{
    use RealtimeTrait;
    private $transferHistoryRepository;

    /**
     * TeacherService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->transferHistoryRepository = app(TransferHistoryRepository::class);
    }

    /**
     * @return string
     */
    public function repository()
    {
        return SettlementRepository::class;
    }

    public function updateStatusPayout($payload)
    {
        $poId = $payload['id'];
        $status = DBConstant::TRANSFER_HISTORIES_STATUS_PAID;
        if ($payload['status'] === 'failed') {
            $status = DBConstant::TRANSFER_HISTORIES_STATUS_FAIL;
        }
        $payout = $this->transferHistoryRepository
            ->where('str_payout_id', $poId)
            ->first();
        if (!$payout) {
            return;
        }
        $dataUpdate = ['status' => $status];
        if ($status === DBConstant::TRANSFER_HISTORIES_STATUS_PAID) {
            $dataUpdate['transferred_at'] = now();
        } else {
            $dataUpdate['failure_code'] = $payload['failure_code'];
            $dataUpdate['failed_at'] = now();
            $user = $payout->bankAccount->user;
            $data = [
                'approval_at' => $payout->created_at->format('Y-m-d'),
                'nickname' => $user['last_name_kanji'].$user['first_name_kanji'] ?? '',
                'email' => $user->email ?? '',
                'category' => $user->teacher_category_text ?? '',
                'bank' => $payout->bankAccount->bank_name,
                'branch' => $payout->bankAccount->branch_name,
                'account_number' => $payout->bankAccount->account_number,
                'account_name' => $payout->bankAccount->account_name,
                'amount' => $payout->transfer_amount
            ];

            try {
                Mail::to(config('app.to_mail_report'))->queue(new SendMailLappiReportTransferHistory($data));
            } catch (\Exception $e) {}
        }
        $this->sendEvent('realtime', [
            'url' => '/portal/transfer-histories',
            'screen' => 'TRANSFER',
            'id' => $payout->id
        ]);

        $payout->update($dataUpdate);
    }
}
