<?php

declare(strict_types=1);

namespace App\Services\Common;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Mail\StudentCancelCourse;
use App\Mail\TeacherCancelCourse;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\SaleRepository;
use App\Repositories\SettlementRepository;
use App\Repositories\StripeLogRepository;
use App\Services\BaseService;
use App\Services\Client\Common\FirebaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SettlementService extends BaseService
{
    private $courseSchedulesRepository;
    private $firebaseService;
    private $saleRepository;
    private $stripeLogRepository;

    /**
     * TeacherService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->courseSchedulesRepository = app(CourseScheduleRepository::class);
        $this->firebaseService = app(FirebaseService::class);
        $this->saleRepository = app(SaleRepository::class);
        $this->stripeLogRepository = app(StripeLogRepository::class);
    }

    /**
     * @return string
     */
    public function repository()
    {
        return SettlementRepository::class;
    }

    /**
     * Update status settlements.
     *
     * @param $payload
     */
    public function updateStatus($payload)
    {
        DB::beginTransaction();
        try {
            if ($payload['status'] === 'succeeded') {
                $set = $this->repository
                    ->where('str_payment_id', $payload['payment_intent'])
                    ->orderBy('created_at', 'desc')
                    ->first();
                if ($set) {
                    $set->status = $this->getStatus($payload['status']);
                    $set->canceled_at = now();
                    $set->canceled_amount = $payload['amount'];
                    $set->save();

                    $purchase = $set->purchase;

                    if ($purchase->status === DBConstant::PURCHASES_STATUS_CAPTURED) {
                        $purchase->status = DBConstant::PURCHASES_STATUS_CANCELED_AFTER_CAPTURE;
                        $purchase->canceled_at = now();
                        $purchase->save();
                    }
                    $this->updateAfterRefund($purchase);
                }
            } else {
                $settlement = $this->repository
                    ->where('str_payment_id', $payload['payment_intent']);
                $purchase = $settlement->orderBy('created_at', 'desc')->first();
                $settlement->update([
                    'status' => DBConstant::SETTLEMENT_STATUS_VOID_ERROR,
                    'cancellation_failed_at' => now(),
                    'cancellation_error_reason' => $payload['failure_reason'],
                ]);
                if ($purchase) {
                    $courseScheduleId = $purchase->course_schedule_id;
                    $settlements = $this->repository
                        ->join('settlements as pu', function ($query) use ($courseScheduleId) {
                            $query->on('pu.purchase_id', '=', 'settlements.purchase_id')
                                ->where('pu.course_schedule_id', $courseScheduleId);
                        })
                        ->select(DB::raw('count(case settlements.status when 5 then 1 else null end) as count_error, count(*) as count_all'))
                        ->first();
                    if ($settlements->count_error === $settlements->count_all && $settlements->count_all) {
                        $this->courseSchedulesRepository
                            ->update(['status' => DBConstant::COURSE_STATUS_OPEN], $courseScheduleId);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
        }
    }

    /**
     * Update status settlements.
     *
     * @param $payload
     */
    public function paymentCancel($payload)
    {
        DB::beginTransaction();
        try {
            $settlement = $this->repository
                ->where('str_payment_id', $payload['id']);
            $purchase = $settlement->orderBy('created_at', 'desc')->first();
            if (!$purchase) {
                return;
            }
            $purchase = $purchase->purchase;
            $settlement->update([
                'status' => $this->getStatus($payload['status']),
                'cancellation_failed_at' => now(),
                'cancellation_error_reason' => $payload['refunds']['reason'] ?? 'expired',
            ]);
            if ($purchase) {
                $courseScheduleId = $purchase->course_schedule_id;
                $purchase->update([
                    'status' => DBConstant::PURCHASES_STATUS_NOT_CANCELED_BEFORE_CAPTURE,
                    'canceled_at' => now(),
                ]);
                $settlements = $this->repository
                    ->join('purchases as pu', function ($query) use ($courseScheduleId) {
                        $query->on('pu.purchase_id', '=', 'settlements.purchase_id')
                            ->where('pu.course_schedule_id', $courseScheduleId);
                    })
                    ->select(DB::raw('count(case settlements.status when 5 then 1 else null end) as count_error, count(*) as count_all'))
                    ->first();
                if ($settlements->count_error === $settlements->count_all) {
                    $this->courseSchedulesRepository
                        ->update(['status' => DBConstant::COURSE_STATUS_OPEN], $courseScheduleId);
                }
            }
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
        }
    }

    private function updateAfterRefund($purchase)
    {
        $courseScheduleId = $purchase->course_schedule_id;
        $courseCancel = $this->courseSchedulesRepository->find($courseScheduleId);
        $userId = $courseCancel->course->user_id;
//        \Log::info($courseCancel->status);
        if ($courseCancel->status === DBConstant::COURSE_SCHEDULES_STATUS_PENDING) {
            $courseCancel->status = DBConstant::COURSE_SCHEDULES_STATUS_CANCELED;
            $courseCancel->canceled_at = now();
            $courseCancel->save();
            $teacher = $courseCancel->course->user;
            // mailto teacher
            Mail::to($teacher->email)->queue(
                new TeacherCancelCourse(
                    '【Lappi】キャンセルが完了しました。',
                    $teacher->full_name,
                    $courseCancel
                ));
        }
//        $stripeSettlementCaptured = $this->purchaseRepository->getStripeSettlement($courseScheduleId, DBConstant::PURCHASES_STATUS_CAPTURED);

        if (now()->parse($courseCancel->start_datetime)->subDay()->format('Y-m-d 22:00:00') <= now()->format('Y-m-d H:i:s')) {
            // 1-10
            $saleCommission = $courseCancel->price * Constant::SALES_COMMISSION_RATE / 100;

            $withDrawService = new WithdrawCashService();
            $cashId = $withDrawService->withdrawalCash($userId, $saleCommission, DBConstant::WITHDRAWAL_REASON_POINTS_EXPIRED)['cash_id'];

            $this->saleRepository->create([
                'user_id' => $userId,
                'course_schedule_id' => $courseScheduleId,
                'target_date' => now(),
                'cash_id' => $cashId ?? 1,
                'base_price' => $courseCancel->price,
                'sales_commissions' => 0,
                'total_commissions' => 0,
                'cash_balance' => -$saleCommission,
                'teacher_profit' => -$saleCommission,
                'teacher_profit_exc_tax' => -$saleCommission,
                'cancellation_fee' => $saleCommission ?? 0,
            ]);
            $this->stripeLogRepository->create([
                'balance' => $this->stripeLogRepository->getLastBalance() + $saleCommission,
                'type' => DBConstant::STRIPE_LOG_TYPE_IN
            ]);
        }

        $mess = \Cache::get('cancel_cs' . $courseScheduleId) ?? '';

        if ($mess) {
            $teacher = $courseCancel->course->user;
            $type = DBConstant::ROOM_TYPE_CLOSE;
            $status = DBConstant::ROOM_STATUS_TEACHER_CANCEL;
            $update = true;
            $this->firebaseService->sendMessageSmart($mess, $teacher->user_id, (int)$purchase->user_id, $courseScheduleId, $type, $status, $update);
            //Send mail to student.
            $emailUser = $purchase->user;
            Mail::to($emailUser->email)->queue(
                new StudentCancelCourse(
                    '【Lappi】出品者様からのキャンセルのご連絡',
                    $teacher->full_name,
                    $courseCancel,
                    $emailUser->full_name,
                    $mess
                ));
        }
    }

    /**
     * @param $status
     * @return int
     */
    private function getStatus($status)
    {
        switch ($status) {
            case 'succeeded':
                return DBConstant::SETTLEMENT_STATUS_VOIDED_CANCELED;
            case 'failed':
                return DBConstant::SETTLEMENT_STATUS_VOID_ERROR;
            default:
                return DBConstant::SETTLEMENT_STATUS_PENDING;
        }
    }
}
