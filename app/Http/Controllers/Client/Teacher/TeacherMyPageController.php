<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client\Teacher;

use App\Enums\Constant;
use App\Enums\ErrorType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\InquiryRequest;
use App\Http\Requests\Client\Teacher\PromotionalMessageRequest;
use App\Http\Requests\Client\Teacher\TeacherConfirmTransferRequest;
use App\Http\Requests\Client\Teacher\TeacherMyPageRequest;
use App\Http\Requests\Client\Teacher\UpdateBankAccountRequest;
use App\Http\Requests\Client\Teacher\UpdateTeacherRegistrationInfoRequest;
use App\Http\Requests\Client\Teacher\UpdateProfileAccountRequest;
use App\Http\Requests\Client\Teacher\TeacherMypageIdenttifyUpdateRequest;
use App\Http\Requests\Client\Teacher\UpdateProfileNicknameRequest;
use App\Http\Requests\Client\Teacher\UpdateBusinessCardRequest;
use App\Http\Requests\Client\Student\CloseAccountRequest;
use App\Mail\Inquiry;
use App\Mail\TeacherSendMailCourseSchedule;
use App\Services\Client\Common\FirebaseService;
use App\Services\Client\CourseSchedule\CourseScheduleService;
use App\Services\Client\Teacher\BankMasterService;
use App\Services\Client\Teacher\TeacherMyPageService;
use App\Services\Client\Teacher\TeacherService;
use App\Services\Client\Common\ClientService;
use App\Services\Client\Student\UserService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Traits\ManageFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDF;

class TeacherMyPageController extends Controller
{
    use ManageFile;

    protected $clientService;
    protected $courseScheduleService;
    private $firebaseService;
    private $userService;

    /**
     * TeacherMypageController constructor.
     */
    public function __construct(
        ClientService         $clientService,
        CourseScheduleService $courseScheduleService
    )
    {
        $this->clientService = $clientService;
        $this->courseScheduleService = $courseScheduleService;
        $this->firebaseService = app(FirebaseService::class);
        $this->userService = app(UserService::class);
    }

    /**
     * Teacher my-page dashboard
     *
     * @param Request $request
     * @param TeacherService $service
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function dashboard(Request $request, TeacherService $service)
    {
        $dashboard = $service->myTeacherDashboard($request);
        return view('client.screen.teacher.my-page.dashboard', compact('dashboard'));
    }

    /**
     * Get list purchaser.
     *
     * @param TeacherMyPageRequest $request
     * @param TeacherMyPageService $service
     * @return mixed
     */
    public function getList(TeacherMyPageRequest $request, TeacherMyPageService $service)
    {
        // Set params
        $data = [
            'course_schedule_id' => $request->course_schedule_id,
            'per_page' => $request->perpage ?? Constant::PER_PAGE_DEFAULT,
            'page' => $request->page ?? Constant::PAGE_DEFAULT,
        ];

        return $service->purchaserList($data);
    }

    /**
     * Send promotional message.
     *
     * @param PromotionalMessageRequest $request
     * @param TeacherMyPageService $service
     * @return bool
     */
    public function sendMessage(PromotionalMessageRequest $request, TeacherMyPageService $service)
    {
        return $service->sendPromotionalMessage($request);
    }

    /**
     * With drawal request.
     *
     * @param TeacherConfirmTransferRequest $request
     * @param TeacherMyPageService $service
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function withDrawal(TeacherConfirmTransferRequest $request, TeacherMyPageService $service)
    {
        DB::beginTransaction();
        try {
            $data = $service->withDrawalRequest($request);
            if (!$data) {
                return response([
                    'success' => false,
                    'message' => '初売上が確定するまで14日間がかかることとなりますので、しばらくお待ちください。'
                ]);
            }
            $totalPrice = $service->getTotalPrice();
            $dataMonth = $service->dataMonth();
            DB::commit();

            return response([
                'success' => true,
                'totalPrice' => $totalPrice->balance,
                'dataMonth' => $dataMonth
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response(['success' => false]);
        }
    }

    /**
     * @param TeacherMyPageService $service
     */
    public function listFollower(TeacherMyPageService $service): void
    {
        $data = $service->listFollower();
    }

