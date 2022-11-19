<?php


namespace App\Services\Client\Teacher;

use App\Enums\DBConstant;
use App\Mail\AdminSendSaleCommissionEnd;
use App\Repositories\CourseRepository;
use App\Repositories\PromotionRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Mail;

class UserService extends BaseService
{
    private $reviewRepository;
    private $promotionRepository;

    public function __construct()
    {
        parent::__construct();
        $this->reviewRepository = app(ReviewRepository::class);
        $this->courseRepository = app(CourseRepository::class);
        $this->promotionRepository = app(PromotionRepository::class);
    }

    public function repository()
    {
        return UserRepository::class;
    }

    /**
     * Get rate of teacher.
     *
     * @param int $userId
     * @return mixed
     */
    public function rating(int $userId)
    {
        $courseScheduleId = $this->repository->where([
            'users.user_id' => $userId,
            'users.user_type' => DBConstant::USER_TYPE_TEACHER,
            'users.is_archived' => DBConstant::NOT_ARCHIVED_FLAG
        ])
            ->join('courses as co', 'users.user_id', '=', 'co.user_id')
            ->join('course_schedules as cs', 'co.course_id', '=', 'cs.course_id')
            ->pluck('cs.course_schedule_id')->toArray();

        return $this->reviewRepository->findWhereIn('course_schedule_id', $courseScheduleId);
    }

    public function accountIsClose($userId, $isArchived = DBConstant::ARCHIVED_FLAG)
    {
        return $this->repository->where([
            'user_id' => $userId,
            'is_archived' => $isArchived
        ])->first();
    }

    public function autoSendMailUser()
    {
        //get a list of users with new_service = 1;
//        $users = $this->repository->where('new_service', DBConstant::USER_NEW_SERVICE)->get();
        $promotions = $this->promotionRepository
            ->whereRaw("DATE(finished_at) = '" . now()->format('Y-m-d') . "'")
            ->get();
//        if ($users->count() > 0) {
            foreach ($promotions as $promotion) {
                $user = $promotion->user;
                Mail::to($user->email)->queue(
                    new AdminSendSaleCommissionEnd(
                        '【Lappi】販売手数料１０％適応終了のお知らせ。',
                        $promotion,
                        $user->full_name
                    )
                );
//                $userFirstCourse = $this->courseRepository->where([
//                    'user_id' => $user->user_id,
//                    'status' => DBConstant::APPROVAL_STATUS_COURSE
//                ])->orderBy('courses.updated_at', 'ASC')->first();
//                $userLastCourse = $this->courseRepository->where([
//                    'user_id' => $user->user_id,
//                    'status' => DBConstant::APPROVAL_STATUS_COURSE
//                ])->orderBy('courses.updated_at', 'DESC')->pluck('updated_at')->first();
                //distance between 2 times first and last course.
//                if ($userFirstCourse) {
//                    $distanceBetweenTime = $userFirstCourse->updated_at->diffInDays(now());
//                    if ((int)$distanceBetweenTime === Constant::TEACHER_PROMOTION_DAY - 1) {
//                        Mail::to($user->email)->queue(new AdminSendSaleCommissionEnd('【Lappi】販売手数料１０％適応終了のお知らせ。', $userFirstCourse, $user->full_name));
//                    }
//                }
            }
//        }
        return true;
    }
}
