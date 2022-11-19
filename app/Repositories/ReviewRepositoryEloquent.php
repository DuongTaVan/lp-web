<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ReviewRepositoryEloquent.
 */
class ReviewRepositoryEloquent extends BaseRepository implements ReviewRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Review::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get list review.
     *
     * @param array $data
     * @return mixed
     */
    public function listReview($userID)
    {
        return $this->model
            ->select('reviews.*', 'users.user_type', 'users.user_id', 'users.nickname', 'users.last_name_kanji', 'users.first_name_kanji', 'users.last_name_kana', 'users.first_name_kana',
                'users.date_of_birth', 'users.name_use', 'users.sex', 'users.profile_image', 'course_schedules.start_datetime')
            ->join('course_schedules', 'reviews.course_schedule_id', '=', 'course_schedules.course_schedule_id')
            ->join('courses', 'course_schedules.course_id', '=', 'courses.course_id')
            ->join('users', 'reviews.user_id', '=', 'users.user_id')
            ->where('courses.user_id', $userID)
            ->orderBy('reviews.created_at', 'DESC')
            ->paginate(Constant::PAGINATE_LIST_REVIEW);
    }

    /**
     * Get the number of newly registered users.
     *
     * @param $month
     * @param $userType
     * @return mixed
     */
    public function getNewlyUsers($month, $userType)
    {
        return $this->model->where([
            'user_type' => $userType,
            ['created_at', '>=', now()->parse($month)->firstOfMonth()->format('Y-m-d H:i:s')],
            ['created_at', '<=', now()->parse($month)->lastOfMonth()->endOfDay()],
        ])->get();
    }

    /**
     * Get list review of teacher.
     *
     * @param $perPage
     * @param $id
     * @return mixed
     */
    public function listReviewOfTeacher($perPage, $id)
    {
        return $this->model
            ->join('users', 'reviews.user_id', '=', 'users.user_id')
            ->where('course_schedule_id', $id)->orderBy('reviews.created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get Avg Rating.
     *
     * @return mixed|void
     */
    public function getAvgRating()
    {
        return $this->model
            ->selectRaw('DISTINCT(reviews.user_id),AVG(reviews.rating) as avg_rating')
            ->join('users as u', 'reviews.user_id', '=', 'u.user_id')
            ->groupBy('reviews.user_id');
    }

    /**
     * Get Avg Rating coures schedule by id.
     *
     * @return mixed|void
     * @param $id
     */

    public function getRatingCourseScheduleById($userId)
    {
        return $this->model
            ->selectRaw('AVG(reviews.rating) as avg_rating, COUNT(reviews.rating) as totalRecord')
            ->join('course_schedules as cs', 'reviews.course_schedule_id', '=', 'cs.course_schedule_id')
            ->join('courses as c', 'cs.course_id', '=', 'c.course_id')
            ->where('c.user_id', $userId)
            ->get();
    }


    /**
     * Get Avg Rating By TargetDate.
     *
     * @param $periodDaysStandard
     * @return mixed|void
     */
    public function getAvgRatingByTargetDate($periodDaysStandard)
    {
        return $this->model
            ->selectRaw('DISTINCT(reviews.user_id),AVG(reviews.rating) as avg_rating')
            ->join('users as u', 'reviews.user_id', '=', 'u.user_id')
            ->groupBy('reviews.user_id')
            ->where('reviews.created_at', '>=', now()->subDays($periodDaysStandard));
    }

    public function getReviewData($courseId)
    {
        return $this->model->select(
            'reviews.*', 'u.nickname', 'u.last_name_kanji', 'u.name_use', 'u.user_type',
            'u.first_name_kanji', 'profile_image', 'date_of_birth', 'sex',
            'cs.start_datetime'
        )
            ->join('users as u', 'reviews.user_id', '=', 'u.user_id')
            ->join('course_schedules as cs', 'reviews.course_schedule_id', '=', 'cs.course_schedule_id')
            ->where('cs.course_id', $courseId)
            ->orderBy('reviews.rating', Constant::ORDER_BY_DESC)
            ->paginate(Constant::REVIEW_LIMIT);
    }

    /**
     * Sale history review
     *
     * @param $courseScheduleId
     * @param $request
     * @return mixed
     */
    public function saleHistoryReview($courseScheduleId, $request)
    {
        $isOption = $this->isOptionReviewList($request);
        return $this->listHistoryReview($isOption['orderBy'], $courseScheduleId);
    }

    /**
     * Get option review list.
     *
     * @param $request
     * @return array
     */
    public function isOptionReviewList($request)
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
     * List history review
     *
     * @param $orderBy
     * @param $courseScheduleId
     * @return mixed
     */
    public function listHistoryReview($orderBy, $courseScheduleId)
    {
        return $this->model
            ->select('reviews.*',
                'course_schedules.start_datetime',
                'course_schedules.end_datetime',
                'course_schedules.price',
                'course_schedules.title',
                'users.nickname',
                'users.user_type',
                'users.profile_image',
                'users.name_use',
                'users.last_name_kanji',
                'users.first_name_kanji',
                'users.date_of_birth',
                'users.sex',
                DB::raw("MAX(image_paths.dir_path) as dir_path"),
                DB::raw("MAX(image_paths.file_name) as file_name"))
            ->join('users', 'reviews.user_id', '=', 'users.user_id')
            ->join('course_schedules', 'reviews.course_schedule_id', '=', 'course_schedules.course_schedule_id')
            ->join('courses', 'courses.course_id', '=', 'course_schedules.course_id')
            ->leftJoin('image_paths', function ($q) {
                $q->on('image_paths.course_id', '=', 'course_schedules.course_id')
                    ->where('image_paths.display_order', DBConstant::DISPLAY_ORDER_IMAGE_PATH)
                    ->where('image_paths.type', Constant::IMAGE_TYPE)
                    ->where('image_paths.status', Constant::IMAGE_STATUS);
            })
            ->where('reviews.course_schedule_id', $courseScheduleId)
            ->where('courses.user_id', auth('client')->user()->user_id)
            ->orderBy('reviews.created_at', $orderBy)
            ->groupBy('reviews.id')
            ->paginate(Constant::REVIEW_LIMIT);
    }
}
