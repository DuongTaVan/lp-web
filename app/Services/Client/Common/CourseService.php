<?php

declare(strict_types=1);

namespace App\Services\Client\Common;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Models\Course;
use App\Models\CourseSchedule;
use App\Repositories\CategoryRepositoryEloquent;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepositoryEloquent;
use App\Repositories\FavoriteRepositoryEloquent;
use App\Repositories\PageViewRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CourseService extends BaseService
{
    private $pageViewRepository;

    private $favoriteRepository;

    private $cRepository;

    public $courseRepository;

    public $categoryRepository;

    /**
     * CourseService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->pageViewRepository = app(PageViewRepository::class);
        $this->favoriteRepository = app(FavoriteRepositoryEloquent::class);
        $this->courseRepository = app(Course::class);
        $this->categoryRepository = app(CategoryRepositoryEloquent::class);
        $this->cRepository = app(CourseRepository::class);
    }

    /**
     * @return string
     */
    public function repository()
    {
        return CourseScheduleRepositoryEloquent::class;
    }

    /**
     * Search course.
     *
     * @param $request
     * @param mixed $data
     * @return array
     */
    public function searchCourse($request)
    {
        $request->merge([
            'page' => $request->input('page', Constant::PAGE_DEFAULT),
            'perPage' => $request->input('per_page', Constant::PER_PAGE_DEFAULT),
        ]);

        // Handle request data with difference time frame.
        $data = $request->all();
        if (isset($data['time_frame'])) {
            if ($data['time_frame'] == Constant::COURSES_TIME_FRAME_MORNING) {
                $data['start_time'] = '00:00:00';
                $data['end_time'] = '12:00:00';
            } elseif ($data['time_frame'] == Constant::COURSES_TIME_FRAME_AFFTERNOON) {
                $data['start_time'] = '12:00:00';
                $data['end_time'] = '18:00:00';
            } else {
                $data['start_time'] = '18:00:00';
                $data['end_time'] = '23:59:00';
            }
        }

        // Set start of day.
        $data['start_datetime'] = now()->parse($data['start_date'])->startOfDay();
        $data['end_datetime'] = now()->parse($data['end_date'])->addDay()->startOfDay();

        // 1-1) search course schedule when sort = 開催日順.
        if ($data['sort'] == Constant::COURSES_SORT_ORDER_DATE) {
            $courseScheduleList = $this->repository->getCourseScheduleListBySort($data);

            // 1-4) get list course schedule.
            return $this->getCourseScheduleList($courseScheduleList);
        } elseif ($data['sort'] == Constant::COURSES_TIME_FRAME_AFFTERNOON) {
            $subQuery = $this->pageViewRepository->getSumViewCount();
            $courseScheduleList = $this->repository->getCourseScheduleListByOrderSearch($data, $subQuery);

            // 1-4) get list course schedule.
            return $this->getCourseScheduleList($courseScheduleList);
        }
        $subQuery = $this->favoriteRepository->getCountCourseSchedule();
        $courseScheduleList = $this->repository->getCourseScheduleListByOrderReCommend($data, $subQuery);

        // 1-4) get list course schedule.
        return $this->getCourseScheduleList($courseScheduleList);
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

            return $this->repository->getCourseScheduleList($courseIds);
        }

        return [];
    }

    /**
     * @param $courseScheduleId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getSubCourseDetail($courseScheduleId)
    {
        $courseSchedule = CourseSchedule::where('course_schedule_id', $courseScheduleId)->firstOrFail();
        $userId = auth()->guard('client')->id();
        return Course::with(['courseSchedules' => function ($query) {
            $query->where([
                ['purchase_deadline', '>=', Carbon::now()],
                'course_schedules.type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                'course_schedules.status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
            ]);
        }, 'courseSchedules.purchases' => function ($query) use ($userId) {
            $query->where('status', DBConstant::PURCHASES_STATUS_CAPTURED)
                ->where('user_id', $userId);
        }])
            ->where([
                'type' => DBConstant::COURSE_TYPE_SUB,
                'parent_course_id' => $courseSchedule->course_id,
                'courses.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
            ])
            ->firstOrFail();
    }

    /**
     * @param $courseScheduleId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getAllSubCourseDetail($courseScheduleId)
    {
        $courseSchedule = CourseSchedule::where('course_schedule_id', $courseScheduleId)->firstOrFail();
        $userId = auth()->guard('client')->id();
        return Course::with(['courseSchedules' => function ($query) {
            $query->where([
                ['purchase_deadline', '>=', Carbon::now()],
                'course_schedules.type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                'course_schedules.status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
            ]);
        }, 'courseSchedules.purchases' => function ($query) use ($userId) {
            $query->where('status', DBConstant::PURCHASES_STATUS_CAPTURED)
                ->where('user_id', $userId);
        }])
            ->where([
                'type' => DBConstant::COURSE_TYPE_SUB,
                'parent_course_id' => $courseSchedule->course_id,
                'courses.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
            ])
            ->firstOrFail();
    }

    /**
     * Show list course request
     *
     * @param $request
     * @return mixed
     */
    public function getRequestCourses($request)
    {
        $perPage = $request->per_page ?? Constant::PER_PAGE_DEFAULT;
        $courses = $this->courseRepository
            ->join(
                DB::raw("
                    (SELECT user_id,
                        CASE
                            WHEN user_type = " . DBConstant::USER_TEACHER . " AND name_use = " . DBConstant::USER_REALNAME . " THEN CONCAT(last_name_kanji,' ', first_name_kanji)
                            ELSE nickname
                        END AS full_name_user
                        FROM users
                    ) as css
                "), function ($join) {
                $join->on('courses.user_id', '=', 'css.user_id');
            })
            ->where([
                'dist_method' => DBConstant::DIST_METHOD_LIVE_STREAMING,
                'type' => DBConstant::COURSE_TYPE_MAIN
            ])
            ->whereNull('parent_course_id')
            ->whereNotIn('status', [DBConstant::COURSE_STATUS_DRAFT, DBConstant::COURSE_STATUS_PREVIEW])
            ->with(['category', 'user']);
        if ($request->start_created_at) {
            $courses->where('created_at', '>=', Carbon::parse($request->start_created_at)->startOfDay()->format('Y-m-d H:i:s'));
        }

        if ($request->end_created_at) {
            $courses->where('created_at', '<=', Carbon::parse($request->end_created_at)->endOfDay()->format('Y-m-d H:i:s'));
        }

        if (isset($request->approval_status) && $request->approval_status != 4) {
            $courses->where('approval_status', '=', $request->approval_status);
        }

        if ($request->category) {
            $courses->where('category_id', '=', $request->category);
        }

        if ($request->seller) {
            $courses->where('full_name_user', 'like', '%' . $request->seller . '%');
        }

        if ($request->sort_column) {
            $courses->orderBy($request->sort_column, $request->sort_by);
        }
        if ($request->filled('approval_status')) {
            $courses->orderBy('created_at', Constant::COURSE_DESC);
        } else {
            $courses->orderBy('created_at', Constant::COURSE_DESC);
        }
        $courses = $courses->paginate($perPage);
        return $courses;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getDetail(int $id)
    {
        return $this->courseRepository
            ->where([
                'dist_method' => DBConstant::DIST_METHOD_LIVE_STREAMING,
                'course_id' => $id
            ])
            ->first();
    }

    public function getCategoryLiveStream()
    {
        return $this->categoryRepository->getCategoryLiveStream();
    }

    /**
     * Get request course detail
     *
     * @param $courseId
     * @return mixed
     */
    public function getRequestCourse($courseId)
    {
        $course = $this->courseRepository
            ->with(['imagePaths', 'category'])
            ->findOrFail($courseId);
        $subCourse = $this->courseRepository->where('parent_course_id', $course->course_id)->first();

        return [
            'course' => $course,
            'subCourse' => $subCourse
        ];
    }

    /**
     * Count course not approve.
     *
     * @return mixed
     */
    public function countCourseNotApprove()
    {
        return $this->cRepository->countCourseNotApprove();
    }
}
