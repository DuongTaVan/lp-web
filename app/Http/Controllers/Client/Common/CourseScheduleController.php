<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client\Common;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Common\CourseScheduleDetailRequest;
use App\Http\Requests\Client\CourseSchedule\PurchaseCourseRequest;
use App\Mail\HoldingRequest;
use App\Mail\HoldingRequestTeacher;
use App\Services\Client\CourseSchedule\PurchaseMainCourseService;
use App\Services\Client\CourseSchedule\PurchaseSubCourseService;
use App\Services\Client\Common\CommonCourseScheduleService;
use App\Services\Client\Student\Course\CourseRestockService;
use App\Services\Client\Teacher\CourseScheduleService;
use App\Services\Client\TeacherPage\TeacherPageService;
use App\Services\Client\TopPage\TopPageService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CourseScheduleController extends Controller
{

    protected $restockService;

    public function __construct()
    {
        $this->restockService = app(CourseRestockService::class);
    }

    /**
     * Purchase main course.
     *
     * @param PurchaseCourseRequest $request
     * @param PurchaseMainCourseService $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function purchaseMainCourse(PurchaseCourseRequest $request, PurchaseMainCourseService $service)
    {
        $result = $service->purchaseMainCourse($request->all());
        if (!$result['success']) {
            return redirect()->back()->withErrors([
                'error' => $result['message']
            ]);
        }
        return redirect()->to($result['endpoint_url']);
    }

    /**
     * Purchase sub course.
     *
     * @param PurchaseCourseRequest $request
     * @param PurchaseSubCourseService $service
     * @param CourseScheduleService $courseSchedule
     * @return \Illuminate\Http\RedirectResponse
     */
    public function purchaseSubCourse(PurchaseCourseRequest $request, PurchaseSubCourseService $service, CourseScheduleService $courseSchedule)
    {
        $result = $service->purchaseSubCourse($request->all());

        if (!$result['success']) {
            return redirect()->back()->withErrors([
                'error' => $result['message']
            ]);
        }
//        $courseSchedule = $courseSchedule->repository->find($request->course_schedule_id, ['course_schedule_id', 'course_id', 'title', 'price', 'start_datetime', 'end_datetime']);
        $courseSchedule = $courseSchedule->repository->getCourseScheduleById($request->course_schedule_id);
        $courseSchedule->title = $courseSchedule->course->title;
        $listCourseSchedules = [];
        if ($courseSchedule->start_datetime->format('Y-m-d') === Carbon::now()->addDays(Constant::DAY_REMIND_COURSE_SCHEDULE)->format('Y-m-d') || $courseSchedule->start_datetime->format('Y-m-d') === Carbon::now()->format('Y-m-d')) {
            $listCourseSchedules[0] = $courseSchedule;
        }

        Mail::to(Auth::guard('client')->user()->email)->queue(new HoldingRequest($courseSchedule->course->user->full_name, $courseSchedule->toArray(), Auth::guard('client')->user()->full_name, $listCourseSchedules));
        Mail::to($courseSchedule->course->user->email)->queue(new HoldingRequestTeacher($courseSchedule->course->user->full_name, $courseSchedule->toArray()));
        return redirect()->to($result['endpoint_url']);
    }

    /**
     * Course Schedule Detail livestream.
     *
     * @param CourseScheduleDetailRequest $request
     * @param string $courseScheduleId
     * @param CommonCourseScheduleService $service
     * @param TopPageService $topPageService
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     * @throws \Throwable
     */
    public function detail(CourseScheduleDetailRequest $request, string $courseScheduleId, CommonCourseScheduleService $service, TopPageService $topPageService)
    {
        $request->flash();
        $result = $service->courseScheduleDetail((int)$courseScheduleId);

        if (!$result['success']) {
            return redirect()->route('client.common.404');
        }

        if (isset($result['course_schedule_open'])) {
            return redirect()->route('client.course-schedules.detail', $result['course_schedule_open']);
        }
        $result['courseSchedules'] = $result['courseScheduleList'];
        $topPage = null;
        if (!$request->is_ajax) {
            $topPage = $topPageService->getDataTopPage();
        }
        $requestRestock = $this->restockService->getAllRequestRestock($result['courses']->course_id);
        $result['count_request_restock'] = count($requestRestock);
        $result['is_request_restock'] = $requestRestock->filter(function ($el) {
            return $el->user_id === auth('client')->id();
        })->isNotEmpty();

        $result['enabled_request_restock'] = !count($result['courseSchedulePurchases']);
        $result['current_cs_can_buy'] = false;

        foreach ($result['courseSchedulePurchases'] as $key => $item) {
            // move data courseSchedule with $courseScheduleId to first array
            if ($item['course_schedule_id'] === (int)$courseScheduleId) {
                $result['current_cs_can_buy'] = true;
                array_unshift($result['courseScheduleList'], $item);
                $result['courseScheduleList'] = array_splice($result['courseScheduleList'], $key + 1, 1);
            }
        }

        $result['enabled_request_restock_course'] = false;
        if ($result['courses']['courseSchedules']->count() > 0) {
            $result['enabled_request_restock_course'] = $result['courses']['courseSchedules']->filter(function ($cs) {
                return $cs->fixed_num != $cs->num_of_applicants;
            })->isNotEmpty();
        }
        if (count($result['courseSchedules']) === 1) {
            if ($result['courseSchedule']['purchase_deadline'] < now() && now() < $result['courseSchedule']['start_datetime']) {
                $result['enabled_request_restock'] = true;
            }
        }
        $result['user_can_buy'] = false;
        if ($result['courses']['user_id'] === auth('client')->id()) {
            $result['user_can_buy'] = true;
            $result['is_request_restock'] = false;
            $result['enabled_request_restock'] = false;
        }
        if ($result['courseSchedulePurchased']) {
            $result['is_request_restock'] = false;
        }

        # Restock for video call
        $userLoginId = auth('client')->id();
        if (
            $result['courses']['user_id'] !== $userLoginId &&
            $result['courses']['dist_method'] === DBConstant::DIST_METHOD_LIVE_VIDEO_CALL
        ) {
            $listSchedulePurchaseAvailableID = array_map(function ($schedule) {
                return $schedule['course_schedule_id'];
            }, $result['courseSchedulePurchases']);
            $result['courses']['purchases'] = $result['courses']['applicant'];
            $listSchedulePurchasedID = $result['courses']['purchases']->map(function ($schedule) {
                return $schedule['course_schedule_id'];
            })->toArray();
            $listScheduleNotPurchased = array_diff($listSchedulePurchaseAvailableID, $listSchedulePurchasedID);

            $scheduleClientPurchased = $result['courses']['purchases']
                ->filter(function ($purchases) use ($userLoginId) {
                    return $userLoginId === $purchases['user_id'];
                });
            $isClientNotPurchasedAnySchedule = $scheduleClientPurchased->isEmpty();

            $listScheduleIdOpen = array_map(function ($schedule) {
                return $schedule['course_schedule_id'];
            }, $result['courseScheduleList']);

            $isClientNotPurchasedScheduleOpening = $scheduleClientPurchased->filter(function ($schedule) use ($listScheduleIdOpen) {
                return in_array($schedule['course_schedule_id'], $listScheduleIdOpen);
            })->isEmpty();
            // TODO: Refactor the conditions below
            // If all of schedules is Purchased and client not purchase any schedule, then enable restock
            if (count($listScheduleNotPurchased) === 0 && $isClientNotPurchasedAnySchedule) {
                $result['enabled_request_restock'] = true;
            }

            /**
             * If all of schedules is expired purchased and
             * The user purchased the schedule in course -> restock = false, disabled Purchases button
             * The user not purchased the schedule in course -> restock = true
             */
            if (count($result['courseSchedulePurchases']) === 0) {
                if ($isClientNotPurchasedAnySchedule) {
                    $result['enabled_request_restock'] = true;
                } else {
                    if ($isClientNotPurchasedScheduleOpening) {
                        $result['enabled_request_restock'] = true;
                    } else {
                        $result['enabled_request_restock'] = true;
                    }
                }
            }
            // If all of schedules is close
//            if (count($result['courseScheduleList']) === 0) {
//                $result['enabled_request_restock'] = true;
//            }
        }
        // If is teacher of video call course
        if (
            $result['courses']['user_id'] === $userLoginId &&
            $result['courses']['dist_method'] === DBConstant::DIST_METHOD_LIVE_VIDEO_CALL
        ) {

            $courseScheduleListClose = Arr::where($result['courseScheduleList'], function ($value, $key) {
                return $value['status'] === 2;
            });

            $courseScheduleOpen = collect($result['courseSchedules'])->filter(function ($item) {
                return (int)$item['status'] === DBConstant::COURSE_STATUS_OPEN &&
                    ((int)$item['num_of_applicants'] < (int)$item['fixed_num']) &&
                    $item['purchase_deadline'] > now();
            })->count();

            // If all of schedules is close
            if (count($courseScheduleListClose) === $courseScheduleOpen) {
                $result['is_all_schedule_close'] = true;
            }
        }

        if ($request->is_ajax) {
            if (isset($request->is_mobile)) {
                $html = view('client.screen.course-detail.choose-course_schedule-sp', compact('result', 'courseScheduleId'))->render();
            } else {
                $html = view('client.screen.course-detail.choose-course-schedule', compact('result', 'courseScheduleId'))->render();
            }

            return response([
                'html' => $html,
                'data' => $result['courseSchedule'],
                'images' => $result['images']
            ]);
        }
        $html = view('client.screen.course-detail.choose-course-schedule', compact('result', 'courseScheduleId'))->render();

        # End Restock for video call
        return view('client.screen.course-detail.livestream')->with([
            'result' => $result,
            'topPage' => $topPage,
            'courseScheduleId' => $courseScheduleId,
            'html' => $html
        ]);
    }

    public function detailStatus(Request $request, $courseScheduleId, TeacherPageService $service)
    {
        if ($request->ajax()) {
            $data = $service->getDataCourseSchedule($courseScheduleId);
            return response([
                'status' => $data['bgColor'],
                'title' => $data['title'],
                'body' => $data['body'],
                'image_url' => $data['image_url'],
                'price' => isset($data['price']) ? number_format($data['price']) : 0
            ]);
        }
    }

    /**
     * @param int $id
     * @param Request $request
     * @param TopPageService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNewBuyer(int $id, Request $request, TopPageService $service)   {
        if ($request->ajax() || $request->wantsJson()) {
            $data = $service->countNumOfApplication($id);

            return response()->json([
                'success' => true,
                'count' => $data
            ]);
        }
    }


    /**
     * Course Schedule Detail fortune.
     *
     * @param CourseScheduleDetailRequest $request
     * @param $courseScheduleId
     * @param CommonCourseScheduleService $service
     * @param TopPageService $topPageService
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
//    public function detailFortune(CourseScheduleDetailRequest $request, $courseScheduleId, CommonCourseScheduleService $service, TopPageService $topPageService)
//    {
//        $result = $service->courseScheduleDetail($courseScheduleId);
//        if (!$result['success']) {
//            return redirect()->route('client.common.404');
//        }
//        $topPage = $topPageService->getDataTopPage();
//        return view('client.screen.course-detail.fortune')->with([
//            'result' => $result,
//            'course_schedule_id' => $courseScheduleId,
//            'topPage' => $topPage,
//        ]);
//    }

    /**
     * Fetch Data Course Schedule
     *
     * @param CourseScheduleDetailRequest $request
     * @param $courseScheduleId
     * @param CommonCourseScheduleService $service
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function fetchData(CourseScheduleDetailRequest $request, $courseScheduleId, CommonCourseScheduleService $service)
    {
        $data = $service->fetchDataCourseSchedule($courseScheduleId);
        $html = view('client.screen.course-detail.test', compact('data'))->render();
        return response([
            'html' => $html,
            'data' => $data,
        ]);
    }
}
