<?php

namespace App\Http\Controllers\Client\Student;

use App\Enums\DBConstant;
use App\Enums\ErrorType;
use App\Http\Controllers\Controller;
use App\Mail\SendMailReportBlade;
use App\Repositories\CourseRepository;
use App\Repositories\OptionalExtraRepository;
use App\Services\Client\Common\ImagePathService;
use App\Services\Client\Gift\PurchaseGiftService;
use App\Services\Client\Student\CourseScheduleService;
use App\Services\Client\Teacher\PurchaseDetailService;
use App\Services\Common\StripePaymentService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Throwable;

class JoinCourseController extends Controller
{
    protected $giftService;
    protected $stripePaymentService;
    protected $courseRepository;
    protected $optionalExtraRepository;
    private $purchaseDetailService;
    private $imagePathService;

    public function __construct()
    {
        $this->giftService = app(PurchaseGiftService::class);
        $this->stripePaymentService = app(StripePaymentService::class);
        $this->courseRepository = app(CourseRepository::class);
        $this->optionalExtraRepository = app(OptionalExtraRepository::class);
        $this->purchaseDetailService = app(PurchaseDetailService::class);
        $this->imagePathService = app(ImagePathService::class);
    }

    /**
     * Join Course Live Stream page
     *
     * @return array|false|Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function joinCourseLiveStreamPage()
    {
        return view('client.screen.join-course.livestream');
    }

    /**
     * Join Course Live Stream Not Ready page
     *
     * @return array|false|Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function joinCourseLiveStreamNotReadyPage()
    {
        return view('client.screen.join-course.livestream-not-ready');
    }

    /**
     * Video Call Page.
     *
     * @return array|false|Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function joinCourseVideoCallPage()
    {
        return view('client.screen.join-course.video-call');
    }

    /**
     * Video Call Late Page.
     *
     * @return array|false|Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function joinCourseVideoCallLatePage()
    {
        return view('client.screen.join-course.video-call-late');
    }

    /**
     * Teacher Trouble Consultation Page.
     *
     * @param CourseScheduleService $service
     * @param int $courseScheduleId
     * @param \App\Services\Client\Teacher\CourseScheduleService $teacherService
     * @return array|false|Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function joinCourse(CourseScheduleService $service, int $courseScheduleId, \App\Services\Client\Teacher\CourseScheduleService $teacherService)
    {
        $loginUser = Auth::guard('client');
        $extendCourse = null;
        $optionalExtra = null;
        $extendCourseSchedulePurchased = null;
        $optionPurchased = null;
        $subCourse = null;
        $allSubCourse = null;

        $courseSchedule = $service->getDetail($courseScheduleId);
        if ($courseSchedule) {
            //get extend course by course id
            $extendCourse = $this->courseRepository->getListExtendCourseBy($courseSchedule->course_id);

            if ($extendCourse->count() > 0) {
                $countDisable = 0;
                foreach ($extendCourse as $etc) {
                    $etc['purchased'] = false;
                    if (count($etc->courseSchedules) > 0) {
                        $courseScheduleOfUser = $etc->courseSchedules->filter(function ($cs) use ($courseScheduleId) {
                            return $cs->parent_course_schedule_id === $courseScheduleId;
                        })->values();
                        if ($courseScheduleOfUser->count() > 0) {
                            $etc['purchased'] = true;
                            $countDisable++;
                        }
                    }
                }
                foreach ($extendCourse as $etc) {
                    $etc['disabled'] = false;
                    if ($countDisable > 0) {
                        $etc['disabled'] = true;
                    }
                }

            }
            $optionalExtra = $courseSchedule->optionalExtras;
        }

        if (!$courseSchedule ||
            !$courseSchedule->course ||
            !$courseSchedule->course->user ||
            !$courseSchedule->purchases->count()
        ) {
            throw new ModelNotFoundException();
        }

        $courseSchedule->current_course_schedule_id = $courseSchedule->course_schedule_id;

        if (!$courseSchedule->course->category || $courseSchedule->course->category->type !== DBConstant::CATEGORY_TYPE_SKILLS) {
            $extendCourseSchedulePurchased = $service->getExtend($courseScheduleId);
        }

        if ($extendCourseSchedulePurchased) {
            $courseSchedule->end_datetime = $extendCourseSchedulePurchased->end_datetime;
            $courseSchedule->current_course_schedule_id = $extendCourseSchedulePurchased->course_schedule_id;
            if (isset($courseSchedule->actual_start_date)) {
                $courseSchedule->actual_end_date = $extendCourseSchedulePurchased->end_datetime;
            }
        }

        if ($courseSchedule->end_datetime < $courseSchedule->start_datetime) {
            throw new ModelNotFoundException();
        }
//        if ($courseSchedule->end_datetime < now() || $courseSchedule->start_datetime > now()->addMinutes(15)) {
//            return view('common.419');
//        }
        $courseSchedule->teacher_join_late = false;
        if (isset($courseSchedule->actual_start_date)) {
            if ($courseSchedule->actual_end_date < now() || $courseSchedule->actual_start_date > now()->addMinutes(15)) {
                return view('common.419');
            }
            $courseSchedule->start_datetime_string = $courseSchedule->actual_start_date->toString();
            $courseSchedule->end_datetime_string = $courseSchedule->actual_end_date->toString();
        } else {
            if ($courseSchedule->end_datetime < now() || $courseSchedule->start_datetime > now()->addMinutes(15) ||
                $courseSchedule->start_datetime < now()->subMinutes(15)) {
                return view('common.419');
            }
            $courseSchedule->teacher_join_late = true;
            $courseSchedule->start_datetime_string = $courseSchedule->start_datetime->toString();
            $courseSchedule->end_datetime_string = $courseSchedule->end_datetime->toString();
        }

//        $courseSchedule->start_datetime_string = $courseSchedule->start_datetime->toString();
//        $courseSchedule->end_datetime_string = $courseSchedule->end_datetime->toString();

        // disable uncheck default option purchase issues 1307
        if ($courseSchedule->course->category->type === DBConstant::CATEGORY_TYPE_FORTUNETELLING) {
            $optionPurchased = $this->purchaseDetailService->getOption($courseScheduleId);
        }
        if ($optionalExtra && $optionPurchased && $optionalExtra->count() && count($optionPurchased)) {
            $optionalExtra->map(function ($el) use ($optionPurchased) {
                return $el->purchased = in_array($el->optional_extra_id, $optionPurchased, true);
            });
        }
        if ($courseSchedule->course->category) {
            $subCourse = $service->getSubCourseDetail($courseSchedule->course_id);
            $allSubCourse = $teacherService->getAllSubCourseDetail($courseSchedule->course->course_id);
            $allSubCourse = $allSubCourse->filter(function ($el) {
                return $el->fixed_num > $el->num_of_applicants;
            })->values();
        }
        $gifts = $this->giftService->repository->all();
        $boughtGifts = $this->giftService->boughtGifts($courseSchedule->course_schedule_id);
        foreach ($boughtGifts as $key => $item) {
            $boughtGifts[$key] = (object)[
                'gift' => (object)[
                    'name' => $item->gift->name,
                    'image' => $item->gift->image
                ],
                'user' => (object)[
                    'fullName' => $item->user->full_name,
                    'profile' => $item->user->profile_image
                ]
            ];
        }
        $creditCard = $this->stripePaymentService->getCreditCard()['data'] ?? [];
        $rate = $this->courseRepository->getTheRatingOfCourse($courseSchedule->course_id);

        $rating = [
            'avg_rating' => $rate->avg('rating') ?? 0,
            'sum_rating' => $rate->sum('num_of_ratings')
        ];

        $listBackground = $this->imagePathService->getListImage($loginUser->id(), DBConstant::IMAGE_PATH_TYPE['background']);
        $listBackground = $listBackground->map(function ($item) {
            return $item->image_s3_url;
        });
        $authUser = $loginUser->user();
        $authUser->list_background_remove = json_decode($authUser->list_background_remove, true);

        return view('client.screen.agora.livestream.student')
            ->with([
                'courseSchedule' => $courseSchedule,
                'loginUser' => $authUser,
                'gifts' => $gifts,
                'boughtGifts' => $boughtGifts,
                'creditCard' => $creditCard,
                'rating' => $rating,
                'subCourse' => $subCourse,
                'allSubCourse' => $allSubCourse,
                'extendCourse' => $extendCourse,
                'optionCourse' => $optionalExtra,
                'background' => $listBackground,
                'courseScheduleId' => $courseScheduleId,
                'minuteExtent' => $extendCourseSchedulePurchased ? $extendCourseSchedulePurchased->minutes_required : 0
            ]);
    }

    /**
     * Pay extent course schedule.
     *
     * @param CourseScheduleService $service
     * @param int $courseScheduleId
     * @param \App\Services\Client\Teacher\CourseScheduleService $teacherService
     * @return array|false|Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function payExtent(CourseScheduleService $service, int $courseScheduleId, \App\Services\Client\Teacher\CourseScheduleService $teacherService)
    {
        $loginUser = Auth::guard('client');

        $courseSchedule = $service->getDetail($courseScheduleId);

        if ($courseSchedule->course->category) {
            $subCourse = $service->getSubCourseDetail($courseSchedule->course_id);
            $allSubCourse = $teacherService->getAllSubCourseDetail($courseSchedule->course->course_id);
            $allSubCourse = $allSubCourse->filter(function ($el) {
                return $el->fixed_num > $el->num_of_applicants;
            })->values();
        }

        return view('client.screen.agora.livestream.pay_extend')
            ->with([
                'courseSchedule' => $courseSchedule,
                'loginUser' => $loginUser->user(),
                'subCourse' => $subCourse,
                'allSubCourse' => $allSubCourse,
                'courseScheduleId' => $courseScheduleId
            ]);
    }

    /**
     * Pay extent end course schedule.
     *
     * @param Request $request
     * @param CourseScheduleService $service
     * @param int $courseScheduleId
     * @param \App\Services\Client\Teacher\CourseScheduleService $teacherService
     * @return Application|ResponseFactory|Response|void
     * @throws Throwable
     */
    public function payExtentEnd(Request $request, CourseScheduleService $service, int $courseScheduleId, \App\Services\Client\Teacher\CourseScheduleService $teacherService)
    {
        if ($request->ajax()) {
            $courseSchedule = $service->getDetail($courseScheduleId);
            $allSubCourse = [];
            $html = null;
            if ($courseSchedule->course->category) {
                $allSubCourse = $teacherService->getAllSubCourseDetail($courseSchedule->course->course_id);
                $allSubCourse = $allSubCourse->filter(function ($el) {
                    return $el->fixed_num > $el->num_of_applicants;
                })->values();
            }
            if (count($allSubCourse)) {
                $html = view('client.screen.agora.livestream.sub-course-item', compact('allSubCourse', 'courseScheduleId'))->render();
            }

            return response([
                'html' => $html,
                'allSubCourse' => count($allSubCourse)
            ]);
        }

    }


