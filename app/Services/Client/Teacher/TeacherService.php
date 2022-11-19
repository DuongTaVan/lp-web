<?php

namespace App\Services\Client\Teacher;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Enums\ErrorType;
use App\Mail\StudentCancelCourse;
use App\Mail\TeacherCancelCourse;
use App\Repositories\ApplicantRepository;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\FollowRepository;
use App\Repositories\PageViewRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\SaleRepository;
use App\Repositories\SettlementRepository;
use App\Repositories\StripeLogRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Services\Client\Common\FirebaseService;
use App\Services\Common\StripePaymentService;
use App\Services\Common\WithdrawCashService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TeacherService extends BaseService
{
    private $pageViewRepository;
    private $applicantRepository;
    private $courseSchedulesRepository;
    private $purchaseRepository;
    private $settlementRepository;
    private $followRepository;
    private $stripePaymentService;
    private $firebaseService;
    private $courseRepository;
    private $userRepository;
    private $stripeLogRepository;

    /**
     * TeacherService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->pageViewRepository = app(PageViewRepository::class);
        $this->applicantRepository = app(ApplicantRepository::class);
        $this->courseSchedulesRepository = app(CourseScheduleRepository::class);
        $this->purchaseRepository = app(PurchaseRepository::class);
        $this->settlementRepository = app(SettlementRepository::class);
        $this->followRepository = app(FollowRepository::class);
        $this->stripePaymentService = app(StripePaymentService::class);
        $this->firebaseService = app(FirebaseService::class);
        $this->courseRepository = app(CourseRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->stripeLogRepository = app(StripeLogRepository::class);
    }

    public function repository()
    {
        return SaleRepository::class;
    }

    /**
     * Get my teacher dashboard.
     *
     * @param $request
     * @return array
     */
    public function myTeacherDashboard($request)
    {
        $userId = auth()->guard('client')->user()->user_id;
        if (isset($request->month)) {
            $date = $request->year . '/' . $request->month . '/01';
            $data = [
                'startDate' => Carbon::parse($date)->startOfMonth()->toDateString(),
                'endDate' => Carbon::parse($date)->endOfMonth()->toDateString(),
                'userId' => $userId,
                'year' => $request->year,
                'month' => $request->month
            ];
        } else {
            $data = [
                'startDate' => Carbon::now()->startOfMonth()->toDateString(),
                'endDate' => Carbon::now()->endOfMonth()->toDateString(),
                'userId' => $userId,
                'year' => Carbon::now()->year,
                'month' => Carbon::now()->month
            ];
        }
        $sales = $this->repository->teacherDashboard($request, $data);
        $dataSexRatio = [$sales->sales_male ?? 0, $sales->sales_female ?? 0, $sales->sales_not_known ?? 0, $sales->sales_unapplicable ?? 0];
        $ageRatio = [$sales->sales_10s ?? 0, $sales->sales_20s ?? 0, $sales->sales_30s ?? 0, $sales->sales_40s ?? 0, $sales->sales_50s ?? 0, $sales->sales_60s ?? 0];
        $pageView = $this->pageViewRepository->getSumTeacherPageView($data);
        $countStudentCancellation = $this->applicantRepository->getCountStudentCancellation($request, $data);
        $countTeacherCancellation = $this->courseSchedulesRepository->getCountTeacherCancellation($request, $data);
        $countFollow = $this->getFollowerTeacher($userId, $data);
        return [
            'sales' => $sales,
            'pageView' => $pageView,
            'countStudentCancellation' => $countStudentCancellation,
            'countTeacherCancellation' => $countTeacherCancellation,
            'dataSexRatio' => $dataSexRatio,
            'ageRatio' => $ageRatio,
            'date' => $data,
            'follow' => $countFollow
        ];
    }


    /**
     * List sale service of teacher
     *
     * @param $data
     * @return mixed
     */
    public function getSaleCourse($data)
    {
        return $this->courseSchedulesRepository->getSaleCourse($data);
    }

    /**
     * Get follower teacher.
     *
     * @param $userId
     * @param $data
     * @return array
     */
    public function getFollowerTeacher($userId, $data)
    {
        return [
            'countFollow' => $this->followRepository->getCountFollow($userId),
            'countFollowInMonth' => $this->followRepository->getCountFollowInMonth($userId, $data)
        ];
    }

    /**
     * Get course drafts
     *
     * @param $data
     * @return mixed
     */
    public function getDrafts($data)
    {
        return $this->courseSchedulesRepository->getDrafts($data);
    }

    /**
     * Get course cancel
     *
     * @param $data
     * @return mixed
     */
    public function getCourseCancel($data)
    {
        return $this->courseSchedulesRepository->getCourseCancel($data);
    }

    /**
     * Cancel the captured settlement on Stripe.
     *
     * @param $request
     * @return array|bool[]|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function cancelCourse($request)
    {
        DB::beginTransaction();
        try {
            $courseScheduleId = $request->course_schedule_id;
            $userId = auth('client')->id();
            $courseScheduleCancel = $this->courseSchedulesRepository
                ->scopeQuery(function ($query) {
                    return $query->join('courses as c', 'c.course_id', '=', 'course_schedules.course_id')
                        ->select('course_schedules.*');
                })
                ->findWhere([
                    'c.user_id' => $userId,
                    'course_schedules.type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                    'course_schedules.canceled_at' => NULL,
                    'course_schedules.status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                    'course_schedules.course_schedule_id' => $courseScheduleId
                ])->first();

            if (!$courseScheduleCancel) {
                return response(__('errors.MSG_8000'), ErrorType::STATUS_4041);
            }

            \Cache::put('cancel_cs' . $courseScheduleId, $request->message, 10000);

            if (now() > now()->parse($courseScheduleCancel->purchase_deadline)) {
                $this->cancelAfterCapture($courseScheduleCancel);
                $result = [
                    'pending' => true
                ];
            } else {
                $this->cancelBeforeCapture($courseScheduleCancel);
                $result = [
                    'success' => true
                ];
            }

            DB::commit();

            return $result;
        } catch (\Exception $exception) {
            DB::rollBack();
//            Log::error($exception->getMessage());
            return response(__('errors.MSG_5000'), ErrorType::STATUS_5000);
        }
    }

    /**
     * cancel cs Before Capture
     *
     * @param $courseScheduleCancel
     */
    private function cancelBeforeCapture($courseScheduleCancel)
    {
        $courseScheduleId = $courseScheduleCancel->course_schedule_id;
        $userId = auth('client')->id();
        // update purchase data
        $purchases = $this->purchaseRepository
            ->where([
                'course_schedule_id' => $courseScheduleId,
                'status' => DBConstant::PURCHASES_STATUS_NOT_CAPTURED
            ])->get();
        $purchaseIds = $purchases->pluck('purchase_id')->toArray();
        $userIds = $purchases->pluck('user_id')->unique()->toArray();

        foreach ($purchases as $item) {
            $this->stripePaymentService->cancelPaymentIntent($item->settlement->str_payment_id);
        }

        $this->purchaseRepository
            ->where([
                'course_schedule_id' => $courseScheduleId,
                'status' => DBConstant::PURCHASES_STATUS_NOT_CAPTURED
            ])->update([
                'status' => DBConstant::PURCHASES_STATUS_NOT_CANCELED_BEFORE_CAPTURE,
                'canceled_at' => now()
            ]);

        // update settlements data
        $this->settlementRepository
            ->whereIn('purchase_id', $purchaseIds)
            ->where('status', DBConstant::SETTLEMENT_STATUS_APPROVED)
            ->update([
                'status' => DBConstant::SETTLEMENT_STATUS_VOIDED_CANCELED,
                'canceled_at' => now()
            ]);
        $this->courseSchedulesRepository->find($courseScheduleId)
            ->update([
                'status' => DBConstant::COURSE_SCHEDULES_STATUS_CANCELED,
                'canceled_at' => now()
            ]);
        $this->sendMailCancelCourseSchedule($userIds, $courseScheduleId);

        if (now()->parse($courseScheduleCancel->start_datetime)->subDay()->format('Y-m-d 22:00:00') <= now()->format('Y-m-d H:i:s')) {
            // 1-10
            $saleCommission = $courseScheduleCancel->price * Constant::SALES_COMMISSION_RATE / 100;
            $cancellationFee = 0;

            foreach ($userIds as $item) {
//                $withDrawService = new WithdrawCashService();
//                $cashId = $withDrawService->withdrawalCash($userId, $saleCommission, DBConstant::WITHDRAWAL_REASON_POINTS_EXPIRED);
//
//                $this->saleRepository->create([
//                    'user_id' => $userId,
//                    'course_schedule_id' => $courseScheduleId,
//                    'target_date' => now(),
//                    'cash_id' => $cashId,
//                    'base_price' => $courseScheduleCancel->price,
//                    'sales_commissions' => 0,
//                    'total_commissions' => 0,
//                    'teacher_profit' => -$saleCommission,
//                    'cash_balance' => -$saleCommission,
//                    'teacher_profit_exc_tax' => -$saleCommission,
//                    'cancellation_fee' => $saleCommission,
//                ]);
                $cancellationFee += $saleCommission;
            }
            $this->stripePaymentService->chargeConnectedAccount([
                'cancellation_fee' => $cancellationFee,
                'connect_id' => auth('client')->user()->str_connect_id
            ]);
        }
    }

    /**
     * cancel cs Before Capture
     *
     * @param $courseSchedule
     * @param $cancellationFee
     */
    public function cancelAfterCapture($courseSchedule)
    {
        $courseScheduleId = $courseSchedule->course_schedule_id;
        $purchases = $this->purchaseRepository
            ->where([
                'course_schedule_id' => $courseScheduleId,
                'status' => DBConstant::PURCHASES_STATUS_CAPTURED
            ])->get();

        $purchaseIds = $purchases->pluck('purchase_id')->toArray();
        // update settlements data
        $this->settlementRepository
            ->whereIn('purchase_id', $purchaseIds)
            ->where('status', DBConstant::SETTLEMENT_STATUS_CAPTURED)
            ->update([
                'status' => DBConstant::SETTLEMENT_STATUS_PENDING
            ]);

        // update status course_schedule to pending
        $courseSchedule->status = DBConstant::COURSE_SCHEDULES_STATUS_PENDING;
        $courseSchedule->save();
        foreach ($purchases as $item) {
            $this->stripeLogRepository->whenRefund($item->total_amount);
            $this->stripePaymentService->refundCapturedSettlement($item->settlement->str_payment_id);
        }
        $this->stripePaymentService->chargeConnectedAccount([
            'cancellation_fee' => $purchases->sum('total_amount') * Constant::SALES_COMMISSION_RATE / 100,
            'connect_id' => $courseSchedule->course->user->str_connect_id
        ]);
    }

    /**
     * send mail cancel course schedule
     *
     * @param array $userIds
     * @param int $courseScheduleId
     */
    private function sendMailCancelCourseSchedule(array $userIds, int $courseScheduleId)
    {
        //Send mail to user.
        $teacher = auth('client')->user();
        $courseScheduleCancel = $this->courseSchedulesRepository->find($courseScheduleId);
        if (!$teacher) {
            return;
        }
        // mailto teacher
        Mail::to($teacher->email)->queue(
            new TeacherCancelCourse(
                '【Lappi】キャンセルが完了しました。',
                $teacher->full_name,
                $courseScheduleCancel
            ));
        $mess = \Cache::pull('cancel_cs' . $courseScheduleId) ?? '';
        foreach ($userIds as $userId) {
            $type = DBConstant::ROOM_TYPE_CLOSE;
            $status = DBConstant::ROOM_STATUS_TEACHER_CANCEL;
            $update = true;
            $this->firebaseService->sendMessageSmart($mess, $teacher->user_id, (int)$userId, $courseScheduleId, $type, $status, $update);
            //Send mail to student.
            $emailUser = $this->userRepository->find($userId);
            Mail::to($emailUser->email)->queue(
                new StudentCancelCourse(
                    '【Lappi】出品者様からのキャンセルのご連絡',
                    $teacher->full_name,
                    $courseScheduleCancel,
                    $emailUser->full_name,
                    $mess
                ));
        }
    }

    /**
     * Delete course
     *
     * @param $request
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws \Exception
     */
    public function deleteCourse($request)
    {
        DB::beginTransaction();
        try {
            // Check cs of this teacher
            $courseSchedule = $this->courseSchedulesRepository->getCourseToDelete($request);
            if ($request->group) {
                //Remove the extension courses corresponding to the deleted course.
                $this->courseRepository->where([
                    'parent_course_id' => $request->id,
                    'type' => DBConstant::COURSE_TYPE_EXTENSION,
                    'group' => $request->group
                ])->delete();

                //Delete all the schedules of the respective sub-course.
                $this->courseSchedulesRepository->where([
                    'status' => DBConstant::COURSE_SCHEDULES_STATUS_DRAFT,
                    'group' => $request->group
                ])->delete();
            }

            if ($request->type === 'SCHEDULE') {
                if ($courseSchedule->num_of_applicants > 0) {
                    return redirect()->back()->with('error', __('errors.MSG_8009'));
                }
                // remove chat firebase with $request->id
                $this->firebaseService->removeRoom($request->id);
            } else {
                $courseSchedules = $this->courseSchedulesRepository->findWhere(['course_id' => $request->id])->count();
                if (!$courseSchedules) {
                    $course = $this->courseRepository->find($request->id);
                    if ($course && $course->status === DBConstant::COURSE_STATUS_DRAFT) {
                        $this->courseRepository->delete($request->id);
                        $sub = $this->courseRepository->findByField('parent_course_id', $request->id)->first();
                        if ($sub) {
                            $this->courseSchedulesRepository->deleteWhere(['course_id' => $sub->course_id]);
                            $this->courseRepository->delete($sub->course_id);
                        }
                    }
                }
            }
            DB::commit();
            return redirect()->back()->with('success', __('message.delete_success'));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
