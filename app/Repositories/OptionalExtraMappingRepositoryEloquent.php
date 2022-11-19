<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\Constant;
use App\Models\OptionalExtraMapping;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class OptionalExtraMappingRepositoryEloquent.
 */
class OptionalExtraMappingRepositoryEloquent extends BaseRepository implements OptionalExtraMappingRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return OptionalExtraMapping::class;
    }

//    /**
//     * Get option sales.
//     *
//     * @param $request
//     * @param mixed $courseScheduleId
//     * @return mixed
//     */
//    public function getOptionSales($courseScheduleId)
//    {
//        return $this->model->join(
//            'optional_extras as oe', 'optional_extra_mappings.optional_extra_id', '=', 'oe.optional_extra_id'
//        )->selectRaw(
//            'COUNT(optional_extra_mappings.optional_extra_id) as count_optional_extra_id, SUM(oe.price) as sum_price'
//        )->where(['course_schedule_id' => $courseScheduleId])->first();
//    }

    /**
     * Get Option Data.
     *
     * @param $courseScheduleId
     * @return mixed|void
     */
    public function getOptionData($courseScheduleId)
    {
        return $this->model
            ->select('optional_extra_mappings.*','oe.price', 'oe.title')
            ->join('optional_extras as oe', 'optional_extra_mappings.optional_extra_id', '=', 'oe.optional_extra_id')
            ->where([
                'optional_extra_mappings.course_schedule_id' => $courseScheduleId,
            ])
            ->orderBy('oe.optional_extra_id', Constant::ORDER_BY_ASC)
            ->get();
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