    /**
     * Get list schedule sale history.
     *
     * @param Request $request
     * @param TeacherMyPageService $service
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function listTeacherSale(Request $request, TeacherMyPageService $service)
    {
        $saleHistories = $service->saleHistory($request);
        return view('client.screen.teacher.my-page.sale-history.index', compact('saleHistories'));
    }

    /**
     * Get list service or teacher
     * @param Request $request
     * @param CourseScheduleService $courseScheduleService
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function serviceList(Request $request, CourseScheduleService $courseScheduleService)
    {
        return $courseScheduleService->listServiceTeacher($request);
    }

    /**
     * Get list students applicant
     *
     * @param $courseScheduleId
     * @param Request $request
     * @param CourseScheduleService $courseScheduleService
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function getListStudent($courseScheduleId, Request $request, CourseScheduleService $courseScheduleService)
    {
        return $courseScheduleService->getListStudent($courseScheduleId, $request);
    }

    /** Sale History
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function saleHistory()
    {
        return view('client.screen.teacher.my-page.sale-history.index');
    }

    /**
     * Sale history student list.
     *
     * @param $courseScheduleId
     * @param TeacherMyPageService $service
     * @param Request $request
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function saleHistoryStudentList($courseScheduleId, TeacherMyPageService $service, Request $request)
    {
        $students = $service->saleHistoryStudentList($courseScheduleId, $request);
        return view('client.screen.teacher.my-page.sale-history.student-list', compact('students'));
    }

    /**
     * Sale History Review
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function saleHistoryReview($courseScheduleId, TeacherMyPageService $service, Request $request)
    {
        $reviews = $service->saleHistoryReview($courseScheduleId, $request);
        return view('client.screen.teacher.my-page.sale-history.review')->with(compact('reviews'));
    }

    /**
     * Message Page.
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function message()
    {
        return view('client.screen.teacher.my-page.message.index');
    }

    /**
     * Message Buyer Page.
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function messageBuyer($courseScheduleId, Request $request)
    {
        // TeacherMypage_Message_Buyer
        $params = [
            'page' => $request->page ?? 1,
            'limit' => Constant::PER_PAGE_DEFAULT, // default
            'option' => isset($request->option) ? $request->option == 1 ? 'DESC' : 'ASC' : 'DESC', // 1: DESC, 0: ASC default 1
        ];

        $data = $this->courseScheduleService->getListBuyerMessage($courseScheduleId, $params);
        $imageUrl = '';
        if (!empty($data['courseSchedule']->course) && !empty($data['courseSchedule']->course->imagePathByDisplayOrder->image_url)) {
            $imageUrl = $data['courseSchedule']->course->imagePathByDisplayOrder->image_url;
        }
        $messages = [
            'data' => [
                'courseSchedule' => $data['courseSchedule'],
                'image_url' => $imageUrl,
                'messages' => $data['messages']
            ],
            'pagination' => [
                'total' => $data['total'],
                'totalPage' => (int)ceil($data['total'] / (int)$params['limit']),
                'totalRecord' => $data['totalRecord'],
                'limit' => $params['limit'],
                'page' => $request->page ?? 1,
            ],
        ];
        return view('client.screen.teacher.my-page.message.buyer', compact('messages'));
    }

    /**
     * Get view message
     * @param $courseScheduleId
     * @param $userId
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function getMessageRoomDetail($courseScheduleId, $userId)
    {
        $roomInfo = $this->courseScheduleService->getRoomIdByCourseScheduleUser($courseScheduleId, $userId);
        $roomId = $roomInfo['roomId'];

        return redirect()->route('client.messages.room-detail', ['roomId' => $roomId]);
    }

    /**
     * Get view message private chat by userId
     * @param $studentId
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function getMessageRoomPrivate($studentId)
    {
        $teacherId = auth('client')->id();
        $roomId = $this->firebaseService->getRoomPrivateChat($teacherId, (int)$studentId);

        return redirect()->route('client.messages.room-detail', ['roomId' => $roomId]);
    }

    /**
     * Teacher send message to student by course schedule
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendDetailCourseMessage(Request $request)
    {
        try {
            $courseScheduleId = $request->courseScheduleId ?? null;
            $studentId = $request->studentId ?? null;
            $message = $request->message ?? null;
            $teacherId = auth()->guard('client')->id();
            $roomType = $request->roomType ?? null;
            $toAllUser = isset($request->toAllUser);
            $roomIds = isset($request->roomIds);

            if ($roomIds) {
                $this->courseScheduleService->sendMessageToRoomIds(explode(",", $request->roomIds), $teacherId, $message);
            } else {
                $this->courseScheduleService->sendMessage(
                    $studentId,
                    $message,
                    $teacherId,
                    $courseScheduleId,
                    $roomType
                );
            }
            $userIds = explode(",", $request->userIds);
            $courseSchedule = $this->courseScheduleService->repository->find($courseScheduleId);
            if (isset($userIds) && isset($courseScheduleId)) {
                foreach ($userIds as $userId) {
                    $user = $this->userService->repository->find($userId);
                    $checkPurchased = 1;
                    $enabledRequestRestock = "false";
                    Mail::to($user->email)->queue(new TeacherSendMailCourseSchedule('【Lappi】新着メッセージがありました。', auth()->guard('client')->user()->full_name, $user->full_name, $message, $courseSchedule->toArray(), $checkPurchased, $enabledRequestRestock));
                }
            }

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
     * Get list private chat room
     * @param Request $request
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function getListPrivateChat(Request $request)
    {
        $params = [
            'limit' => Constant::PER_PAGE_DEFAULT,
            'page' => isset($request->page) ? (int)$request->page : 1,
            'option' => isset($request->option) ? (int)$request->option === 1 ? 'DESC' : 'ASC' : 'DESC', // 1: DESC, 0: ASC default 1
            'year' => $request->year ?? date("Y"), // default current year,
            'month' => $request->month ?? date("m"), // default current month,
        ];
        $data = $this->courseScheduleService->getListPrivateChat($params);
        $messages = [
            'users' => $data['users'],
            'pagination' => [
                'total' => $data['total'],
                'totalPage' => (int)ceil($data['total'] / (int)$params['limit']),
                'limit' => $params['limit'],
                'page' => $params['page'],
            ],
            'date' => [
                'month' => $params['month'],
                'year' => $params['year']
            ]
        ];
        return view('client.screen.teacher.my-page.message.private-chat', compact('messages'));
    }

    /**
     * @return review follower
     */
    public function follower(Request $request, TeacherMyPageService $service)
    {
        $follows = $service->listFollower($request);
        return view('client.screen.teacher.my-page.follower-view', compact('follows'));
    }

