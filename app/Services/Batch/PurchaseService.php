<?php

namespace App\Services\Batch;

use App\Enums\DBConstant;
use App\Mail\TransferHistoryMail;
use App\Repositories\ApplicantRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\RankingRepository;
use App\Repositories\SaleRepository;
use App\Repositories\SettlementRepository;
use App\Repositories\StripeLogRepository;
use App\Repositories\TransferHistoryRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Services\Client\Common\FirebaseService;
use App\Services\Common\StripePaymentService;
use App\Traits\RealtimeTrait;
use App\Traits\StripeTrait;
use Illuminate\Support\Facades\Mail;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class PurchaseService extends BaseService
{
    use StripeTrait, RealtimeTrait;
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    private $courseScheduleRepository;
    private $settlementRepository;
    private $userRepository;
    private $purchaseRepository;
    private $applicantRepository;
    private $transferHistoryRepository;
    private $stripePaymentService;
    private $firebaseService;
    private $stripeLogRepository;
    private $saleRepository;

    /**
     * HomeService constructor.
     */
    public function __construct()
    {
        // add repository
        parent::__construct();
        $this->courseScheduleRepository = app(CourseScheduleRepository::class);
        $this->transferHistoryRepository = app(TransferHistoryRepository::class);
        $this->settlementRepository = app(SettlementRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->purchaseRepository = app(PurchaseRepository::class);
        $this->applicantRepository = app(ApplicantRepository::class);
        $this->firebaseService = app(FirebaseService::class);
        $this->stripeClient = new StripeClient(
            config('app.stripe_secret')
        );
        $this->stripePaymentService = app(StripePaymentService::class);
        $this->stripeLogRepository = app(StripeLogRepository::class);
        $this->saleRepository = app(SaleRepository::class);
    }

    /**
     * User repository class
     *
     * @return string
     */
    public function repository(): string
    {
        return RankingRepository::class;
    }

    /**
     * Batch 05 Ranking batch
     *
     * @return array
     */
    public function batch03(): array
    {
        try {
            // 1-1) Get the target data.
            $courseSchedules = $this->courseScheduleRepository
                ->with('course')
                ->where([
                    'type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                    'status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                    ['start_datetime', '<=', now()->addHour()->format('Y-m-d H:i:s')], // update logic
                    'canceled_at' => null
                ])->get();

            // 1-2) Loop as many times as the number of data at 1-1).
            foreach ($courseSchedules as $courseSchedule) {
                // 1-2-1) Get Stripe settlements which haven't been captured.
                $settlements = $this->settlementRepository->getDataNotCapture($courseSchedule->course_schedule_id);
                $teacherId = $courseSchedule->course->user_id ?? null;
                $numOfApplicant = $courseSchedule->num_of_applicants ?? 0;
                // 1-2-2) Loop as many times as the number of data at 1-2-1).
                foreach ($settlements as $settlement) {
                    // 1-2-2-1) Get Stripe settlements which haven't been captured.
                    $user = $this->userRepository->getDataBySettlementId($settlement->id);

                    // 1-2-2-2) Capture on Stripe.
                    if ($user->currency === 'HUS') {
                        $captureStripe = [
                            'success' => false,
                            'message' => 'test capture false'
                        ];
                    } else {
                        $captureStripe = $this->captureOnStripe($user->str_payment_id);
                    }

                    $status = DBConstant::ROOM_STATUS_NOT_PURCHASED;
                    if ($captureStripe['success']) {
                        // 1-2-2-3) Update purchase and settlement status when success.
                        $this->purchaseRepository->update([
                            'status' => DBConstant::PURCHASES_STATUS_CAPTURED
                        ], $user->purchase_id);
//
                        $this->settlementRepository->update([
                            'status' => DBConstant::PAYMENT_STATUS_CAPTURED,
                            'captured_at' => now(),
                            'captured_amount' => $captureStripe['data']->amount
                        ], $settlement->id);
                        $status = DBConstant::ROOM_STATUS_PURCHASED;
                    } else {
                        $this->stripePaymentService->cancelPaymentIntent($captureStripe['data']['id']);
                        // 1-2-2-4) Update settlement status when failure.
                        $this->settlementRepository->update([
                            'status' => DBConstant::PAYMENT_STATUS_CAPTURE_ERROR,
                            'capture_failed_at' => now(),
                            'capture_error_reason' => $captureStripe['message']
                        ], $settlement->id);

                        // 1-2-2-5) Settle(Capture) {settlements.payment_amount} on Stripe.
                        $captureStripe = $this->captureOnStripe($user->str_payment_id);

                        if (!$captureStripe['success']) {
                            $captureStripe = $this->stripePaymentService->charges([
                                'amount' => $settlement->total_amount,
                                'capture' => 'automatic',
                                'studentId' => $user->user_id,
                                'teacherId' => $teacherId,
                                'strCustomerId' => $user->str_customer_id,
                                'type' => 'COURSE',
                                'course_schedule_id' => $courseSchedule->course_schedule_id
                            ]);
                        }

                        if ($captureStripe['success']) {
                            // 1-2-2-6) Update purchase and create success settlement.
                            $this->purchaseRepository->update([
                                'status' => DBConstant::PURCHASES_STATUS_CAPTURED
                            ], $user->purchase_id);
                            $this->settlementRepository->create([
                                'purchase_id' => $user->purchase_id,
                                'str_payment_id' => $captureStripe['data']['id'],
                                'currency' => DBConstant::CURRENCY_DEFAULT,
                                'payment_method' => DBConstant::PAYMENT_METHOD_CREDIT_CARD,
                                'card_brand' => $captureStripe['data']['metadata']['card_brand'] ?? "",
                                'payment_amount' => $captureStripe['data']['amount'],
                                'status' => DBConstant::PAYMENT_STATUS_CAPTURED,
                                'approval_failed_at' => null,
                                'approval_error_reason' => null,
                                'approved_at' => null,
                                'approved_amount' => null,
                                'capture_failed_at' => null,
                                'capture_error_reason' => null,
                                'captured_at' => now(),
                                'captured_amount' => $captureStripe['data']['amount_received'],
                                'cancellation_failed_at' => null,
                                'cancellation_error_reason' => null,
                                'canceled_at' => null,
                                'canceled_amount' => null,
                            ]);
//
                            $status = DBConstant::ROOM_STATUS_PURCHASED;
                        } else {
                            // 1-2-2-7) Cancel the purchase and applicant.
                            $this->purchaseRepository->update([
                                'status' => DBConstant::PURCHASES_STATUS_NOT_CANCELED_BEFORE_CAPTURE,
                                'student_canceled_at' => now(),
                                'canceled_at' => now(),
                            ], $user->purchase_id);

                            $this->applicantRepository->where([
                                'user_id' => $user->user_id,
                                'course_schedule_id' => $courseSchedule->course_schedule_id
                            ])->update([
                                'canceled_at' => now()
                            ]);
                            --$numOfApplicant;
                            $this->courseScheduleRepository->update([
                                'num_of_applicants' => $numOfApplicant,
                            ], $courseSchedule->course_schedule_id);

                            $this->stripePaymentService->cancelPaymentIntent($captureStripe['data']['id']);
                        }
                    }

                    // check && update room if has message room
                    $this->firebaseService->updateRoomUserPurchase($courseSchedule->course_schedule_id, $user->user_id, $teacherId, $status);
                }
            }

            return [
                'success' => true
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Capture on Stripe.
     *
     * @param $id
     * @param bool $first
     * @return array
     */
    public function captureOnStripe($id): array
    {
        try {
            // TODO DELETE
            $payment = $this->stripeClient->paymentIntents->retrieve($id);
//            if ($payment['metadata']) {
//                $card = $payment['metadata'];
//                if (isset($card['card_brand']) && isset($card['card_number']) && ($card['card_brand'] === 'mastercard') && ($card['card_number'] === '8210')) {
//                    return [
//                        'success' => false,
//                        'message' => 'Credit card cancel error'
//                    ];
//                }
//            }
            // end TODO
            $responseStripe = $this->stripeClient->paymentIntents->capture(
                $id,
                []
            );

            return [
                'success' => true,
                'data' => $responseStripe
            ];
        } catch (ApiErrorException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Payout
     */
    public function tranferOutTeacher()
    {
        $now = now()->format('Y-m-d');
        $payouts = $this->transferHistoryRepository
            ->join('cashes', 'cashes.cash_id', '=', 'transfer_histories.cash_id')
            ->join('users', 'users.user_id', '=', 'cashes.user_id')
            ->where([
                'scheduled_date' => $now,
                'status' => DBConstant::TRANSFER_HISTORIES_STATUS_APPROVED
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

    /**
     * Payout lappi
     */
    public function tranferOutLappi()
    {
        try {
            $startDate = $endDate = null;
            if (now()->day === 10) {
                $startDate = now()->subMonth()->setDay(16)->startOfDay();
                $endDate = now()->parse($startDate)->lastOfMonth()->endOfDay();
            } else if (now()->day === 22) {
                $startDate = now()->setDay(1)->startOfDay();
                $endDate = now()->parse($startDate)->setDay(15)->endOfDay();
            }

            $totalPayout = 0;
            $saleRecord = null;
            if ($startDate && $endDate) {
                $saleRecord = $this->saleRepository
                    ->where('target_date', '>=', $startDate)
                    ->where('target_date', '<=', $endDate)
                    ->get();
                $transferFee = $this->transferHistoryRepository
                    ->where('created_at', '>=', $startDate)
                    ->where('created_at', '<=', $endDate)
                    ->where('status', '!=', 0)
                    ->sum('transfer_fee');
                $saleOptionCancel = $this->purchaseRepository
                    ->where('canceled_at', '>=', $startDate)
                    ->where('canceled_at', '<=', $endDate)
                    ->where('status', DBConstant::PURCHASES_STATUS_CANCELED_AFTER_CAPTURE)
                    ->sum('total_amount');
                $totalSale = $saleRecord->sum('total_sales');
                $stripeFee = round(($totalSale + $saleOptionCancel) * 3.6 / 100);
                $totalCommission = $saleRecord->sum('total_commissions');
                $cancellationFee = $saleRecord->sum('cancellation_fee');
                $totalTransferTeacher = $totalSale - $totalCommission - round($totalCommission * 10 / 100) - $cancellationFee - $transferFee;
                $totalPayout = $totalSale - $stripeFee - $totalTransferTeacher - $transferFee;
            }

            if ($totalPayout > 0 && $saleRecord) {
                $po = $this->stripeClient->payouts->create([
                    'amount' => round($totalPayout),
                    'currency' => 'jpy',
                    'description' => 'Payout profit of LAPPI'
                ]);
                \Log::info('Lappi payout success');
                \Log::info($po);
            }
        } catch (\Exception $e) {
            \Log::info('Lappi payout error');
            \Log::info($e);
        }
    }
}
