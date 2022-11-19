<?php

namespace App\Services\Client\Student\Course;

use App\Enums\DBConstant;
use App\Repositories\ApplicantRepository;
use App\Repositories\FollowRepository;
use App\Repositories\SubscriberRepository;
use App\Services\BaseService;
use App\Services\Common\FollowService;
use Illuminate\Support\Facades\Auth;

class FollowTeacherService extends BaseService
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    public $subscriberRepository;
    public $commonService;
    public $applicantRepository;

    /**
     * CourseReviewService constructor.
     */
    public function __construct()
    {
        // add repository
        parent::__construct();
        $this->subscriberRepository = app(SubscriberRepository::class);
        $this->commonService = app(FollowService::class);
        $this->applicantRepository = app(ApplicantRepository::class);
    }

    /**
     * Review repository class
     *
     * @return string
     */
    public function repository(): string
    {
        return FollowRepository::class;
    }

    /**
     * Post review.
     *
     * @param $request
     * @return array
     */
    public function followTeacher($request): array
    {
        // set value
        $teacherId = (int)$request->user_id;
        $userId = Auth::guard('client')->id();
        // 1-1) Check if the user has already followed the teacher.
        $follow = $this->repository->where([
            'from_user_id' => $userId,
            'to_user_id' => $teacherId
        ])->first();

        if ($follow) {
            // 1-3) Update follow (Execute "06_Update follow".)
            $this->commonService->updateFollow($userId, $teacherId);
            return [
                'status' => false,
                'message' => __('errors.MSG_6028'),
            ];
        }

        if ($teacherId === $userId) {
            return [
                'status' => false,
                'message' => __('errors.MSG_6033'),
            ];
        }

        // Update follow.
        $teacherRepeatCount = $this->applicantRepository->getTeacherRepeatCount($userId, $teacherId);
        $lastPurchasedAt = $this->applicantRepository->getLastPurchaseDate($userId, $teacherId);

        // 1-2) Create follow.
        $this->repository->create([
            'from_user_id' => $userId,
            'to_user_id' => $teacherId,
            'teacher_repeat_count' => $teacherRepeatCount['teacher_repeat_count'] ?? DBConstant::TEACHER_REPEAT_COUNT_DEFAULT,
            'last_purchased_at' => $lastPurchasedAt['created_at'] ?? null,
            'course_id' => null,
        ]);

        // 1-4) Check if the user subscribe the teacher.
        $subscriber = $this->subscriberRepository->firstWhere([
            'from_user_id' => $userId,
            'to_user_id' => $teacherId
        ]);

        // 1-5) Create subscriber(If there's no record at 1-4))
        if (!$subscriber) {
            $this->subscriberRepository->create([
                'from_user_id' => $userId,
                'to_user_id' => $teacherId
            ]);
        }

        return [
            'status' => true,
            'message' => __('errors.MSG_6032'),
        ];
    }

    /**
     * Post review.
     *
     * @param $request
     * @return array
     */
    public function checkFollowTeacher($request): array
    {
        // set value
        $teacherId = (int)$request->user_id;
        $userId = Auth::guard('client')->id();
        // 1-1) Check if the user has already followed the teacher.
        $follow = $this->repository->where([
            'from_user_id' => $userId,
            'to_user_id' => $teacherId
        ])->first();

        if ($follow) {
            // 1-3) Update follow (Execute "06_Update follow".)
            $this->commonService->updateFollow($userId, $teacherId);
            return [
                'status' => false,
                'message' => __('errors.MSG_6028'),
            ];
        }

        if ($teacherId === $userId) {
            return [
                'status' => false,
                'message' => __('errors.MSG_6033'),
            ];
        }

        return [
            'status' => true,
            'message' => __('errors.MSG_6032'),
        ];
    }
}
