<?php

namespace App\Repositories;

use App\Enums\Constant;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OptionalExtraRepository;
use App\Models\OptionalExtra;
use App\Validators\OptionalExtraValidator;

/**
 * Class OptionalExtraRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OptionalExtraRepositoryEloquent extends BaseRepository implements OptionalExtraRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OptionalExtra::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get optional extra
     *
     * @param array $data
     * @return mixed
     */
    public function getOptionalExtra(array $data)
    {
        return $this->model
            ->join('optional_extra_mappings', 'optional_extras.optional_extra_id', '=', 'optional_extra_mappings.optional_extra_id')
            ->whereIn('optional_extras.optional_extra_id', $data['optional_extra_ids'])
            ->where('optional_extra_mappings.course_schedule_id', $data['course_schedule_id'])
            ->get();
    }

    /**
     * Get optional extra
     *
     * @param $courseId
     * @return mixed
     */
    public function getOptionExtraPreview($courseId)
    {
        return $this->model
            ->select('optional_extras.optional_extra_id', 'optional_extras.title', 'optional_extras.price')
            ->where(['optional_extras.course_id' => $courseId])
            ->orderBy('optional_extras.optional_extra_id', Constant::ORDER_BY_ASC)
            ->get();
    }
}
