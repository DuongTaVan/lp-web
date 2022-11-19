<?php

namespace App\Services\Client\TeacherPage;

use App\Enums\DBConstant;
use App\Repositories\ApplicantRepository;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\FollowRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Traits\CourseImageTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TeacherPageService extends BaseService
{
    use CourseImageTrait;
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $userRepository;

    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $courseScheduleRepository;

    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $reviewRepository;

    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $applicantRepository;

    /**
     * TeacherPageService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->userRepository = app(UserRepository::class);
        $this->courseScheduleRepository = app(CourseScheduleRepository::class);
        $this->reviewRepository = app(ReviewRepository::class);
        $this->applicantRepository = app(ApplicantRepository::class);
        $this->followRepository = app(FollowRepository::class);
        $this->courseRepository = app(CourseRepository::class);
    }

    /**
     * User repository class
     *
     * @return string
     */
    public function repository(): string
    {
        return CourseRepository::class;
    }

    /**
     * check in array
     *
     * @param array $field
     * @param array $input
     * @return array
     */
    private function checkNotGet(array $field, array $input)
    {
        $output = [];
        foreach ($input as $item) {
            $output[] = !empty($field) && !in_array($item, $field, true);
        }
        return $output;
    }

    /**
     * Get data teacher page
     *
     * @param $userId
     * @param array $field
     * @param bool $onlyOpen
     * @return array
     */
    public function getDataTeacherPage($userId, array $field = [], bool $onlyOpen = false)
    {
        $input = ['rating', 'courses', 'reviews', 'countCourseScheduleHeld', 'countHoldingResult', 'followed'];
        $result = [];
        [
            $notRating,
            $notCourses,
            $notReviews,
            $notCountCourseScheduleHeld,
            $notCountHoldingResult,
            $notFollowed
        ] = $this->checkNotGet($field, $input);

        // Get the teacher
        $teacher = $this->userRepository->getDataTeacher($userId);
        $reviewTeacher = $this->reviewRepository->getRatingCourseScheduleById($userId);
        if (empty($teacher)) {
            throw new ModelNotFoundException();
        }
        $result['users'] = $teacher;
        $result['userId'] = $userId;
        $result['reviewTeacher'] = $reviewTeacher;

        // Get the rating and review count
        if (!$notRating) {
            $rating = $this->repository->getTheRatingAndCountReview($userId);
            $result['rating'] = [
                'avg_rating' => $rating->avg('rating') ?? 0,
                'sum_rating' => $rating->sum('num_of_ratings') ?? 0
            ];
        }

        // Get course list
        $courses = null;
        if (!$notCourses) {
            $courses = $this->repository->getListCourses($userId, $onlyOpen);
            $result['courses'] = $courses;
        }
        // Get review list
        if (!$notReviews) {
            $result['reviews'] = $this->reviewRepository->listReview($userId);
        }

        // Count type 開催実績
        if (!$notCountCourseScheduleHeld) {
            $result['countCourseScheduleHeld'] = $this->courseScheduleRepository->countNumberOfUser($userId);

        }

        // Count type 利用者数
        if (!$notCountHoldingResult) {
            $result['countHoldingResult'] = $this->applicantRepository->countHoldingResult($userId);
        }
        if (!$notFollowed) {
            $followed = false;
            if (!$courses) {
                $courses = $this->repository->getListCourses($userId);
            }
            if ($courses) {
                $follow = $this->followRepository->where([
                    'from_user_id' => auth('client')->id(),
                    'to_user_id' => $userId
                ])->first();

                if ($follow) {
                    $followed = true;
                }
            }
            $result['followed'] = $followed;
        }
        if (isset($result['courses'])) {

            foreach ($result['courses'] as $course) {
                if (count($course->courseSchedules) > 0) {
                    $this->getImageOfSchedules($course->courseSchedules);
                    $schedule = $course->courseSchedules[0];
                    $courseSchedules = $course->courseSchedules;
                    $scheduleStatus = $courseSchedules->filter(function ($item) use ($schedule) {
                        if ($schedule['type'] !== 1) {
                            return $item['status'] === 0 && $item['purchase_deadline'] > now()->format('Y-m-d H:i:s') && $item['num_of_applicants'] < 1;
                        } else {
                            return $item['status'] === 0 && $item['purchase_deadline'] > now()->format('Y-m-d H:i:s');
                        }
                    });
                    $countSchedule = count($scheduleStatus);
                    if ($countSchedule > 0) {
                        $course['is_open'] = $countSchedule;
                        $course['is_restock'] = false;
                    } else {
                        $course['is_restock'] = true;
                    }
                }
            }
        }
        return $result;
    }

    public function getDataCourseSchedule($courseScheduleId)
    {
        $user = auth()->guard('client')->user();
        $courseSchedule = $this->courseScheduleRepository->with(['course' => function ($c) {
            $c->join('categories', 'courses.category_id', 'categories.category_id');
            $c->select('courses.*', 'categories.type as category_type');
        }, 'purchases' => function ($q) use ($user) {
            if (isset($user)){
                $q->where('purchases.user_id', $user->user_id);
                $q->where('purchases.status', DBConstant::PURCHASES_STATUS_NOT_CAPTURED);
            }

        }])->where('course_schedule_id', $courseScheduleId)->firstOrFail();
        $course = $courseSchedule->course;
        if (count($course->courseSchedules) > 0) {
            $schedule = $course->courseSchedules[0];
            $courseSchedules = $course->courseSchedules;
            $scheduleStatus = $courseSchedules->filter(function ($item) use ($schedule) {
                if ($schedule['type'] !== 1) {
                    return $item['status'] === 0 && $item['purchase_deadline'] > now()->format('Y-m-d H:i:s') && $item['num_of_applicants'] < 1;
                } else {
                    return $item['status'] === 0 && $item['purchase_deadline'] > now()->format('Y-m-d H:i:s');
                }
            });
            $countSchedule = count($scheduleStatus);
            if ($countSchedule > 0) {
                $course['is_open'] = $countSchedule;
                $course['is_restock'] = false;
            } else {
                $course['is_restock'] = true;
            }
        }

        $bgColor = '';
        $canRestock = false;
        $userPurchase = count($courseSchedule['purchases']) ? $courseSchedule['purchases'][0]['user_id'] : null;
        if (empty($course['is_open']) ||
            ($courseSchedule['purchase_deadline'] < now()->format('Y-m-d H:i:s') || ($courseSchedule['num_of_applicants'] > 0 && $courseSchedule['type'] !== DBConstant::TYPE_CATEGORY_LIVESTREAM))
        ) {
            $bgColor = '販売終了';
        }
        if (
            ($user && $user->user_id === $userPurchase && $courseSchedule['status'] === DBConstant::COURSE_SCHEDULES_STATUS_OPEN) ||
            ($courseSchedule['num_of_applicants'] > 0 && $course['category_type'] !== DBConstant::TYPE_CATEGORY_LIVESTREAM && $courseSchedule['status'] === DBConstant::COURSE_SCHEDULES_STATUS_OPEN)
        ) {

            $bgColor = '販売終了';
        } else if ($courseSchedule['status'] !== DBConstant::COURSE_SCHEDULES_STATUS_OPEN && $courseSchedule->course->user->user_status === DBConstant::USER_STATUS_DEACTIVE) {
            $bgColor = 'サービス休止';
        } else if ($course['is_restock'] === true) {
            $bgColor = '開催リクエスト受付中';
        } else if ($course['is_restock'] === false && $courseSchedule['status'] !== DBConstant::COURSE_SCHEDULES_STATUS_OPEN) {
            $bgColor = '開催終了';
        }
        $data['bgColor'] = $bgColor;
        $data['title'] = $courseSchedule->title;
        $data['body'] = $courseSchedule->body;
        $this->getImageOfSchedule($courseSchedule);
        $data['image_url'] = $courseSchedule->image_url;
        $data['price'] = (int)$courseSchedule->price;
        return $data;
    }

    /**
     * Get course detail.
     *
     * @param $data
     * @return mixed
     */

    public function courseDetail($data)
    {
        // Get course list
        return $this->repository->getListCourses($data);

    }

    /**
     * Get review detail.
     *
     * @param $data
     * @return mixed
     */
    public function reviewDetail($data)
    {
        // Get review list

        return $this->reviewRepository->listReview($data);
    }


    public function getListCourse($userId)
    {
        return $this->repository->getCourseByUseID($userId);
    }

    public function getDetailCourseSchedule(int $courseScheduleId)
    {
        return $this->courseScheduleRepository->find($courseScheduleId);
    }
}
