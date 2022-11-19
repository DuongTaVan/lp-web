<?php

namespace App\Services\Client\CourseSchedule;

use App\Enums\DBConstant;
use App\Models\CourseSchedule;
use App\Repositories\ApplicantRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\OptionalExtraRepository;
use App\Repositories\PurchaseDetailRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\SettlementRepository;
use App\Repositories\SubscriberRepository;
use App\Services\BaseService;
use App\Services\Client\Common\FirebaseService;
use App\Services\Common\FollowService;
use App\Services\Common\RepeaterCheckService;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Services\Common\StripePaymentService;

class PurchaseSubCourseService extends BaseService
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $optionalExtraRepository;
    protected $applicantRepository;
    protected $purchaseRepository;
    protected $purchaseDetailRepository;
    protected $settlementRepository;
    protected $subscriberRepository;
    protected $repeaterCheckService;
    protected $followService;
    protected $stripePaymentService;
    protected $courseScheduleService;
    protected $firebaseService;

    /**
     * PurchaseMainCourseService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->optionalExtraRepository = app(OptionalExtraRepository::class);
        $this->applicantRepository = app(ApplicantRepository::class);
        $this->purchaseRepository = app(PurchaseRepository::class);
        $this->purchaseDetailRepository = app(PurchaseDetailRepository::class);
        $this->settlementRepository = app(SettlementRepository::class);
        $this->subscriberRepository = app(SubscriberRepository::class);
        $this->repeaterCheckService = app(RepeaterCheckService::class);
        $this->followService = app(FollowService::class);
        $this->stripePaymentService = app(StripePaymentService::class);
        $this->courseScheduleService = app(CourseSchedule::class);
        $this->firebaseService = app(FirebaseService::class);
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
     * Purchase sub course
     *
     * @param array $data
     * @param RepeaterCheckService $repeaterCheckService
     * @return array|bool[]
     */
    public function purchaseSubCourse(array $data)
    {
        // Get user has login
        $authUserId = auth()->guard('client')->id();
        $mainCourseScheduleId = $data['main_course_schedule_id'] ?? null;

        // 1-1) Check if the sub course can be purchased.
        $courseCanPurchased = $this->repository->getCourseCanPurchased($data, DBConstant::COURSE_TYPE_SUB);

        // If there's no record, return error response and show the message below.
        if (empty($courseCanPurchased)) {
            return [
                'success' => false,
                'message' => __('errors.MSG_5027')
            ];
        }

        // If {course_schedules.fixed_num} - {course_schedules.num_of_applicants} <= 0, return error response and show the message below.
        if (($courseCanPurchased->fixed_num - $courseCanPurchased->num_of_applicants) <= 0) {
            return [
                'success' => false,
                'message' => __('errors.MSG_5027')
            ];
        }

        // 1-2)	Check if the user has already purchased this sub course.
        $userHasAlreadyPurchased = $this->applicantRepository->getUserHasAlreadyPurchasedCourse($data, $authUserId);
        if (count($userHasAlreadyPurchased) > 0) {
            return [
                'success' => false,
                'message' => __('errors.MSG_5028')
            ];
        }

        // 1-3)	Check if repeater.
        // Execute "01_Repeater check service"
        $repeat = $this->repeaterCheckService->checkRepeater($authUserId, $data['course_schedule_id']);

        // 1-4) Start transaction.
        $pdo = DB::connection()->getPdo();
        $pdo->exec('SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED');
        DB::beginTransaction();
        try {
            $courseSchedule = $this->repository->getCourseScheduleById($data['course_schedule_id']);
            ++$courseSchedule->num_of_applicants;
            $courseSchedule->save();

            // 1-5)	Select for update to avoid exceeding capacity.
            $courseSchedule = $this->repository->getCourseScheduleById($data['course_schedule_id']);
            if (($courseSchedule->fixed_num < $courseSchedule->num_of_applicants)) {
                DB::rollBack();
                return [
                    'success' => false,
                    'message' => __('errors.MSG_5028')
                ];
            }

            // 1-6)	Create applicant.
            $this->applicantRepository->create([
                'user_id' => $authUserId,
                'course_schedule_id' => $data['course_schedule_id'],
                'is_lappi_new' => $repeat['is_lappi_new'],
                'is_lappi_repeater' => $repeat['is_lappi_repeater'],
                'lappi_repeat_count' => $repeat['lappi_repeat_count'] + 1,
                'is_teacher_new' => $repeat['is_teacher_new'],
                'is_teacher_repeater' => $repeat['is_teacher_repeater'],
                'teacher_repeat_count' => $repeat['lappi_teacher_count'] + 1,
                'canceled_at' => null,
                'is_reviewed' => DBConstant::NOT_REVIEWED
            ]);

            // 1-7)	Create course purchase.
            $purchaseCreated = $this->purchaseRepository->create([
                'order_no' => convertStringBase36(),
                'user_id' => $authUserId,
                'course_schedule_id' => $data['course_schedule_id'],
                'status' => DBConstant::PURCHASES_STATUS_NOT_CAPTURED,
                'subtotal_amount' => $courseSchedule->price,
                'discount_amount' => DBConstant::DISCOUNT_AMOUNT_DEFAULT,
                'total_amount' => $courseSchedule->price,
                'purchased_at' => now(),
                'canceled_at' => null
            ]);

            $this->purchaseDetailRepository->create([
                'purchase_id' => $purchaseCreated->purchase_id,
                'item' => DBConstant::PURCHASE_ITEM_COURSE_TYPE,
                'course_schedule_id' => $data['course_schedule_id'],
                'optional_extra_id' => null,
                'question_ticket_id' => null,
                'gift_id' => null,
                'unit_price' => $courseSchedule->price,
                'quantity' => 1,
                'total_amount' => $courseSchedule->price,
                'canceled_at' => null
            ]);

            // Authorize on stripe, if failed rollback and return error response and show the message below "クレジットカード決済に失敗しました"
            $response = $this->stripePaymentService->charges([
                'amount' => $courseSchedule->price,
                'teacherId' => $courseSchedule->course->user_id,
                'type' => 'COURSE',
                'course_schedule_id' => $courseSchedule->course_schedule_id
            ]);

            if (!$response['success']) {
                throw new Exception();
            }

            // Create settlement record
            $this->settlementRepository->create([
                'purchase_id' => $purchaseCreated->purchase_id,
                'str_payment_id' => $response['data']['id'],
                'currency' => DBConstant::CURRENCY_DEFAULT,
                'payment_method' => DBConstant::PAYMENT_METHOD_CREDIT_CARD,
                'card_brand' => $response['data']['metadata']['card_brand'],
                'payment_amount' => $response['data']['amount'],
                'status' => DBConstant::PAYMENT_STATUS_APPROVED,
                'approval_failed_at' => null,
                'approval_error_reason' => null,
                'approved_at' => now(),
                'approved_amount' => $response['data']['amount'],
                'capture_failed_at' => null,
                'capture_error_reason' => null,
                'captured_at' => null,
                'captured_amount' => null,
                'cancellation_failed_at' => null,
                'cancellation_error_reason' => null,
                'canceled_at' => null,
                'canceled_amount' => null
            ]);
            DB::commit();

            return [
                'success' => true,
                'endpoint_url' => route('client.orders.payment.success') . '?order_no=' . $purchaseCreated->order_no . '&main_course_schedule_id=' . $mainCourseScheduleId
            ];
        } catch (Exception $exception) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => __('errors.MSG_5038')
            ];
        }
    }
}
