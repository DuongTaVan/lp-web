<?php

declare(strict_types=1);

namespace App\Services\Client\Student;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Mail\StudentCancel;
use App\Mail\TeacherCancel;
use App\Models\CourseSchedule;
use App\Repositories\ApplicantRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\PurchaseRepositoryEloquent;
use App\Repositories\SettlementRepository;
use App\Services\BaseService;
use App\Services\Client\Common\FirebaseService;
use App\Services\Common\StripePaymentService;
use App\Traits\RealtimeTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class MyPageOrderService extends BaseService
{
    use RealtimeTrait;

    private $applicantRepository;
    private $settlementRepository;
    private $courseScheduleRepository;
    private $stripePaymentService;
    private $firebaseService;

    /**
     * MyPageOrderService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->applicantRepository = app(ApplicantRepository::class);
        $this->settlementRepository = app(SettlementRepository::class);
        $this->courseScheduleRepository = app(CourseScheduleRepository::class);
        $this->stripePaymentService = app(StripePaymentService::class);
        $this->firebaseService = app(FirebaseService::class);
    }

    /**
     * @return string
     */
    public function repository()
    {
        return PurchaseRepositoryEloquent::class;
    }

    /**
     * Cancel participation.
     *
     * @param $request
     * @return array|bool[]
     */
    public function cancelParticipation($request)
    {
        $courseScheduleId = $request->course_schedule_id;
        $userId = auth('client')->id();
        // Check if the user can cancel.
        $applicant = $this->applicantRepository->getApplicantWithCourseSchedule($courseScheduleId);
        if (empty($applicant)) {
            return [
                'success' => false,
                'message' => __('message.already'),
            ];
        }

        // Check 22:00 on the day before the day of start date time schedule course <= now.
        if (now() > (Carbon::parse($applicant['startDateTime'])->subDay(1)->format('Y-m-d')) . ' ' . Constant::TIME_ORDER_CANCEL) {
            return [
                'message' => __('message.deadline_cancel'),
            ];
        }

        // Get settlements info. Cannot be canceled because payment has been confirmed
        $settlementsInfo = $this->settlementRepository->getSettlementsInfo($courseScheduleId);
        if (empty($settlementsInfo)) {
            return [
                'message' => __('message.cannot_be_canceled'),
            ];
        }

        DB::beginTransaction();

        try {
            $courseSchedule = $this->courseScheduleRepository->getCourseSchedule($courseScheduleId);

            // Teacher cancel before.
            if (!empty($courseSchedule) && $courseSchedule['status'] == DBConstant::COURSE_SCHEDULES_STATUS_CANCELED) {
                return [
                    'message' => __('message.canceled'),
                ];
            }

            // Applicant cancel.
            $applicant = $this->applicantRepository->getApplicant($courseScheduleId);

            $applicant->update(['canceled_at' => now()], $userId);

            //Cancel the authorization of the settlement at 1-2) on Stripe
            $detailPayment = $this->stripePaymentService->getDetailPaymentIntents($settlementsInfo->str_payment_id);
//            if (strtolower($settlementsInfo->card_brand) === strtolower(Constant::CARD_AMEX)) {
//                $timestampRaw = $detailPayment->created;
//                $timestamp = gmdate("Y-m-d H:i:s", $timestampRaw);
//                $expirationDate = now()->subday(Constant::EXPIRATION_DATE);
//                if ($expirationDate > $timestamp) {
//                    return [
//                        'message' => __('message.failed_cancel_credit_card_payment')
//                    ];
//                }
//            }
            //Update settlements record.
            $this->settlementRepository->updateSettlements($settlementsInfo->str_payment_id, $detailPayment->amount);
            // Update purchase record.
            $this->repository->update([
                'status' => DBConstant::PURCHASES_STATUS_NOT_CANCELED_BEFORE_CAPTURE,
                'student_canceled_at' => now(),
                'canceled_at' => now(),
            ], $settlementsInfo['purchase_id']);

            // Update the number of applicants.
            $courseSchedule = $this->courseScheduleRepository->with(['course' => function ($q) {
                $q->select('course_id', 'user_id')->with(['user']);
            }])->find($courseScheduleId);

            // follow teacher when pay course success
//            $teacherId = $this->courseScheduleService->join('courses as c', 'course_schedules.course_id', '=', 'c.course_id')->where([
//                'course_schedules.course_schedule_id' => $courseSchedule->course_schedule_id
//            ])->first();

            $this->courseScheduleRepository->update(['num_of_applicants' => $courseSchedule['num_of_applicants'] - 1], $courseScheduleId);

            // update room message not buyer
            $this->firebaseService->updateRoomStudentCancel($courseSchedule->course_schedule_id, $userId);

            if (isset($courseSchedule->course->user)) {
                $course = $this->courseScheduleRepository->find($courseScheduleId);
                //Send mail to teacher.
                Mail::to(\Auth()->guard('client')->user()->email)->queue(
                    new StudentCancel(
                        '【Lappi】予約キャンセルが完了しました。',
                        $course,
                        $courseSchedule->course->user->full_name,
                        \Auth()->guard('client')->user()->full_name

                    ));
                //Send mail to user.
                Mail::to($courseSchedule->course->user->email)->queue(
                    new TeacherCancel(
                        '【Lappi】予約キャンセルのご連絡',
                        $course,
                        $courseSchedule->course->user->full_name,
                        \Auth()->guard('client')->user()->full_name
                    ));
            }
            $this->stripePaymentService->cancelPaymentIntent($settlementsInfo->str_payment_id);
            DB::commit();

            // event cancel success
            $this->sendEvent('realtime', [
                'url' => '/course-schedules/',
                'screen' => 'SCHEDULE_DETAIL',
                'id' => (int)$courseScheduleId
            ]);

            return [
                'success' => true,
                'message' => __('message.cancel_course_success')
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
//                'message' => __('message.failed_cancel_credit_card_payment')
            ];
        }
    }

    /**
     * Get order cancel.
     *
     * @return mixed
     */
    public function orderCancel()
    {
        return $this->courseScheduleRepository->orderCancel();
    }

    /**
     * Update status in table course_schedules
     *
     * @param $request
     * @return array|bool[]
     */
    public function cancelOrderConfirm($request)
    {
        try {
            $this->courseScheduleRepository->cancelOrderConfirm($request->course_schedule_id);
            $this->applicantRepository->cancelOrderConfirm($request->course_schedule_id);
            return [
                'success' => true,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
