<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Models\UserPoint;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserPointRepositoryEloquent.
 */
class UserPointRepositoryEloquent extends BaseRepository implements UserPointRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return UserPoint::class;
    }

    /**
     * Get Decrease expired points.
     *
     * @return mixed
     */
    public function getDecreaseExpiredPoint()
    {
        return $this->model->where([
            'expiration_date' => now()->subDay()->format('Y-m-d'),
            'is_consumed' => DBConstant::USER_POINT_IS_CONSUMED['not_consumed'],
            'is_processed' => DBConstant::USER_POINT_IS_PROCESSED['not_processed'],
        ]);
    }

    /**
     * Get Decrease expired points.
     *
     * @param mixed $userId
     * @return mixed
     */
    public function getCurrentPointByUserId($userId)
    {
        return $this->model->where([
            'user_id' => $userId,
        ])->orderBy('user_point_id', 'DESC')->first();
    }

    /**
     * Get Current Points Balance.
     *
     * @param $userId
     * @return mixed|void
     */
    public function getCurrentPointsBalance($userId)
    {
        return $this->model->where('user_id', $userId)->orderBy('user_point_id', Constant::ORDER_BY_DESC)->first();
    }

    /**
     * Get Target Point Data.
     *
     * @param $userId
     * @return mixed|void
     */
    public function getTargetPoint($userId)
    {
        return $this->model->where([
            ['user_id', '=', $userId],
            ['deposit_points', '!=', null],
            ['is_consumed', '=', DBConstant::NOT_CONSUMED],
        ])->orderBy('user_point_id', Constant::ORDER_BY_ASC)->get();
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get point data.
     *
     * @param $request
     * @return mixed|void
     */
    public function getMyPagePoint($request)
    {
        $userId = Auth::guard('client')->id();
        $perPage = DBConstant::DEFAULT_LIMIT_PURCHASE_POINT;
        $sortColumn = $request->input('sort_column', Constant::USER_POINT_SORT_BY_DEFAULT);
        $sortType = $request->input('sort_by', Constant::ORDER_BY_DESC);
        $year = now()->year;
        if (isset($request->year)) {
            $year = $request->year;
        }
        $yearStartFormat = $year . Constant::START_YEAR_FORMAT;
        $yearEndFormat = $year . Constant::END_YEAR_FORMAT;
        $query = $this->model->leftJoin('reviews as r', 'user_points.review_id', '=', 'r.id'
        )->leftjoin('course_schedules as cs', 'cs.course_schedule_id', '=', 'r.course_schedule_id'
        )->leftjoin('courses as c', 'cs.course_id', '=', 'c.course_id'
        )->leftjoin('image_paths as ip', 'c.course_id', '=', 'ip.course_id'
        )->select(
            'user_points.deposit_points',
            'user_points.deposit_reason',
            'user_points.transacted_at',
            'user_points.withdrawal_points',
            'user_points.expiration_date',
            'user_points.is_consumed',
            'user_points.is_processed',
            'user_points.consumed_points',
            'c.price',
            'ip.file_name',
            'ip.dir_path',
            'c.title'
        )->where([
            'user_points.user_id' => $userId,
            'r.user_id' => $userId,
            'ip.display_order' => DBConstant::IMAGE_COURSE_DISPLAY]
        )->whereBetween('user_points.created_at', [$yearStartFormat, $yearEndFormat]
        )->orderBy($sortColumn, $sortType)->paginate($perPage);
        return [
            'year'=> $year,
            'listPoint'=> $query
        ];
    }
}
