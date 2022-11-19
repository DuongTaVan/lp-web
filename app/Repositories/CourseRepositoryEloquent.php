<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Exceptions\NoAccountException;
use App\Models\Course;
use App\Services\Client\Common\FirebaseService;
use App\Traits\CourseImageTrait;
use App\Traits\TopLabelTrait;
use Carbon\Carbon;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CourseRepositoryEloquent.
 */
class CourseRepositoryEloquent extends BaseRepository implements CourseRepository
{
    use TopLabelTrait, CourseImageTrait;

    /**
     * Specify Model class name.
     *
     * @return string
     */
    private $purchaseRepository;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->purchaseRepository = app(PurchaseRepository::class);
    }

    public function model()
    {
        return Course::class;
    }

    /**
     * Get main courses.
     *
     * @return mixed
     */
    public function getMainCourses()
    {
        return $this->model->join(
            'categories as ca', 'courses.category_id', '=', 'ca.category_id'
        )->where([
            'courses.type' => DBConstant::COURSE_TYPE_MAIN,
            'courses.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
        ]);
    }

    /**
     * Get Teacher Of Course Schedule.
     *
     * @param $courseScheduleId
     * @return mixed|void
     */
    public function getTeacherOfCourseSchedule($courseScheduleId)
    {
        return $this->model
            ->select('courses.user_id as teacher')
            ->join('course_schedules as cs', 'courses.course_id', '=', 'cs.course_id')
            ->where('cs.course_schedule_id', '=', $courseScheduleId)
            ->first();
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get rating and count review.
     *
     * @param $userId
     * @return mixed
     */
    public function getTheRatingAndCountReview($userId)
    {
        return $this->model
            ->where([
                'user_id' => $userId,
                'type' => DBConstant::COURSE_TYPE_MAIN,
                'is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
            ])->get();
    }

    /**
     * Get course rating
     *
     * @param $courseId
     * @param $userId
     */
    public function getTheRatingOfCourse($courseId)
    {
        return $this->model
            ->where([
                'course_id' => $courseId,
                'type' => DBConstant::COURSE_TYPE_MAIN,
                'is_archived' => DBConstant::NOT_ARCHIVED_FLAG
            ])->get();
    }

    /**
     * Get list course.
     *
     * @param $userId
     * @param bool $onlyOpen
     * @return mixed
     */
    public function getListCourses($userId, $onlyOpen = false)
    {
        $courses = $this->model
            ->select('users.nickname as nickname',
                'users.profile_image as profile_image',
                'courses.*',
                'categories.type as category_type'
            )
            ->join('users', 'courses.user_id', '=', 'users.user_id')
            ->join('categories', 'courses.category_id', 'categories.category_id');
        if ($onlyOpen) {
            $courses->join('course_schedules', function ($q) {
                $q->on('courses.course_id', '=', 'course_schedules.course_id')
                    ->where('course_schedules.status', DBConstant::STATUS_COURSE_SCHEDULE_OPEN)
                    ->whereRaw('course_schedules.num_of_applicants < course_schedules.fixed_num')
                    ->where('course_schedules.purchase_deadline', '>', now());
            });
        }
        $courses = $courses
            ->where([
                'courses.user_id' => $userId,
                'courses.type' => DBConstant::COURSE_TYPE_MAIN,
                'courses.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
            ])
            ->with(['courseSchedules' => function ($q) use ($userId, $onlyOpen) {
                if ($onlyOpen) {
                    $q->where('status', DBConstant::STATUS_COURSE_SCHEDULE_OPEN)
                        ->whereRaw('course_schedules.num_of_applicants < course_schedules.fixed_num')
                        ->where('purchase_deadline', '>', now());
                } else {
                    $q->whereIn('status', DBConstant::LIST_COURSE_STATUS);
                }
                $q->orderBy('start_datetime', 'ASC');
                $q->with(['purchases' => function ($t) use ($userId) {
                    $t->where('purchases.user_id', $userId);
                    $t->where('purchases.status', DBConstant::PURCHASES_STATUS_NOT_CAPTURED);
                }]);
            }])
            ->groupBy('courses.course_id')
            ->orderBy('courses.created_at', 'DESC')
            ->paginate(Constant::PAGINATE_LIST_REVIEW);
        foreach ($courses as $course) {
            if (count($course->courseSchedules) > 0) {
                $schedule = $course->courseSchedules[0];
                $courseSchedules = $course->courseSchedules;
                $this->getImageOfSchedules($course->courseSchedules);
                $scheduleStatus = $courseSchedules->filter(function ($item) use ($schedule) {
                    // return $schedule['status'] === 0;
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
        return $courses;
    }

    /**
     * Check extension course exist.
     *
     * @param array $data
     * @param $authUserId
     * @return mixed
     */
    public function checkExtensionCourseExist(array $data, $authUserId)
    {
        return $this->model
            ->select(
                'courses.course_id',
                'courses.minutes_required as course_minutes_required',
                'courses.user_id as course_user_id',
                'courses.price as course_price',
                'courses.fixed_num as course_fixed_num'
            )
            ->join('courses as co2', 'courses.parent_course_id', '=', 'co2.course_id')
            ->join('course_schedules as cs', 'co2.course_id', '=', 'cs.course_id')
            ->join('applicants as a', 'cs.course_schedule_id', '=', 'a.course_schedule_id')
            ->where([
                'courses.course_id' => $data['course_id'],
                'courses.type' => DBConstant::COURSE_TYPE_EXTENSION,
                'courses.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
//                'co2.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
//                'cs.type' => DBConstant::COURSE_TYPE_MAIN,
//                'a.course_schedule_id' => $data['origin_course_schedule_id'],
//                'a.user_id' => $authUserId,
            ])
//            ->whereIn('courses.course_id', $data['extend_ids'])
            ->first();
    }

    /**
     * @param $courseId
     * @return mixed
     */
    public function courseRanking($courseId)
    {
        return $this->model->find($courseId);
    }

    /**     * Get Course Schedule.
     *
     * @param $courseScheduleId
     * @return mixed|void
     */
    public function getCourseSchedule($courseScheduleId)
    {
        return $this->model
            ->select('courses.*', 'cs.course_schedule_id as course_schedule_id', 'cs.status as cs_status', 'cs.purchase_deadline as cs_purchase_deadline', 'cate.type as category_type')
            ->join('course_schedules as cs', 'courses.course_id', '=', 'cs.course_id')
            ->join('categories as cate', 'courses.category_id', '=', 'cate.category_id')
            ->where([
                'cs.course_schedule_id' => $courseScheduleId,
                'cs.type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                'courses.type' => DBConstant::COURSE_TYPE_MAIN,
                'courses.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
            ])
            ->with([
                'courseSchedules' => function ($query) {
                    $query->where('status', Constant::COURSE_SCHEDULE_STATUS_OPEN)
                        ->where('purchase_deadline', '>', now())
                        ->select('course_schedule_id', 'course_id', 'fixed_num', 'num_of_applicants', 'purchase_deadline');
                },
                'purchases'
            ])
            ->first();
    }

    public function getListCoursePreview($courseId)
    {
        return $this->model
            ->select('courses.*', 'u.nickname', 'u.identity_verification_status', 'u.catchphrase',
                'u.nda_status', 'u.profile_image', 'c.type as category_type')
            ->join('course_schedules as cs', 'courses.course_id', '=', 'cs.course_id')
            ->join('users as u', 'courses.user_id', '=', 'u.user_id')
            ->join('categories as c', 'courses.category_id', '=', 'c.category_id')
            ->where([
                'courses.course_id' => $courseId,
                'cs.type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                'courses.type' => DBConstant::COURSE_TYPE_MAIN,
                'courses.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
            ])->first();
    }

//    /**
//     * check is Course.
//     *
//     * @param $id , $user
//     * @return mixed|void
//     */
//    public function checkIsCourse($id, $user)
//    {
//        return $this->model
//            ->where('courses.course_id', $id)
//            ->where('user_id', $user->user_id)
//            ->first();
//    }

    /**
     * Get detail Course.
     *
     * @param $id , $user
     * @return mixed|void
     */
    public function getCourse($id, $user)
    {
        $mainCourse = $this->model->with('courseSchedules:course_schedule_id,course_id,start_datetime')
            ->where('courses.course_id', $id)
            ->where('user_id', $user->user_id)
            ->first();

        $subCourse = $this->model->with('courseSchedules:course_schedule_id,course_id,start_datetime')
            ->where('courses.parent_course_id', $id)
            ->where('user_id', $user->user_id)
            ->first();
        return [
            'mainCourse' => $mainCourse,
            'subCourse' => $subCourse
        ];
    }

    /**
     * Get course parent.
     *
     * @param $id
     * @param $user
     * @return Builder|\Illuminate\Database\Eloquent\Model|mixed
     */
    public function getCourseParent($id, $user)
    {
        return $this->model
            ->with('category', 'optionalExtras')
            ->where('course_id', $id)
            ->where('user_id', $user->user_id)
            ->firstOrFail();
    }

//    /**
//     * Get course extent .
//     *
//     * @param $id
//     * @param $user
//     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
//     */
//    public function getCourseExtent($id, $user)
//    {
//        return $this->model
//            ->where('parent_course_id', $id)
//            ->whereNull('category_id')
//            ->where('user_id', $user->user_id)
//            ->get();
//    }

    /**
     * @return mixed|void
     */
    public function getSubCourse($data)
    {
        return $this->model
            ->selectRaw('COUNT(courses.course_id) as totalSubCourse')
            ->join('course_schedules as cs', 'courses.course_id', '=', 'cs.course_id')
            ->where('courses.type', DBConstant::SUB_COURSE_TYPE)
            ->where('courses.user_id', auth('client')->user()->user_id)
            ->whereBetween('cs.created_at', [$data['startDate'], $data['endDate']])
            ->first();
    }

    public function getCourseScheduleId()
    {
        return $this->model
            ->join('course_schedules as cs', 'courses.course_id', '=', 'cs.course_id')
            ->where('courses.type', DBConstant::SUB_COURSE_TYPE)
            ->where('user_id', auth('client')->user()->user_id)
            ->pluck('cs.course_schedule_id')
            ->toArray();
    }


    public function getCourseByUseID($userId)
    {
        return $this->model
            ->select('c.type as category_type'
            )
            ->join('categories as c', 'courses.category_id', '=', 'c.category_id')
            ->where([
                'courses.user_id' => $userId,
                'courses.status' => DBConstant::COURSE_STATUS_OPEN,
                'courses.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
            ])->first();
    }

//    public function getAllCourseByUseId($userId)
//    {
//        $result = DB::select(
//            DB::raw('SELECT c.user_id, avg(cs.rating) as avg, count(cs.rating) as totalRecord
//            FROM courses AS c
//            INNER JOIN
//                (
//                    SELECT cs1.*, rv.rating
//                    FROM course_schedules cs1
//                    LEFT JOIN
//                        (
//                            SELECT rv1.*
//                            FROM reviews rv1
//                        ) rv
//                    ON cs1.course_schedule_id = rv.course_schedule_id
//                ) cs
//            ON c.course_id = cs.course_id
//            WHERE c.user_id =' . $userId .
//                ' Group By c.user_id'));
//
//        return $result;
//    }

    public function getListExtendCourseBy($courseId)
    {
        $loginUser = Auth::guard('client')->user();

        return $this->model
            ->where([
                'type' => DBConstant::COURSE_TYPE_EXTENSION,
                'parent_course_id' => $courseId,
                'is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
                'status' => DBConstant::COURSE_STATUS_OPEN,
                'is_hidden' => DBConstant::COURSE_IS_HIDDEN_OPEN
            ])
            ->with(['courseSchedules' => function ($q) {
                $q->with('purchasesDetail');
            }])
            ->orderBy('course_id', Constant::ORDER_BY_ASC)
            ->get();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getNewCoursesOfTeacher($request)
    {
        $perPage = $request->perPage ?? Constant::PER_PAGE_DEFAULT;

        $data = $this->model
            ->where([
                'type' => DBConstant::COURSE_TYPE_MAIN,
                'user_id' => auth('client')->id(),
            ])
            ->where('fixed_num', '<>', DBConstant::FIXED_NUM_DRAB)
            ->whereIn('status', [
                DBConstant::COURSE_STATUS_WAIT_APPROVAL,
                DBConstant::COURSE_STATUS_OPEN,
                DBConstant::COURSE_STATUS_PREVIEW
            ])
            ->with(['imagePaths'])
            ->withCount(['courseSchedules' => function ($query) {
                $query->whereIn('status', [
                    DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                    DBConstant::COURSE_SCHEDULES_STATUS_DRAFT
                ])
                    ->where('course_schedules.purchase_deadline', '>', now())
                    ->whereRaw('course_schedules.num_of_applicants < course_schedules.fixed_num');
            }])
            ->with(['courseChildren' => function ($query) {
                $query->withCount(['courseSchedules' => function ($query) {
                    $query->whereIn('status', [DBConstant::COURSE_SCHEDULES_STATUS_OPEN, DBConstant::COURSE_SCHEDULES_STATUS_CLOSED, DBConstant::COURSE_SCHEDULES_STATUS_RECORDED]);
                }]);
            }]);

        switch ($request->option) {
            case Constant::SORT_DATETIME_DESC:
                $data = $data->orderBy('created_at', Constant::ORDER_BY_DESC);
                break;
            case Constant::SORT_DATETIME_ASC:
                $data = $data->orderBy('created_at', Constant::ORDER_BY_ASC);
                break;
            default:
                $data = $data->orderBy('created_at', Constant::ORDER_BY_DESC);
                break;
        }

        return $data->paginate($perPage);
    }

    public function getNewCoursesCloneOfTeacher($request)
    {
        $perPage = $request->perPage ?? Constant::PER_PAGE_DEFAULT;

        $data = $this->model
            ->where([
                'courses.type' => DBConstant::COURSE_TYPE_MAIN,
                'courses.user_id' => auth()->guard('client')->id(),
                'parent_course_id' => NULL
            ])
            ->whereIn('courses.status', [
                DBConstant::COURSE_STATUS_WAIT_APPROVAL,
                DBConstant::COURSE_STATUS_OPEN
            ])
            ->withCount(['courseSchedules' => function ($query) {
                $query->whereIn('status', [
                    DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                    DBConstant::COURSE_SCHEDULES_STATUS_DRAFT
                ])
                    ->where('course_schedules.purchase_deadline', '>', now())
                    ->whereRaw('course_schedules.num_of_applicants < course_schedules.fixed_num');
            }])
            ->with(['courseChildren' => function ($query) {
                $query->withCount(['courseSchedules' => function ($query) {
                    $query->whereIn('status', [DBConstant::COURSE_SCHEDULES_STATUS_OPEN, DBConstant::COURSE_SCHEDULES_STATUS_CLOSED, DBConstant::COURSE_SCHEDULES_STATUS_RECORDED]);
                }]);
            }]);

        if ((int)$request->option === Constant::SORT_DATETIME_ASC) {
            $data = $data->orderBy('courses.created_at', Constant::ORDER_BY_ASC);
        } else {
            $data = $data->orderBy('courses.created_at', Constant::ORDER_BY_DESC);
        }

        return $data->paginate($perPage);
    }

    /**
     * @param $courseScheduleId
     * @return mixed
     */
    public function getNumberGiveGift($courseScheduleId)
    {
        return $this->model
            ->join('course_schedules', 'courses.course_id', 'course_schedules.course_id')
            ->join('purchases', 'course_schedules.course_schedule_id', 'purchases.course_schedule_id')
            ->join('purchase_details', 'purchases.purchase_id', 'purchase_details.purchase_id')
            ->where('course_schedules.course_schedule_id', '=', $courseScheduleId)
            ->where('purchase_details.item', '=', DBConstant::PURCHASE_ITEM_GIFT)
            ->get()->pluck('user_id')->unique()->toArray();
    }

    /**
     * Get new course schedule.
     *
     * @return array|mixed
     */
    public function getNewCourseSchedule($csIds, $option = null)
    {
        $userId = auth('client')->id();
        $courseSchedules = $this->model
            ->select(
                'course_schedules.course_schedule_id',
                'course_schedules.title',
                'course_schedules.price',
                'course_schedules.body',
                'course_schedules.status',
                'course_schedules.start_datetime',
                'course_schedules.end_datetime',
                'course_schedules.purchase_deadline',
                'course_schedules.num_of_applicants',
                'course_schedules.actual_start_date',
                'course_schedules.actual_end_date',
                'courses.num_of_ratings',
                'courses.rating',
                'courses.updated_at',
                'users.nickname',
                'courses.user_id',
                'courses.course_id',
                'users.last_name_kanji',
                'users.first_name_kanji',
                'users.name_use',
                'users.profile_image',
                'users.user_type',
                'users.user_status',
                'categories.type as category_type',
                'purchases.user_id as p_user_id'
            )
            ->join('categories', 'courses.category_id', 'categories.category_id')
            ->join('users', 'users.user_id', 'courses.user_id')
            ->join('course_schedules', function ($q) use ($csIds) {
                $q->on('course_schedules.course_id', '=', 'courses.course_id')
                    ->whereIn('course_schedules.course_schedule_id', $csIds);
            })
            ->leftJoin('purchases', function ($q) use ($userId) {
                $q->on('purchases.course_schedule_id', 'course_schedules.course_schedule_id')
                    ->where('purchases.user_id', $userId)
                    ->where('purchases.status', DBConstant::PURCHASES_STATUS_NOT_CAPTURED);
            })
            ->where('courses.type', DBConstant::COURSE_TYPE)
            ->where('courses.status', DBConstant::COURSE_STATUS_OPEN)
            ->with(['courseSchedules' => function ($q) {
                $q->where('course_schedules.status', DBConstant::STATUS_COURSE_SCHEDULE_OPEN)
                    ->whereRaw('course_schedules.num_of_applicants < course_schedules.fixed_num')
                    ->where('course_schedules.purchase_deadline', '>', now())
                    ->orderBy('start_datetime');
            }]);

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
//                $startDateTime = now()->parse($option['startDate'])->startOfDay();
//                $endDateTime = now()->parse($option['startDate'])->endOfDay();
//                $courseSchedules = $courseSchedules->whereBetween('course_schedules.start_datetime', [$startDateTime, $endDateTime]);
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
            if ($option['sort'] === Constant::COURSES_SORT_ORDER_DATE) {
                $courseSchedules = $courseSchedules->orderBy('course_schedules.updated_at', 'DESC');
            } else {
                $courseSchedules = $courseSchedules->orderBy('course_schedules.start_datetime', 'DESC')
                    ->orderBy('course_schedules.status', 'ASC');
            }

            $courseSchedules = $courseSchedules->paginate($option['perPage']);
        } else {
            $courseSchedules = $courseSchedules
                ->orderBy('courses.updated_at', 'DESC')
                ->orderBy('course_schedules.updated_at', 'DESC')
                ->get();

            $this->progressLabel($courseSchedules);
        }
        $this->getImageOfSchedules($courseSchedules);

        return $courseSchedules;
    }

    /**
     * Get Course Viewed Recently.
     *
     * @param $pvIds
     * @return Builder[]|Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function getCourseViewedRecently($pvIds)
    {
        $userId = auth('client')->id();
        $courseSchedules = $this->model
            ->select(
                'course_schedules.course_schedule_id',
                'course_schedules.title',
                'course_schedules.price',
                'course_schedules.status',
                'course_schedules.start_datetime',
                'course_schedules.end_datetime',
                'course_schedules.purchase_deadline',
                'course_schedules.num_of_applicants',
                'course_schedules.fixed_num',
                'courses.num_of_ratings',
                'courses.rating',
                'users.nickname',
                'courses.user_id',
                'courses.course_id',
                'users.last_name_kanji',
                'users.first_name_kanji',
                'users.name_use',
                'users.profile_image',
                'users.user_type',
                'users.user_status',
                'categories.type as category_type',
                'purchases.user_id as p_user_id'
            )
            ->join('categories', 'courses.category_id', 'categories.category_id')
            ->join('users', 'users.user_id', 'courses.user_id')
            ->join('course_schedules', function ($q) {
                $q->on('course_schedules.course_id', '=', 'courses.course_id')
                    ->whereIn('course_schedules.status', [
                        DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                        DBConstant::COURSE_SCHEDULES_STATUS_CLOSED,
                        DBConstant::COURSE_SCHEDULES_STATUS_RECORDED,
                        DBConstant::COURSE_SCHEDULES_STATUS_CANCELED
                    ]);
            })
            ->join('page_views', function ($q) use ($pvIds) {
                $q->on('course_schedules.course_schedule_id', '=', 'page_views.to_course_schedule_id')
                    ->whereIn('page_views.id', $pvIds);
            })
            ->leftJoin('purchases', function ($q) use ($userId) {
                $q->on('purchases.course_schedule_id', 'course_schedules.course_schedule_id')
                    ->where('purchases.user_id', $userId)
                    ->where('purchases.status', DBConstant::PURCHASES_STATUS_NOT_CAPTURED);
            })
            ->where('courses.type', DBConstant::COURSE_TYPE)
            ->with([
                'courseSchedules' => function ($query) {
                    $query->whereRaw('course_schedules.num_of_applicants < course_schedules.fixed_num');
                }
            ])
            ->withCount('courseSchedulesOpenAndClose')
            ->orderBy('page_views.viewed_at', 'desc')
            ->get();

        // check if course schedule is closed
        foreach ($courseSchedules as $course) {
            if ($course->num_of_applicants >= $course->fixed_num) {
                $courseScheduleOpen = $this->model
                    ->select('cs.*')
                    ->where('courses.course_id', $course->course_id)
                    ->join('course_schedules as cs', 'cs.course_id', 'courses.course_id')
                    ->where('cs.status', DBConstant::COURSE_SCHEDULES_STATUS_OPEN)
                    ->orderBy('cs.num_of_applicants', 'asc')
                    ->orderBy('cs.start_datetime', 'asc')->first();
                if ($courseScheduleOpen) {
                    $course->course_schedule_id = $courseScheduleOpen->course_schedule_id;
                    $course->title = $courseScheduleOpen->title;
                    $course->price = $courseScheduleOpen->price;
                    $course->status = $courseScheduleOpen->status;
                    $course->start_datetime = $courseScheduleOpen->start_datetime;
                    $course->end_datetime = $courseScheduleOpen->end_datetime;
                    $course->purchase_deadline = $courseScheduleOpen->purchase_deadline;
                    $course->fixed_num = $courseScheduleOpen->fixed_num;
                    $course->num_of_applicants = $courseScheduleOpen->num_of_applicants;
                    $p = $this->purchaseRepository->findWhere([
                        'course_schedule_id' => $courseScheduleOpen->course_schedule_id,
                        'user_id' => $userId
                    ])->first();
                    $course->p_user_id = $p->user_id ?? null;
                }
            }
        }
        $courseSchedules = $courseSchedules->filter(function ($item) {
            return !($item->status === DBConstant::COURSE_SCHEDULES_STATUS_CANCELED && $item->course_schedules_open_and_close_count === 0);
        });

        $cIds = $courseSchedules->filter(function ($item) {
            return $item->status === 1 || $item->purchase_deadline < now();
        });
        $cIds = $cIds->pluck('course_id')->toArray() ?? [];
        $schedulesOpen = [];
        if (count($cIds)) {
            $schedulesOpen = $this->model
                ->join('course_schedules', function ($q) {
                    $q->on('course_schedules.course_id', '=', 'courses.course_id')
                        ->where('course_schedules.purchase_deadline', '>', now())
                        ->whereRaw('course_schedules.fixed_num > course_schedules.num_of_applicants')
                        ->where('course_schedules.status', DBConstant::COURSE_SCHEDULES_STATUS_OPEN);
                })
                ->whereIn('courses.course_id', $cIds)
                ->select(DB::raw('
                    ROW_NUMBER()
                    OVER(PARTITION BY course_schedules.course_id ORDER BY course_schedules.purchase_deadline ASC) rowNumber,
                    course_schedules.*
                '))
                ->get();
            $schedulesOpen = $schedulesOpen->filter(function ($item) {
                return $item->rowNumber === 1;
            });
        }

        if (count($schedulesOpen)) {
            foreach ($courseSchedules as $s) {
                if ($s->status === DBConstant::COURSE_SCHEDULES_STATUS_CANCELED || $s->purchase_deadline < now()) {
                    $t = $schedulesOpen->filter(function ($item) use ($s) {
                        return $item->course_id === $s->course_id;
                    })->first();
                    if ($t) {
                        $s->course_schedule_id = $t->course_schedule_id;
                        $s->title = $t->title;
                        $s->price = $t->price;
                        $s->status = $t->status;
                        $s->start_datetime = $t->start_datetime;
                        $s->end_datetime = $t->end_datetime;
                        $s->purchase_deadline = $t->purchase_deadline;
                        $s->num_of_applicants = $t->num_of_applicants;
                    }
                }
            }
        }

        $this->progressLabel($courseSchedules);
        $this->getImageOfSchedules($courseSchedules);

        return $courseSchedules;
    }

    public function getDraffCourse($request)
    {
        $perPage = $request->perPage ?? Constant::PER_PAGE_DEFAULT;
        $data = $this->model
            ->leftJoin('course_schedules', 'courses.course_id', '=', 'course_schedules.course_id')
            ->leftJoin('image_paths', function ($q) {
                $q->on('image_paths.course_id', '=', DB::raw('CASE WHEN courses.type = 1 THEN courses.course_id ELSE courses.parent_course_id END'))
                    ->where('display_order', DBConstant::DISPLAY_ORDER_IMAGE_PATH)
                    ->where('image_paths.type', Constant::IMAGE_TYPE)
                    ->where('image_paths.status', Constant::IMAGE_STATUS);
            })
            ->where([
                'courses.user_id' => auth('client')->id(),
                'courses.type' => DBConstant::COURSE_TYPE_MAIN,
                'is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
            ])
//            ->whereIn('courses.type', [DBConstant::COURSE_TYPE_MAIN, DBConstant::COURSE_TYPE_SUB])
            ->whereRaw("CASE
                WHEN course_schedules.status IS NULL THEN courses.status IN(" . DBConstant::COURSE_STATUS_DRAFT . ", " . DBConstant::COURSE_STATUS_PREVIEW . ")
                ELSE course_schedules.status = '" . DBConstant::COURSE_SCHEDULES_STATUS_DRAFT . "' END")
            ->select(
                DB::raw('CASE WHEN course_schedules.title IS NULL THEN courses.title ELSE course_schedules.title END as title'),
                DB::raw('CASE WHEN course_schedules.price IS NULL THEN courses.price ELSE course_schedules.price END as price'),
                'course_schedules.start_datetime',
                'course_schedules.end_datetime',
                'course_schedules.actual_start_date',
                'course_schedules.actual_end_date',
                'course_schedules.group as group',
                'num_of_applicants',
                'dist_method',
                'courses.type',
                'courses.parent_course_id',
                'image_paths.file_name',
                'image_paths.dir_path',
                'canceled_at',
                'course_schedules.course_schedule_id',
                'courses.course_id',
                DB::raw('CASE WHEN course_schedules.updated_at IS NULL THEN courses.updated_at ELSE course_schedules.updated_at END as updated_at'),
                'courses.approval_status',
                'courses.created_at',
                'courses.status',
                DB::raw('course_schedules.status as cs_status'),
                DB::raw('CASE WHEN course_schedules.title IS NULL THEN 1 ELSE ROW_NUMBER() OVER(PARTITION BY course_schedules.group) END as rowNumber')
            );

        switch ($request->option) {
            case Constant::SORT_DATETIME_DESC:
                $data = $data->orderBy(DB::raw("CASE
                    WHEN course_schedules.start_datetime IS NULL THEN courses.updated_at
                    ELSE course_schedules.start_datetime END"), Constant::ORDER_BY_DESC);
                break;
            case Constant::SORT_DATETIME_ASC:
                $data = $data->orderBy(DB::raw("CASE
                    WHEN course_schedules.start_datetime IS NULL THEN courses.updated_at
                    ELSE course_schedules.start_datetime END"), Constant::ORDER_BY_ASC);
                break;
            default:
                $data = $data->orderBy(DB::raw("CASE
                    WHEN course_schedules.start_datetime IS NULL THEN courses.updated_at
                    ELSE course_schedules.start_datetime END"), Constant::ORDER_BY_DESC);
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
        $data = $data->get();
        $temp = $data->filter(function ($item) {
            return (int)$item->rowNumber === 1;
        });
        $page = Paginator::resolveCurrentPage() ?: 1;
        $data = new LengthAwarePaginator(
            $temp->forPage($page, $perPage), $temp->count(), $perPage, $page, ['path' => Paginator::resolveCurrentPath()]
        );
        $this->getImageOfSchedules($data);
        return $data;
    }


    public function countCourseNotApprove()
    {
        return $this->model->where([
            'type' => DBConstant::COURSE_TYPE,
            'dist_method' => DBConstant::DIST_METHOD_LIVE_STREAMING,
            'approval_status' => DBConstant::COURSE_APPROVED_STATUS_PENDING
        ])
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
        })->where(function ($query) {
            $query->where('status', '=', DBConstant::COURSE_STATUS_OPEN)
                ->orWhere('status', '=', DBConstant::COURSE_STATUS_WAIT_APPROVAL);
        })->count();
    }

    /**
     * Get course video call
     * Get all course consultation and fortunetelling.
     *
     * @return mixed
     */
    public function getCourseVideoCall()
    {
        return $this->model
            ->select('courses.*')
            ->join('categories', 'courses.category_id', '=', 'categories.category_id')
            ->where([
                'courses.status' => DBConstant::COURSE_STATUS_OPEN,
                'courses.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
            ])
            ->whereIn('categories.type', [DBConstant::CATEGORY_TYPE_CONSULTATION, DBConstant::CATEGORY_TYPE_FORTUNETELLING])
            ->withCount('courseSchedulesOpenAndDraft')
            ->get();
    }

    public function getCourseDataWithGroup(int $courseId, Request $request)
    {
        $user = auth('client')->user();
        if (!$user) {
            throw new NoAccountException();
        }
        $group = $request->group;
        return $this->model
            ->select(
                'courses.category_id',
                'courses.course_id',
                'courses.dist_method',
                'course_schedules.course_schedule_id',
                'course_schedules.title',
                'course_schedules.subtitle',
                'course_schedules.body',
                'course_schedules.flow',
                'course_schedules.cautions',
                'course_schedules.minutes_required',
                'course_schedules.price',
                'course_schedules.is_mask_required'
            )
            ->where([
                'courses.course_id' => $courseId,
                'user_id' => $user['user_id'],
            ])
            ->join('course_schedules', function ($q) use ($group) {
                $q->on('course_schedules.course_id', '=', 'courses.course_id')
                    ->where('course_schedules.group', $group)
                    ->limit(1);
            })
            ->with(['imagePaths', 'category'])
            ->withCount(['courseSchedules' => function ($q) {
                $q->whereIn('status', [DBConstant::COURSE_SCHEDULES_STATUS_OPEN])
                    ->where('purchase_deadline', '>', now())
                    ->whereRaw('fixed_num > num_of_applicants');
            }])
            ->with(['courseSchedules' => function ($q) use ($group) {
                $q->where('group', $group);
            }])
            ->with(['subCourse' => function ($q) use ($group) {
                $q->with(['courseSchedules' => function ($q2) use ($group) {
                    $q2->whereIn('status', [
                        DBConstant::COURSE_SCHEDULES_STATUS_DRAFT,
                        DBConstant::COURSE_SCHEDULES_STATUS_PREVIEW,
                    ])->where('group', $group);
                }]);
            }])
            ->with(['extensions' => function ($q) use ($group) {
                $q->whereIn('status', [
                    DBConstant::COURSE_SCHEDULES_STATUS_DRAFT,
                    DBConstant::COURSE_SCHEDULES_STATUS_PREVIEW,
                ])->where([
                    'group' => $group,
                    'is_hidden' => DBConstant::COURSE_IS_HIDDEN_OPEN
                ]);
            }])
            ->with(['extensionsPreview' => function ($q) {
                $q->where('status', DBConstant::COURSE_SCHEDULES_STATUS_OPEN);
            }])
            ->withCount(['extensions' => function ($q) {
                $q->where([
                    'status' => DBConstant::COURSE_STATUS_OPEN,
                ]);
            }])
            ->withCount('subCourse')
            ->firstOrFail();
    }

    /**
     * Get course extension not in group.
     *
     * @param $courseId
     * @param $request
     * @return mixed
     */
    public function getScheduleExtensionNotInGroup($courseId, $request)
    {
        $group = $request->group;
        return $this->model
            ->where([
                'parent_course_id' => $courseId,
                'is_hidden' => DBConstant::COURSE_IS_HIDDEN_OPEN
            ])
            ->where('group', '!=', $group)
            ->whereIn('status', [DBConstant::COURSE_STATUS_DRAFT, DBConstant::COURSE_STATUS_OPEN])
            ->count();
    }
}