    /**
     * @return review profit-livestream
     */
    public function profitLiveStream(TeacherMyPageService $service, Request $request)
    {
        $data = $service->saleProfitLiveStream($request);
        $profitLiveStream = $data['profitLiveStream'];
        $textProfitUser = $data['textProfitUser'];

        return view('client.screen.teacher.my-page.profit-livestream', compact('profitLiveStream', 'textProfitUser'));
    }

    /**
     * Seller user guide .
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function sellerUserGuide()
    {
        return view('client.screen.teacher.my-page.seller_user_guide');
    }

    /**
     * Student guide.
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function studentGuide()
    {
        return view('client.screen.teacher.my-page.student-guide');
    }

    /**
     * Teacher guide.
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function teacherGuide()
    {
        return view('client.screen.teacher.my-page.teacher-guide');
    }

    /**
     * Seller rank.
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function sellerRank()
    {
        return view('client.screen.teacher.my-page.seller-rank');
    }

    /**
     * Inquiry.
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function inquiry()
    {
        return view('client.screen.teacher.my-page.inquiry');
    }

    /**
     * Inquiry Teacher.
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function inquiryTeacher()
    {
        return view('client.screen.teacher.my-page.inquiry-teacher');
    }

    public function sendInquiry(InquiryRequest $request)
    {
        if ($request->ajax()) {
            $imageUrl = '';
            if ($request->file('file')) {
                $path = 'inquiry/' . time();
                $params = [
                    'id' => 1,
                ];
                $imagePath = $this->uploadFileToS3($request->file('file'), $path, $params);
                if (isset($imagePath['urlPath'])) {
                    $imageUrl = $this->getS3FileUrl($imagePath['urlPath']);
                }
            }
            // send mail verify
            $emailAdmin = Config::get('app.to_mail_report');

            Mail::to($emailAdmin)->queue(
                new Inquiry(
                    'お問い合わせを正常に受け付けました。',
                    $request->full_name,
                    $request->email,
                    $request->type,
                    $request->subject,
                    $request->content_inquiry,
                    $imageUrl
                ));
        }
    }

    /**
     * Guide
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixe
     *
     */
    public function guide()
    {
        return view('client.screen.teacher.my-page.guide');
    }

