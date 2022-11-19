<?php

declare(strict_types=1);

namespace App\Services\Client\TopPage;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Repositories\CategoryRepository;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\FavoriteRepositoryEloquent;
use App\Repositories\ImagePathRepository;
use App\Repositories\PageViewRepository;
use App\Repositories\RankingRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Class TopPageService
 *
 * @package App\Services\Client\TopPage
 */
class TopPageService extends BaseService
{
    protected $rankingRepository;
    protected $pageViewRepository;
    protected $imagePathRepository;
    protected $courseScheduleRepository;
    protected $userRepository;
    protected $courseRepository;
    protected $favoriteRepository;
    protected $categoryRepository;


    /**
     * TopPageService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->rankingRepository = app(RankingRepository::class);
        $this->pageViewRepository = app(PageViewRepository::class);
        $this->imagePathRepository = app(ImagePathRepository::class);
        $this->courseScheduleRepository = app(CourseScheduleRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->courseRepository = app(CourseRepository::class);
        $this->favoriteRepository = app(FavoriteRepositoryEloquent::class);
        $this->categoryRepository = app(CategoryRepository::class);
    }

    /**
     * User repository class.
     *
     * @return string
     */
    public function repository(): string
    {
        return CourseScheduleRepository::class;
    }

    /**
     * Get data top page.
     *
     * @return array
     */
    public function getDataTopPage()
    {
        $newCourseSchedule = $this->courseRepository->getNewCourseSchedule($this->courseScheduleRepository->getOneScheduleOfCourseNew());

        $popularCoursesInSkills = $this->rankingRepository->getPopularCoursesInCategory(DBConstant::CATEGORY_TYPE_SKILLS);
//        $popularCoursesInSkills = Cache::remember('rankings/skills:popular_courses', 24 * 60, function () {
//            return $this->rankingRepository->getPopularCoursesInCategory(DBConstant::CATEGORY_TYPE_SKILLS);
//        });

        // Get popular courses in consultation
        $popularCoursesInConsultation = $this->rankingRepository->getPopularCoursesInCategory(DBConstant::CATEGORY_TYPE_CONSULTATION);
//        $popularCoursesInConsultation = Cache::remember('rankings/consultation:popular_courses', 24 * 60, function () {
//            return $this->rankingRepository->getPopularCoursesInCategory(DBConstant::CATEGORY_TYPE_CONSULTATION);
//        });

        // Get popular courses in skills
        $popularCoursesFortunetelling = $this->rankingRepository->getPopularCoursesInCategory(DBConstant::CATEGORY_TYPE_FORTUNETELLING);
//        $popularCoursesFortunetelling = Cache::remember('rankings/fortunetelling:popular_courses', 24 * 60, function () {
//            return $this->rankingRepository->getPopularCoursesInCategory(DBConstant::CATEGORY_TYPE_FORTUNETELLING);
//        });
//         Get course viewed recently
        if (auth('client')->check()) {
            $courseViewedRecently = $this->courseRepository->getCourseViewedRecently($this->pageViewRepository->getOneScheduleOfCourseRecently());
        } else {
            $courseViewedRecently = null;
        }

        return [
            'newCourseSchedule' => $newCourseSchedule,
            'popularCoursesInSkills' => $popularCoursesInSkills,
            'popularCoursesInConsultation' => $popularCoursesInConsultation,
            'popularCoursesFortunetelling' => $popularCoursesFortunetelling,
            'courseViewedRecently' => $courseViewedRecently,
        ];
    }

    /**
     * Add page view top page.
     */
    public function addPageViewTopPage()
    {
        // Get user login
        $authUserId = auth()->guard('client')->id();
        if (Auth::guard('client')->check()) {
            // Add page view
            $this->pageViewRepository->create([
                'user_id' => $authUserId,
                'view_count' => DBConstant::PAGE_VIEW_COUNT_DEFAULT,
                'is_top_page' => DBConstant::IS_TOP_PAGE_VIEWED,
                'is_skills' => DBConstant::IS_SKILL_NOT_VIEWED,
                'is_consultation' => DBConstant::IS_CONSULTATION_NOT_VIEWED,
                'is_fortunetelling' => DBConstant::IS_FORTUNETELLING_NOT_VIEWED,
                'to_user_id' => null,
                'to_course_schedule_id' => null,
                'viewed_at' => now(),
            ]);
        }
    }

