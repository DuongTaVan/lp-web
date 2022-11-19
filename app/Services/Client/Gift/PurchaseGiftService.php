<?php

namespace App\Services\Client\Gift;

use App\Enums\DBConstant;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\GiftRepository;
use App\Repositories\GiftTippingHistoryRepository;
use App\Repositories\PurchaseDetailRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\SettlementRepository;
use App\Services\BaseService;
use App\Services\Client\Common\FirebaseService;
use App\Services\Common\StripePaymentService;
use Exception;
use Illuminate\Support\Facades\DB;

class PurchaseGiftService extends BaseService
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $courseScheduleRepository;
    protected $purchaseRepository;
    protected $purchaseDetailRepository;
    protected $settlementRepository;
    protected $giftTippingHistoryRepository;
    protected $stripePaymentService;
    protected $firebaseService;

    /**
     * PurchaseGiftService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->courseScheduleRepository = app(CourseScheduleRepository::class);
        $this->purchaseRepository = app(PurchaseRepository::class);
        $this->purchaseDetailRepository = app(PurchaseDetailRepository::class);
        $this->settlementRepository = app(SettlementRepository::class);
        $this->giftTippingHistoryRepository = app(GiftTippingHistoryRepository::class);
        $this->stripePaymentService = app(StripePaymentService::class);
        $this->firebaseService = app(FirebaseService::class);
    }

    /**
     * Gift repository class
     *
     * @return string
     */
    public function repository(): string
    {
        return GiftRepository::class;
    }

    /**
     * get bought Gifts
     */
    public function boughtGifts(int $courseScheduleId)
    {
        return $this->purchaseRepository
            ->join('purchase_details as pd', function ($q) {
                $q->on('pd.purchase_id', '=', 'purchases.purchase_id')
                    ->whereNotNull('gift_id')
                    ->where('pd.item', DBConstant::PURCHASE_ITEM_GIFT);
            })
            ->where([
                'purchases.course_schedule_id' => $courseScheduleId
            ])
            ->orderBy('purchases.created_at', 'DESC')
            ->get();
    }

    /**
     * Purchase gift
     *
     * @param $data
     * @return array|bool[]
     */
    public function purchaseGift($data)
    {
        \Log::info('Function purchase gift');
        DB::connection()->enableQueryLog();
        DB::beginTransaction();
        try {
            // Get user has login
            $authUserId = auth('client')->id();

            // Check course exists
            $courseSchedule = $this->courseScheduleRepository->checkCourseScheduleExist($data['course_schedule_id']);
            if (empty($courseSchedule)) {
                return [
                    'success' => false,
                    'message' => __('errors.MSG_5030')
                ];
            }

            // Check gift exists
            $gift = $this->repository->getGiftById($data['gift_id']);
            if (empty($gift)) {
                return [
                    'success' => false,
                    'message' => __('errors.MSG_5031')
                ];
            }

            // Redirect stripe to payment
            $giftPrice = $gift->price;

            // Create purchase
            $purchaseCreated = $this->purchaseRepository->create([
                'order_no' => convertStringBase36(),
                'user_id' => $authUserId,
                'course_schedule_id' => $data['course_schedule_id'],
                'status' => DBConstant::PURCHASES_STATUS_CAPTURED,
                'subtotal_amount' => $giftPrice,
                'discount_amount' => DBConstant::DISCOUNT_AMOUNT_DEFAULT,
                'total_amount' => $giftPrice,
                'purchased_at' => now(),
                'canceled_at' => null
            ]);

            $this->purchaseDetailRepository->create([
                'purchase_id' => $purchaseCreated->purchase_id,
                'item' => DBConstant::PURCHASE_ITEM_GIFT,
                'course_schedule_id' => null,
                'optional_extra_id' => null,
                'question_ticket_id' => null,
                'gift_id' => $gift->gift_id,
                'unit_price' => $giftPrice,
                'quantity' => 1,
                'total_amount' => $giftPrice,
                'canceled_at' => null
            ]);

            $paymentIntent = $this->stripePaymentService->charges([
                'amount' => $giftPrice,
                'teacherId' => $courseSchedule->course->user_id,
                'capture' => 'automatic',
                'type' => 'GIFT',
                'course_schedule_id' => $data['course_schedule_id']
            ]);

            if (!$paymentIntent['success']) {
                return [
                    'success' => false,
                    'message' => __('errors.MSG_5038')
                ];
            }
            // Create settlement record
            $this->settlementRepository->create([
                'purchase_id' => $purchaseCreated->purchase_id,
                'str_payment_id' => $paymentIntent['data']['id'],
                'currency' => DBConstant::CURRENCY_DEFAULT,
                'payment_method' => DBConstant::PAYMENT_METHOD_CREDIT_CARD,
                'card_brand' => $paymentIntent['data']['metadata']['card_brand'],
                'payment_amount' => $giftPrice,
                'status' => DBConstant::PAYMENT_STATUS_CAPTURED,
                'approval_failed_at' => null,
                'approval_error_reason' => null,
                'approved_at' => null,
                'approved_amount' => null,
                'capture_failed_at' => null,
                'capture_error_reason' => null,
                'captured_at' => now(),
                'captured_amount' => $giftPrice,
                'cancellation_failed_at' => null,
                'cancellation_error_reason' => null,
                'canceled_at' => null,
                'canceled_amount' => null
            ]);

            // Create tipping record
            $this->giftTippingHistoryRepository->create([
                'from_user_id' => $authUserId,
                'to_user_id' => $courseSchedule->user_id,
                'course_schedule_id' => $data['course_schedule_id'],
                'points_equivalent' => $gift->points_equivalent,
                'tipped_at' => now()
            ]);

            DB::commit();
            $queries = DB::getQueryLog();
            \Log::info('Log sql query', $queries);

            $message = $gift->name . '('. $gift->points_equivalent .'コイン)を送りました';
            $this->firebaseService->sendLiveStreamComment($courseSchedule->course_schedule_id, $message, true, 'GIFT');

            return [
                'success' => true
            ];
        } catch (Exception $exception) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => $exception->getMessage()
            ];
        }
    }
}
