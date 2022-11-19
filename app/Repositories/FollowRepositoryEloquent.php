<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Models\Follow;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class FollowRepositoryEloquent.
 */
class FollowRepositoryEloquent extends BaseRepository implements FollowRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Follow::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get list follow.
     *
     * @param $request
     * @return mixed
     */
    public function myPageFollowList($request)
    {
        $perPage = DBConstant::DEFAULT_LIMIT_PURCHASE_POINT;
        $sortColumn = $request->input('sort_column', Constant::FOLLOW_SORT_BY_DEFAULT);
        $sortType = $request->input('sort_by', Constant::ORDER_BY_DESC);
        $query = $this->model->join('users as u', 'follows.to_user_id', '=', 'u.user_id')
            ->where([
                'from_user_id' => auth('client')->id(),
                'u.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
            ])
            ->select('u.nickname', 'u.first_name_kanji', 'u.last_name_kanji', 'u.name_use', 'follows.created_at', 'u.sex', 'follows.to_user_id');
        return $query->orderBy($sortColumn, $sortType)->paginate($perPage);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getFollowByUserId($request)
    {
        $isOption = $this->isOptionFollower($request);
        return $this->studentFollow($isOption['orderBy']);
    }

    /**
     * @return mixed
     */
    public function getTotalFollowByUserId()
    {
        return  $this->model
            ->select('follows.created_at', 'follows.teacher_repeat_count', 'follows.last_purchased_at', 'u.nickname', 'u.sex', 'u.date_of_birth', 'u.user_type', 'u.name_use', 'u.last_name_kanji', 'u.first_name_kanji')
            ->join('users as u', 'follows.from_user_id', '=', 'u.user_id')
            ->where('follows.to_user_id', auth('client')->user()->user_id)
            ->paginate(Constant::PAGINATE_LIST_FOLLOWER)->total();
    }

    /**
     * Get option student list.
     *
     * @param $request
     *
     * @return array
     */
    public function isOptionFollower($request)
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
     * Get follow By session user.
     *
     * @return mixed
     */
    public function studentFollow($orderBy)
    {
        return $this->model
            ->select('follows.created_at', 'follows.teacher_repeat_count', 'follows.last_purchased_at', 'u.nickname', 'u.sex', 'u.date_of_birth', 'u.user_type', 'u.name_use', 'u.last_name_kanji', 'u.first_name_kanji')
            ->join('users as u', 'follows.from_user_id', '=', 'u.user_id')
            ->where('follows.to_user_id', auth('client')->user()->user_id)
            ->orderBy('follows.created_at', $orderBy)
            ->paginate(Constant::PAGINATE_LIST_FOLLOWER);
    }

    /**
     * Get Count Follow.
     *
     * @param $userId
     * @return mixed|void
     */
    public function getCountFollow($userId)
    {
        return $this->model->where('to_user_id', $userId)->get()->count();
    }

    /**
     * Get count follow in month.
     *
     * @param $userId
     * @param $data
     * @return mixed
     */
    public function getCountFollowInMonth($userId, $data)
    {
        return $this->model->selectRaw('COUNT(to_user_id) as amount_follower')->where('to_user_id', $userId)->whereBetween('created_at', [$data['startDate'], $data['endDate']])->first();
    }
}