    /**
     *  Get schedules in day.
     *
     * @param $type
     * @return mixed
     */
    public function getSchedulesInDay($request)
    {
//        return $this->courseScheduleRepository->listCourseInDay($request);
        $request->merge([
            'page' => $request->input('page', Constant::PAGE_DEFAULT),
            'perPage' => $request->input('per_page', Constant::PER_PAGE_DEFAULT),
            'category_id' => $request->input('category_id'),
            'category_type' => $request->input('category_type', null),
            'start_date' => $request->input('start_date', null),
            'keyword' => $request->input('keyword', ''),
            'time_frame' => $request->input('time_frame', null),
            'sort' => $request->input('sort', Constant::COURSES_SORT_ORDER_SEARCH),
            'calendar' => true
        ]);
        $data = $request->all();

        $query = $this->searchCourseQuery($data)
            ->select(DB::raw('CAST(start_datetime AS DATETIME) as date'))
            ->groupBy(DB::raw('CAST(start_datetime AS DATETIME)'));

        return $query->get()->pluck('date');

    }

    /**
     * Search Course.
     *
     * @param $request
     * @return mixed
     */
    public function searchCourse($request)
    {
        $request->merge([
            'page' => $request->input('page', Constant::PAGE_DEFAULT),
            'perPage' => $request->input('per_page', Constant::PER_PAGE_DEFAULT),
            'category_id' => $request->input('category_id'),
            'category_type' => $request->input('category_type', null),
            'start_date' => $request->input('start_date', null),
            'keyword' => $request->input('keyword', ''),
            'time_frame' => $request->input('time_frame', null),
            'sort' => $request->input('sort', Constant::COURSES_SORT_ORDER_SEARCH),
            'calendar' => false
        ]);
        $data = $request->all();
        $category = [
            'type' => $data['category_type'],
            'id' => $data['category_id'],
            'keyword' => $data['keyword']
        ];
        $option = [
            'sort' => (int)$data['sort'],
            'perPage' => $data['perPage'],
            'startDate' => $data['start_date'],
            'timeFrame' => $data['time_frame']
        ];
        $csIds = $this->courseScheduleRepository->getOneScheduleOfCourseNew($category, $option);
        $result = $this->courseRepository->getNewCourseSchedule($csIds, $option);

        foreach ($result as $schedule) {
            $course = $schedule;
            $courseSchedules = $schedule->courseSchedules;
            $scheduleStatus = $courseSchedules->filter(function ($cs) use ($course) {
                if ($course['type'] !== 1) {
                    return $cs['status'] === 0 && $cs['purchase_deadline'] > now()->format('Y-m-d H:i:s') && $cs['num_of_applicants'] < 1;
                }

                return $cs['status'] === 0 && $cs['purchase_deadline'] > now()->format('Y-m-d H:i:s');
            });
            $countSchedule = count($scheduleStatus);
            if ($countSchedule > 0) {
                $schedule['is_open'] = $countSchedule;
                $schedule['is_restock'] = false;
            } else {
                $schedule['is_restock'] = true;
            }
        }
        return $result;
    }

