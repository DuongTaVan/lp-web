<?php

namespace App\Services\Client\CourseSchedule;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Mail\HoldingRequest;
use App\Mail\HoldingRequestTeacher;
use App\Models\CourseSchedule;
use App\Repositories\ApplicantRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\OptionalExtraRepository;
use App\Repositories\PurchaseDetailRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\SettlementRepository;
use App\Repositories\SubscriberRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Services\Client\Common\FirebaseService;
use App\Services\Client\Student\Course\FollowTeacherService;
use App\Services\Common\RepeaterCheckService;
use App\Traits\RealtimeTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Services\Common\StripePaymentService;
use Illuminate\Support\Facades\Mail;

class PurchaseMainCourseService extends BaseService
{
    use RealtimeTrait;

    protected $optionalExtraRepository;
    protected $applicantRepository;
    protected $purchaseRepository;
    protected $userRepository;
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
        $this->userRepository = app(UserRepository::class);
        $this->purchaseDetailRepository = app(PurchaseDetailRepository::class);
        $this->settlementRepository = app(SettlementRepository::class);
        $this->subscriberRepository = app(SubscriberRepository::class);
        $this->repeaterCheckService = app(RepeaterCheckService::class);
        $this->followService = app(FollowTeacherService::class);
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
     * Purchase main course
     *
     * @param array $data
     * @return array|bool[]
     */
    public function purchaseMainCourse(array $data)
    {
        // Get user has login
        $user = auth('client')->user();

        // 1-1) Check course can purchase
        $courseCanPurchased = $this->repository->getCourseCanPurchased($data, DBConstant::COURSE_TYPE_MAIN);
        if (empty($courseCanPurchased)) {
            return [
                'success' => false,
                'message' => __('errors.MSG_5027')
            ];
        }

        if ($courseCanPurchased->user_id === $user->user_id) {
            return [
                'success' => false,
                'message' => __('errors.MSG_5034')
            ];
        }

        if (($courseCanPurchased->fixed_num - $courseCanPurchased->number_of_applicants) <= 0) {
            return [
                'success' => false,
                'message' => __('errors.MSG_5027')
            ];
        }

        // 1-2) Check user has already purchased course
        $userHasAlreadyPurchased = $this->applicantRepository->getUserHasAlreadyPurchasedCourse($data, $user->user_id);
        if (count($userHasAlreadyPurchased) > 0) {
            return [
                'success' => false,
                'message' => __('errors.MSG_5028')
            ];
        }

        // 1-3) Loop as many times as the number of {request.optional_extra_ids}
        // 1-3-1) Check optional extra exists
        $priceExtras = 0;
        $optionalExtra = [];

        if (isset($data['optional_extra_ids'])) {
            $optionalExtra = $this->optionalExtraRepository->getOptionalExtra($data);
            if (empty($optionalExtra)) {
                return [
                    'success' => false,
                    'message' => __('errors.MSG_5029')
                ];
            }

            $priceExtras = $optionalExtra->sum('price');
        }

        // 1-4) Check if repeater. Execute "01_Repeater check service"
        $repeat = $this->repeaterCheckService->checkRepeater($user->user_id, $data['course_schedule_id']);

        // 1-5) Start transaction.
        $pdo = DB::connection()->getPdo();
        $pdo->exec('SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED');
        DB::beginTransaction();
        try {
            // 1-6) Select for update to avoid from exceeding capacity.
            $courseSchedule = $this->repository->getCourseScheduleById($data['course_schedule_id']);
            ++$courseSchedule->num_of_applicants;
            $courseSchedule->save();

            if (($courseSchedule->fixed_num < $courseSchedule->num_of_applicants)) {
                DB::rollBack();
                return [
                    'success' => false,
                    'message' => __('errors.MSG_5027')
                ];
            }

            // 1-7) Create applicant
            $this->applicantRepository->create([
                'user_id' => $user->user_id,
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

            // Create course purchase
            $purchaseCreated = $this->purchaseRepository->create([
                'order_no' => convertStringBase36(),
                'user_id' => $user->user_id,
                'course_schedule_id' => $data['course_schedule_id'],
                'status' => DBConstant::PURCHASES_STATUS_NOT_CAPTURED,
                'subtotal_amount' => $courseSchedule->price + $priceExtras,
                'discount_amount' => DBConstant::DISCOUNT_AMOUNT_DEFAULT,
                'total_amount' => $courseSchedule->price + $priceExtras,
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

            // Authorize on stripe, if failed rollback and return error response and show the message below "クレジットカード決済に失敗しました"
            $response = $this->stripePaymentService->charges([
                'type' => 'COURSE',
                'amount' => $courseSchedule->price + $priceExtras,
                'teacherId' => $courseSchedule->course->user_id,
                'course_schedule_id' => $courseSchedule->course_schedule_id
            ]);

            if (!$response['success']) {
                return [
                    'success' => false,
                    'message' => __('errors.MSG_5038')
                ];
            }
            // follow teacher when pay course success
            $teacherId = $this->courseScheduleService
                ->join('courses as c', 'course_schedules.course_id', '=', 'c.course_id')
                ->where([
                    'course_schedules.course_schedule_id' => $data['course_schedule_id']
                ])->first();
            // follow teacher
            $this->followService->checkFollowTeacher($teacherId, $courseCanPurchased->user_id);

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

            // check && update room if has message room
            $this->firebaseService->updateRoomUserPurchase($courseSchedule->course_schedule_id, $user->user_id, $teacherId->user_id, DBConstant::ROOM_STATUS_PURCHASED);

            // 1-13) Commit
            DB::commit();

            // event purchase success
            $this->sendEvent('realtime', [
                'url' => '/course-schedules/',
                'screen' => 'SCHEDULE_DETAIL',
                'id' => (int)$data['course_schedule_id']
            ]);
        } catch (Exception $exception) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => __('errors.MSG_5038')
            ];
        }

        // 1-14) Execute "06_Update follow"
//        $this->followService->updateFollow($user->user_id, $courseCanPurchased->user_id);

        //1-16) Create subscriber
        $this->subscriberRepository->insertDataSubscriber($user->user_id, $courseCanPurchased->user_id);
        // find user purchase by course-schedules
        $userPurchase = $this->userRepository->userPurchase(\auth('client')->id(), $courseSchedule->course_schedule_id);
        $listCourseSchedules = [];
        if ($courseSchedule->start_datetime->format('Y-m-d') === Carbon::now()->addDays(Constant::DAY_REMIND_COURSE_SCHEDULE)->format('Y-m-d') || $courseSchedule->start_datetime->format('Y-m-d') === Carbon::now()->format('Y-m-d')) {
//            $listCourseSchedules = $this->repository->getCourseScheduleUpcomingHolding(\auth('client')->id())->toArray();
//        } elseif ($courseSchedule->start_datetime->format('Y-m-d') === Carbon::now()->format('Y-m-d')) {
            $listCourseSchedules[0] = $courseSchedule;
        }

//        if ($listCourseSchedules->count() > 0) {
//            $listCourseSchedules = $listCourseSchedules->filter(function ($item) use ($courseSchedule) {
//                return $item->course_schedule_id != $courseSchedule->course_schedule_id;
//            })->values()->toArray();
//        } else {
//            $listCourseSchedules = [];
//        }
        Mail::to($user->email)->queue(new HoldingRequest($courseSchedule->course->user->full_name, $courseSchedule->toArray(), $userPurchase->full_name, $listCourseSchedules));
        Mail::to($courseSchedule->course->user->email)->queue(new HoldingRequestTeacher($courseSchedule->course->user->full_name, $courseSchedule->toArray()));
        return [
            'success' => true,
            'endpoint_url' => route('client.orders.payment.success') . '?order_no=' . $purchaseCreated->order_no
        ];

    }
}
