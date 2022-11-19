<?php

namespace App\Services\Client\Student\Course;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Repositories\ApplicantRepository;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Services\Common\DepositPointsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseReviewService extends BaseService
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    public $applicantRepository;
    public $courseScheduleRepository;
    public $courseRepository;
    public $commonService;
    public $userRepository;

    /**
     * CourseReviewService constructor.
     */
    public function __construct()
    {
        // add repository
        parent::__construct();
        $this->applicantRepository = app(ApplicantRepository::class);
        $this->courseRepository = app(CourseRepository::class);
        $this->courseScheduleRepository = app(CourseScheduleRepository::class);
        $this->commonService = app(DepositPointsService::class);
        $this->userRepository = app(UserRepository::class);
    }

    /**
     * Review repository class
     *
     * @return string
     */
    public function repository(): string
    {
        return ReviewRepository::class;
    }

    /**
     * Post review
     *
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function postReview($request)
    {
        DB::beginTransaction();
        try {
            $courseScheduleId = $request->course_schedule_id;
            $rating = $request->rating;
            $comment = $request->comment;
            $userId = Auth::guard('client')->id();

            // check student buy course
            $applicant = $this->applicantRepository->where([
                'user_id' => $userId,
                'course_schedule_id' => $courseScheduleId
            ])->first();

            if (!$applicant) {
                return response([
                    'status' => false,
                    'message' => __('errors.MSG_8007')
                ]);
            }

            // 1-1) Check if the user has already posted the review.
            $review = $this->repository->where([
                'user_id' => $userId,
                'course_schedule_id' => $courseScheduleId
            ])->first();

            if ($review) {
                return response([
                    'status' => false,
                    'message' => __('errors.MSG_6027')
                ]);
            }

            // 1-2) Post a review.
            $review = $this->repository->create([
                'user_id' => $userId,
                'course_schedule_id' => $courseScheduleId,
                'rating' => $rating / 2,
                'comment' => $comment,
                'is_public' => $request->profile === 'true' ? DBConstant::PUBLIC_INFO : DBConstant::HIDDEN_INFO
            ]);

            // 1-3) Update applicant status.
            $applicant->is_reviewed = DBConstant::REVIEWED;
            $applicant->save();

            // 1-4) Get the course ID.
            $courseId = $this->courseScheduleRepository->firstWhere('course_schedule_id', $courseScheduleId)->course_id;

            // 1-5) Calculate average rating.
            $avgRating = $this->repository->join(
                'course_schedules as cs', 'reviews.course_schedule_id', '=', 'cs.course_schedule_id'
            )->where('cs.course_id', '=', $courseId)->avg('rating');

            // 1-6) Update average rating and the number of reviews.
            $course = $this->courseRepository->firstWhere('course_id', $courseId);
            if (!$course) {
                return response([
                    'status' => false,
                    'message' => __('errors.MSG_5030')
                ]);
            }

            $course->rating = $avgRating;
            $course->num_of_ratings = ++$course->num_of_ratings;
            $course->save();

            // get course schedule
            $courseSchedule = $this->courseScheduleRepository->firstWhere('course_schedule_id', $courseScheduleId);
            $pointReward = Constant::REVIEW_REWARD_POINTS;

            // update when course schedule ended 30 days
            if (now()->parse($courseSchedule->end_datetime)->addDays(Constant::REVIEW_REWARD_LIMIT_DATE) < now()) {
                $pointReward = Constant::REVIEW_REWARD_POINTS_OUT_DATE;
            }

            // 1-7) Deposit points (Execute "02_Deposit points service")
            $this->commonService->depositPoints($userId, $pointReward, DBConstant::DEPOSIT_REASON_SERVICES, $review->id);

            //Get user and reviewed last one.
            $user = $this->userRepository->find(auth('client')->id());
            $reviewed = $this->repository->where([
                'user_id' => $userId,
                'course_schedule_id' => $courseScheduleId
            ])->first();

//            $html = view('client.screen.student-livestream.modal', compact('user', 'reviewed', 'courseSchedule'))->render();

            DB::commit();

            return response([
                'status' => true,
                'message' => __('errors.MSG_5039'),
//                'html' => $html
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();

            return response([
                'status' => false,
                'message' => __('errors.MSG_6027')
            ]);
        }
    }

    public function getReviewView($courseScheduleId)
    {
        $review = $this->repository->where([
            'user_id' => \auth()->guard('client')->id(),
            'course_schedule_id' => $courseScheduleId
        ])->first();

        if ($review) {
            return [
                'courseSchedule' => $this->courseScheduleRepository->firstWhere('course_schedule_id', $courseScheduleId),
                'reviewed' => $review
            ];
        }


    }
}
