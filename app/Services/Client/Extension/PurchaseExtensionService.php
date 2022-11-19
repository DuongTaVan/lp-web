<?php

namespace App\Services\Client\Extension;

use App\Enums\DBConstant;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\OptionalExtraRepository;
use App\Repositories\PurchaseDetailRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\SettlementRepository;
use App\Services\BaseService;
use App\Services\Common\StripePaymentService;
use Illuminate\Support\Facades\DB;
use Exception;

class PurchaseExtensionService extends BaseService
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $courseRepository;
    protected $optionalExtraRepository;
    protected $purchaseRepository;
    protected $purchaseDetailRepository;
    protected $settlementRepository;
    protected $stripePaymentService;

    /**
     * PurchaseExtensionService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->courseRepository = app(CourseRepository::class);
        $this->optionalExtraRepository = app(OptionalExtraRepository::class);
        $this->purchaseRepository = app(PurchaseRepository::class);
        $this->purchaseDetailRepository = app(PurchaseDetailRepository::class);
        $this->settlementRepository = app(SettlementRepository::class);
        $this->stripePaymentService = app(StripePaymentService::class);
    }

    /**
     * Course schedule repository class
     *
     * @return string
     */
    public function repository(): string
    {
        return CourseScheduleRepository::class;
    }

    /**
     * Purchase extension
     *
     * @param array $data
     * @return array|bool[]
     */
    public function purchaseExtension(array $data)
    {
        \Log::info('Function purchase extension');
        DB::connection()->enableQueryLog();
        DB::beginTransaction();
        try {
            // Get user has login
            $authUserId = auth('client')->id();

            // Check extension course exists
            $extensionCourse = $this->courseRepository->checkExtensionCourseExist($data, $authUserId);

            if (!empty($extensionCourse)) {
                // Get current course schedule
                $currentCourseSchedule = $this->repository->getCourseScheduleById($data['current_course_schedule_id']);

                // Check extension can purchase
                $canPurchase = $this->repository->checkExtensionCanPurchased(
                    $data['current_course_schedule_id'],
                    $extensionCourse->course_user_id,
                    $currentCourseSchedule->end_datetime,
                    $extensionCourse->course_minutes_required,
                    $data['origin_course_schedule_id']
                );
                if ($canPurchase->count()) {
                    return [
                        'success' => false,
                        'message' => __('errors.MSG_5037')
                    ];
                }
            }

            // Check optional extra exists
            $optionalExtra = $this->optionalExtraRepository->getOptionalExtra($data);

            if (empty($optionalExtra)) {
                return [
                    'success' => false,
                    'message' => __('errors.MSG_5029')
                ];
            }

//            $price = $extensionCourse->course_price ?? 0 + $optionalExtra->sum('price');
            $course = $this->courseRepository->find($data['course_id']);
            $teacherId = $course->user_id ?? null;
            if (!$teacherId) {
                return [
                    'success' => false,
                    'message' => __('errors.MSG_5038')
                ];
            }
            $paymentIntent = $this->stripePaymentService->charges([
                'amount' => $extensionCourse->course_price ?? 0,
                'amountOption' => $optionalExtra->sum('price'),
                'teacherId' => $teacherId,
                'capture' => 'automatic',
                'type' => 'EXTEND',
                'course_schedule_id' => $data['current_course_schedule_id']
            ]);
            if (!$paymentIntent['success']) {
                return [
                    'success' => false,
                    'message' => __('errors.MSG_5038')
                ];
            }
            if (isset($extensionCourse)) {
                //Check extension bought .
                $extensionBought = $this->repository->where(['course_id' => $data['course_id'], 'status' => DBConstant::COURSE_SCHEDULES_STATUS_CLOSED, 'parent_course_schedule_id' => $data['origin_course_schedule_id']])->get();
                if ($extensionBought->count() && count($data['optional_extra_ids']) === 0) {
                    return [
                        'success' => false,
                        'message' => __('labels.course-detail.tool_tip_purchase_notification')
                    ];
                }
                $originCourseSchedule = $this->repository->getCourseScheduleById($data['origin_course_schedule_id']);
                if ($originCourseSchedule->course_id !== (int)$data['course_id']) {
                    // 1-7) Create extension course schedule.
                    $extension = $this->repository->create([
                        'course_id' => $data['course_id'],
                        'type' => DBConstant::COURSE_SCHEDULES_TYPE_EXTENSION,
                        'parent_course_schedule_id' => $data['origin_course_schedule_id'],
                        'status' => DBConstant::COURSE_SCHEDULES_STATUS_CLOSED,
                        'title' => null,
                        'subtitle' => null,
                        'body' => null,
                        'flow' => null,
                        'cautions' => null,
                        'minutes_required' => $extensionCourse->course_minutes_required,
                        'price' => $extensionCourse->course_price,
                        'fixed_num' => $extensionCourse->course_fixed_num,
                        'num_of_applicants' => 1,
                        'purchase_deadline' => now(),
                        'start_datetime' => $currentCourseSchedule->actual_start_date,
                        'end_datetime' => $currentCourseSchedule->actual_end_date->addMinutes($extensionCourse->course_minutes_required),
                        'agora_channel' => null,
                        'agora_token' => null,
                        'canceled_at' => null,
                        'is_mask_required' => DBConstant::FACEMASK_NG
                    ]);
                    $currentCourseSchedule->actual_end_date = $currentCourseSchedule->actual_end_date->addMinutes($extensionCourse->course_minutes_required);
                    $currentCourseSchedule->save();
                }

            }

            $totalAmount = $extensionCourse->course_price ?? 0;
            foreach ($optionalExtra as $option) {
                $totalAmount += $option->price;
            }

            // Create course purchase
            $purchaseCreated = $this->purchaseRepository->create([
                'order_no' => convertStringBase36(),
                'user_id' => $authUserId,
                'course_schedule_id' => $data['origin_course_schedule_id'],
                'status' => DBConstant::PURCHASES_STATUS_CAPTURED,
                'subtotal_amount' => $totalAmount,
                'discount_amount' => DBConstant::DISCOUNT_AMOUNT_DEFAULT,
                'total_amount' => $totalAmount,
                'purchased_at' => now(),
                'canceled_at' => null
            ]);
            if (isset($extensionCourse)) {
                $this->purchaseDetailRepository->create([
                    'purchase_id' => $purchaseCreated->purchase_id,
                    'item' => DBConstant::PURCHASE_ITEM_EXTENSION,
                    'course_schedule_id' => $data['current_course_schedule_id'],
                    'optional_extra_id' => null,
                    'question_ticket_id' => null,
                    'gift_id' => null,
                    'unit_price' => $extensionCourse->course_price,
                    'quantity' => 1,
                    'total_amount' => $extensionCourse->course_price,
                    'canceled_at' => null
                ]);
            }

            // Create option purchase
            $dataInsert = [];
            foreach ($optionalExtra as $option) {
                $dataInsert[] = [
                    'purchase_id' => $purchaseCreated->purchase_id,
                    'item' => DBConstant::PURCHASE_ITEM_OPTION,
                    'course_schedule_id' => null,
                    'optional_extra_id' => $option->optional_extra_id,
                    'question_ticket_id' => null,
                    'gift_id' => null,
                    'unit_price' => $option->price,
                    'quantity' => 1,
                    'total_amount' => $option->price,
                    'canceled_at' => null,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            $this->purchaseDetailRepository->insert($dataInsert);

            // Create settlement record
            $this->settlementRepository->create([
                'purchase_id' => $purchaseCreated->purchase_id,
                'str_payment_id' => $paymentIntent['data']['id'],
                'currency' => DBConstant::CURRENCY_DEFAULT,
                'payment_method' => DBConstant::PAYMENT_METHOD_CREDIT_CARD,
                'card_brand' => $paymentIntent['data']['payment_method_details'] ? $paymentIntent['data']['payment_method_details']['card']['brand'] : "",
                'payment_amount' => $paymentIntent['data']['amount'],
                'status' => DBConstant::PAYMENT_STATUS_CAPTURED,
                'approval_failed_at' => null,
                'approval_error_reason' => null,
                'approved_at' => now(),
                'approved_amount' => null,
                'capture_failed_at' => null,
                'capture_error_reason' => null,
                'captured_at' => now(),
                'captured_amount' => $paymentIntent['data']['amount_received'],
                'cancellation_failed_at' => null,
                'cancellation_error_reason' => null,
                'canceled_at' => null,
                'canceled_amount' => null
            ]);

            DB::commit();
            $queries = DB::getQueryLog();
            \Log::info('Log sql query', $queries);

            return [
                'success' => true,
                'current_course_schedule_id' => isset($extension) ? $extension->course_schedule_id : null,
                'course_id' => $data['course_id'] ?? null,
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