    /**
     * Search Course query.
     *
     * @param $data
     * @return mixed
     */
    public function searchCourseQuery($data)
    {
        $userId = auth()->guard('client')->user()->user_id ?? null;
        $query = $this->courseRepository
            ->with('courseSchedules')
            ->select(
                'courses.course_id',
                'courses.user_id',
                'courses.parent_course_id',
                'courses.category_id',
                'courses.approval_status',
                'courses.dist_method',
                'courses.rating',
                'courses.num_of_ratings',
                'courses.is_mask_required',
                'courses.is_archived',
                'courses.num_of_sales',
                DB::raw('MAX(cs.course_schedule_id) as course_schedule_id'),
                DB::raw('MAX(cs.status) as status'),
                DB::raw('MAX(cs.title) as title'),
                DB::raw('MAX(cs.subtitle) as subtitle'),
                DB::raw('MAX(cs.body) as body'),
                DB::raw('MAX(cs.minutes_required) as minutes_required'),
                DB::raw('MAX(cs.price) as price'),
                DB::raw('MAX(cs.fixed_num) as fixed_num'),
                DB::raw('MAX(cs.start_datetime) as start_datetime'),
                DB::raw('MAX(cs.end_datetime) as end_datetime'),
                DB::raw('MAX(cs.created_at) as created_at'),
                'categories.type',
                DB::raw('MAX(purchases.user_id) as p_user_id')
            )
            ->join('course_schedules as cs', function ($query) {
                $query->on('cs.course_id', 'courses.course_id')
                    ->where('cs.status', DBConstant::COURSE_SCHEDULES_STATUS_OPEN)
                    ->where('cs.purchase_deadline', '>', now())
                    ->whereColumn('cs.fixed_num', '>', 'cs.num_of_applicants')
                    ->where('cs.status', DBConstant::COURSE_SCHEDULES_STATUS_OPEN); //TODO duongtv confirm
            })
            ->leftJoin('purchases', function ($q) use ($userId) {
                $q->on('purchases.course_schedule_id', 'cs.course_schedule_id')
                    ->where('purchases.user_id', '<>', $userId);
            })
            ->join('categories', 'courses.category_id', 'categories.category_id')->where([
                'courses.type' => DBConstant::COURSE_TYPE_MAIN,
                'courses.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
                'cs.type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                ['cs.title', 'LIKE', '%' . $data['keyword'] . '%']
            ])
            ->groupBy('courses.course_id');


        $categoryId = $data['category_id'];
        if ($categoryId) {
            $query->where(['courses.category_id' => $categoryId]);
        }
        $categoryType = $data['category_type'];
        if ($categoryType) {

            $query->where(['categories.type' => $categoryType]);
//            $query->join(
//                'categories as ca', 'ca.category_id', '=', 'co.category_id'
//            )->where(['ca.type' => $categoryType]);
        }


        $search = trim($data['keyword'] ?? '', ' ');
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('cs.title', 'LIKE', '%' . $search . '%')
                    ->orWhere('cs.body', 'LIKE', '%' . $search . '%');
            });
        }

        $date = $data['start_date'];
        $timeFrame = $data['time_frame'];
        $frame1 = null;

        switch ($timeFrame) {
            case Constant::COURSES_TIME_FRAME_MORNING:
                $frame = [Constant::MORNING['startTime'], Constant::MORNING['endTime']];
                break;
            case Constant::COURSES_TIME_FRAME_AFFTERNOON:
                $frame = [Constant::AFTERNOON['startTime'], Constant::AFTERNOON['endTime']];
                break;
            default:
                $frame = [Constant::NIGHT['startTime'], '23:59:59'];
                $frame1 = ['00:00:00', Constant::NIGHT['endTime']];
        }
        if (!$data['calendar']) {

            if ($date) {
                if ($timeFrame && $timeFrame == Constant::COURSES_TIME_FRAME_NIGHT) {
                    $startDateTime = now()->parse($date)->format('Y-m-d') . ' 19:00:00';
                    $endDateTime = Date('Y-m-d', strtotime($date . '+1 day')) . ' 07:59:59';
                    $query->where('start_datetime', '>=', $startDateTime)
                        ->where('start_datetime', '<=', $endDateTime);
                } else {
                    $query->where(DB::raw("(DATE_FORMAT(start_datetime, '%Y-%m-%d'))"), "=", now()->parse($date)->format('Y-m-d'));
                }
            } else {
                $nowDate = now()->subMonth()->firstOfMonth()->format('Y-m-d') . ' 08:00:00';
                $nextMonthDay = now()->addMonth()->firstOfMonth()->format('Y-m-d') . ' 07:59:59';
                $query->where('start_datetime', '>=', $nowDate);
            }
        }

        if ($timeFrame) {
            $query->where(function ($query) use ($frame, $timeFrame, $date) {
                $query->whereBetween(DB::raw("(DATE_FORMAT(start_datetime, '%H:%i:%s'))"), $frame);
                if ($timeFrame == Constant::COURSES_TIME_FRAME_NIGHT) {
                    $query->orWhereBetween(DB::raw("(DATE_FORMAT(start_datetime, '%H:%i:%s'))"), ['00:00:00', Constant::NIGHT['endTime']]);
                }
            });
        }

        if ($data['calendar']) {
            return $query;
        }

        $sort = (int)$data['sort'];

        switch (true) {
            // 1-1) Search course schedules. (When sort = "開催日順")
            case $sort === Constant::COURSES_SORT_ORDER_DATE:
                $query->orderBy('created_at', 'DESC');
                break;
            // 1-3) Search course schedules. (When sort = "おすすめ順")
//            case $sort === Constant::COURSES_SORT_ORDER_RECOMMEND:
//                break;
            // 1-2) Search course schedules. (When sort = "検索順")
            default:
                $query->orderBy('start_datetime', 'DESC');
                $query->orderBy('status', 'ASC');
        }

        return $query;
    }

    /**
     * Get Course Schedule List.
     *
     * @param $courseScheduleList
     * @return array
     */
    private function getCourseScheduleList($courseScheduleList)
    {
        if (count($courseScheduleList) > 0) {
            $courseIds = [];
            foreach ($courseScheduleList as $course) {
                $courseIds[] = $course['course_id'];
            }

            $courseSchedules = $this->repository->getCourseScheduleList($courseIds);
            $timeFrame = [];
            $monthDays = [];
            if (count($courseSchedules) > 0) {
                foreach ($courseSchedules as $courseSchedule) {
                    if (in_array($courseSchedule['course_id'], $courseIds)) {
                        $timeFrame[$courseSchedule['course_id']][] = $courseSchedule->hour_minute;
                        $monthDays[$courseSchedule['course_id']][] = $courseSchedule->month_day;
                    }
                }
                foreach ($courseScheduleList as $key => $item) {
                    $courseScheduleList[$key]['time_frame'] = $timeFrame[$item['course_id']] ?? [];
                    $courseScheduleList[$key]['month_days'] = $monthDays[$item['course_id']] ?? [];
                }
            }

            return $courseScheduleList;
        }
        return [];
    }

    /**
     * Get Data Category.
     */
    public function getDataCategory(): array
    {
        $categories = $this->categoryRepository->all()->toArray();

        $categoriesSkill = [];
        $categoriesConsult = [];
        $categoriesFortunetelling = [];

        if (count($categories) > 0) {
            foreach ($categories as $category) {
                switch ($category['type']) {
                    case DBConstant::CATEGORY_TYPE_SKILLS:
                        array_push($categoriesSkill, $category);
                        break;
                    case DBConstant::CATEGORY_TYPE_CONSULTATION:
                        array_push($categoriesConsult, $category);
                        break;
                    case DBConstant::CATEGORY_TYPE_FORTUNETELLING:
                        array_push($categoriesFortunetelling, $category);
                }
            }
        }

        return [
            'categoriesSkill' => $categoriesSkill,
            'categoriesConsult' => $categoriesConsult,
            'categoriesFortunetelling' => $categoriesFortunetelling
        ];
    }

    public function countNumOfApplication(int $id)
    {
        $schedule = $this->courseScheduleRepository
            ->where('course_schedule_id', $id)
            ->select('num_of_applicants')
            ->first();

        return $schedule->num_of_applicants ?? 0;
    }
}
