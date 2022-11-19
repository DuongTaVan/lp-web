<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Favorite;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class FavoriteRepositoryEloquent.
 */
class FavoriteRepositoryEloquent extends BaseRepository implements FavoriteRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Favorite::class;
    }

    /**
     * Get Count Course Schedule.
     *
     * @return mixed|void
     */
    public function getCountCourseSchedule()
    {
        return $this->model->selectRaw('COUNT(course_schedule_id) as fcsi, course_schedule_id')->groupBy('course_schedule_id');
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getLikeSubCourse($listCourseScheduleId, $data)
    {
        return $this->model->selectRaw('COUNT(course_schedule_id) as likeSubCourse')->whereIn('course_schedule_id', $listCourseScheduleId)->whereBetween('created_at', [$data['startDate'], $data['endDate']])->first();
    }
}
