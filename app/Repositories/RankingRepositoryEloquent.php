<?php

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Services\Client\CourseSchedule\CourseScheduleService;
use App\Traits\CourseImageTrait;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Ranking;
use App\Validators\RankingValidator;

/**
 * Class RankingRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RankingRepositoryEloquent extends BaseRepository implements RankingRepository
{
    use CourseImageTrait;
    private $courseScheduleService;
    private $purchaseRepository;

    public function __construct(Application $app, CourseScheduleService $courseScheduleService)
    {
        parent::__construct($app);
        $this->courseScheduleService = $courseScheduleService;
        $this->purchaseRepository = app(PurchaseRepository::class);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Ranking::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get course popular in category
     *
     * @param $category
     * @return mixed
     */
    public function getPopularCoursesInCategory($category)
    {
        $type = DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION;
        $courses = $this->model
            ->select(
                'courses.course_id',
                'courses.num_of_ratings',
                'courses.rating',
                'courses.user_id',
                'users.nickname',
                'users.last_name_kanji',
                'users.first_name_kanji',
                'users.name_use',
                'users.user_type',
                'users.profile_image',
                'users.user_status',
                'categories.type',
                DB::raw('MAX(categories.type) as category_type'),
                DB::raw('MAX(rankings.category) as category'),
                DB::raw('MAX(rankings.num_of_applicants) as num_of_applicants')
            )
            ->join('courses', function ($q) {
                $q->on('rankings.course_id', '=', 'courses.course_id')
                    ->where('courses.type', DBConstant::COURSE_TYPE_MAIN)
                    ->where('courses.status', DBConstant::COURSE_STATUS_OPEN)
                    ->where('courses.is_archived', DBConstant::NOT_ARCHIVED_FLAG);
            })
            ->join('categories', function ($q) use ($category) {
                $q->on('courses.category_id', '=', 'categories.category_id')
                    ->where('categories.type', $category);
            })
            ->join('course_schedules as cs', function ($query) use ($type) {
                $query->on('cs.course_id', 'courses.course_id')
                    ->where('cs.type', $type)
                    ->whereIn('cs.status', [DBConstant::COURSE_SCHEDULES_STATUS_OPEN, DBConstant::COURSE_SCHEDULES_STATUS_CLOSED, DBConstant::COURSE_SCHEDULES_STATUS_RECORDED]);
            })
            ->join('users', 'users.user_id', 'courses.user_id')
            ->where([
                'rankings.target_date' => now()->subDays(Constant::DAY_AGO_2)->format('Y-m-d'),
            ])
            ->groupBy('courses.course_id')
            ->orderBy('num_of_applicants', Constant::ORDER_BY_DESC)
            ->take(Constant::NUMBER_RECORDS_DISPLAY['DISPLAY_12'])->get();
        $userId = auth()->guard('client')->user()->user_id ?? null;
        $arrFirst = [];
        $arrLast = [];

        foreach ($courses as $course) {
            $courseSchedule = $this->courseScheduleService->getNearestCourseScheduleByCourseId($course->course_id);
            if ($courseSchedule) {
                if ($courseSchedule->course->courseSchedulesOpenAndPurchase->count() > 1) {
                    $isPurchase = 0;
                    foreach ($courseSchedule->course->courseSchedulesOpenAndPurchase as $cs) {
                        $userPurchased = $this->purchaseRepository->findWhere([
                            'user_id' => $userId,
                            'status' => DBConstant::PURCHASES_STATUS_NOT_CAPTURED,
                            'course_schedule_id' => $courseSchedule->course_schedule_id
                        ])->count();
                        if ($userPurchased === 0 && (int)$cs->status === 0 && $cs->fixed_num > $cs->num_of_applicants && $cs->purchase_deadline > now()->format('Y-m-d H:i:s')) {
                            $isPurchase++;
                        }
                    }

                    if ($isPurchase > 1) {
                        $courseSchedule['isPurchase'] = true;
                    } else {
                        $courseSchedule['isPurchase'] = false;
                    }
                }

                foreach (array_keys($courseSchedule->toArray()) as $key) {
                    $course[$key] = $courseSchedule[$key];
                }
                if (
                    ($course->category_type === DBConstant::CATEGORY_TYPE_SKILLS && $courseSchedule->status === DBConstant::COURSE_SCHEDULES_STATUS_OPEN && $courseSchedule->purchase_deadline > now()->format('Y-m-d H:i:s'))
                    || ($course->category_type !== DBConstant::CATEGORY_TYPE_SKILLS && $courseSchedule->status === DBConstant::COURSE_SCHEDULES_STATUS_OPEN && $courseSchedule->purchase_deadline > now()->format('Y-m-d H:i:s') && $courseSchedule->num_of_applicants < 1)
                ) {
                    $arrFirst[] = $course;
                } else {
                    $arrLast[] = $course;
                }
            }
        }

        $this->getImageOfSchedules($arrFirst);
        $this->getImageOfSchedules($arrLast);

        return array_merge($arrFirst, $arrLast);
    }
}
