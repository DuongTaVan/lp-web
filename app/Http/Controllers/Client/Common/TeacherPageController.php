<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client\Common;

use App\Enums\DBConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\TeacherPage\TeacherPageRequest;
use App\Services\Client\BoxNotification\BoxNotificationService;
use App\Services\Client\Common\FirebaseService;
use App\Services\Client\TeacherPage\TeacherPageService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Services\Client\Common\ClientService;

class TeacherPageController extends Controller
{
    /**
     * Get data teacher page.
     *
     * @param $userId
     * @param TeacherPageService $service
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function teacherPage($userId, TeacherPageService $service)
    {
        $data = $service->getDataTeacherPage($userId, [], true);
        if (isset($data['success']) && !$data['success']) {
            $notification = [
                'message' => $data['message'],
                'alert-type' => 'error',
            ];

            return redirect()->back()->with($notification);
        }
        return view('client.screen.teacher.my-page.index', compact('data', 'userId'));
    }

    /**
     * show view message teacher
     *
     * @param $teacherId
     * @param FirebaseService $firebaseService
     *
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function detailMessage($teacherId, FirebaseService $firebaseService)
    {
        $studentId = auth('client')->id();
        if ((int)$studentId === (int)$teacherId) {
            throw new ModelNotFoundException();
        }
        $roomId = $firebaseService->getRoomPrivateChat((int)$teacherId, $studentId);

        return redirect()->route('client.messages.room-detail', ['roomId'=> $roomId]);
    }

    /**
     * Get course detail.
     *
     * @param $userId
     * @param Request $request
     * @param TeacherPageService $service
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|void
     * @throws \Throwable
     */

    public function courseDetail($userId, Request $request, TeacherPageService $service)
    {
        if ($request->ajax()) {
            $courses = $service->courseDetail($userId);
            $html = view('client.screen.teacher.my-page.component.course-item', compact('courses'))->render();
            return response(['html' => $html]);
        }
    }

    /**
     * Get review detail.
     *
     * @param $userId
     * @param Request $request
     * @param TeacherPageService $service
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|void
     * @throws \Throwable
     */

    public function reviewDetail($userId, Request $request, TeacherPageService $service)
    {
        if ($request->ajax()) {
            $reviews = $service->reviewDetail($userId);
            $html = view('client.screen.teacher.my-page.component.comment-review', compact('reviews'))->render();
            return response(['html' => $html]);
        }
    }

    /**
     * Update read box notice
     * @param Request $request
     * @param BoxNotificationService $service
     */
    public function updateNoticeBox(Request $request, BoxNotificationService $service)
    {
        if ($request->ajax()) {
            $service->updateReadBoxNotice($request);
            return response([
                'success' => true
            ]);
        }
    }

    /**
     * Notice page view.
     *
     * @param Request $request
     * @param BoxNotificationService $service
     * @return array|false|\Illuminate\Contracts\Foundation\Application
     */
    public function noticePage(Request $request, BoxNotificationService $service)
    {
        $data = $service->getListBoxNotification($request);

        if ($request->ajax()) {
            // update reade flag
            $notice = $service->updateReadBoxNotice($request);

            $html = view('client.screen.teacher.my-page.component.noti-item', compact('data'))->render();

            return response([
                'html' => $html,
                'notice' => $notice
            ]);
        }

        return view('client.screen.teacher.my-page.notice', compact('data'));
    }

    /**
     * Get detail notification
     *
     * @param $boxNotificationId
     * @param BoxNotificationService $service
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($boxNotificationId, BoxNotificationService $service)
    {
        $result = $service->show($boxNotificationId);

        return view('client.screen.teacher.my-page.notice-detail', compact('result'));

    }

    public function removeImageBackgroundDefault(Request $request, ClientService $clientService)
    {
        return $clientService->removeImageBackgroundDefault($request);
    }
}
