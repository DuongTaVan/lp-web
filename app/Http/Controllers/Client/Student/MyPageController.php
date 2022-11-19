<?php

namespace App\Http\Controllers\Client\Student;

use App\Enums\Constant;
use App\Enums\ErrorType;
use App\Repositories\CourseRepository;
use App\Repositories\PageViewRepository;
use App\Services\Client\Common\FirebaseService;
use App\Services\Client\CourseSchedule\ViewedRecentlyService;
use App\Services\Client\Student\Course\CourseReviewService;
use App\Services\Client\Student\MyPagePurchasePointService;
use App\Services\Client\TeacherPage\TeacherPageService;
use App\Traits\ManageFile;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Client\Auth\ChangePasswordRequest;
use App\Http\Requests\Client\Auth\UpdateProfileRequest;
use App\Http\Requests\Client\Student\CloseAccountRequest;
use App\Http\Requests\Client\Teacher\UpdateProfileAccountRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Student\PurchaseDetailRequest;
use App\Services\Client\CourseSchedule\CourseScheduleService;
use App\Services\Client\Student\Course\MyPagePurchaseService;
use App\Services\Client\Student\MyPageOrderService;
use App\Services\Client\Student\MyPagePurchaseHistoryService;
use Illuminate\Http\Request;
use App\Services\Client\Student\MyPageFollowService;
use App\Services\Client\Student\MyPageNotiSettingService;
use App\Services\Client\Common\ClientService;
use App\Services\Client\Student\UserService;
use App\Enums\DBConstant;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class MyPageController
 * @package App\Http\Controllers\Client\Student
 */
class MyPageController extends Controller
{
    use ManageFile;

    private $userRepository;
    private $firebaseService;
    private $courseRepository;
    private $teacherPageService;
    protected $pageViewRepository;

    /**
     * List follow
     *
     * @param MyPageFollowService $followService
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */

    public function __construct()
    {
        $this->userRepository = app(UserRepository::class);
        $this->firebaseService = app(FirebaseService::class);
        $this->teacherPageService = app(TeacherPageService::class);
        $this->pageViewRepository = app(PageViewRepository::class);
        $this->courseRepository = app(CourseRepository::class);
    }

//    public function myPageFollowList()
//    {
//    }

    /**
     * Cancel Order in mypage.
     *
     * @param Request $request
     * @param MyPageOrderService $service
     * @return array|bool[]
     */
    public function cancelOrder(Request $request, MyPageOrderService $service)
    {
        return $service->cancelParticipation($request);
    }

//    /**
//     * List Purchase History.
//     *
//     * @param Request $request
//     * @param MyPagePurchaseHistoryService $service
//     * @return mixed
//     */
//    public function listPurchaseHistory(Request $request, MyPagePurchaseHistoryService $service)
//    {
//        return $service->getList($request);
//    }

    /**
     * Purchase detail.
     *
     * @param PurchaseDetailRequest $request
     * @param MyPagePurchaseHistoryService $service
     * @param CourseScheduleService $courseScheduleService
     * @return mixed
     */
    public function show(
        PurchaseDetailRequest        $request,
        MyPagePurchaseHistoryService $service,
        CourseScheduleService        $courseScheduleService
    )
    {
        $course = $courseScheduleService->getAllInfoCourse($request->id);
        $purchase = $service->purchaseDetail($request->id);
        return view('client.student-mypage.order-detail')->with([
            'purchaseDetail' => $purchase,
            'course' => $course
        ]);
    }