    /**
     * Guide Nine
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixe
     *
     */
    public function guideNine()
    {
        return view('client.screen.teacher.my-page.guide-nine');
    }

    /**
     * @return review profit-videocall
     */
    public function profitVideocall()
    {
        return view('client.screen.teacher.my-page.profit-videocall');
    }


    /**
     * Message Notification Page.
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function messageNotification(TeacherMyPageService $service, Request $request)
    {
        $data = $service->listNotifications($request);

        return view('client.screen.teacher.my-page.message.notification', compact('data'));
    }

    /**
     * Update status read notification
     *
     * @param Request $request
     * @param TeacherMyPageService $service
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatusReadNotification(Request $request, TeacherMyPageService $service)
    {
        $result = $service->changeStatusReadMessage($request);
        if ($result) {
            return \response()->json(['data' => true], Response::HTTP_OK);
        } else {
            return \response()->json(['data' => false], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Message Notice Page.
     *
     * @param Request $request
     * @param TeacherMyPageService $service
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function messageNotice(Request $request, TeacherMyPageService $service)
    {
        $data = $service->listNotices($request);

        return view('client.screen.teacher.my-page.message.notice', compact('data'));
    }

    /**
     * Send Notice Message
     *
     * @param PromotionalMessageRequest $request
     * @param TeacherMyPageService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function messageNoticeStore(PromotionalMessageRequest $request, TeacherMyPageService $service)
    {
        $resultNotice = $service->sendPromotionalMessage($request);
        if ($resultNotice) {
            return response()->json(['data' => true], Response::HTTP_OK);
        }

        return response()->json(['data' => false], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @return review transfer-apply livestream
     */
    public function transferApply(Request $request, TeacherMyPageService $service, BankMasterService $bankMasterService)
    {
        $data = $service->getTransferApplyLiveStream($request);
        $banks = $bankMasterService->listBank();

        return view('client.screen.teacher.my-page.transfer_apply.livestream', compact('data', 'banks'));
    }

    /**
     * update bank account
     *
     * @param int $id
     * @param UpdateBankAccountRequest $request
     * @param TeacherMyPageService $service
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|void
     */
    public function updateCard(int $id, UpdateBankAccountRequest $request, TeacherMyPageService $service)
    {
        if ($request->ajax()) {
            $data = $service->updateBankAccount($id, $request);
            return response($data);
        }
    }

    /**
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
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
            return redirect()->back()->with(['success' => trans('message.delete_account_success')]);
        }

        return redirect()->back()->with(['error' => $result['message']]);
    }

    /**
     * Teacher my-page message
     */
    public function messageCourse(Request $request)
    {
        $message = $this->courseScheduleService->getListCourseScheduleMessage($request);

        return view('client.screen.teacher.my-page.message.index', compact('message'));
    }

    /**
     * @return review setting-account
     */
    public function settingAccount()
    {
        return view('client.screen.teacher.my-page.setting-account');
    }

    /**
     * Change status user to rest.
     *
     * @param Request $request
     * @param TeacherMyPageService $service
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|void
     */
    public function restAccount(Request $request, TeacherMyPageService $service)
    {
        if ($request->ajax()) {
            $user = $service->teacherStopService();
            return \response([
                'user' => $user,
            ]);
        }

    }

    /**
     * @return review profile-edit
     */
    public function profileEdit()
    {
        $user = auth()->guard('client')->user();
        return view('client.screen.teacher.my-page.profile-edit')->with(['user' => $user]);
    }