    /**
     * get hand-up question_tickets
     *
     * @pararm CourseScheduleService $service
     * @pararm int $course_schedule_id
     * @return array|false|Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function getQuestionTicket(CourseScheduleService $service, int $course_schedule_id)
    {
        return $service->getQuestionTicket($course_schedule_id);
    }

    /**
     * Use hand-up question_tickets
     *
     * @pararm CourseScheduleService $service
     * @pararm int $course_schedule_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function useQuestionTicket(CourseScheduleService $service, Request $request)
    {
        try {
            $message = $request->message ?? "";
            $courseScheduleId = $request->courseScheduleId ?? null;
            $forceSend = $request->forceSend ? (bool)$request->forceSend : false;
            return $service->useQuestionTicket($message, $courseScheduleId, $forceSend);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('errors.MSG_5000')
            ], ErrorType::STATUS_5000);
        }
    }

    public function useQuestionTicketStamp(CourseScheduleService $service, Request $request)
    {
        try {
            $message = $request->message ?? "";
            $courseScheduleId = $request->courseScheduleId ?? null;
            $forceSend = $request->forceSend ? (bool)$request->forceSend : false;
            $course_schedule_id = $request->courseScheduleId;
            return $service->useQuestionTicketStamp($course_schedule_id, $message, $courseScheduleId, $forceSend);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('errors.MSG_5000')
            ], ErrorType::STATUS_5000);
        }
    }

    /**
     * Report teacher.
     *
     * @param Request $request
     * @return array
     */
    public function reportTeacher(Request $request): array
    {
        $content = $request->all();

        try {
            Mail::to(config('app.to_mail_report'))->queue(new SendMailReportBlade('通報を正常に受け付けました。', $content));
            return [
                'success' => true,
                'message' => __('message.report_teacher_success')
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => __('errors.MSG_5022')
            ];
        }

    }

    /**
     * Get time end.
     *
     * @param \App\Services\Client\Teacher\CourseScheduleService $service
     * @param Request $request
     * @param $courseScheduleId
     * @return Application|ResponseFactory|Response|void
     */
    public function getTimeEnd(\App\Services\Client\Teacher\CourseScheduleService $service, Request $request, $courseScheduleId, CourseScheduleService $csService)
    {
        if ($request->ajax()) {
            $extendCourseSchedulePurchased = null;
            $endTimeString = $service->getTimeEndString($courseScheduleId);
            $courseSchedule = $service->getDetail($courseScheduleId);
            if (!$courseSchedule->course->category || $courseSchedule->course->category->type !== DBConstant::CATEGORY_TYPE_SKILLS) {
                $extendCourseSchedulePurchased = $csService->getExtend($courseScheduleId);
            }
            if ($extendCourseSchedulePurchased) {
                $endTimeString = $extendCourseSchedulePurchased->end_datetime->toString();
            }
            return response(['endTimeString' => $endTimeString]);
        }
    }
}
