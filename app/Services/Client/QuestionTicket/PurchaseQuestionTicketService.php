<?php

namespace App\Services\Client\QuestionTicket;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\PurchaseDetailRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\QuestionTicketRepository;
use App\Repositories\SettlementRepository;
use App\Services\BaseService;
use App\Services\Common\StripePaymentService;
use Illuminate\Support\Facades\DB;
use Exception;

class PurchaseQuestionTicketService extends BaseService
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $courseScheduleRepository;
    protected $purchaseRepository;
    protected $purchaseDetailRepository;
    protected $settlementRepository;
    protected $stripePaymentService;

    /**
     * PurchaseQuestionTicketService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->courseScheduleRepository = app(CourseScheduleRepository::class);
        $this->purchaseRepository = app(PurchaseRepository::class);
        $this->purchaseDetailRepository = app(PurchaseDetailRepository::class);
        $this->settlementRepository = app(SettlementRepository::class);
        $this->stripePaymentService = app(StripePaymentService::class);
    }

    /**
     * Question ticket repository class
     *
     * @return string
     */
    public function repository(): string
    {
        return QuestionTicketRepository::class;
    }

    /**
     * Purchase question ticket
     *
     * @param array $data
     * @return array|bool[]
     */
    public function purchaseQuestionTicket(array $data)
    {
        \Log::info('Function purchase question ticket');
        DB::connection()->enableQueryLog();
        DB::beginTransaction();
        try {
            // Get user has login
            $authUserId = auth()->guard('client')->id();

            // Check course exists
            $courseSchedule = $this->courseScheduleRepository->checkCourseScheduleExist($data['course_schedule_id']);
            if (empty($courseSchedule)) {
                return [
                    'success' => false,
                    'message' => __('errors.MSG_5030')
                ];
            }

            $questionTicketPrice = Constant::QUESTION_TICKET_PRICE;
            $paymentIntent = $this->stripePaymentService->charges([
                'amount' => $questionTicketPrice,
                'teacherId' => $courseSchedule->course->user_id,
                'course_schedule_id' => $data['course_schedule_id'],
            ]);

            if (!$paymentIntent['success']) {
                return [
                    'success' => false,
                    'message' => __('errors.MSG_5038')
                ];
            }

            // Create question ticket
            $questionTicket = $this->repository->create([
                'user_id' => $authUserId,
                'course_schedule_id' => $data['course_schedule_id'],
                'points_equivalent' => Constant::QUESTION_TICKET_POINTS_EQUIVALENT,
                'status' => DBConstant::UNUSED_STATUS
            ]);
            // Create purchase
            $purchaseCreated = $this->purchaseRepository->create([
                'order_no' => convertStringBase36(),
                'user_id' => $authUserId,
                'course_schedule_id' => $data['course_schedule_id'],
                'status' => DBConstant::PURCHASES_STATUS_CAPTURED,
                'subtotal_amount' => Constant::QUESTION_TICKET_PRICE,
                'discount_amount' => DBConstant::DISCOUNT_AMOUNT_DEFAULT,
                'total_amount' => Constant::QUESTION_TICKET_PRICE,
                'purchased_at' => now(),
                'canceled_at' => null
            ]);

            $this->purchaseDetailRepository->create([
                'purchase_id' => $purchaseCreated->purchase_id,
                'item' => DBConstant::PURCHASE_ITEM_QUESTION,
                'course_schedule_id' => null,
                'optional_extra_id' => null,
                'question_ticket_id' => $questionTicket->question_ticket_id,
                'gift_id' => null,
                'unit_price' => Constant::QUESTION_TICKET_PRICE,
                'quantity' => 1,
                'total_amount' => Constant::QUESTION_TICKET_PRICE,
                'canceled_at' => null
            ]);

            // Create settlement record
            $this->settlementRepository->create([
                'purchase_id' => $purchaseCreated->purchase_id,
                'str_payment_id' => $paymentIntent['data']['id'],
                'currency' => DBConstant::CURRENCY_DEFAULT,
                'payment_method' => DBConstant::PAYMENT_METHOD_CREDIT_CARD,
                'card_brand' => $paymentIntent['data']['metadata']['card_brand'],
                'payment_amount' => $paymentIntent['data']['amount'],
                'status' => DBConstant::PAYMENT_STATUS_CAPTURED,
                'approval_failed_at' => null,
                'approval_error_reason' => null,
                'approved_at' => null,
                'approved_amount' => null,
                'capture_failed_at' => null,
                'capture_error_reason' => null,
                'captured_at' => now(),
                'captured_amount' => $paymentIntent['data']['amount'],
                'cancellation_failed_at' => null,
                'cancellation_error_reason' => null,
                'canceled_at' => null,
                'canceled_amount' => null
            ]);

            DB::commit();
            $queries = DB::getQueryLog();
            \Log::info('Log sql query', $queries);

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