    /**
     * @return review profile-edit
     */
    public function profileEditNickname()
    {
        $user = auth()->guard('client')->user();
        return view('client.screen.teacher.my-page.profile-edit-role-student')->with(['user' => $user]);
    }

    /**
     * @return review update profile nickname
     */
    public function updateProfileNickname(UpdateProfileNicknameRequest $request)
    {
        $result = $this->clientService->updateProfileNickname($request);
        if ($result['success']) {
            return redirect()->back()->with(['success' => $result['message']]);
        }

        return redirect()->back()->with(['error' => $result['message']]);
    }

    /**
     * @return update registration profile-edit
     */
    public function registrationProfileEdit(UpdateProfileAccountRequest $request)
    {
        $result = $this->clientService->updateProfileAccount($request, auth()->guard('client')->user()->user_id);
        if ($result['success']) {
            return redirect()->back()->with(['success' => trans('message.update_profile_nickname_success')]);
        }

        return redirect()->back()->with(['error' => $result['message']]);
    }

    /**
     * @return review info-edit
     */
    public function infoEdit()
    {
        $user = auth()->guard('client')->user();
        return view('client.screen.teacher.my-page.info-edit')->with(['user' => $user]);
    }

    /**
     * @param UpdateTeacherRegistrationInfoRequest $request
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View|mixed
     */
    public function registrationInfoEdit(UpdateTeacherRegistrationInfoRequest $request)
    {
        return $this->clientService->updateRegistrationInfo($request);
    }

    /**
     * @return review verification-edit
     */
    public function verificationEdit()
    {
        $user = auth()->guard('client')->user();

        return view('client.screen.teacher.my-page.verification-edit')->with(['user' => $user]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse verification-edit-update
     */
    public function updateVerification(TeacherMypageIdenttifyUpdateRequest $request)
    {
        $status = 0;
        $result = $this->clientService->updateImageIdentify($request, auth('client')->id(), $status);
        $rp = json_decode($result->content(), true);
        if ($rp['success']) {
            return redirect()->route('client.teacher.mypage-teacher-settingAccount')->with(['success' => $rp['message']]);
        }

        return redirect()->back()->with(['error' => $rp['message']]);
    }

    /**
     * @return review credentials-edit
     */
    public function credentialsEdit()
    {
        $user = auth()->guard('client')->user();
        return view('client.screen.teacher.my-page.credentials-edit')->with(['user' => $user]);
    }

    /**
     * @return review nda
     */
    public function ndaDetails()
    {
        $user = auth()->guard('client')->user();
        return view('client.screen.teacher.my-page.nda-detail')->with(['user' => $user]);
    }

    /**
     * @param updateBusinessCard $request
     * @param $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateBusinessCard(UpdateBusinessCardRequest $request)
    {
        $userId = auth('client')->id();
        if ((int)$request->qualifications === 0) {
            //remove image when qualification  === 1
            $this->clientService->removeImageQualification($userId);
        }
        $result = $this->clientService->updateBusinessCard($request, auth()->guard('client')->user()->user_id);
        if ($result['success']) {
            return redirect()->route('client.teacher.mypage-teacher-settingAccount')->with('success', trans('message.change_success_alt'));
        }
    }

    /**
     * Delete course schedule
     *
     * @param Request $request
     * @param TeacherService $teacherService
     * @return \Illuminate\Http\RedirectResponse|void
     * @throws \Exception
     */
    public function deleteCourse(Request $request, TeacherService $teacherService)
    {
        return $teacherService->deleteCourse($request);
    }

    /**
     * Cancel course schedule
     *
     * @param Request $request
     * @param TeacherService $teacherService
     * @return array|bool[]|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function cancelCourse(Request $request, TeacherService $teacherService)
    {
        return $teacherService->cancelCourse($request);
    }

    public function EmailEndCourseSchedule($courseSchedule, CourseScheduleService $courseScheduleService)
    {
        return $courseScheduleService->EmailEndCourseSchedule($courseSchedule);
    }

    public function generateNdaPDF()
    {
        $pdf = PDF::loadView('client.screen.teacher.my-page.ndaPDF');

        return $pdf->stream('myPDF.pdf');
    }
}
