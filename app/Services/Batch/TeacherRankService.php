<?php

declare(strict_types=1);

namespace App\Services\Batch;

use App\Enums\DBConstant;
use App\Models\Review;
use App\Models\Sale;
use App\Models\User;
use App\Repositories\RankRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\SaleRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class TeacherRankService extends BaseService
{
    private $rankRepository;

    private $saleRepository;

    private $reviewRepository;

    private $userRepository;

    /**
     * TeacherRankService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->rankRepository = app(RankRepository::class);
        $this->saleRepository = app(SaleRepository::class);
        $this->reviewRepository = app(ReviewRepository::class);
        $this->userRepository = app(UserRepository::class);
    }

    /**
     * @return string
     */
    public function repository()
    {
        return UserRepositoryEloquent::class;
    }

    /**
     * Batch 09 change teacher rank.
     */
    public function changeTeacherRank()
    {
        // 1-1) Get rank data.
        $ranks = $this->rankRepository->getRankData();

        try {
            foreach ($ranks as $rank) {
                // get course schedule status = close or sale.
                $users = User::query()->join('courses', 'users.user_id', '=', 'courses.user_id')
                    ->join('course_schedules', 'course_schedules.course_id', '=', 'courses.course_id')
                    ->whereIn('course_schedules.status', [DBConstant::COURSE_SCHEDULES_STATUS_CLOSED, DBConstant::COURSE_SCHEDULES_STATUS_RECORDED])
                    ->where('course_schedules.num_of_applicants', '>', DBConstant::NUM_OF_APPLICANT)
                    ->where([
                        ['users.user_type', '=', DBConstant::USER_TYPE_TEACHER],
                        ['users.is_archived', '=', DBConstant::NOT_ARCHIVED_FLAG],
                    ])
                    ->select('users.user_id', 'course_schedule_id')
                    ->get();

                $users = $users->mapToGroups(function ($item, $key) {
                    return [$item['user_id'] => $item['course_schedule_id']];
                });

                $users = $users->filter(function ($item, $key) use ($rank) {
                    return count($item) >= $rank->num_of_courses_held_standard;
                });

                // Check if you can sell any key for 3 months, then you can move to higher rank from 3rd rank.
                if ($rank['period_days_standard'] === 90) {
                    $data = Sale::query()->selectRaw('user_id, count(target_date) as total')
                        ->where('sales.target_date', '<=', now()->subDays(90))
                        ->whereIn('user_id', $users->keys())
                        ->groupBy('user_id')
                        ->get();

                    $users = $users->filter(function ($item, $key) use ($data, $rank) {
                        foreach ($data as $value) {
                            if ($value->total >= $rank->num_of_courses_held_standard && $value->user_id === $key) {
                                return $item;
                            }
                        }
                    });
                }

                foreach ($users as $key => $userArr) {
                    $avg = Review::query()->whereIn('course_schedule_id', $userArr)
                        ->selectRaw("avg(rating) as avg_rating")
                        ->first();

                    if ($avg->avg_rating >= $rank->avg_rating_standard) {
                        User::query()->where('user_id', $key)->update(['rank_id' => $rank['rank_id']]);
                    }

                    if ($avg->avg_rating < 3.5) {
                        User::query()->where('user_id', $key)->update(['rank_id' => 1]);
                    }
                }
            }

            return [
                'success' => true,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
