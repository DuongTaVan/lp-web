<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Models\Applicant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ApplicantRepositoryEloquent.
 */
class ApplicantRepositoryEloquent extends BaseRepository implements ApplicantRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Applicant::class;
    }

    /**
     * Get Student Cancellation Count.
     *
     * @param $request
     * @return mixed
     */
    public function getStudentCancellationCount($request)
    {
        // Set variable
        $category = $request->category;
        // $month = $request->month;
        $date = [
            'start_date' => $request->start_date ?? now()->firstOfMonth(),
            'end_date' => $request->end_date ?? now()
        ];

        $query = $this->model->join(
            'course_schedules as cs',
            'applicants.course_schedule_id',
            '=',
            'cs.course_schedule_id'
        )->join(
            'courses as co',
            'co.course_id',
            '=',
            'cs.course_id'
        )->join(
            'categories as ca',
            'co.category_id',
            '=',
            'ca.category_id'
        )->where([
            ['applicants.canceled_at', '>=', now()->parse($date['start_date'])],
            ['applicants.canceled_at', '<=', now()->parse($date['end_date'])->endOfDay()],
        ]);

        if ($category) {
            $query->where('ca.type', '=', $category);
        }

        return $query->count('applicants.applicant_id');
    }

    /**
     * Get count of applicants by courseId.
     *
     * @param $request
     * @param mixed $courseId
     * @return mixed
     */
    public function getDataCountByCourseId($courseId)
    {
        return $this->model->join(
            'course_schedules as cs',
            'applicants.course_schedule_id',
            '=',
            'cs.course_schedule_id'
        )->where([
            ['cs.course_id', '=', $courseId],
            ['applicants.created_at', '>=', now()->subDays(Constant::PLAN_ONE_WEEK)->startOfDay()->format('Y-m-d H:i:s')],
            ['applicants.created_at', '<', now()->startOfDay()->format('Y-m-d H:i:s')],
        ])->count('applicants.applicant_id');
    }

    /**
     * Get count and SUM applicants by courseScheduleId.
     *
     * @param mixed $courseScheduleId
     * @return mixed
     */
    public function getDataByCourseScheduleId($courseScheduleId)
    {
        // Set select raw with Sum
        $selectSum = 'COUNT(applicant_id) as count_applicant,
            COALESCE(SUM(is_lappi_new), 0) as sum_is_lappi_new,
            COALESCE(SUM(is_lappi_repeater), 0) as sum_is_lappi_repeater,
            COALESCE(SUM(is_teacher_new), 0) as sum_is_teacher_new,
            COALESCE(SUM(is_teacher_repeater), 0) as sum_is_teacher_repeater,
            COUNT(CASE WHEN u.sex = ' . DBConstant::SEX_OTHER . ' THEN 1 ELSE NULL END) as count_sales_hidden_male,
            COUNT(CASE WHEN u.sex = ' . DBConstant::SEX_MALE . ' THEN 1 ELSE NULL END) as count_sales_male,
            COUNT(CASE WHEN u.sex = ' . DBConstant::SEX_FEMALE . ' THEN 1 ELSE NULL END) as count_sales_female,
            COUNT(CASE WHEN u.sex = ' . DBConstant::SEX_NOT_APPLICABLE . ' THEN 1 ELSE NULL END) as count_sales_unapplicable,
            COUNT(CASE WHEN YEAR(u.date_of_birth) > ' . now()->subYears(Constant::AGE_YEAR_20)->format('Y') .
            ' AND YEAR(u.date_of_birth) <= ' . now()->format('Y') . ' THEN 1 ELSE NULL END) as count_sales_10s,
            COUNT(CASE WHEN YEAR(u.date_of_birth) > ' . now()->subYears(Constant::AGE_YEAR_30)->format('Y') .
            ' AND YEAR(u.date_of_birth) <= ' . now()->subYears(Constant::AGE_YEAR_20)->format('Y') . ' THEN 1 ELSE NULL END) as count_sales_20s,
            COUNT(CASE WHEN YEAR(u.date_of_birth) > ' . now()->subYears(Constant::AGE_YEAR_40)->format('Y') .
            ' AND YEAR(u.date_of_birth) <= ' . now()->subYears(Constant::AGE_YEAR_30)->format('Y') . ' THEN 1 ELSE NULL END) as count_sales_30s,
            COUNT(CASE WHEN YEAR(u.date_of_birth) > ' . now()->subYears(Constant::AGE_YEAR_50)->format('Y') .
            ' AND YEAR(u.date_of_birth) <= ' . now()->subYears(Constant::AGE_YEAR_40)->format('Y') . ' THEN 1 ELSE NULL END) as count_sales_40s,
            COUNT(CASE WHEN YEAR(u.date_of_birth) > ' . now()->subYears(Constant::AGE_YEAR_60)->format('Y') .
            ' AND YEAR(u.date_of_birth) <= ' . now()->subYears(Constant::AGE_YEAR_50)->format('Y') . ' THEN 1 ELSE NULL END) as count_sales_50s,
            COUNT(CASE WHEN YEAR(u.date_of_birth) <= ' . now()->subYears(Constant::AGE_YEAR_60)->format('Y') .
            ' THEN 1 ELSE NULL END) as count_sales_60s';

        return $this->model->join(
            'users as u', 'applicants.user_id', '=', 'u.user_id'
        )->selectRaw($selectSum)->where([
            'course_schedule_id' => $courseScheduleId,
            'canceled_at' => null,
        ])->first();
    }

    /**
     * Get teacher repeat count.
     *
     * @param $studentId
     * @param $teacherId
     * @return mixed|void
     */
    public function getTeacherRepeatCount($studentId, $teacherId)
    {
        return $this->model
            ->selectRaw('COUNT(applicants.applicant_id) as teacher_repeat_count')
            ->join('course_schedules as cs', 'applicants.course_schedule_id', '=', 'cs.course_schedule_id')
            ->join('courses as co', 'cs.course_id', '=', 'co.course_id')
            ->where([
                'applicants.user_id' => $studentId,
                'co.user_id' => $teacherId,
            ])
            ->first();
    }

    /**
     * Get Last Purchase Date.
     *
     * @param $studentId
     * @param $teacherId
     * @return mixed|void
     */
    public function getLastPurchaseDate($studentId, $teacherId)
    {
        return $this->model
            ->select('applicants.created_at')
            ->join('course_schedules as cs', 'applicants.course_schedule_id', '=', 'cs.course_schedule_id')
            ->join('courses as co', 'cs.course_id', '=', 'co.course_id')
            ->where([
                'applicants.user_id' => $studentId,
                'co.user_id' => $teacherId,
            ])
            ->orderBy('applicants.created_at', Constant::ORDER_BY_DESC)
            ->first();
    }

    /**
     * Count applicant By UserId.
     *
     * @param $userId
     * @return mixed|void
     */
    public function countApplicantByUserId($userId)
    {
        return $this->model->selectRaw('COUNT(applicant_id) as count')->where('user_id', $userId)->first();
    }

    /**
     * Count Teacher By UserId.
     *
     * @param $userId
     * @param $teacher
     * @return mixed|void
     */
    public function countTeacherByUserId($userId, $teacher)
    {
        return $this->model
            ->selectRaw('COUNT(applicants.applicant_id) as count')
            ->join('course_schedules as cs', 'applicants.course_schedule_id', '=', 'cs.course_schedule_id')
            ->join('courses as co', 'cs.course_id', '=', 'co.course_id')
            ->where([
                'applicants.user_id' => $userId,
                'co.user_id' => $teacher,
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
     * Count holding result.
     *
     * @param $userId
     * @return mixed
     */
    public function countHoldingResult($userId)
    {
        return $this->model
            ->join('course_schedules', 'applicants.course_schedule_id', '=', 'course_schedules.course_schedule_id')
            ->join('courses', 'course_schedules.course_id', '=', 'courses.course_id')
            ->where([
                'courses.user_id' => $userId,
                'course_schedules.type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
            ])
            ->whereBetween('course_schedules.status', [DBConstant::COURSE_SCHEDULES_STATUS_CLOSED, DBConstant::COURSE_SCHEDULES_STATUS_RECORDED])
            ->whereNull('applicants.canceled_at')
            ->count();
    }

    /**
     * Get user has already purchased course.
     *
     * @param array $data
     * @param $userId
     * @return mixed
     */
    public function getUserHasAlreadyPurchasedCourse(array $data, $userId)
    {
        return $this->model
            ->join('course_schedules', 'applicants.course_schedule_id', '=', 'course_schedules.course_schedule_id')
            ->join('purchases', function ($query) {
                $query->on('purchases.user_id', 'applicants.user_id');
                $query->on('purchases.course_schedule_id', 'applicants.course_schedule_id');
                $query->whereIn('purchases.status', [DBConstant::PURCHASES_STATUS_NOT_CAPTURED, DBConstant::PURCHASES_STATUS_CAPTURED]);
            })
            ->where([
                'applicants.user_id' => $userId,
                'applicants.course_schedule_id' => $data['course_schedule_id'],
            ])
            ->whereNull('applicants.canceled_at')
            ->get();
    }

    /**
     * Get student's cancellation count.
     *
     * @param $request
     * @param $data
     * @return mixed
     */
    public function getCountStudentCancellation($request, $data)
    {
        $data = $this->model
            ->join('course_schedules', 'course_schedules.course_schedule_id', '=', 'applicants.course_schedule_id')
            ->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->join('categories', 'courses.category_id', '=', 'categories.category_id')
            ->where('courses.user_id', $data['userId'])
            ->where('applicants.canceled_at', '>=', $data['startDate'])
            ->where('applicants.canceled_at', '<=', $data['endDate']);

        if ($request->has('category') && $request->category) {
            $data->where('categories.type', $request->category);
        }

        return $data->count();
    }

    /**
     * Get Applicant With Course Schedule.
     *
     * @param $courseScheduleId
     * @return mixed|void
     */
    public function getApplicantWithCourseSchedule($courseScheduleId)
    {
        return $this->model
            ->select('cs.start_datetime as startDateTime')
            ->join('course_schedules as cs', 'applicants.course_schedule_id', '=', 'cs.course_schedule_id')
            ->where([
                'applicants.user_id' => auth('client')->user()->user_id,
                'applicants.course_schedule_id' => $courseScheduleId,
                'applicants.canceled_at' => null,
                'cs.status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                'cs.canceled_at' => null,
            ])->first();
    }

    /**
     * Get applicant.
     *
     * @param $courseScheduleId
     * @return mixed|void
     */
    public function getApplicant($courseScheduleId)
    {
        return $this->model->where([
            'user_id' => auth('client')->user()->user_id,
            'course_schedule_id' => $courseScheduleId,
        ]);
    }

    /**
     * Get List Applicant.
     *
     * @param $data
     * @return mixed|void
     */
    public function getListApplicant($data)
    {
        return $this->model
            ->join('users as u', 'applicants.user_id', '=', 'u.user_id')
            ->where([
                'applicants.course_schedule_id' => $data['course_schedule_id'],
                'applicants.canceled_at' => null,
            ])
            ->orderBy('applicants.created_at', Constant::ORDER_BY_ASC)
            ->take($data['per_page'])
            ->offset($data['per_page'] * ($data['page'] - 1))
            ->get();
    }

    /**
     * Check if the user has course schedules which he will participate in.
     *
     * @param $userId
     * @return mixed|void
     */
    public function getParticipateCourseSchedule($userId)
    {
        return $this->model
            ->join('course_schedules as cs', 'applicants.course_schedule_id', '=', 'cs.course_schedule_id')
            ->join('courses as co', 'cs.course_id', '=', 'co.course_id')
            ->where([
                'applicants.user_id' => $userId,
                'applicants.canceled_at' => null,
                'cs.status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                'co.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
            ])->get();
    }

    /**
     * Get Count Applicant.
     *
     * @param $courseId
     * @return mixed|void
     */
    public function getCountApplicant($courseId)
    {
        return $this->model
//            ->selectRaw('COUNT(applicants.applicant_id) as count')
            ->join('course_schedules as cs', 'applicants.course_schedule_id', '=', 'cs.course_schedule_id')
            ->where([
                'cs.course_id' => $courseId,
                'cs.type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
            ])
            ->whereNull('applicants.canceled_at')
            ->whereIn('cs.status', [DBConstant::COURSE_SCHEDULES_STATUS_CLOSED, DBConstant::COURSE_SCHEDULES_STATUS_RECORDED])
            ->get()->count();
    }

    /**
     * update cancel order confirm.
     *
     * @param $courseScheduleId
     * @return mixed
     */
    public function cancelOrderConfirm($courseScheduleId)
    {
        $applicant = $this->model->where('user_id', auth('client')->user()->user_id)->where('course_schedule_id', $courseScheduleId)->firstOrFail();
        return $applicant->update(['canceled_at' => now()]);
    }

    /**
     * Get user pay course schedule.
     *
     * @return mixed
     */
    public function getUserPayCourseSchedule()
    {
        return $this->model->where([
            'applicants.canceled_at' => null,
        ])->where(DB::raw("(DATE_FORMAT(created_at, '%Y-%m-%d'))"), "<>", Carbon::now()->format('Y-m-d'))->get()->unique('user_id')->toArray();
    }
}
