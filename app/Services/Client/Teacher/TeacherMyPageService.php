<?php

declare(strict_types=1);

namespace App\Services\Client\Teacher;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Jobs\SendFollowMail;
use App\Mail\TeacherRequestTransfer;
use App\Repositories\ApplicantRepository;
use App\Repositories\BankAccountHistoryRepository;
use App\Repositories\BankAccountRepository;
use App\Repositories\BoxNotificationRepository;
use App\Repositories\CashRepository;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\FollowRepository;
use App\Repositories\MessageRepository;
use App\Repositories\PromotionalMessageRepository;
use App\Repositories\PurchaseRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\SaleRepository;
use App\Repositories\StripeLogRepository;
use App\Repositories\SubscriberRepository;
use App\Repositories\TransferHistoryRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Services\Client\Common\FirebaseService;
use App\Services\Common\StripePaymentService;
use App\Services\Common\WithdrawCashService;
use App\Traits\PromotionTrait;
use App\Traits\RealtimeTrait;
use App\Traits\StripeTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * Class TeacherMyPageService.
 */
class TeacherMyPageService extends BaseService
{
    use RealtimeTrait, PromotionTrait, StripeTrait;

    private $promotionalMessageRepository;
    private $subscriberRepository;
    private $messageRepository;
    private $commonService;
    private $transferHistoryRepository;
    private $followRepository;
    private $saleRepository;
    private $courseScheduleRepository;
    private $courseRepository;
    private $reviewRepository;
    private $bankAccountRepository;
    private $cashRepository;
    private $boxNotificationRepository;
    private $userRepository;
    private $applicantRepository;
    private $firebaseService;
    private $stripePaymentService;
    private $bankAccountHistory;
    private $purchaseRepository;
    private $stripeLogRepository;


    /**
     * TeacherMyPageService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->promotionalMessageRepository = app(PromotionalMessageRepository::class);
        $this->subscriberRepository = app(SubscriberRepository::class);
        $this->messageRepository = app(MessageRepository::class);
        $this->commonService = app(WithdrawCashService::class);
        $this->transferHistoryRepository = app(TransferHistoryRepository::class);
        $this->followRepository = app(FollowRepository::class);
        $this->saleRepository = app(SaleRepository::class);
        $this->courseScheduleRepository = app(CourseScheduleRepository::class);
        $this->reviewRepository = app(ReviewRepository::class);
        $this->bankAccountRepository = app(BankAccountRepository::class);
        $this->cashRepository = app(CashRepository::class);
        $this->boxNotificationRepository = app(BoxNotificationRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->applicantRepository = app(ApplicantRepository::class);
        $this->firebaseService = app(FirebaseService::class);
        $this->bankAccountHistory = app(BankAccountHistoryRepository::class);
        $this->stripePaymentService = app(StripePaymentService::class);
        $this->courseRepository = app(CourseRepository::class);
        $this->purchaseRepository = app(PurchaseRepository::class);
        $this->stripeLogRepository = app(StripeLogRepository::class);
    }

    public function repository()
    {
        // TODO: Implement repository() method.
    }

    /**
     * Get purchaser list.
     *
     * @param mixed $data
     * @return mixed
     */
    public function purchaserList($data)
    {
        return $this->applicantRepository->getListApplicant($data);
    }

