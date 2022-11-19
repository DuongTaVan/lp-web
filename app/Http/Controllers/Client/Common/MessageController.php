<?php

namespace App\Http\Controllers\Client\Common;

use App\Enums\DBConstant;
use App\Enums\ErrorType;
use App\Http\Controllers\Controller;
use App\Mail\StudentSendMailCourseSchedule;
use App\Mail\StudentSendMessage;
use App\Mail\TeacherSendMailCourseSchedule;
use App\Mail\TeacherSendMessage;
use App\Services\Batch\CourseScheduleService;
use App\Services\Client\Common\FirebaseService;
use App\Services\Client\Teacher\UserService;
use App\Services\Client\TeacherPage\TeacherPageService;
use App\Services\Common\MessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MessageController extends Controller
{
    private $teacherPageService;
    private $firebaseService;

    public function __construct()
    {
        $this->teacherPageService = app(TeacherPageService::class);
        $this->firebaseService = app(FirebaseService::class);
        $this->courseSchedule = app(FirebaseService::class);
    }

    /**
     * Get list message
     *
     * @param Request $request
     * @param MessageService $messageService
     */
    public function list(Request $request, MessageService $messageService)
    {
//        $result = $messageService->list($request);
//        if (!$result['success']) {
//            //false
//        }

        // success
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
        $user = auth('client')->user();
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
            $endDatetime = $courseSchedule->canceled_at ?? $courseSchedule->end_datetime;
            $courseSchedule->enddatetime_string = $endDatetime->toString();
        }

        return view('client.student-mypage.message-detail', compact('roomData', 'user', 'teacher', 'courseSchedule'));
    }

    /**
     * Send message with room Id
     *
     * @param Request $request
     * @param CourseScheduleService $courseScheduleService
     * @param UserService $userService
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request, CourseScheduleService $courseScheduleService, UserService $userService)
    {
        $userId = auth('client')->id();
        $message = $request->message ?? null;
        $roomId = $request->roomId ?? null;
        if ($roomId && $message && !$userId) {
            return response()->json([
                'success' => false
            ]);
        }
        $studentId = $request->studentId ?? null;
        $teacherEmail = $request->teacherEmail ?? null;
        $teacherFullName = $request->teacherFullName ?? null;
        $studentEmail = $request->studentEmail ?? null;
        $studentFullName = $request->studentFullName ?? null;
        $enabledRequestRestock = $request->enabledRequestRestock ?? null;
        $this->firebaseService->sendMessageToRoomId($roomId, $userId, $message);
        $courseScheduleId = $request->courseScheduleId ?? null;
        if (isset($studentEmail) && isset($teacherEmail) && isset($courseScheduleId) && $studentEmail === $teacherEmail) {
            $courseSchedule = $courseScheduleService->repository->find($courseScheduleId, ['course_schedule_id', 'title', 'start_datetime', 'end_datetime', 'price']);
            $courseSchedule->setAppends([]);
            if (isset($courseSchedule) && isset($studentId)) {
                $checkPurchased = $courseScheduleService->checkPurchaseCourseSchedule($courseScheduleId, $studentId);
                $student = $userService->repository->find($studentId)->toArray();
                Mail::to($student['email'])->queue(new TeacherSendMailCourseSchedule('【Lappi】新着メッセージがありました。', $teacherFullName, $student['full_name'], $message, $courseSchedule->toArray(), $checkPurchased, $enabledRequestRestock));
            }
        } elseif (isset($studentEmail) && isset($teacherEmail) && isset($courseScheduleId) && $studentEmail != $teacherEmail) {
            $courseSchedule = $courseScheduleService->repository->find($courseScheduleId, ['course_schedule_id', 'title', 'start_datetime', 'end_datetime', 'price']);
            $courseSchedule->setAppends([]);
            if (isset($courseSchedule) && isset($studentId)) {
                $checkPurchased = $courseScheduleService->checkPurchaseCourseSchedule($courseScheduleId, $studentId);
                Mail::to($teacherEmail)->queue(new StudentSendMailCourseSchedule('【Lappi】新着メッセージがありました。', $teacherFullName, $studentFullName, $message, $courseSchedule->toArray(), $checkPurchased, $enabledRequestRestock));
            }
        } else {
            if ($studentEmail != $teacherEmail) {
                Mail::to($teacherEmail)->queue(new StudentSendMessage('【Lappi】新着メッセージがありました。', $teacherFullName, $studentFullName, $message));
            } else {
                $student = $userService->repository->find($studentId)->toArray();
                Mail::to($student['email'])->queue(new TeacherSendMessage('【Lappi】新着メッセージがありました。', $student['full_name'], $teacherFullName, $message));
            }
        }
        return response()->json([
            'success' => true
        ]);
    }
}