    /**
     * Screen student dashboard.
     *
     * @param Request $request
     * @param CourseScheduleService $service
     * @param MyPageFollowService $followService
     * @param MyPagePurchaseHistoryService $historyService
     * @param MyPagePurchaseService $purchaseService
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     */
    public function dashboard(
        Request                      $request,
        ViewedRecentlyService        $service,
        MyPageFollowService          $followService,
        MyPagePurchaseHistoryService $historyService,
        MyPagePurchaseService        $purchaseService
    )
    {
        if (!auth('client')->check()) {
            $notification = [
                'message' => __('errors.MSG_5023'),
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }

        $user = auth('client')->user();
        $follows = $followService->myPageFollowList($request);
        $purchaseHistories = $historyService->getList($request);
        $purchase = $purchaseService->courseSchedulePurchaseList($request);
        $messageUnread = $this->firebaseService->countMessageUnreadStudent();
        Cache::put('student/' . $user['user_id'] . '/count_message_unread', $messageUnread, 10000);
        $coursePurchasing = $messageUnread['purchasedOpen'];
        $courseNotPurchase = $messageUnread['notPurchase'];
        $orderReviews = $historyService->getAllOrderReview($request);
        $totalReviews = $historyService->totalCourseScheduleReview($orderReviews);
//        $courseViewedRecently = $service->listCourseScheduleViewed();
        $courseViewedRecently = $this->courseRepository->getCourseViewedRecently($this->pageViewRepository->getOneScheduleOfCourseRecently());

        return view('client.student-mypage.dashboard', compact(
            'follows', 'user', 'purchaseHistories', 'purchase', 'coursePurchasing',
            'courseNotPurchase', 'totalReviews', 'courseViewedRecently'
        ));
    }

    /**
     * Get list order cancel
     *
     * @param MyPageOrderService $service
     * @return view order
     */
    public function order(MyPageOrderService $service)
    {
        $orderCancels = $service->orderCancel();
        return view('client.student-mypage.order-cancel', compact('orderCancels'));
    }

    /**
     * Get List history service
     *
     * @return view list order
     */
    public function list(Request $request, MyPagePurchaseHistoryService $service)
    {
        $purchaseHistories = $service->getList($request);

        return view('client.student-mypage.order-list', compact('purchaseHistories'));
    }

    /**
     * Message
     *
     * @param Request $request
     * @param MyPagePurchaseHistoryService $service
     * @param CourseScheduleService $courseScheduleService
     * @return array|false
     */
    public function listMessage(Request $request, MyPagePurchaseHistoryService $service, CourseScheduleService $courseScheduleService)
    {
        if (!$request->exists('sort')) {
            $request->merge([
                'sort' => 1
            ]);
        }

        $data = $service->getRoomMessage($request);
        $unreadMessage = $this->firebaseService->getStudentMessageUnread($courseScheduleService);
        return view('client.student-mypage.courses.purchasing', compact('data', 'unreadMessage'));
    }

    public function updateReadMessage(Request $request)
    {
        $response = $this->firebaseService->updateIsRead($request);

        return response()->json(['success' => $response]);
    }

    /**
     * detail by room id
     *
     * @param string $roomId
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function detailRoom(string $roomId)
    {
        // check room exist
        // check authorize room
        $user = Auth::guard('client')->user();
        if (!$user) {
            throw new NotFoundHttpException();
        }

        $roomData = $this->firebaseService->getRoomById($roomId, $user['user_id']);
        if (empty($roomData)) {
            throw new NotFoundHttpException();
        }
        $roomData['roomId'] = $roomId;

        $teacher = $roomData['teacher_id'] ? $this->teacherPageService->getDataTeacherPage($roomData['teacher_id'], [
            'rating', 'countCourseScheduleHeld', 'countHoldingResult'
        ]) : null;

        $courseSchedule = null;
        if (isset($roomData['courseScheduleId'])) {
            $courseSchedule = $this->teacherPageService->getDetailCourseSchedule($roomData['courseScheduleId']);
        }

        return view('client.student-mypage.message-detail', compact('roomData', 'user', 'teacher', 'courseSchedule'));
    }

    /**
     * @param int $courseScheduleId
     * @param CourseScheduleService $courseScheduleService
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function getDetailCourseMessage(int $courseScheduleId, Request $request, CourseScheduleService $courseScheduleService)
    {
        $userId = auth('client')->id();
        $courseSchedule = $courseScheduleService->repository
            ->with(['course', 'purchases' => function ($query) use ($courseScheduleId, $userId) {
                $query->where('course_schedule_id', $courseScheduleId);
                $query->where('user_id', $userId);
                $query->whereIn('status', [DBConstant::PURCHASES_STATUS_CAPTURED, DBConstant::PURCHASES_STATUS_CANCELED_AFTER_CAPTURE, DBConstant::PURCHASES_STATUS_NOT_CAPTURED]);
            }])
            ->find($courseScheduleId);
        if ($courseSchedule->course && $courseSchedule->course->user_id === $userId) {
            throw new ModelNotFoundException();
        }

        $teacherId = $courseSchedule->course->user_id ?? null;
        $type = $courseSchedule->status === 0 ? DBConstant::ROOM_TYPE_OPEN : DBConstant::ROOM_TYPE_CLOSE;
        $status = $courseSchedule->purchases->count() > 0 ? DBConstant::ROOM_STATUS_PURCHASED : DBConstant::ROOM_STATUS_NOT_PURCHASED;
        $room = $this->firebaseService->getRoomByCourseScheduleId($teacherId, $userId, $courseScheduleId, $type, $status, $request->restock);
        $roomId = $room['roomId'];
//        $type = DBConstant::ROOM_COURSE;
//        if ($courseSchedule) {
//            $courseSchedule->end_datetime_string = $courseSchedule->end_datetime->toString();
//        }
        return redirect()->route('client.messages.room-detail', ['roomId' => $roomId]);

//        return view('client.student-mypage.detail-message',
//            compact('courseScheduleId', 'user', 'courseSchedule', 'type', 'roomId', 'typeRoom'));
    }

    /**
     * Get message detail user chat 1 - 1 teacher
     *
     * @param int $teacherId
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function getDetailTeacherMessage(int $teacherId)
    {
        $user = Auth::guard('client')->user();
        $roomId = $this->firebaseService->getRoomPrivateChat($teacherId, $user->user_id);
        $type = DBConstant::ROOM_PRIVATE;
        $courseSchedule = null;
        $data = $this->teacherPageService->getDataTeacherPage($teacherId);
        $rating = $data['rating'];
        $teacher = $data['users'];
        $teacher->countCourseScheduleHeld = $data['countCourseScheduleHeld'];
        $teacher->countHoldingResult = $data['countHoldingResult'];

        return view('client.student-mypage.detail-message',
            compact('roomId', 'user', 'type', 'courseSchedule', 'teacher', 'rating'));
    }

    /**
     * @param Request $request
     * @param CourseRepository $courseRepository
     * @param CourseScheduleService $courseScheduleService
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendDetailCourseMessage(Request $request, CourseRepository $courseRepository, CourseScheduleService $courseScheduleService)
    {
        try {
            $courseScheduleId = $request->courseScheduleId ?? null;
            $teacherId = $request->teacherId ?? null;
            $message = $request->message ?? null;
            $roomIds = $request->roomIds;
            $userId = auth()->guard('client')->id();
            // if it has course Schedule : Send message with course
            if ($courseScheduleId) {
                $courseSchedule = $courseRepository->getTeacherOfCourseSchedule($courseScheduleId);
                $countPurchase = $courseScheduleService->repository
                    ->with(['course', 'purchases' => function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                        $query->whereIn('status', [DBConstant::PURCHASES_STATUS_CAPTURED, DBConstant::PURCHASES_STATUS_CANCELED_AFTER_CAPTURE, DBConstant::PURCHASES_STATUS_NOT_CAPTURED]);
                    }])
                    ->find($courseScheduleId);
                $typeRoom = $countPurchase->purchases->count() > 0 ? DBConstant::ROOM_PURCHASED : DBConstant::ROOM_NOT_PURCHASED;
                $teacherId = $courseSchedule->teacher;
            } else {// send message 1 - 1
                $typeRoom = DBConstant::ROOM_NOT_PURCHASED;
            }

            $this->firebaseService->sendMessageToRoomIds($roomIds, $userId, $message);
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false
            ], ErrorType::STATUS_5000);
        }
    }

    /**
     *  Get order review service
     *
     * @return review list review
     */
    public function review(Request $request, MyPagePurchaseHistoryService $service)
    {
        switch ($request->tab) {
            case Constant::TAB_NOT_REVIEW:
                $orderReviews = $service->getOrderNotReview($request);
                break;
            case Constant::TAB_REIVEWED:
                $orderReviews = $service->getOrderReviewed($request);
                break;
            default:
                $orderReviews = $service->getOrderReview($request);
                break;
        }
        return view('client.student-mypage.order-review', compact('orderReviews'));
    }

    /**
     *
     * @return review order-view
     */
    public function view($id, CourseReviewService $courseReviewService)
    {
        return $courseReviewService->getReviewView($id);
    }

    /**
     * Purchase Service.
     */
    public function purchaseService(Request $request, MyPagePurchaseService $service)
    {
        $data = $service->courseSchedulePurchaseList($request);

        return view('client.student-mypage.purchase-service', compact('data'));
    }

    /**
     *  Purchase service livestream.
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function liveStream()
    {
        return view('client.student-mypage.live-stream');
    }

    /**
     * @return review point-view
     */
    public function point(Request $request, MyPagePurchasePointService $myPagePurchasePoint)
    {
        $searchParam = $request->all();
        $data = $myPagePurchasePoint->getListPoint($request);
        $pointBalance = $this->userRepository->findWhere([
            'user_id' => \auth()->guard('client')->user()->user_id,
        ])->first();
        foreach ($data['listPoint'] as $index => $item) {
            $data['listPoint'][$index]['img'] = $this->getS3FileUrl($item['dir_path'] . '/' . $item['file_name']) ?? asset('assets/img/portal/default-image.svg');
        }
        return view('client.student-mypage.point-view')->with([
            'data' => $data,
            'searchParam' => $searchParam,
            'pointBalance' => $pointBalance,
        ]);
    }

    /**
     * @return review coupon-view
     */
    public function coupon()
    {
        return view('client.student-mypage.coupon-view');
    }

    /**
     * @return review follow-view
     */
    public function follow(Request $request, MyPageFollowService $followService)
    {
        $data = $followService->myPageFollowList($request);
        return view('client.student-mypage.follow-view', compact('data'));
    }

    /**
     * @return review account-setting
     */
    public function accountSetting()
    {
        return view('client.student-mypage.account-setting');
    }

    /**
     * @return review change-password
     */
    public function display()
    {
        return view('client.student-mypage.change-password');
    }

    /**
     * changePassword
     *
     * @param mixed $request
     * @return void
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $request->flash();
        $user = Auth::guard('client')->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error-wrong', trans('errors.MSG_5025'));
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        $request->flush();
        return redirect()->back()->with('success', trans('message.change_password_success'));
    }

    /**
     * @return review noti-setting
     */
    public function notiSetting(MyPageNotiSettingService $service)
    {
        $notiSetting = $service->getNotifySetting(Auth::guard('client')->user()->user_id);

        return view('client.student-mypage.noti-setting')->with([
            'notiSetting' => $notiSetting
        ]);
    }

    /**
     * update setting notify user
     *
     * @param Request $request
     * @param MyPageNotiSettingService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function settingNotify(Request $request, MyPageNotiSettingService $service)
    {
        $data = [
            'user_id' => Auth::guard('client')->user()->user_id,
            'message' => $request->message ?? DBConstant::NOTIFICATION_SETTING_DISABLED,
            'followed_or_faved' => $request->followed_or_faved ?? DBConstant::NOTIFICATION_SETTING_DISABLED,
            'special_offers' => $request->special_offers ?? DBConstant::NOTIFICATION_SETTING_DISABLED,
            'maintenance' => $request->maintenance ?? DBConstant::NOTIFICATION_SETTING_DISABLED
        ];
        $result = $service->settingNotify($data);

        if (!$result['success']) {
            return redirect()->back()->withErrors([
                'error' => $result['message']
            ]);
        }

        return redirect()->back()->with('success', trans('message.setting_notify_success'));
    }

    /**
     * @return review delete-account
     */
    public function deleteAccount()
    {
        $user = auth()->guard('client')->user();
        return view('client.student-mypage.delete-account')->with(['user' => $user]);
    }

    /**
     * 29_Close account.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function closeAccount(CloseAccountRequest $request, UserService $service)
    {
        $result = $service->close($request);

        if ($result['status']) {
            return redirect()->route('client.login')->with(['success' => trans('message.delete_account_success')]);
        }

        return redirect()->back()->with(['error' => $result['message']]);
    }

    /**
     * @return review credit-card-info
     */
    public function creditCardInfo()
    {
        return view('client.student-mypage.credit-info');
    }

    /**
     * @return review profile-email
     */
    public function profileAndEmail()
    {
        $user = Auth::guard('client')->user();
        return view('client.student-mypage.profile-email')->with([
            'user' => $user
        ]);;
    }

    /**
     * @return review update profile and email
     */
    public function updateProfileAndEmail(UpdateProfileAccountRequest $request, ClientService $service)
    {
        $result = $service->updateProfileAccount($request);
        if ($result['success']) {
            return redirect()->back()->with(['success' => trans('message.update_profile_success')]);
        }

        return redirect()->back()->with(['error' => $result['message']]);
    }

    /**
     * @return review update profile-email
     */
    public function updateProfile(UpdateProfileRequest $request, ClientService $service)
    {
        return $service->updateProfileStudent($request);
    }

    /**
     * Update status in table course_schedules
     *
     * @param Request $request
     * @param MyPageOrderService $service
     * @return mixed
     */
    public function cancelOrderConfirm(Request $request, MyPageOrderService $service)
    {
        return $service->cancelOrderConfirm($request);
    }

    /**
     * Screen message detail chat 1_1
     */
    public function detailMessage()
    {
        return view('client.student-mypage.detail-message');
    }

    /**
     * Screen edit-profile-email
     */
    public function updateProfileEmail()
    {
        $user = Auth::guard('client')->user();
        return view('client.student-mypage.edit-profile-email')->with([
            'user' => $user
        ]);
    }
    public function liveStreamGuide(){
        return view('client.student-mypage.live-stream');
    }

    public function videoCallGuide(){
        return view('client.student-mypage.video-call');
    }
}
