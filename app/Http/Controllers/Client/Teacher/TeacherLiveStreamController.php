<?php

namespace App\Http\Controllers\Client\Teacher;

use App\Enums\DBConstant;
use App\Http\Controllers\Controller;
use App\Repositories\CourseRepository;
use App\Repositories\OptionalExtraRepository;
use App\Services\Client\Common\FirebaseService;
use App\Services\Client\Common\ImagePathService;
use App\Services\Client\Gift\PurchaseGiftService;
use App\Services\Client\Teacher\CourseScheduleService;
use App\Services\Client\Teacher\CourseService;
use App\Services\Client\Teacher\PurchaseDetailService;
use App\Services\Client\Teacher\UserService;
use App\Services\Common\StripePaymentService;
use App\Traits\ManageFile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Stripe\Exception\ApiErrorException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TeacherLiveStreamController extends Controller
{
    use ManageFile;

    protected $giftService;
    protected $stripePaymentService;
    protected $userService;
    protected $courseRepository;
    protected $firebaseService;
    protected $optionalExtraRepository;
    private $courseScheduleService;
    private $imagePathService;

    public function __construct()
    {
        $this->giftService = app(PurchaseGiftService::class);
        $this->stripePaymentService = app(StripePaymentService::class);
        $this->userService = app(UserService::class);
        $this->courseRepository = app(CourseRepository::class);
        $this->firebaseService = app(FirebaseService::class);
        $this->optionalExtraRepository = app(OptionalExtraRepository::class);
        $this->courseScheduleService = app(CourseScheduleService::class);
        $this->imagePathService = app(ImagePathService::class);
    }

    /**
     * Teacher Sub Course Detail Page.
     *
     * @param CourseScheduleService $service
     * @param int $courseId
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View|mixed
     */
    public function subCourseDetailPage(CourseScheduleService $service, int $courseId)
    {
        $data = $service->getSubCourseDetail($courseId);
        if (!$data['sub'] || !count($data['schedules'])) {
            throw new ModelNotFoundException();
        }

        $schedules = $data['schedules'];
        $course = $data['sub'];

        return view('client.screen.agora.sub-course_detail')->with(['parentSubCourse' => $schedules, 'course' => $course]);
    }

    /**
     *Teacher Trouble Consultation Page.
     *
     * @param int $courseScheduleId
     * @param CourseScheduleService $teacherService
     * @return View|mixed
     */
    public function joinCourse(int $courseScheduleId, \App\Services\Client\Teacher\CourseScheduleService $teacherService)
    {
        $courseSchedule = $this->courseScheduleService->getDetail($courseScheduleId);

        $loginUser = Auth::guard('client');
        $extendCourse = null;
        $optionalExtra = null;
        $extendCourseSchedule = null;
        $subCourse = null;
        $optionPurchased = null;
        $allSubCourse = null;

        if ($courseSchedule) {
            //get extend course by course id
            $extendCourse = $this->courseRepository->getListExtendCourseBy($courseSchedule->course_id);
            $optionalExtra = $courseSchedule->optionalExtras;
        }

        if (!$courseSchedule ||
            !$courseSchedule->course ||
            !$courseSchedule->course->user
        ) {
            throw new ModelNotFoundException();
        }

        if (!$courseSchedule->course->category || $courseSchedule->course->category->type !== DBConstant::CATEGORY_TYPE_SKILLS) {
            $extendCourseSchedule = $this->courseScheduleService->getLastExtendPurchased($courseScheduleId);
        }

        if ($courseSchedule->end_datetime < $courseSchedule->start_datetime) {
            throw new ModelNotFoundException();
        }
        $courseSchedule->teacher_join_late = false;
        if ($extendCourseSchedule) {
            $courseSchedule->end_datetime_string = $extendCourseSchedule->end_datetime;
            if (isset($courseSchedule->actual_start_date)) {
                $courseSchedule->actual_end_date = $extendCourseSchedule->end_datetime;
            }
        }
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

        if ($optionalExtra && $optionPurchased && $optionalExtra->count() && count($optionPurchased)) {
            $optionalExtra->map(function ($el) use ($optionPurchased) {
                return $el->purchased = in_array($el->optional_extra_id, $optionPurchased, true);
            });
        }

        if ($courseSchedule->course->category) {
            $subCourse = $this->courseScheduleService->getAllSubCourseDetail($courseSchedule->course->course_id)->first();
            $allSubCourse = $teacherService->getAllSubCourseDetail($courseSchedule->course->course_id);
            $allSubCourse = $allSubCourse->filter(function ($el) {
                return $el->fixed_num > $el->num_of_applicants;
            })->values();
        }
        $courseSchedule->current_course_schedule_id = $courseSchedule->course_schedule_id;

        if ($courseSchedule->course->user->user_id !== $loginUser->id()) {
            throw new HttpException(403);
        }

        $gifts = $this->giftService->repository->all();

        $creditCard = $this->stripePaymentService->getCreditCard()['data'] ?? [];
        $rate = $this->courseRepository->getTheRatingOfCourse($courseSchedule->course_id);

        $rating = [
            'avg_rating' => $rate->avg('rating') ?? 0,
            'sum_rating' => $rate->sum('num_of_ratings')
        ];

        // check room is valid and create room
        $this->firebaseService->getLivestream($courseScheduleId);

        $listBackground = $this->imagePathService->getListImage($loginUser->id(), DBConstant::IMAGE_PATH_TYPE['background']);
        $listBackground = $listBackground->map(function ($item) {
            return $item->image_s3_url;
        });
        $authUser = $loginUser->user();
        $authUser->list_background_remove = json_decode($authUser->list_background_remove, true);

        return view('client.screen.agora.livestream.teacher')
            ->with([
                'courseSchedule' => $courseSchedule,
                'loginUser' => $authUser,
                'gifts' => $gifts,
                'allSubCourse' => $allSubCourse,
                'creditCard' => $creditCard,
                'rating' => $rating,
                'subCourse' => $subCourse,
                'extendCourse' => $extendCourse,
                'optionCourse' => $optionalExtra,
                'background' => $listBackground,
                'courseScheduleId' => $courseScheduleId,
                'extendCourseSchedule' => $extendCourseSchedule ?? 0,
                'minuteExtent' => $extendCourseSchedule ? $extendCourseSchedule->minutes_required : 0
            ]);
    }

    /**
     * Add time actual.
     *
     * @param Request $request
     * @param $courseScheduleId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|void
     */
    public function addTimeActual(Request $request, $courseScheduleId)
    {
        if ($request->ajax()) {
            $teacherJoinLate = $this->courseScheduleService->addTimeActual($courseScheduleId);
            if (isset($teacherJoinLate))
                return response([
                    'status' => true,
                    'actualEndDate' => $teacherJoinLate
                ]);
            return response([
                'status' => false,
            ]);
        }
    }
}
