<?php

namespace App\Services\Client\Student;

use App\Repositories\CourseRepository;
use App\Repositories\FollowRepository;
use App\Repositories\ReviewRepository;
use App\Services\BaseService;

class MyPageFollowService extends BaseService
{

    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $courseRepository;
    protected $reviewRepository;


    public function __construct()
    {
        parent::__construct();
        $this->courseRepository = app(CourseRepository::class);
        $this->reviewRepository = app(ReviewRepository::class);
    }

    /**
     * Follow repository class
     *
     * @return string
     */
    public function repository()
    {
        return FollowRepository::class;
    }

    /**
     * Get list follow
     * @param $request
     * @return mixed
     */
    public function myPageFollowList($request)
    {
        $follows = $this->repository->myPageFollowList($request);
        $ratings = [];
        $avgRating = [];
        foreach ($follows as $follow) {
            $ratings[] = $this->reviewRepository->getRatingCourseScheduleById($follow->to_user_id);
        }
        foreach ($ratings as $rating) {
            $avgRating[] = $rating->avg('avg_rating') ?? 0;
        }
        return [
            'avg_rating' => $avgRating,
            'follows' => $follows,
        ];
    }
}
