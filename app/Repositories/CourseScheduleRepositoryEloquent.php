<?php

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Models\CourseSchedule;
use App\Services\Client\Common\FirebaseService;
use App\Traits\CourseImageTrait;
use App\Traits\EloquentTrait;
use Carbon\Carbon;
use Illuminate\Container\Container as Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CourseScheduleRepositoryEloquent.
 */
class CourseScheduleRepositoryEloquent extends BaseRepository implements CourseScheduleRepository
{
    use EloquentTrait, CourseImageTrait;

    public $firebaseService;
    private $userRepository;
    private $courseRepository;

    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->firebaseService = app(FirebaseService::class);
        $this->courseRepository = app(CourseRepository::class);
        $this->userRepository = app(UserRepository::class);
    }

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return CourseSchedule::class;
    }

    /**
     * Get Teacher Cancellation Count.
     *
     * @param $request
     *
     * @return mixed
     */
    public function getTeacherCancellationCount($request)
    {
        // Set variable
        $category = $request->category;
        // $month = $request->month;
        $date = [
            'start_date' => $request->start_date ?? now()->firstOfMonth(),
            'end_date' => $request->end_date ?? now()
        ];

        $query = $this->model
            ->join(
                'courses as co',
                'co.course_id',
                '=',
                'course_schedules.course_id'
            )->join(
                'categories as ca',
                'co.category_id',
                '=',
                'ca.category_id'
            )->where([
                ['course_schedules.num_of_applicants', '>', DBConstant::COURSE_SCHEDULE_NOT_BOOKED],
                ['course_schedules.canceled_at', '>=', now()->parse($date['start_date'])],
                ['course_schedules.canceled_at', '<=', now()->parse($date['end_date'])->endOfDay()],
            ]);

        if ($category) {
            $query->where('ca.type', '=', $category);
        }
        return $query->count('course_schedules.course_schedule_id');
    }

    /**
     * Get the schedule of courses Reservation.
     *
     * @return mixed
     */
    public function getReservationData()
    {
        return $this->model
            ->join('courses as co', 'course_schedules.course_id', '=', 'co.course_id')
            ->join('categories as ca', 'co.category_id', '=', 'ca.category_id')
            ->join('applicants as ap', 'course_schedules.course_schedule_id', '=', 'ap.course_schedule_id')
            ->where([
                'course_schedules.type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                'course_schedules.status' => DBConstant::COURSE_SCHEDULES_STATUS_CLOSED,
                'course_schedules.canceled_at' => null,
                'ap.canceled_at' => null,
            ])
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where([
                        ['course_schedules.actual_end_date', '>=', now()->subDay()->startOfDay()->format('Y-m-d H:i:s')],
                        ['course_schedules.actual_end_date', '<', now()->subDay()->endOfDay()->format('Y-m-d H:i:s')],
                    ])->whereNotNull('actual_end_date');
                })
                    ->orWhere(function ($q) {
                        $q->where([
                            ['course_schedules.start_datetime', '>=', now()->subDay()->startOfDay()->format('Y-m-d H:i:s')],
                            ['course_schedules.end_datetime', '<', now()->subDay()->endOfDay()->format('Y-m-d H:i:s')],
                        ])->whereNull('actual_end_date');
                    });
            })
            ->groupBy('course_schedules.course_schedule_id')
            ->selectRaw(
                'course_schedules.*,co.category_id as category_id, ca.type as category_type, co.type as course_type,
                course_schedules.price as course_price, co.user_id as user_id'
            );
    }

    /**
     * Get the schedule of courses Reservation.
     *
     * @param mixed $courseScheduleId
     *
     * @return mixed
     */
    public function getSumExtensionData($courseScheduleId)
    {
        return $this->model->selectRaw(
            'COUNT(course_schedule_id) as count_course_schedule_id,
            COALESCE(SUM(minutes_required), 0) as sum_minutes_required,
            COALESCE(SUM(price), 0) as sum_price'
        )->where([
            'type' => DBConstant::COURSE_SCHEDULES_TYPE_EXTENSION,
            'parent_course_schedule_id' => $courseScheduleId,
            'status' => DBConstant::COURSE_SCHEDULES_STATUS_CLOSED,
        ])->first();
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get course schedule data with status open.
     *
     * @return mixed
     */
    public function getCourseScheduleData()
    {
        return $this->model
            ->join('courses as co', 'course_schedules.course_id', '=', 'co.course_id')
            ->where([
                ['course_schedules.type', '=', DBConstant::COURSE_TYPE_MAIN],
                ['course_schedules.status', '=', DBConstant::COURSE_SCHEDULES_STATUS_OPEN],
                ['course_schedules.actual_end_date', '<', now()],
            ])
            ->whereNull('course_schedules.canceled_at')
            ->get();
    }

    /**
     * Get Course Schedule Extended.
     *
     * @param $id
     *
     * @return mixed
     */
    public function getCourseScheduleExtended($id)
    {
        // Get course schedule extended nearest.
        return $this->model->where([
            ['type', '=', DBConstant::COURSE_SCHEDULES_TYPE_EXTENSION],
            ['parent_course_schedule_id', '=', $id],
            ['end_datetime', '>=', now()],
        ])->orderBy('end_datetime', 'DESC')->first();
    }

    /**
     * Get course schedule.
     *
     * @param $courseIds
     *
     * @return mixed
     */
    public function getCourseScheduleList($courseIds)
    {
        return $this->model
            ->whereIn('course_id', $courseIds)
            ->where('purchase_deadline', '>', now())
            ->orderBy('start_datetime', Constant::ORDER_BY_ASC)
            ->get();
    }

    /**
     * Count number of users.
     *
     * @param $userId
     *
     * @return mixed
     */
    public function countNumberOfUser($userId)
    {
        return $this->model
            ->join('courses', 'course_schedules.course_id', '=', 'courses.course_id')
            ->where([
                'courses.user_id' => $userId,
                'course_schedules.type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
            ])
            ->whereBetween('course_schedules.status', [DBConstant::COURSE_SCHEDULES_STATUS_CLOSED, DBConstant::COURSE_SCHEDULES_STATUS_RECORDED])
            ->count();
    }

    /**
     * Get course schedule can purchase.
     *
     * @param array $data
     * @param mixed $courseType
     *
     * @return mixed
     */
    public function getCourseCanPurchased(array $data, $courseType)
    {
        return $this->model
            ->select('course_schedules.*', 'users.user_id')
            ->join('courses', 'course_schedules.course_id', '=', 'courses.course_id')
            ->join('users', 'users.user_id', '=', 'courses.user_id')
            ->where([
                ['course_schedules.purchase_deadline', '>', now()],
                'course_schedules.course_schedule_id' => $data['course_schedule_id'],
                'course_schedules.type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                'course_schedules.status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                'courses.type' => $courseType,
                'courses.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
            ])
            ->first();
    }

    /**
     * Get course schedule by id.
     *
     * @param $courseScheduleId
     *
     * @return mixed
     */
    public function getCourseScheduleById($courseScheduleId)
    {
        return $this->model
            ->with('course')
            ->join('courses as co', 'course_schedules.course_id', '=', 'co.course_id')
            ->where('course_schedule_id', $courseScheduleId)
            ->select('course_schedules.*', 'co.dist_method as dist_method', 'co.type as course_type')
            ->first();
    }

    /**
     * Get count teacher cancellation.
     *
     * @param $request
     * @param $data
     *
     * @return mixed
     */
    public function getCountTeacherCancellation($request, $data)
    {
        $data = $this->model
            ->join('courses', 'course_schedules.course_id', '=', 'courses.course_id')
            ->join('categories', 'categories.category_id', '=', 'courses.category_id')
            ->where('canceled_at', '>=', $data['startDate'])
            ->where('canceled_at', '<=', $data['endDate'])
            ->where('user_id', '=', $data['userId']);

        if ($request->has('category') && $request->category) {
            $data->where('categories.type', $request->category);
        }

        return $data->count();
    }

    /**
     * Get Course Schedule.
     * Check course schedule exists.
     *
     * @param $courseScheduleId
     * @param array $optionalExtraIds
     * @return mixed
     */
    public function getCourseSchedule($courseScheduleId, $optionalExtraIds = [])
    {
        return $this->model
            ->with(['course', 'course.category',
                'optionalExtras' => function ($query) use ($optionalExtraIds) {
                    $query->whereIn('optional_extra_mappings.optional_extra_id', $optionalExtraIds);
                },
                'course.imagePaths' => function ($query) {
                    $query->where([
                        'type' => DBConstant::IMAGE_TYPE_COURSE,
                        'display_order' => Constant::COURSES_SORT_ORDER_DATE
                    ])->first();
                }])
            ->withCount([
                'optionalExtras as optional_price_sum' => function ($query) use ($optionalExtraIds) {
                    $query->whereIn('optional_extra_mappings.optional_extra_id', $optionalExtraIds)
                        ->select(\DB::raw("SUM(price) as paidsum"));
                }
            ])
            ->where([
                ['purchase_deadline', '>=', Carbon::now()],
                'type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                'status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                'course_schedule_id' => $courseScheduleId
            ])->first();
    }

    /**
     * List sale service of teacher.
     *
     * @param $data
     *
     * @return mixed
     */
    public function getSaleCourse($data)
    {
        return $this->model->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->where('user_id', $data['userId'])
            ->whereIn('courses.type', [DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION, DBConstant::COURSE_SCHEDULES_TYPE_EXTENSION])
            ->where('is_archived', DBConstant::NOT_ARCHIVED_FLAG)
            ->where('status', DBConstant::COURSE_SCHEDULES_STATUS_OPEN)
            ->paginate($data['perPage']);
    }

    /**
     * Get course drafts.
     *
     * @param $data
     *
     * @return mixed
     */
    public function getDrafts($data)
    {
        return $this->model->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->where('user_id', $data['userId'])
            ->whereIn('courses.type', [DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION, DBConstant::COURSE_SCHEDULES_TYPE_EXTENSION])
            ->where('is_archived', DBConstant::NOT_ARCHIVED_FLAG)
            ->where('status', DBConstant::COURSE_SCHEDULES_STATUS_DRAFT)
            ->paginate($data['perPage']);
    }

    /**
     * Get course cancel.
     *
     * @param $data
     *
     * @return mixed
     */
    public function getCourseCancel($data)
    {
        return $this->model->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->where('user_id', $data['userId'])
            ->whereIn('courses.type', [DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION, DBConstant::COURSE_SCHEDULES_TYPE_EXTENSION])
            ->where('is_archived', DBConstant::NOT_ARCHIVED_FLAG)
            ->whereIn('status', [DBConstant::COURSE_SCHEDULES_STATUS_OPEN, DBConstant::COURSE_SCHEDULES_STATUS_CANCELED])
            ->paginate($data['perPage']);
    }

    /**
     * Get List Purchase History.
     *
     * @return mixed|void
     */
    public function getListPurchaseHistory($request)
    {
        $isOption = $this->isOption($request);
        return $this->getPurchaseHistory($isOption['orderBy'], $isOption['currentYear']);
    }

    /**
     * Get purchase history
     *
     * @param $orderBy
     * @param $year
     *
     * @return array
     */
    function getPurchaseHistory($orderBy, $year)
    {
        // TODO purchase history
        $userId = auth('client')->id();
        $yearStartFormat = $year . Constant::START_YEAR_FORMAT;
        $yearEndFormat = $year . Constant::END_YEAR_FORMAT;
        $listPurchaseHistory = $this->model
            ->select('course_schedules.*', 'co.title as title_course', 'co.parent_course_id', DB::raw("MAX(image_paths.dir_path) as dir_path, MAX(image_paths.file_name) as file_name"), DB::raw("MAX(s.card_brand) as card_brand"))
            ->join('courses as co', 'co.course_id', '=', 'course_schedules.course_id')
            ->join('users as u', 'co.user_id', '=', 'u.user_id')
            ->leftJoin('applicants', function ($join) use ($userId) {
                $join->on('course_schedules.course_schedule_id', '=', 'applicants.course_schedule_id')
                    ->where([
                        'applicants.user_id' => $userId,
                        'applicants.canceled_at' => null,
                    ]);
            })
            ->leftJoin('purchases', function ($join) use ($userId) {
                $join->on('course_schedules.course_schedule_id', '=', 'purchases.course_schedule_id')
                    ->where([
                        'purchases.user_id' => $userId,
                    ]);
            })
            ->leftJoin(
                DB::raw("
                    (select settlements.card_brand, settlements.purchase_id, settlements.id
                    from settlements
                    order by settlements.updated_at DESC
                    ) as s
                "), function ($join) {
                $join->on('purchases.purchase_id', '=', 's.purchase_id');
            })
            ->leftJoin('image_paths', function ($join): void {
                $join->on('image_paths.course_id', '=', 'course_schedules.course_id')
                    ->where([
                        'image_paths.display_order' => DBConstant::DISPLAY_ORDER_IMAGE_PATH,
                        'image_paths.type' => DBConstant::IMAGE_TYPE_COURSE,
                        'image_paths.status' => Constant::IMAGE_STATUS
                    ]);
            })
            ->leftJoin('reviews', function ($join) use ($userId) {
                $join->on('reviews.course_schedule_id', '=', 'course_schedules.course_schedule_id')
                    ->where('reviews.user_id', '=', $userId);
            })
            ->where([
                'applicants.user_id' => $userId,
                'u.is_archived' => DBConstant::NOT_ARCHIVED_FLAG
//                'u.user_status' => DBConstant::USER_STATUS_ACTIVE
            ])
            ->whereIn('course_schedules.status', [DBConstant::STATUS_ORDER_LIST, DBConstant::STATUS_ORDER_END_LIST])
            ->whereBetween('course_schedules.created_at', [$yearStartFormat, $yearEndFormat])
            ->groupBy('course_schedules.course_schedule_id')
            ->orderBy('course_schedules.start_datetime', $orderBy)
            ->paginate(Constant::PAGINATE_LIST_HISTORY);

        // Get course schedule image
        $this->getImageOfSchedules($listPurchaseHistory);

        return [
            'year' => $year,
            'listPurchaseHistory' => $listPurchaseHistory
        ];
    }

    /**
     * Check course schedule exists.
     *
     * @param $courseScheduleId
     *
     * @return mixed
     */
    public function checkCourseScheduleExist($courseScheduleId)
    {
        return $this->model
            ->join('courses', 'course_schedules.course_id', '=', 'courses.course_id')
            ->where('course_schedule_id', $courseScheduleId)
            ->first();
    }

    /**
     * Get course schedule history.
     *
     * @param $perPage
     *
     * @return mixed
     */
    public function listHistory($perPage)
    {
        return $this->model->join('courses', 'course_schedules.course_id', '=', 'courses.course_id')
            ->where('user_id', auth()->guard('client')->user()->user_id)
            ->whereIn('courses.type', [DBConstant::COURSE_TYPE_MAIN, DBConstant::COURSE_TYPE_SUB])
            ->whereIn('course_schedules.status', [
                DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                DBConstant::COURSE_SCHEDULES_TYPE_EXTENSION,
                DBConstant::COURSE_SCHEDULES_STATUS_RECORDED,
            ])->paginate($perPage);
    }

    /**
     * Check extension can purchased.
     *
     * @param int $currentCourseScheduleId
     * @param int $courseUserId
     * @param string $endDatetime
     * @param int $minute
     *
     * @return mixed
     */
    public function checkExtensionCanPurchased(int $currentCourseScheduleId, int $courseUserId, string $endDatetime, int $minute, int $originCourseScheduleId)
    {
        return $this->model
            ->join('courses as co', 'course_schedules.course_id', '=', 'co.course_id')
            ->where([
                'course_schedules.status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                ['course_schedules.course_schedule_id', '!=', $currentCourseScheduleId],
                ['course_schedules.parent_course_schedule_id', '!=', $originCourseScheduleId],
                ['course_schedules.start_datetime', '<', now()->parse($endDatetime)->addMinutes($minute)],
                ['course_schedules.start_datetime', '>=', now()],
                'co.user_id' => $courseUserId,
                'co.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
            ])
            ->get();
    }

    /**
     * Check if the user has open course schedules.
     *
     * @param $userId
     *
     * @return mixed
     */
    public function open($userId)
    {
        return $this->model->join(
            'courses as co',
            'course_schedules.course_id',
            '=',
            'co.course_id'
        )->where([
            'co.user_id' => $userId,
            'co.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
            'course_schedules.status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
        ])->get();
    }

    /**
     * Check if the user has open course schedules.
     *
     * @param $userId
     *
     * @return mixed
     */
    public function courseCheckStopService($userId)
    {
        return $this->model->join(
            'courses as co',
            'course_schedules.course_id',
            '=',
            'co.course_id'
        )->where([
            'co.user_id' => $userId,
            'co.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
        ])->whereRaw(
            "case
            WHEN course_schedules.status = 2 || course_schedules.status = 3 THEN (course_schedules.canceled_at IS NULL AND course_schedules.end_datetime > '" . now()->subHours(48) . "')
            WHEN course_schedules.status = 0 THEN (course_schedules.start_datetime >='" . now() . "')
            ELSE 0 END"
        )->get();
    }

    /**
     * Get Course Schedule List By Sort.
     *
     * @param $data
     *
     * @return mixed|void
     */
    public function getCourseScheduleListBySort($data)
    {
        $query = $this->model
            ->select('course_schedules.*', 'course_schedules.start_datetime')
            ->join('courses as co', 'course_schedules.course_id', '=', 'co.course_id')
            ->where([
                ['co.type', '=', DBConstant::COURSE_TYPE_MAIN],
                ['co.is_archived', '=', DBConstant::NOT_ARCHIVED_FLAG],
                ['course_schedules.type', '=', DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION],
                ['course_schedules.status', '=', DBConstant::COURSE_SCHEDULES_STATUS_OPEN],
                ['course_schedules.start_datetime', '>', now()],
            ])
            ->orderBy('course_schedules.start_datetime', Constant::ORDER_BY_ASC);

        return $this->conditionalSearch($query, $data);
    }

    /**
     * Get Course Schedule List By Order Search.
     *
     * @param $data
     * @param $subQuery
     *
     * @return mixed|void
     */
    public function getCourseScheduleListSortByViewed($data, $subQuery)
    {
        $query = $this->model
            ->select('course_schedules.*', 'page_views.pvvc', 'course_schedules.course_schedule_id')
            ->leftJoin('courses as co', 'course_schedules.course_id', '=', 'co.course_id')
            ->leftJoinSub($subQuery, 'page_views', function ($join) {
                $join->on('course_schedules.course_schedule_id', '=', 'page_views.to_course_schedule_id');
            })
            ->where([
                ['co.type', '=', DBConstant::COURSE_TYPE_MAIN],
                ['co.is_archived', '=', DBConstant::NOT_ARCHIVED_FLAG],
                ['course_schedules.type', '=', DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION],
                ['course_schedules.status', '=', DBConstant::COURSE_SCHEDULES_STATUS_OPEN],
                ['course_schedules.start_datetime', '>=', now()],
            ])
            ->orderBy('page_views.pvvc', Constant::ORDER_BY_DESC);

        return $this->conditionalSearch($query, $data);
    }

    /**
     * Get Course Schedule List By Order ReCommend.
     *
     * @param mixed $data
     * @param $subQuery
     *
     * @return mixed|void
     */
    public function getCourseScheduleListSortByFavorite($data, $subQuery)
    {
        $query = $this->model
            ->select('course_schedules.*', 'favorites.fcsi', 'course_schedules.course_schedule_id')
            ->leftJoin('courses as co', 'course_schedules.course_id', '=', 'co.course_id')
            ->leftJoinSub($subQuery, 'favorites', function ($join) {
                $join->on('course_schedules.course_schedule_id', '=', 'favorites.course_schedule_id');
            })
            ->where([
                ['co.type', '=', DBConstant::COURSE_TYPE_MAIN],
                ['co.is_archived', '=', DBConstant::NOT_ARCHIVED_FLAG],
                ['course_schedules.type', '=', DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION],
                ['course_schedules.status', '=', DBConstant::COURSE_SCHEDULES_STATUS_OPEN],
                ['course_schedules.start_datetime', '>', now()],
            ])
            ->orderBy('favorites.fcsi', Constant::ORDER_BY_DESC);

        return $this->conditionalSearch($query, $data);
    }

    /**
     * Conditional Search.
     *
     * @param $query
     * @param $data
     *
     * @return mixed
     */
    private function conditionalSearch($query, $data)
    {
        if (isset($data['category_id']) && !empty($data['category_id'])) {
            if (!isset($data['calendar'])) {
                $query->where('co.category_id', $data['category_id']);
            }
        }

        if (isset($data['keyword']) && !empty($data['keyword'])) {
            $search = trim($data['keyword'], ' ');
            $query->where(function ($query) use ($search) {
                $query->orWhere('course_schedules.title', 'LIKE', '%' . $search . '%')
                    ->orWhere('course_schedules.body', 'LIKE', '%' . $search . '%');
            });
        }

        if (isset($data['keyword']) && !empty($data['keyword']) && !empty($data['time_frame'])) {
            $search = trim($data['keyword'], ' ');
            $query->where(function ($query) use ($search) {
                $query->orWhere('course_schedules.title', 'LIKE', '%' . $search . '%')
                    ->orWhere('course_schedules.body', 'LIKE', '%' . $search . '%');
            });

            if ($data['time_frame'] == Constant::NIGHT['type']) {
                $query->where(function ($query) use ($data) {
                    $query->whereTime("course_schedules.start_datetime", '>=', $data['start_time'])
                        ->whereTime('course_schedules.start_datetime', '<=', Constant::MIDNIGHT_BEFORE)
                        ->orwhereTime('course_schedules.start_datetime', '>=', Constant::MIDNIGHT)
                        ->whereTime('course_schedules.start_datetime', '<=', Constant::NIGHT['endTime']);

                });
            } else {
                $query->whereTime("course_schedules.start_datetime", '>=', $data['start_time']);
                $query->whereTime("course_schedules.start_datetime", '<=', $data['end_time']);
            }
        }

        // Search date.
        if (isset($data['start_date']) && !empty($data['start_date']) && $data['time_frame'] == null) {
            if (isset($data['calendar']) && $data['calendar']) {
                return $query->get();
            } else {
                $query->where(function ($query) use ($data) {
                    $query->whereDate('course_schedules.start_datetime', '=', now()->parse($data['start_date']))
                        ->orwhereDate('course_schedules.start_datetime', '=', now()->parse($data['end_date']))
                        ->whereTime('course_schedules.start_datetime', '>=', Constant::MIDNIGHT)
                        ->whereTime('course_schedules.start_datetime', '<=', Constant::NIGHT['endTime']);
                });
            }
        }

        //Search date and time
        if (isset($data['start_date']) && !empty($data['start_date']) && !empty($data['time_frame'])) {
            if (!isset($data['calendar'])) {
                if ($data['time_frame'] == Constant::NIGHT['type']) {
                    $startDateTime = $this->setTimeForDate(now()->parse($data['start_date']), $data['start_time']);
                    $endDateTime = $this->setTimeForDate(now()->parse($data['end_date']), $data['end_time']);
                } else {
                    $startDateTime = $this->setTimeForDate(now()->parse($data['start_date']), $data['start_time']);
                    $endDateTime = $this->setTimeForDate(now()->parse($data['start_date']), $data['end_time']);
                }
                $query->where('course_schedules.start_datetime', '>=', $startDateTime);
                $query->where('course_schedules.start_datetime', '<=', $endDateTime);
            }
        }

        // Fetch calendar
        if (isset($data['calendar']) && $data['calendar'] == true) {
            if (isset($data['time_frame']) && !empty($data['time_frame'])) {
                if ($data['time_frame'] == Constant::NIGHT['type']) {
                    $query->where(function ($query) use ($data) {
                        $query->whereTime("course_schedules.start_datetime", '>=', $data['start_time'])
                            ->whereTime('course_schedules.start_datetime', '<=', Constant::MIDNIGHT_BEFORE)
                            ->orwhereTime('course_schedules.start_datetime', '>=', Constant::MIDNIGHT)
                            ->whereTime('course_schedules.start_datetime', '<=', Constant::NIGHT['endTime']);

                    });
                } else {
                    $query->whereTime("course_schedules.start_datetime", '>=', $data['start_time']);
                    $query->whereTime("course_schedules.start_datetime", '<=', $data['end_time']);
                }
            }
            return $query->get();
        }

        if (empty($data['keyword'])
            && empty($data['time_frame'])
            && empty($data['start_datetime'])
            && empty($data['end_datetime'])
            && empty($data['category_id'])
        ) {
            return [];
        }

        return $query->paginate($data['perPage']);
    }

    /**
     * Get course schedule
     *
     * @param $courseScheduleId
     *
     * @return mixed|void
     */
    public function courseSchedule($courseScheduleId)
    {
        return $this->model
            ->select('course_schedules.*', 'co.dist_method as dist_method')
            ->leftJoin('purchases', function ($q) {
                $q->on('purchases.course_schedule_id', '=', 'course_schedules.course_schedule_id')
                    ->where('purchases.user_id', auth('client')->id());
            })
            ->join('courses as co', 'course_schedules.course_id', '=', 'co.course_id')
            ->where('course_schedules.status', '!=', DBConstant::COURSE_SCHEDULES_STATUS_PENDING)
            ->findOrFail($courseScheduleId);
    }

    /**
     * Get list course in day
     *
     * @param $request
     *
     * @return array|mixed
     */
    public function listCourseInDay($request)
    {
        $data = $request->all();

        // Set default time frame in morning.
        $data['calendar'] = true;

        if (isset($data['time_frame'])) {
            switch ($data['time_frame']) {
                case Constant::AFTERNOON['type']:
                    $startTime = Constant::AFTERNOON['startTime'];
                    $endTime = Constant::AFTERNOON['endTime'];
                    break;
                case Constant::NIGHT['type']:
                    $startTime = Constant::NIGHT['startTime'];
                    $endTime = Constant::NIGHT['endTime'];
                    break;
                case Constant::MORNING['type']:
                    $startTime = Constant::MORNING['startTime'];
                    $endTime = Constant::MORNING['endTime'];
                    break;
            }
            $data['start_time'] = $startTime;
            $data['end_time'] = $endTime;
        }

        // Get list day >= get day
        $temp = [];

        if (isset($data['sort'])) {
            // 1-1) search course schedule when sort = 開催日順.
            if ($data['sort'] == Constant::COURSES_SORT_ORDER_DATE) {

                $courseSchedules = $this->getCourseScheduleListBySort($data);

                return $this->modifyDayStartDate($courseSchedules, $temp);
            } elseif ($data['sort'] == Constant::COURSES_TIME_FRAME_AFFTERNOON) {
                // Search course schedules. (When sort = "検索順")
                $subQuery = DB::table('page_views')->select('to_course_schedule_id', DB::raw('SUM(view_count) as pvvc'))->groupBy('to_course_schedule_id');
                $courseSchedules = $this->getCourseScheduleListSortByViewed($data, $subQuery);

                return $this->modifyDayStartDate($courseSchedules, $temp);
            }
        }
        $courseSchedules = $this->getAllCourseScheduleOpen($data);

        return $this->modifyDayStartDate($courseSchedules, $temp);


    }

    private function getAllCourseScheduleOpen($data)
    {
        $query = $this->model
            ->select('course_schedules.*', 'co.category_id', 'co.dist_method')
            ->join('courses as co', 'course_schedules.course_id', '=', 'co.course_id')
            ->where([
                ['course_schedules.start_datetime', '>', now()],
                ['course_schedules.type', '=', DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION],
                ['course_schedules.status', '=', DBConstant::COURSE_SCHEDULES_STATUS_OPEN],
                ['co.type', '=', DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION],
                ['co.is_archived', '=', DBConstant::NOT_ARCHIVED_FLAG],
            ]);

        return $this->conditionalSearch($query, $data);
    }

    /**
     * ModifyDayStartDate
     *
     * @param $scheduleInTheMornings
     * @param $temp
     *
     * @return mixed|void
     */
    private function modifyDayStartDate($scheduleInTheMornings, $temp)
    {
        if (count($scheduleInTheMornings) > 0) {
            foreach ($scheduleInTheMornings as $scheduleInTheMorning) {
                $hourCourse = now()->parse($scheduleInTheMorning->start_datetime)->format('H:i:s');
                if ($hourCourse >= Constant::MIDNIGHT && $hourCourse < Constant::MORNING['startTime']) {
                    $temp['day'][] = now()->parse($scheduleInTheMorning->start_datetime)->modify('-1 day')->format('Y-m-d');
                    continue;
                }
                $temp['day'][] = now()->parse($scheduleInTheMorning->start_datetime)->format('Y-m-d');
            }

            $dayAndCourseId = [];
            if (isset($temp['day'])) {
                $dayAndCourseId = array_values(array_unique($temp['day']));
            }
            return $dayAndCourseId;
        }
    }

    /**
     * Get All Course Schedule.
     *
     * @param $courseId
     *
     * @return mixed|void
     */
    public function getAllCourseSchedule($courseId)
    {
        return $this->model
            ->select('course_schedules.*', 'co.dist_method')
            ->join('courses as co', 'course_schedules.course_id', '=', 'co.course_id')
            ->where([
                'co.course_id' => $courseId,
                'co.type' => DBConstant::COURSE_TYPE_MAIN,
                'course_schedules.type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
//                'course_schedules.status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
            ])
//            ->where('course_schedules.purchase_deadline', '>', now())
            ->orderBy('course_schedules.start_datetime', Constant::ORDER_BY_ASC)
            ->get();
    }

    /**
     * Get All Course Schedule Open.
     *
     * @param $courseId
     * @param $timeSubCourseSchedule
     * @return mixed|void
     */
    public function listAllCourseScheduleOpen($courseId)
    {
        return $this->model
            ->select('course_schedules.*', 'co.dist_method', 'purchases.purchase_id')
            ->join('courses as co', 'course_schedules.course_id', '=', 'co.course_id')
            ->leftJoin('purchases', function ($q) {
                $q->on('purchases.course_schedule_id', '=', 'course_schedules.course_schedule_id')
                    ->where('purchases.user_id', auth('client')->id());
            })
            ->where([
                'co.course_id' => $courseId,
                'co.type' => DBConstant::COURSE_TYPE_MAIN,
                'course_schedules.type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                'course_schedules.status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                'course_schedules.canceled_at' => null
            ])
            ->where('course_schedules.purchase_deadline', '>', now())
            ->whereRaw('course_schedules.num_of_applicants < course_schedules.fixed_num')
            ->orderBy('course_schedules.start_datetime', Constant::ORDER_BY_ASC)
            ->get();
    }

    /**
     * Get Count Course Schedule.
     *
     * @param $courseId
     *
     * @return mixed|void
     */
    public function getCountCourseSchedule($courseId)
    {
        return $this->model
            ->where([
                'course_id' => $courseId,
                'type' => DBConstant::COURSE_TYPE_MAIN,
            ])
            ->whereIn('status', [DBConstant::COURSE_SCHEDULES_STATUS_CLOSED, DBConstant::COURSE_SCHEDULES_STATUS_RECORDED])
            ->get()->count();
    }

    /**
     * Get course schedule with children
     *
     * @param $courseScheduleId
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|mixed|object|null
     */
    public function getCourseScheduleWithChild($courseScheduleId)
    {
        return $this->model
            ->with('courseChildren')
            ->where('course_schedule_id', $courseScheduleId)
            ->whereNull('parent_course_schedule_id')
            ->first();
    }

    /**
     * Get order cancel
     *
     * @return mixed|void
     */
    public function orderCancel()
    {
        return $this->model
            ->join('applicants', function ($join): void {
                $join->on('course_schedules.course_schedule_id', '=', 'applicants.course_schedule_id')
                    ->where([
                        'applicants.user_id' => auth('client')->user()->user_id,
                        'applicants.canceled_at' => null,
                    ]);
            })
            ->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->where('course_schedules.type', DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION)
//            ->where('course_schedules.end_datetime', '>', now())
            ->where('course_schedules.status', '=', DBConstant::STATUS_ORDER_CANCEL)
            ->whereBetween('courses.type', [DBConstant::USER_TYPE_STUDENT, DBConstant::USER_TYPE_TEACHER])
            ->where('courses.is_archived', DBConstant::NOT_ARCHIVED_FLAG)
            ->select('course_schedules.*', 'courses.title as title_course', 'courses.parent_course_id as parent_course_id')
            ->orderBy('course_schedules.start_datetime', 'ASC')
            ->paginate(Constant::PAGINATE_LIST_HISTORY);
    }

    /**
     * Update status in table course_schedules
     *
     * @param $id
     *
     * @return mixed|void
     */
    public function cancelOrderConfirm($id)
    {
        // TODO update status in course schedules
        return $this->model->findOrFail($id)->update(['status' => 1]);
    }


    /**
     *  List CourseSchedule Visited
     *
     * @return mixed
     */
    public function listCourseScheduleVisited()
    {
        return $this->model
            ->join('page_views as pv', 'course_schedules.course_schedule_id', '=', 'pv.to_course_schedule_id')
            ->where([
                ['pv.user_id', '=', auth('client')->user()->user_id],
                ['pv.view_count', '>', Constant::PAGE_VIEW_COUNT],
            ])
            ->whereNotNull('viewed_at')
            ->orderBy('pv.viewed_at', Constant::ORDER_BY_DESC)
            ->take(Constant::COURSE_SCHEDULE_SEEN_RECORD)
            ->get();
    }

    /**
     * Get order not review.
     *
     * @param $request
     *
     * @return array|mixed
     */
    public function getOrderNotReview($request)
    {
        $isOption = $this->isOption($request);
        return $this->listSchedulesNotReview($isOption['orderBy'], $isOption['currentYear']);
    }

    /**
     * Get order reviewed.
     *
     * @param $request
     *
     * @return array|mixed
     */
    public function getOrderReviewed($request)
    {
        $isOption = $this->isOption($request);
        return $this->listSchedulesReviewed($isOption['orderBy'], $isOption['currentYear']);
    }

    /**
     * Get Course Schedule Purchase
     *
     * @return mixed|void
     */
    public function getCourseSchedulePurchase($data)
    {
        return $this->model
            ->select('course_schedules.*', 'co.course_id as course_id', 'co.parent_course_id as parent_course_id', 'co.title as title_course', 'co.dist_method as dist_method', 'co.type as course_type')
            ->join('applicants as a', function ($join) {
                $join->on('course_schedules.course_schedule_id', '=', 'a.course_schedule_id')
                    ->where('a.user_id', auth('client')->user()->user_id)
                    ->whereNull('a.canceled_at');
            })
            ->join('courses as co', 'course_schedules.course_id', '=', 'co.course_id')
            ->where([
                ['course_schedules.type', '=', DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION],
                ['co.is_archived', '=', DBConstant::NOT_ARCHIVED_FLAG],
                ['course_schedules.status', '=', DBConstant::COURSE_SCHEDULES_STATUS_OPEN],
            ])
            ->whereNull('course_schedules.canceled_at')
            ->whereBetween('co.type', [DBConstant::COURSE_TYPE_MAIN, DBConstant::COURSE_TYPE_SUB])
            ->paginate($data['perPage']);
    }

    /**
     * Get order review
     *
     * @param $request
     *
     * @return mixed
     */
    public function getOrderReview($request)
    {
        $isOption = $this->isOption($request);

        return $this->listSchedulesReview($isOption['orderBy'], $isOption['currentYear']);
    }

    /**
     * Get order review
     *
     * @param $request
     *
     * @return mixed
     */
    public function getAllOrderReview($request)
    {
        $isOption = $this->isOption($request);

        return $this->listSchedulesReview($isOption['orderBy'], $isOption['currentYear']);
    }

    /**
     * Get list schedule review
     *
     * @param $orderBy
     * @param $year
     * @param bool $dashboard
     * @return array
     */
    public function listSchedulesReview($orderBy, $year, $dashboard = false)
    {
        $userId = auth('client')->id();
        $yearStartFormat = $year . Constant::START_YEAR_FORMAT;
        $yearEndFormat = $year . Constant::END_YEAR_FORMAT;
        $listSchedulesReviews = $this->model
            ->select(['course_schedules.*', 'co.title as title_course', 'co.parent_course_id', DB::raw("MAX(image_paths.dir_path) as dir_path, MAX(image_paths.file_name) as file_name"), DB::raw("MAX(reviews.comment) as comment")])
            ->join('courses as co', 'co.course_id', '=', 'course_schedules.course_id')
            ->join('users as u', 'co.user_id', '=', 'u.user_id')
            ->leftJoin('applicants', function ($join) use ($userId) {
                $join->on('course_schedules.course_schedule_id', '=', 'applicants.course_schedule_id')
                    ->where([
                        'applicants.user_id' => $userId,
                        'applicants.canceled_at' => null,
                    ]);
            })
            ->leftJoin('purchases', function ($join) use ($userId) {
                $join->on('course_schedules.course_schedule_id', '=', 'purchases.course_schedule_id')
                    ->where([
                        'purchases.user_id' => $userId,
                    ]);
            })
            ->leftJoin(
                DB::raw("
                    (select settlements.card_brand, settlements.purchase_id, settlements.id
                    from settlements
                    order by settlements.updated_at DESC
                    ) as s
                "), function ($join) {
                $join->on('purchases.purchase_id', '=', 's.purchase_id');
            })
            ->leftJoin('image_paths', function ($join): void {
                $join->on('image_paths.course_id', '=', 'course_schedules.course_id')
                    ->where([
                        'image_paths.display_order' => DBConstant::DISPLAY_ORDER_IMAGE_PATH,
                        'image_paths.type' => DBConstant::IMAGE_TYPE_COURSE,
                        'image_paths.status' => Constant::IMAGE_STATUS
                    ]);
            })
            ->leftJoin('reviews', function ($join) use ($userId) {
                $join->on('reviews.course_schedule_id', '=', 'course_schedules.course_schedule_id')
                    ->where('reviews.user_id', '=', $userId);
            })
            ->where([
                'applicants.user_id' => $userId,
                'u.is_archived' => DBConstant::NOT_ARCHIVED_FLAG
            ])
            ->whereIn('course_schedules.status', [DBConstant::STATUS_ORDER_LIST, DBConstant::STATUS_ORDER_END_LIST])
            ->groupBy('course_schedules.course_schedule_id')
            ->orderBy('course_schedules.start_datetime', $orderBy);
        if ($dashboard) {
            $listSchedulesReviews = $listSchedulesReviews->get();
        } else {
            $listSchedulesReviews = $listSchedulesReviews->whereBetween('course_schedules.created_at', [$yearStartFormat, $yearEndFormat])->paginate(Constant::PAGINATE_LIST_HISTORY);
        }

        // get image course by parent course
        $this->getImageOfSchedules($listSchedulesReviews);
        return [
            'year' => $year,
            'listSchedulesReviews' => $listSchedulesReviews
        ];
    }

    /**
     * Get list schedule not review
     *
     * @param $orderBy
     * @param $year
     *
     * @return array
     */
    public function listSchedulesNotReview($orderBy, $year)
    {
        $yearStartFormat = $year . Constant::START_YEAR_FORMAT;
        $yearEndFormat = $year . Constant::END_YEAR_FORMAT;
        $listSchedulesReviews = $this->model
            ->select(['course_schedules.*', 'co.title as title_course', DB::raw("MAX(image_paths.dir_path) as dir_path, MAX(image_paths.file_name) as file_name"), DB::raw("MAX(reviews.comment) as comment")])
            ->join('courses as co', 'co.course_id', '=', 'course_schedules.course_id')
            ->leftJoin('applicants', function ($join): void {
                $join->on('course_schedules.course_schedule_id', '=', 'applicants.course_schedule_id')
                    ->where([
                        'applicants.user_id' => auth('client')->user()->user_id,
                        'applicants.canceled_at' => null,
                    ]);
            })
            ->leftJoin('purchases', function ($join): void {
                $join->on('course_schedules.course_schedule_id', '=', 'purchases.course_schedule_id')
                    ->where([
                        'purchases.user_id' => auth('client')->user()->user_id,
                    ]);
            })
            ->leftJoin(
                DB::raw("
                    (select settlements.card_brand, settlements.purchase_id, settlements.id
                    from settlements
                    order by settlements.updated_at DESC
                    ) as s
                "), function ($join) {
                $join->on('purchases.purchase_id', '=', 's.purchase_id');
            })
            ->leftJoin('image_paths', function ($join): void {
                $join->on('image_paths.course_id', '=', 'course_schedules.course_id')
                    ->where([
                        'image_paths.display_order' => DBConstant::DISPLAY_ORDER_IMAGE_PATH,
                        'image_paths.type' => DBConstant::IMAGE_TYPE_COURSE,
                        'image_paths.status' => Constant::IMAGE_STATUS
                    ]);
            })
            ->leftJoin('reviews', function ($join) {
                $join->on('reviews.course_schedule_id', '=', 'course_schedules.course_schedule_id')
                    ->where('reviews.user_id', '=', auth('client')->user()->user_id);
            })
            ->where('reviews.comment', null)
            ->whereIn('course_schedules.status', [DBConstant::STATUS_ORDER_LIST, DBConstant::STATUS_ORDER_END_LIST])
            ->where('applicants.user_id', auth('client')->user()->user_id)
            ->whereBetween('course_schedules.created_at', [$yearStartFormat, $yearEndFormat])
            ->groupBy('course_schedules.course_schedule_id')
            ->orderBy('course_schedules.start_datetime', $orderBy)
            ->paginate(Constant::PAGINATE_LIST_HISTORY);
        return [
            'year' => $year,
            'listSchedulesReviews' => $listSchedulesReviews
        ];
    }


    /**
     * Get list schedule not review
     *
     * @param $orderBy
     * @param $year
     *
     * @return array
     */
    public function listSchedulesReviewed($orderBy, $year)
    {
        $userId = auth('client')->id();
        $yearStartFormat = $year . Constant::START_YEAR_FORMAT;
        $yearEndFormat = $year . Constant::END_YEAR_FORMAT;
        $listSchedulesReviews = $this->model
            ->select(['course_schedules.*', 'co.title as title_course', DB::raw("MAX(image_paths.dir_path) as dir_path, MAX(image_paths.file_name) as file_name"), DB::raw("MAX(reviews.comment) as comment")])
            ->join('courses as co', 'co.course_id', '=', 'course_schedules.course_id')
            ->join('users as u', 'co.user_id', '=', 'u.user_id')
            ->leftJoin('applicants', function ($join) use ($userId) {
                $join->on('course_schedules.course_schedule_id', '=', 'applicants.course_schedule_id')
                    ->where([
                        'applicants.user_id' => $userId,
                        'applicants.canceled_at' => null,
                    ]);
            })
            ->leftJoin('purchases', function ($join) use ($userId) {
                $join->on('course_schedules.course_schedule_id', '=', 'purchases.course_schedule_id')
                    ->where([
                        'purchases.user_id' => $userId,
                    ]);
            })
            ->leftJoin(
                DB::raw("
                    (select settlements.card_brand, settlements.purchase_id, settlements.id
                    from settlements
                    order by settlements.updated_at DESC
                    ) as s
                "), function ($join) {
                $join->on('purchases.purchase_id', '=', 's.purchase_id');
            })
            ->leftJoin('image_paths', function ($join): void {
                $join->on('image_paths.course_id', '=', 'course_schedules.course_id')
                    ->where([
                        'image_paths.display_order' => DBConstant::DISPLAY_ORDER_IMAGE_PATH,
                        'image_paths.type' => DBConstant::IMAGE_TYPE_COURSE,
                        'image_paths.status' => Constant::IMAGE_STATUS
                    ]);
            })
            ->leftJoin('reviews', function ($join) use ($userId) {
                $join->on('reviews.course_schedule_id', '=', 'course_schedules.course_schedule_id')
                    ->where('reviews.user_id', '=', $userId);
            })
            ->where([
                'applicants.user_id' => $userId,
//                'u.user_status' => DBConstant::USER_STATUS_ACTIVE
            ])
            ->whereIn('course_schedules.status', [DBConstant::STATUS_ORDER_LIST, DBConstant::STATUS_ORDER_END_LIST])
            ->where('reviews.comment', '<>', null)
            ->whereBetween('course_schedules.created_at', [$yearStartFormat, $yearEndFormat])
            ->groupBy('course_schedules.course_schedule_id')
            ->orderBy('course_schedules.start_datetime', $orderBy)
            ->paginate(Constant::PAGINATE_LIST_HISTORY);

        return [
            'year' => $year,
            'listSchedulesReviews' => $listSchedulesReviews
        ];
    }

    /**
     * Get option in request order review.
     *
     * @param $request
     *
     * @return array
     */
    private function isOption($request)
    {
        $currentYear = now()->year;
        if (isset($request->year) && isset($request->option) && Constant::ORDER_LIST_ASC == $request->option) {
            $currentYear = $request->year;
            $orderBy = Constant::ORDER_BY_ASC;
        } elseif (isset($request->option) && Constant::ORDER_LIST_ASC == $request->option) {
            $orderBy = Constant::ORDER_BY_ASC;
        } elseif (isset($request->year)) {
            $currentYear = $request->year;
            $orderBy = Constant::ORDER_BY_DESC;
        } else {
            $orderBy = Constant::ORDER_BY_DESC;
        }
        return [
            'orderBy' => $orderBy,
            'currentYear' => $currentYear
        ];
    }

    /**
     * Get all info courses
     *
     * @param $courseScheduleId
     *
     * @return mixed
     */
    public function getAllInfoCourse($courseScheduleId)
    {
        return $this->model
            ->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->join('users', 'courses.user_id', '=', 'users.user_id')
//            ->join('image_paths', 'image_paths.course_id', 'courses.course_id')
//            ->where('image_paths.display_order', '=', DBConstant::DISPLAY_ORDER_IMAGE_PATH)
            ->where('course_schedules.course_schedule_id', '=', $courseScheduleId)
            ->select(
                'course_schedules.course_schedule_id', 'courses.course_id',
                'nickname', 'first_name_kanji', 'profile_image',
                'last_name_kanji', 'name_use', 'rank_id',
                'course_schedules.start_datetime',
                'course_schedules.end_datetime', 'courses.body',
                'course_schedules.price', 'rating', 'num_of_ratings',
                'courses.title', 'courses.parent_course_id',
                'course_schedules.actual_start_date', 'course_schedules.actual_end_date'
            )
            ->first();
    }

    /**
     * Get list services of teacher
     *
     * @param $status
     * @param $request
     * @param bool $option
     * @return mixed
     */
    public function listServiceTeacher($status, $request)
    {
        $perPage = $request->perPage ?? Constant::PER_PAGE_DEFAULT;
        $data = $this->model->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->where([
                'courses.user_id' => auth('client')->id(),
                'courses.is_archived' => DBConstant::NOT_ARCHIVED_FLAG
            ])
            ->whereRaw("CASE
                WHEN course_schedules.purchase_deadline < '" . now() . "' THEN (course_schedules.num_of_applicants > 0)
                ELSE course_schedules.purchase_deadline > '" . now() . "' END")
            ->whereNull('course_schedules.canceled_at')
            ->whereIn('courses.type', [DBConstant::COURSE_TYPE_MAIN, DBConstant::COURSE_TYPE_SUB])
            ->whereIn('course_schedules.status', $status)
            ->groupBy('course_schedules.course_schedule_id')
            ->select(
                'course_schedules.title', 'course_schedules.price',
                'course_schedules.start_datetime', 'course_schedules.end_datetime',
                'course_schedules.actual_start_date', 'course_schedules.actual_end_date',
                'num_of_applicants', 'dist_method', 'courses.type', 'courses.parent_course_id',
                'course_schedules.canceled_at', 'course_schedules.course_schedule_id',
                'courses.course_id', 'course_schedules.updated_at', 'courses.approval_status',
                'courses.created_at', 'courses.status', DB::raw('course_schedules.status as cs_status')
            );

        if (!$request->option) {
            $data = $data->orderBy('course_schedules.start_datetime', Constant::ORDER_BY_DESC);
        }

        if ($request->tab === 'cancel') {
            $data = $data->where('course_schedules.start_datetime', '>', now()->subMinutes(15))
                ->whereNull(['parent_course_schedule_id', 'actual_start_date']);
        }

        switch ($request->option) {
            case Constant::SORT_DATETIME_DESC:
                $data = $data->orderBy('course_schedules.start_datetime', Constant::ORDER_BY_DESC);
                break;
            case Constant::SORT_DATETIME_ASC:
                $data = $data->orderBy('course_schedules.start_datetime', Constant::ORDER_BY_ASC);
                break;
            default:
                $data = $data->orderBy('course_schedules.created_at', Constant::ORDER_BY_DESC);
        }

        switch ($request->dist_method) {
            case DBConstant::DIST_METHOD_LIVE_STREAMING:
                $data->where('dist_method', DBConstant::DIST_METHOD_LIVE_STREAMING);
                break;
            case DBConstant::DIST_METHOD_LIVE_VIDEO_CALL:
                $data->where('dist_method', DBConstant::DIST_METHOD_LIVE_VIDEO_CALL);
                break;
            default:
        }

        $data = $data->paginate($perPage);
        $this->getImageOfSchedules($data);
        return $data;
    }

    /**
     * Get count services of teacher
     *
     * @return mixed
     */
    public function totalCourseScheduleOpen()
    {
        return $this->model->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->where([
                'courses.user_id' => auth('client')->id(),
                'is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
                'course_schedules.status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN
            ])
            ->whereNull(['parent_course_schedule_id', 'course_schedules.canceled_at'])
            ->whereIn('courses.type', [DBConstant::COURSE_TYPE_MAIN, DBConstant::COURSE_TYPE_SUB])
            ->whereRaw("CASE
                WHEN course_schedules.purchase_deadline < '" . now() . "' THEN (course_schedules.num_of_applicants > 0)
                ELSE course_schedules.purchase_deadline > '" . now() . "' END")
            ->count();
    }

    /**
     * Get list student.
     *
     * @param $courseScheduleId
     * @param $request
     * @return array
     */
    public function getListStudent($courseScheduleId, $request)
    {
        $perPage = $request->perPage ?? Constant::PER_PAGE_DEFAULT;

        $userId = auth()->guard('client')->id();

        $courseSchedule = $this->model
            ->select('course_schedules.*')
            ->join('courses', 'course_schedules.course_id', '=', 'courses.course_id')
            ->where(['user_id' => $userId, 'course_schedule_id' => $courseScheduleId])->firstOrFail();

        $listStudent = $this->model
            ->select(
                'purchases.created_at', 'nickname',
                'date_of_birth', 'sex', 'points_balance',
                'settlements.card_brand'
            )
            ->join('courses', 'course_schedules.course_id', '=', 'courses.course_id')
            ->join('purchases', 'purchases.course_schedule_id', '=', 'course_schedules.course_schedule_id')
            ->join('settlements', 'settlements.purchase_id', '=', 'purchases.purchase_id')
            ->join('users', 'purchases.user_id', '=', 'users.user_id')
            ->where([
                'course_schedules.course_schedule_id' => $courseScheduleId,
                'courses.user_id' => $userId
            ])
            ->withCount('purchases')
            ->paginate($perPage);

        return [
            'courseSchedule' => $courseSchedule,
            'listStudent' => $listStudent
        ];
    }

    /**
     * Get course schedule message
     *
     * @param $data
     * @return mixed
     */
    public function getCourseSchedulePurchased($data)
    {
        $studentId = auth('client')->id();
        $sort = Constant::ORDER_BY_DESC;
        if (isset($data['sort']) && (int)$data['sort'] === Constant::SORT_DATETIME_ASC) {
            $sort = Constant::ORDER_BY_ASC;
        }
        if ((int)$data['option'] === 1 || (int)$data['option'] === 3) {
            $courseSchedulePurchased = $this->model
                ->join('purchases as p', function ($query) use ($studentId) {
                    $query->on('p.course_schedule_id', '=', 'course_schedules.course_schedule_id')
                        ->join('purchase_details as pd', 'p.purchase_id', '=', 'pd.purchase_id')
                        ->where([
                            'p.user_id' => $studentId,
                            'pd.item' => DBConstant::PURCHASE_ITEM_COURSE_TYPE
                        ])
                        ->whereNull('p.student_canceled_at');
                })
                ->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
                ->leftJoin('image_paths', function ($q) {
                    $q->on('image_paths.id', '=',
                        DB::raw('(SELECT id FROM image_paths WHERE image_paths.display_order = ' . DBConstant::DISPLAY_ORDER_IMAGE_PATH . '
                            AND image_paths.course_id = courses.course_id LIMIT 1)'));
                })
                ->select(
                    'course_schedules.title as title',
                    'course_schedules.minutes_required as minutes_required',
                    'course_schedules.price as price',
                    'course_schedules.actual_start_date as actual_start_date',
                    'course_schedules.actual_end_date as actual_end_date',
                    'course_schedules.start_datetime as start_datetime',
                    'course_schedules.end_datetime as end_datetime',
                    'course_schedules.course_id as course_id',
                    'course_schedules.status',
                    'course_schedules.course_schedule_id as course_schedule_id',
                    'courses.user_id as teacher_id',
                    'course_schedules.title as title_course',
                    'dir_path', 'file_name', 'courses.type', 'parent_course_id'
                )
                ->whereIn('courses.type', [DBConstant::COURSE_TYPE_MAIN, DBConstant::COURSE_TYPE_SUB]);

            if ((int)$data['option'] === 1) {
                $courseSchedulePurchased = $courseSchedulePurchased
                    ->where('course_schedules.status', [DBConstant::COURSE_SCHEDULES_STATUS_OPEN]);
            } else {
                $courseSchedulePurchased = $courseSchedulePurchased
                    ->whereNotIn('course_schedules.status', [
                        DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                        DBConstant::COURSE_SCHEDULES_STATUS_DRAFT
                    ]);
            }

            $result = $this->conditionalSearchPurchasing($courseSchedulePurchased, $data);

            foreach ($result as $key => $item) {
                if ($item['type'] && $item['parent_course_id']) {
                    $course = $this->courseRepository->find($item['parent_course_id']);
                    if ($course) {
//                        $item->title_course = $course->title;
                        $item->image = $course->imagePathByDisplayOrder->thumbnail ?? null;
                    }
                }
                $type = DBConstant::ROOM_TYPE_OPEN;
                if ((int)$data['option'] === 3) {
                    $type = DBConstant::ROOM_TYPE_CLOSE;
                }
                $status = $item->status === DBConstant::COURSE_SCHEDULES_STATUS_PENDING || $item->status === DBConstant::COURSE_SCHEDULES_STATUS_CANCELED ?
                    DBConstant::ROOM_STATUS_TEACHER_CANCEL : DBConstant::ROOM_STATUS_PURCHASED;
                $room = $this->firebaseService->getRoomByCourseScheduleId($item->teacher_id, $studentId, $item->course_schedule_id, $type, $status);
                if ($room) {
                    if ($room['lastMessage'] && $room['lastMessage']['lastMessage'] && $room['lastMessage']['lastMessage']->snapshot()->exists()) {
                        $item['lastSentDatetime'] = $room['lastMessage']['lastSentDatetime'];
                        $item['lastMessage'] = $room['lastMessage']['lastMessage']->snapshot()->data();
                    }
                    $item['roomId'] = $room['roomId'];
                }

            }

            return $result;
        }

        if ((int)$data['option'] === 5) {
            $rooms = $this->firebaseService->getRoomPromotion($sort);
            $total = count($rooms);
            $rooms = collect($rooms)->forPage($data['page'], $data['perPage']);
            $courseSchedules = [];
            foreach ($rooms as $room) {
                $teacherId = $room['teacher_id'];
                $user = $this->userRepository->getUserPrivateChat($teacherId, true);
                $user['age'] = isset($user['date_of_birth']) ? (int)round(Carbon::parse($user['date_of_birth'])->age / 10, 0, PHP_ROUND_HALF_DOWN) * 10 : null;
                if ($teacherId && count($user) > 0) {
                    $courseSchedules[] = array_merge($room, $user);
                }
            }
            return [
                'total' => $total,
                'courseSchedules' => $courseSchedules
            ];
        }

        $data['option'] = (isset($data['sort']) && (int)$data['sort'] === 2) ? 'ASC' : 'DESC';
        $rooms = $this->firebaseService->getRoomPrivateChatByUser(false, $data);
        $total = count($rooms);
        $rooms = collect($rooms)->forPage($data['page'], $data['perPage']);
        $courseSchedules = [];
        foreach ($rooms as $room) {
            $teacherId = $room['teacher_id'] ?? null;
            $courseSchedule = [];

            if ($room['courseScheduleId']) {
                $data = $this->model->find($room['courseScheduleId'], ['title', 'price']);
                if ($data) {
                    $courseSchedule['title'] = $data->title;
                    $courseSchedule['price'] = $data->price;
                }
            }
            $user = $this->userRepository->getUserPrivateChat($teacherId, true);
            $user['age'] = isset($user['date_of_birth']) ? (int)round(Carbon::parse($user['date_of_birth'])->age / 10, 0, PHP_ROUND_HALF_DOWN) * 10 : null;
            if ($teacherId && count($user) > 0) {
                $courseSchedules[] = array_merge($room, $user, $courseSchedule);
            }
        }
        return [
            'total' => $total,
            'courseSchedules' => $courseSchedules
        ];
    }

    /**
     * Get Course Schedule Purchased Started
     *
     * @param $data
     *
     * @return mixed|void
     */
    public function getCourseSchedulePurchasedStarted($data)
    {
        $courseSchedulePurchased = $this->getCourseSchedulePurchased($data);
        $query = $courseSchedulePurchased->where([
            ['course_schedules.status', '<>', DBConstant::COURSE_SCHEDULES_STATUS_OPEN],
            ['co.is_archived', '=', DBConstant::NOT_ARCHIVED_FLAG],
            ['co.type', '=', DBConstant::COURSE_TYPE_MAIN],
        ]);

        return $this->conditionalSearchPurchasing($query, $data);
    }

    /**
     * Get Course Schedule Not Purchased
     *
     * @param $data
     *
     * @return mixed|void
     */
    public function getCourseScheduleNotPurchased($data)
    {
        $query = $this->model
            ->where([
                'type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                'status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN
            ])
            ->whereIn('course_schedule_id', $data['course_schedule_ids']);

        return $this->conditionalSearchPurchasing($query, $data);
    }

    /**
     * Conditional search
     *
     * @param $query
     * @param $data
     * @param null $groupBy
     * @return mixed
     */
    private function conditionalSearchPurchasing($query, $data, $groupBy = null)
    {
        if (isset($data['sort']) && !empty($data['sort']) && $data['sort'] == Constant::SORT_DATETIME_DESC) {
            $query->orderBy('course_schedules.start_datetime', Constant::ORDER_BY_DESC);
        }

        if (isset($data['sort']) && !empty($data['sort']) && $data['sort'] == Constant::SORT_DATETIME_ASC) {
            $query->orderBy('course_schedules.start_datetime', Constant::ORDER_BY_ASC);
        }
        if (isset($data['year']) && !empty($data['year'])) {
            $query->whereYear('course_schedules.start_datetime', $data['year']);
        }
        if ($groupBy) {
            $query->groupBy($groupBy);
        }

        return $query->paginate($data['perPage']);
    }

    /**
     * Get sale history.
     *
     * @param $request
     *
     * @return mixed
     */
    public function saleHistory($request)
    {
        $isOptionTeacher = $this->isOptionTeacher($request);
        return $this->saleHistoryCourseSchedule($isOptionTeacher);
    }

    /**
     * Get option in request order review.
     *
     * @param $request
     *
     * @return array
     */
    private function isOptionTeacher($request)
    {
        if (isset($request->month) && isset($request->option) && Constant::ORDER_LIST_ASC == $request->option) {
            $date = $request->year . '/' . $request->month . '/01';
            $data = [
                'startDate' => Carbon::parse($date)->startOfMonth()->toDateString(),
                'endDate' => Carbon::parse($date)->endOfMonth()->toDateString(),
                'year' => $request->year,
                'month' => $request->month,
                'orderBy' => Constant::ORDER_BY_ASC
            ];
        } elseif (isset($request->option) && Constant::ORDER_LIST_ASC == $request->option) {
            $data = [
                'startDate' => Carbon::now()->startOfMonth()->toDateString(),
                'endDate' => Carbon::now()->endOfMonth()->toDateString(),
                'year' => Carbon::now()->year,
                'month' => Carbon::now()->month,
                'orderBy' => Constant::ORDER_BY_ASC
            ];
        } elseif (isset($request->month)) {
            $date = $request->year . '/' . $request->month . '/01';
            $data = [
                'startDate' => Carbon::parse($date)->startOfMonth()->toDateString(),
                'endDate' => Carbon::parse($date)->endOfMonth()->toDateString(),
                'year' => $request->year,
                'month' => $request->month,
                'orderBy' => Constant::ORDER_BY_DESC
            ];
        } else {
            $data = [
                'startDate' => Carbon::now()->startOfMonth()->toDateString(),
                'endDate' => Carbon::now()->endOfMonth()->toDateString(),
                'year' => Carbon::now()->year,
                'month' => Carbon::now()->month,
                'orderBy' => Constant::ORDER_BY_DESC
            ];
        }
        return $data;
    }

    /**
     * Get sale history course schedule.
     *
     * @param $data
     *
     * @return array
     */
    public function saleHistoryCourseSchedule($data)
    {
        $listSaleHistories = $this->model
            ->select('course_schedules.*', 'courses.type as course_type', 'courses.is_archived as course_is_archived', DB::raw("MAX(image_paths.dir_path) as dir_path"), DB::raw("MAX(image_paths.file_name) as file_name"))
            ->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->leftJoin('image_paths', function ($q) {
                $q->on('image_paths.course_id', '=', DB::raw('CASE WHEN courses.parent_course_id IS NULL THEN courses.course_id ELSE courses.parent_course_id END'))
                    ->where('display_order', DBConstant::DISPLAY_ORDER_IMAGE_PATH)
                    ->where('image_paths.type', Constant::IMAGE_TYPE)
                    ->where('image_paths.status', Constant::IMAGE_STATUS);
            })
//            ->where('course_schedules.end_datetime', '>', now())
            ->where('courses.user_id', auth('client')->user()->user_id)
            ->whereIn('courses.type', [Constant::SALE_HISTORY_TYPE, Constant::SALE_HISTORY_STATUS])
//            ->whereIn('course_schedules.status', [Constant::SALE_HISTORY_TYPE, Constant::SALE_HISTORY_STATUS, Constant::STATUS_COURSE_SCHEDULE_HISTORY])
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->where('course_schedules.status', Constant::SALE_HISTORY_TYPE);
                })
                    ->orWhere(function ($query) {
                        $query->where('course_schedules.status', Constant::SALE_HISTORY_STATUS);
                        $query->where('course_schedules.num_of_applicants', '>', 0);
                    })
                    ->orWhere(function ($query) {
                        $query->where('course_schedules.status', Constant::STATUS_COURSE_SCHEDULE_HISTORY);
                        $query->where('course_schedules.num_of_applicants', '>', 0);
                    });
            })
            ->whereBetween('course_schedules.start_datetime', [$data['startDate'], $data['endDate']])
            ->withCount('reviews')
            ->groupby('course_schedules.course_schedule_id')
            ->orderBy('course_schedules.start_datetime', $data['orderBy'])
            ->paginate(Constant::PAGINATE_LIST_HISTORY);
        return [
            'data' => $data,
            'listSaleHistories' => $listSaleHistories
        ];
    }

    /**
     * Get sale history student list.
     *
     * @param $courseScheduleId
     * @param $request
     *
     * @return mixed
     */
    public function saleHistoryStudentList($courseScheduleId, $request)
    {
        $isOption = $this->isOptionStudentList($request);
        return $this->studentList($isOption['orderBy'], $courseScheduleId);
    }

    /**
     * Get option student list.
     *
     * @param $request
     *
     * @return array
     */
    public function isOptionStudentList($request)
    {
        if (isset($request->option) && Constant::ORDER_LIST_ASC == $request->option) {
            $orderBy = Constant::ORDER_BY_ASC;
        } else {
            $orderBy = Constant::ORDER_BY_DESC;
        }
        return [
            'orderBy' => $orderBy,
        ];
    }

    /**
     * Get student list.
     *
     * @param $orderBy
     * @param $courseScheduleId
     *
     * @return mixed
     */
    public function studentList($orderBy, $courseScheduleId)
    {
        $userId = auth()->guard('client')->id();
        return $this->model
            ->select(
                'users.nickname',
                'users.user_type',
                'users.name_use',
                'users.last_name_kanji',
                'users.first_name_kanji',
                'users.date_of_birth',
                'users.sex',
                'users.points_balance',
                DB::raw('MAX(course_schedules.course_schedule_id) as course_schedule_id'),
                DB::raw('MAX(course_schedules.title) as title'),
                DB::raw('MAX(course_schedules.start_datetime) as start_datetime'),
                DB::raw('MAX(course_schedules.end_datetime) as end_datetime'),
                DB::raw('MAX(course_schedules.price) as price'),
                DB::raw('MAX(course_schedules.actual_start_date) as actual_start_date'),
                DB::raw('MAX(course_schedules.actual_end_date) as actual_end_date'),
                DB::raw('MAX(settlements.card_brand) as card_brand'),
                DB::raw('MAX(course_schedules.course_schedule_id) as course_schedule_id'),
                DB::raw('MAX(purchases.created_at) as created_at'),
                DB::raw('MAX(purchases.purchase_id) as purchase_id'),
                DB::raw('MAX(image_paths.dir_path) as dir_path'),
                DB::raw('MAX(image_paths.file_name) as file_name'),
                DB::raw('COUNT(purchaseCourse.user_id) as count_purchased')
            )
            ->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->join('purchases', 'purchases.course_schedule_id', '=', 'course_schedules.course_schedule_id')
            ->join('settlements', 'settlements.purchase_id', '=', 'purchases.purchase_id')
            ->join('users', 'purchases.user_id', '=', 'users.user_id')
            ->join('image_paths', 'course_schedules.course_id', '=', 'image_paths.course_id')
            ->where('image_paths.display_order', DBConstant::IMAGE_COURSE_DISPLAY)
            ->leftJoin(DB::raw('(SELECT user_id from purchases where course_schedule_id in (SELECT course_schedule_id from course_schedules join courses on courses.course_id = course_schedules.course_id where courses.user_id = ' . $userId . ')) as purchaseCourse'),
                'purchaseCourse.user_id', 'users.user_id'
            )
            ->where('image_paths.type', DBConstant::IMAGE_TYPE_COURSE)
            ->where('course_schedules.course_schedule_id', $courseScheduleId)
            ->where('courses.user_id', auth('client')->user()->user_id)
            ->groupBy('users.user_id')
            ->orderBy('created_at', $orderBy)
            ->paginate(Constant::PAGINATE_LIST_HISTORY);
    }

    /**
     * Get course to delete
     *
     * @param $request
     *
     * @return mixed
     */
    public function getCourseToDelete($request)
    {
        $query = $this->model
            ->select('courses.*', 'course_schedules.group as cs_group')
            ->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->join('users', 'courses.user_id', '=', 'users.user_id');
        if ($request->group) {
            $query
                ->where([
                    'course_schedules.course_id' => $request->id,
                    'course_schedules.group' => $request->group,
                    'courses.user_id' => auth('client')->id()
                ]);
            $result = $query->get();
            $query->delete();
            return $result;
        }
        $query
            ->where([
                'course_schedules.course_schedule_id' => $request->id,
                'courses.user_id' => auth('client')->id()
            ]);
        $result = $query->first();
        $query->delete();

        return $result;
    }

    /**
     * @param $user
     * @return mixed|void
     */
    public function listSchedulesCourse($user, $courseId = null)
    {
        $data = $this->model->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->where('user_id', $user->user_id)
            ->whereIn('course_schedules.status', [DBConstant::COURSE_STATUS_OPEN, DBConstant::COURSE_STATUS_DRAFT])
            ->select('course_schedule_id', 'start_datetime', 'end_datetime');
        if ($courseId) {
            $data->whereNotIn('course_schedules.course_schedule_id', [$courseId]);
        }
        return $data->get();
    }

    /**
     * @param string $start
     * @param int $minute
     * @return mixed
     */
    public function checkTimeExist(array $start, int $minute)
    {
        $query = $this->model->join('courses as c', function ($query) {
            $query->on('course_schedules.course_id', 'c.course_id')
                ->where('c.user_id', auth('client')->id())
                ->where('c.status', DBConstant::STATUS_COURSE_SCHEDULE_OPEN)
                ->where('course_schedules.status', DBConstant::STATUS_COURSE_SCHEDULE_OPEN);
        });
        foreach ($start as $item) {
            $rangeDate = [now()->parse($item), now()->parse($item)->addMinutes($minute)];
            $query = $query->orWhereBetween('start_datetime', $rangeDate)
                ->orWhereBetween('end_datetime', $rangeDate);
        }

        return $query->count();
    }

    public function listSchedules($user, $courseScheduleId)
    {
        return $this->model->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->where('user_id', $user->user_id)
            ->where('courses.status', DBConstant::COURSE_STATUS_OPEN)
            ->whereNotIn('course_schedule_id', [$courseScheduleId])
            ->select('start_datetime', 'end_datetime')->get();
    }

    /**
     * Get list course schedule of user.
     *
     * @return mixed
     */
    public function getCourseScheduleUser()
    {
        $userId = auth('client')->user()->user_id;
        return $this->model
            ->join('courses', function ($q) use ($userId) {
                $q->on('courses.course_id', '=', 'course_schedules.course_id')
                    ->where('courses.user_id', $userId);
            })
            ->join('users', function ($q) use ($userId) {
                $q->on('courses.user_id', '=', 'users.user_id')
                    ->where('users.user_id', $userId)
                    ->where('users.points_balance', '>=', 0);
            })
            ->whereRaw("case
                WHEN course_schedules.status = 1 THEN (course_schedules.canceled_at IS NULL AND course_schedules.end_datetime > '" . now()->subHours(48) . "')
                WHEN course_schedules.status = 0 THEN (course_schedules.start_datetime >='" . now() . "')
                ELSE 0 END")
            ->count();
    }

    /**
     * Get course schedule upcoming.
     *
     * @param $userId
     * @return mixed
     */
    public function getCourseScheduleUpcoming($userId)
    {
        return $this->model
            ->join('applicants', function ($join) use ($userId): void {
                $join->on('course_schedules.course_schedule_id', '=', 'applicants.course_schedule_id')
                    ->where([
                        'applicants.user_id' => $userId,
                        'applicants.canceled_at' => null,
                    ])
                    ->where(DB::raw("(DATE_FORMAT(applicants.created_at, '%Y-%m-%d'))"), "<>", Carbon::now()->format('Y-m-d'));
            })
            ->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->where('course_schedules.type', DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION)
            ->where(DB::raw("(DATE_FORMAT(course_schedules.start_datetime, '%Y-%m-%d'))"), "=", Carbon::now()->addDays(Constant::DAY_REMIND_COURSE_SCHEDULE)->format('Y-m-d'))
            ->where('course_schedules.status', '=', DBConstant::STATUS_ORDER_CANCEL)
            ->whereBetween('courses.type', [DBConstant::USER_TYPE_STUDENT, DBConstant::USER_TYPE_TEACHER])
            ->where('courses.is_archived', DBConstant::NOT_ARCHIVED_FLAG)
            ->select('course_schedules.*', 'courses.dist_method as dist_method', 'courses.type as course_type')
            ->orderBy('course_schedules.start_datetime', 'ASC')
            ->get();
    }

    /**
     * Get course schedule upcoming holding.
     *
     * @param $userId
     * @return mixed
     */
    public function getCourseScheduleUpcomingHolding($userId)
    {
        return $this->model
            ->join('applicants', function ($join) use ($userId): void {
                $join->on('course_schedules.course_schedule_id', '=', 'applicants.course_schedule_id')
                    ->where([
                        'applicants.user_id' => $userId,
                        'applicants.canceled_at' => null,
                    ])
                    ->where(DB::raw("(DATE_FORMAT(applicants.created_at, '%Y-%m-%d'))"), "=", Carbon::now()->format('Y-m-d'));
            })
            ->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->where('course_schedules.type', DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION)
            ->where(DB::raw("(DATE_FORMAT(course_schedules.start_datetime, '%Y-%m-%d'))"), "=", Carbon::now()->addDays(Constant::DAY_REMIND_COURSE_SCHEDULE)->format('Y-m-d'))
            ->where('course_schedules.status', '=', DBConstant::STATUS_ORDER_CANCEL)
            ->whereBetween('courses.type', [DBConstant::USER_TYPE_STUDENT, DBConstant::USER_TYPE_TEACHER])
            ->where('courses.is_archived', DBConstant::NOT_ARCHIVED_FLAG)
            ->select('course_schedules.*', 'courses.dist_method as dist_method', 'courses.type as course_type')
            ->orderBy('course_schedules.start_datetime', 'ASC')
            ->get();
    }

    /**
     * @param $courseScheduleId
     * @return mixed
     */
    public function getCourseScheduleDetail($courseScheduleId)
    {
        return $this->model
            ->join('purchases', function ($join): void {
                $join->on('purchases.course_schedule_id', '=', 'course_schedules.course_schedule_id')
                    ->where([
                        'purchases.user_id' => auth('client')->user()->user_id,
                    ]);
            })
            ->where([
                ['course_schedules.course_schedule_id', '=', $courseScheduleId],
                ['course_schedules.purchase_deadline', '>', now()],
                ['course_schedules.status', '=', DBConstant::COURSE_SCHEDULES_STATUS_OPEN],
            ])->first();
    }

    public function getCourseSchedules($courseId, $timeSubCourseSchedule)
    {
        return $this->model
            ->where([
                ['course_schedules.course_id', '=', $courseId],
                ['course_schedules.status', '=', DBConstant::COURSE_SCHEDULES_STATUS_OPEN],
            ])->get();
    }

    public function courseSchedulePurchases($courseId)
    {
        return $this->model
            ->select('course_schedules.*', 'co.dist_method')
            ->join('courses as co', 'course_schedules.course_id', '=', 'co.course_id')
            ->where([
                'co.course_id' => $courseId,
                'co.type' => DBConstant::COURSE_TYPE_MAIN,
                'course_schedules.status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                'course_schedules.canceled_at' => null
            ])
            ->where('course_schedules.purchase_deadline', '>', now())
            ->get();
    }

    public function checkPurchaseCourseSchedule($courseScheduleId, $studentId)
    {
        return $this->model
            ->join('applicants', function ($join) use ($studentId, $courseScheduleId): void {
                $join->on('course_schedules.course_schedule_id', '=', 'applicants.course_schedule_id')
                    ->where([
                        'applicants.user_id' => $studentId,
                        'applicants.canceled_at' => null,
                        'applicants.course_schedule_id' => $courseScheduleId,
                    ]);
            })
            ->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->where('course_schedules.type', DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION)
            ->where('course_schedules.status', '=', DBConstant::STATUS_ORDER_CANCEL)
            ->whereBetween('courses.type', [DBConstant::USER_TYPE_STUDENT, DBConstant::USER_TYPE_TEACHER])
            ->where('courses.is_archived', DBConstant::NOT_ARCHIVED_FLAG)
            ->count();
    }

    public function getDetail(int $id)
    {
        return $this->model
            ->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
//            ->join('image_paths', 'image_paths.course_id', '=', 'course_schedules.course_id')
            ->where([
                'course_schedules.course_schedule_id' => $id,
                'courses.user_id' => auth('client')->id()
            ])
            ->select('course_schedules.*')
            ->firstOrFail();
    }

    public function getOneScheduleOfCourseNew($category = null, $option = null)
    {
        $now = now()->format('Y-m-d H:i:s');

        $courseSchedules = $this->model
            ->join('courses', function ($q) {
                $q->on('course_schedules.course_id', '=', 'courses.course_id')
                    ->where('courses.type', DBConstant::COURSE_TYPE);
            })
            ->join('categories', function ($q) use ($category) {
                $q->on('categories.category_id', '=', 'courses.category_id');
                if ($category) {
                    if ($category['type']) {
                        $q->where('categories.type', $category['type']);
                    }
                    if ($category['id']) {
                        $q->where('categories.category_id', $category['id']);
                    }
                }
            })
            ->where([
                'course_schedules.status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                'course_schedules.type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                ['course_schedules.purchase_deadline', '>', $now],
            ])
            ->whereRaw('course_schedules.fixed_num > course_schedules.num_of_applicants')
            ->select(DB::raw('
                ROW_NUMBER()
                OVER(PARTITION BY course_schedules.course_id ORDER BY course_schedules.purchase_deadline ASC) rowNumber,
                course_schedules.course_schedule_id, course_schedules.fixed_num, course_schedules.num_of_applicants,
                course_schedules.course_id
            '));

        if ($option) {
            //Check the timeframe looking for.
            $timeFrame = $option['timeFrame'];
            switch ($timeFrame) {
                case Constant::COURSES_TIME_FRAME_MORNING:
                    $frame = [Constant::MORNING['startTime'], Constant::MORNING['endTime']];
                    break;
                case Constant::COURSES_TIME_FRAME_AFFTERNOON:
                    $frame = [Constant::AFTERNOON['startTime'], Constant::AFTERNOON['endTime']];
                    break;
                default:
                    $frame = [Constant::NIGHT['startTime'], '23:59:59'];
            }
            if ($option['startDate']) {
                if ($timeFrame && $timeFrame == Constant::COURSES_TIME_FRAME_NIGHT) {
                    $startDateTime = now()->parse($option['startDate'])->format('Y-m-d') . ' 19:00:00';
                    $endDateTime = Date('Y-m-d', strtotime($option['startDate'] . '+1 day')) . ' 07:59:59';
                    $courseSchedules->whereBetween('course_schedules.start_datetime', [$startDateTime, $endDateTime]);
                } else {
                    $courseSchedules->where(DB::raw("(DATE_FORMAT(start_datetime, '%Y-%m-%d'))"), "=", now()->parse($option['startDate'])->format('Y-m-d'));
                }
            } else {
                $startDateTime = now()->subMonth()->firstOfMonth()->format('Y-m-d') . ' 08:00:00';
                $courseSchedules->where('start_datetime', '>=', $startDateTime);
            }
            if ($timeFrame) {
                $courseSchedules->where(function ($query) use ($frame, $timeFrame) {
                    $query->whereBetween(DB::raw("(DATE_FORMAT(start_datetime, '%H:%i:%s'))"), $frame);
                    if ($timeFrame == Constant::COURSES_TIME_FRAME_NIGHT) {
                        $query->orWhereBetween(DB::raw("(DATE_FORMAT(start_datetime, '%H:%i:%s'))"), ['00:00:00', Constant::NIGHT['endTime']]);
                    }
                });
            }
        }

        if ($category && $category['keyword']) {
            $search = trim($category['keyword'], ' ');
            if ($search) {
                $courseSchedules->where(function ($query) use ($search) {
                    $query->orWhere('course_schedules.title', 'LIKE', '%' . $search . '%')
                        ->orWhere('course_schedules.body', 'LIKE', '%' . $search . '%');
                });
            }
        }

        $courseSchedules = $courseSchedules->get();
        $arrCourse = [];
        $listPurchased = DB::table('purchases')
            ->whereIn('course_schedule_id', $courseSchedules->pluck('course_schedule_id')->toArray())
            ->where('user_id', auth('client')->id())
            ->whereIn('status', [DBConstant::PURCHASES_STATUS_NOT_CAPTURED, DBConstant::PURCHASES_STATUS_CAPTURED])
            ->pluck('course_schedule_id')->toArray();

        return $courseSchedules->filter(function ($item) use ($listPurchased, &$arrCourse, $courseSchedules) {
            if (in_array($item->course_schedule_id, $listPurchased, true)) {
                return false;
            }
            $count = $courseSchedules->filter(function ($c) use ($item) {
                return $c->course_id === $item->course_id;
            })->count();
            if ($count === 1 ||
                ($item->rowNumber === 1 && $item->fixed_num !== $item->num_of_applicants) ||
                ($item->rowNumber > 1 && !in_array($item->course_id, $arrCourse, true))
            ) {
                $arrCourse[] = $item->course_id;
                return true;
            }

            return false;
        })->pluck('course_schedule_id')->toArray();
    }

    /**
     * Get course schedule clone
     *
     * @param $courseId
     * @param string $group
     * @return mixed
     */
    public function getCourseScheduleClone($courseId, string $group)
    {
        return $this->model
            ->select('course_schedules.*')
            ->join('courses', 'course_schedules.course_id', '=', 'courses.course_id')
            ->where([
                'courses.course_id' => $courseId,
                'course_schedules.canceled_at' => null,
                'course_schedules.group' => $group
            ])
            ->whereIn('course_schedules.status', [
                DBConstant::COURSE_SCHEDULES_STATUS_CLONE,
                DBConstant::COURSE_SCHEDULES_STATUS_DRAFT,
                DBConstant::COURSE_SCHEDULES_STATUS_PREVIEW
            ])
            ->with('imagePaths')
            ->where('course_schedules.purchase_deadline', '>', now())
            ->first();
    }

    public function getScheduleNotInGroup(int $courseId, Request $request)
    {
        $group = $request->group;
        return $this->model
            ->join('courses', 'course_schedules.course_id', '=', 'courses.course_id')
            ->where('courses.parent_course_id', $courseId)
            ->where('course_schedules.group', '!=', $group)
            ->count();
    }
}