    /**
     * Send Promotional Message.
     * @param mixed $request
     * @return false
     */
    public function sendPromotionalMessage($request)
    {
        DB::beginTransaction();
        try {
            $sessionId = auth('client')->user()->user_id;
            //1-2) Get recipients.
            $subscribers = $this->subscriberRepository->findWhere(['to_user_id' => $sessionId]);
            // 1-1) Create promotional message record.
            $promotionalMessage = $this->promotionalMessageRepository->create([
                'from_user_id' => $sessionId,
                'title' => $request->title,
                'body' => $request->body,
                'num_of_delivery' => $subscribers ? count($subscribers) : 0,
            ]);
            // Create message.
            if (count($subscribers) > 0) {
                $toUserIds = [];
                foreach ($subscribers as $subscriber) {
                    $toUserIds[] = $subscriber['from_user_id'];
                    $this->messageRepository->create([
                        'promotional_message_id' => $promotionalMessage['promotional_message_id'],
                        'to_user_id' => $subscriber['from_user_id'],
                        'is_read' => DBConstant::MESSAGE_NOT_READ,
                    ]);

                    // make message room firebase
                    $message = '<b>' . $request->title . '</b><br/>' . $request->body;
                    $this->firebaseService->sendMessagePromotion($sessionId, $subscriber['from_user_id'], $message);
                }

                $this->sendEmailFollow($toUserIds, $request->title, $request->body);


            }
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Send email when enable follow
     *
     * @param array $toUserIds
     * @param string $title
     * @param string $content
     */
    public function sendEmailFollow(array $toUserIds, string $title, string $content)
    {
        if (!count($toUserIds)) {
            return;
        }

        $users = $this->userRepository
            ->join('notification_settings as ns', 'ns.user_id', '=', 'users.user_id')
            ->where('ns.followed_or_faved', DBConstant::NOTIFICATION_SETTING_ENABLED)
            ->whereIn('users.user_id', $toUserIds)
            ->select('users.*')->get()->toArray();
//        $fromUser = auth()->guard('client')->user()->nickname;
        foreach ($users as $user) {
            $emailJob = new SendFollowMail('【Lappi】お知らせ配信のメッセージがありました。', $user['email'], $user['full_name'], Auth::guard('client')->user()->full_name, $title, $content);
            dispatch($emailJob);
        }
    }

    /**
     * Withdrawal Request.
     *
     * @param $request
     * @return mixed
     */
    public function withDrawalRequest($request)
    {
        // 1-1) Withdraw cash.
        $userLogin = auth('client')->user();
        if (!$userLogin) {
            return false;
        }
        $withdrawalAmount = $request->withdrawal_amount;
        $withdrawalReason = DBConstant::WITHDRAWAL_REASON_WITHDRAWAL_REQUEST;
        $cash = $this->commonService->withdrawalCash($userLogin->user_id, $withdrawalAmount, $withdrawalReason);
        Mail::to($userLogin->email)->queue(new TeacherRequestTransfer($withdrawalAmount, $userLogin->full_name));
        $bankAccount = $this->bankAccountRepository
            ->where('user_id', $userLogin->user_id)
            ->first();
        if ($bankAccount) {
            $bankAccountHistory = $this->bankAccountHistory->create([
                'user_id' => $bankAccount->user_id,
                'old_id' => $bankAccount->id,
                'bank_name' => $bankAccount->bank_name,
                'branch_name' => $bankAccount->branch_name,
                'account_type' => $bankAccount->account_type,
                'account_number' => $bankAccount->account_number,
                'account_name' => $bankAccount->account_name
            ]);
        }
        $scheduleDate = schedule_payout();

        $newTf = $this->transferHistoryRepository->create([
            'cash_id' => $cash['cash_id'],
            'bank_id' => $bankAccountHistory->id ?? null,
            'status' => DBConstant::TRANSFER_HISTORIES_STATUS_APPROVED,
            'teacher_profit' => $cash['teacher_profit'],
            'withdrawal_amount' => $withdrawalAmount,
            'transfer_fee' => Constant::TRANSFER_FEE,
            'transfer_amount' => $withdrawalAmount - Constant::TRANSFER_FEE,
            'scheduled_date' => $scheduleDate,
            'transferred_at' => holiday($scheduleDate),
        ]);

        $this->stripeLogRepository->create([
            'balance' => $this->stripeLogRepository->getLastBalance() + Constant::TRANSFER_FEE,
            'type' => DBConstant::STRIPE_LOG_TYPE_IN
        ]);

        $this->sendEvent('realtime', [
            'url' => '/portal/transfer-histories',
            'screen' => 'TRANSFER',
            'id' => $newTf->id
        ]);

        return $newTf;
    }

    /**
     * Get total price.
     *
     * @return mixed
     */
    public function getTotalPrice()
    {
        return $this->cashRepository->getTotalBalance();
    }

    /**
     * @return void
     */
    public function dataMonth()
    {
        $data = [
            'startDate' => now()->startOfMonth()->toDateString(),
            'endDate' => now()->endOfMonth()->toDateString(),
        ];
        $numberOfTransfers = $this->cashRepository->numberOfTransfer($data['startDate'], $data['endDate']);
        $transferRecord = $this->cashRepository->transferRecord($data);
        if ($transferRecord > 0) {
            $transferRecord = number_format((int)$transferRecord);
        }
        $lastDay = $this->cashRepository->transferRecordLastDay();
        if (isset($lastDay)) {
            $data = [
                'startDate' => $lastDay,
                'endDate' => now()->endOfMonth()->toDateString(),
            ];
        }

        $sellerProfitsInMonth = $this->saleRepository->where('sales.user_id', auth('client')->user()->user_id)->whereBetween('sales.target_date', [$data['startDate'], $data['endDate']])->sum('teacher_profit');
        $saleTaxInMonth = $this->saleRepository->where('sales.user_id', auth('client')->user()->user_id)->whereBetween('sales.created_at', [$data['startDate'], $data['endDate']])->sum('sales_commissions');
        $balance = $sellerProfitsInMonth - $saleTaxInMonth;
        return [
            'numberOfTransfers' => $numberOfTransfers,
            'transferRecord' => $transferRecord,
            'balance' => $balance,
        ];
    }

    /**
     * Get List Follower.
     */
    public function listFollower($request)
    {
        return $this->followRepository->getFollowByUserId($request);
    }

    /**
     * Get List Follower.
     */
    public function totalListFollower()
    {
        return $this->followRepository->getTotalFollowByUserId();
    }

    /**
     * list Teacher Sale.
     *
     * @param mixed $request
     * @return mixed
     */
    public function listTeacherSale($request)
    {
        $data = [
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => $request->user_id,
        ];

        return $this->saleRepository->getSaleTargetMonth($data);
    }

    /**
     * Get sale history.
     *
     * @param $request
     * @return mixed
     */
    public function saleHistory($request)
    {
        return $this->courseScheduleRepository->saleHistory($request);
    }

    /**
     * Sale history student list.
     *
     * @param $courseScheduleId
     * @param $request
     * @return mixed
     */
    public function saleHistoryStudentList($courseScheduleId, $request)
    {
        return $this->courseScheduleRepository->saleHistoryStudentList($courseScheduleId, $request);
    }

    /**
     * Get sale history review.
     *
     * @param $courseScheduleId
     * @param $request
     * @return mixed
     */
    public function saleHistoryReview($courseScheduleId, $request)
    {
        return $this->reviewRepository->saleHistoryReview($courseScheduleId, $request);
    }

    /**
     * Get sale profit live stream.
     *
     * @param $request
     * @return mixed
     */
    public function saleProfitLiveStream($request)
    {
        //get course first.
        $userId = auth('client')->id();
//        $userFirstCourse = $this->courseRepository->where([
//            'user_id' => $userId,
//            'status' => DBConstant::APPROVAL_STATUS_COURSE
//        ])->orderBy('courses.updated_at', 'ASC')->pluck('updated_at')->first();
//        $userLastCourse = $this->courseRepository->where([
//            'user_id' => $userId,
//            'status' => DBConstant::APPROVAL_STATUS_COURSE
//        ])->orderBy('courses.updated_at', 'DESC')->pluck('updated_at')->first();
        $textProfitUser = $this->checkPromotion($userId, 0, false, now());
        //distance between 2 times first and last course.
//        if (isset($userFirstCourse)) {
//            $distanceBetweenTime = $userFirstCourse->diffInDays(now());
//            if ((int)$distanceBetweenTime < Constant::TEACHER_PROMOTION_DAY) {
//                $textProfitUser = true;
//            }
//        }

        return [
            'profitLiveStream' => $this->saleRepository->saleProfitLiveStream($request),
            'textProfitUser' => $textProfitUser
        ];
    }

    /**
     * Get transfer apply livestream.
     *
     * @param $request
     * @return array
     */

    public function getTransferApplyLiveStream($request)
    {
        $user = auth('client')->user();
        if ($user->connect_verification_session !== DBConstant::CONNECT_VERIFICATION_SESSION_SUCCESS) {
            $canTransferWithMinDay = false;
        } else {
            $csPublic = $this->courseRepository
                ->join('course_schedules', 'courses.course_id', '=', 'course_schedules.course_id')
                ->where('user_id', auth('client')->id())
                ->pluck('course_schedules.course_schedule_id')->toArray();
            $canTransferWithMinDay = $this->purchaseRepository
                ->where('status', DBConstant::PURCHASES_STATUS_CAPTURED)
                ->where(DB::raw("DATE_ADD(updated_at, INTERVAL " . Constant::MIN_DAY_FOR_TRANSFER . " DAY)"), '<', now())
                ->whereIn('course_schedule_id', $csPublic)
                ->count();
        }

        return [
            'dataTransferApplyLiveStream' => $this->saleRepository->getTransferApplyLiveStream($request),
            'totalPrice' => $user->cash_balance,
            'canTransferWithMinDay' => $canTransferWithMinDay,
            'cardInfo' => $this->bankAccountRepository->getBankAccount()
        ];
    }

    public function updateBankAccount($id, $request)
    {
        DB::beginTransaction();
        try {
            $user = auth('client')->user();
            if (!$user) {
                return [
                    'success' => false
                ];
            }
            $this->bankAccountRepository
                ->find($id)
                ->update($request->all());

            // check if exist transfer history end status is 5 => update to 6
            $tfQuery = $this->transferHistoryRepository
                ->join('cashes', 'cashes.cash_id', '=', 'transfer_histories.cash_id')
                ->join('users', 'users.user_id', '=', 'cashes.user_id')
                ->where([
                    'cashes.user_id' => $user->user_id,
                    'transfer_histories.status' => DBConstant::TRANSFER_HISTORIES_STATUS_REPORT_TEACHER
                ]);

            $listUpdateBankHistory = $tfQuery->pluck('bank_id')->toArray();
            $transfers = $tfQuery->select('transfer_histories.id', 'users.str_connect_id', 'users.user_id', 'transfer_histories.*', 'users.email')
                ->get();
            $this->bankAccountHistory
                ->whereIn('id', $listUpdateBankHistory)
                ->update($request->except('_token'));
            // update bank account on stripe
            $this->stripePaymentService->updateBankCustomAccount();

            if (count($transfers)) {
                foreach ($transfers as $transfer) {
                    $newPo = $this->tranferOut($transfer);
                    $this->sendEvent('realtime', [
                        'url' => '/portal/transfer-histories',
                        'screen' => 'TRANSFER',
                        'id' => $transfer->id
                    ]);
                    $this->transferHistoryRepository->find($transfer->id)
                        ->update([
                        'str_payout_id' => $newPo->id ?? 'FAIL',
                        'status' => DBConstant::TRANSFER_HISTORIES_STATUS_TEACHER_UPDATE
                    ]);
                }
            }

            DB::commit();

            return [
                'success' => true
            ];
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => '口座情報は正しくありません。'
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false
            ];
        }
    }

    /**
     * List Notices.
     *
     * @return array.
     */
    public function listNotices($request)
    {
        $sessionId = auth('client')->id();
        //get subscribers
        $subscribers = $this->subscriberRepository->findWhere(['to_user_id' => $sessionId]);
        //get list notices
        $promotionalMessages = $this->promotionalMessageRepository->listPromotionalMessages($request);
        //count data message
        $countDataMessage = $this->countDataMessage();

        return [
            'countDataMessage' => $countDataMessage,
            'count_subscriber' => count($subscribers),
            'notices' => $promotionalMessages['notices'],
            'dataOption' => $promotionalMessages['dataOption'],
        ];
    }

    /**
     * List notifications.
     *
     * @param $request
     *
     * @return array
     */
    public function listNotifications($request)
    {
        //Get list notification
        $listMessage = $this->boxNotificationRepository->getNotificationList($request);
        //Count data message
        $countMessage = $this->countDataMessage();

        return [
            'dataOption' => $listMessage['dataOption'],
            'notifications' => $listMessage['notifications'],
            'countDataMessage' => $countMessage,
        ];
    }

    /**
     * Change status read notification.
     *
     * @param $request
     * @return string
     */
    public function changeStatusReadMessage($request)
    {
        DB::beginTransaction();
        try {
            $result = $this->boxNotificationRepository->update([
                'is_read' => DBConstant::MESSAGE_READ,
                'read_at' => Carbon::now()
            ], $request->id);
            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }

    /**
     * Count data message.
     *
     * @return array
     */
    public function countDataMessage()
    {
        $unreadNotification = $this->boxNotificationRepository->getUnReadNotification();

        return [
            'unreadNotification' => $unreadNotification
        ];
    }

    /**
     * Teacher stop service
     *
     * @param $request
     * @return array
     */
    public function teacherStopService(): array
    {
        // set value
        $userId = Auth::guard('client')->id();

        // 1-2) Check if cash balance is not negative.
        $user = Auth::guard('client')->user();

        if (!$user) {
            return [];
        }

        if ($user->cash_balance < 0) {
            return [
                'status' => false,
                'message' => __('errors.MSG_6030')
            ];
        }

        // 1-3)	Check if the user has open course schedules.
        $courseSchedule = $this->courseScheduleRepository->courseCheckStopService($userId, true);

        if (count($courseSchedule)) {
            return [
                'status' => false,
                'message' => __('errors.MSG_6031')
            ];
        }

        return $this->userRepository->changeStatus();
    }

    public function updateStatusUser()
    {
        // Check there are no current and upcoming courses
        $courseSchedules = $this->courseScheduleRepository->getCourseScheduleUser();
        // If isset course schedules.
        if (isset($courseSchedules) && $courseSchedules === 0) {
            return $this->userRepository->changeStatus();
        }

        return [
            'message' => 'サービス休止はできません。',
            'status' => false
        ];
    }
}
