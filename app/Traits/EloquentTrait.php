<?php

namespace App\Traits;

use App\Enums\Constant;
use App\Enums\DBConstant;
use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

/**
 * Trait EloquentTrait
 * @package App\Traits
 */
trait EloquentTrait
{
    /**
     * Set Value With Category Type
     *
     * @param $categoryType
     * @param $pair
     * @return int
     */
    public function setValueWithCategoryType($categoryType, $pair)
    {
        if (is_null($categoryType)) {
            return Constant::IS_NOT_ACTIVE;
        }

        // Get pair category to check with category_type
        $pairCategory = $this->setPairCategory($pair);

        switch (true) {
            case in_array($categoryType, $pairCategory):
                return Constant::IS_ACTIVE;
            default:
                return Constant::IS_NOT_ACTIVE;
        }
    }

    /**
     * Set Pair Category
     * 
     * @param $pair
     * @return array
     */
    public function setPairCategory($pair)
    {
        switch ($pair) {
            case Constant::PAIR_CATEGORY_1:
                return [DBConstant::LIST_CATEGORY_TYPE['all'], DBConstant::LIST_CATEGORY_TYPE['live_stream']];
            case Constant::PAIR_CATEGORY_2:
                return [DBConstant::LIST_CATEGORY_TYPE['all'], DBConstant::LIST_CATEGORY_TYPE['trouble_consultation']];
            case Constant::PAIR_CATEGORY_3:
                return [DBConstant::LIST_CATEGORY_TYPE['all'], DBConstant::LIST_CATEGORY_TYPE['fortune_telling']];
            default:
                return [DBConstant::LIST_CATEGORY_TYPE['all']];
        }
    }

    /**
     * Set time for date time.
     *
     * @param $formatDate
     * @param $time
     * @return mixed
     */
    public function setTimeForDate($formatDate,$time)
    {
        $hour = date('H',strtotime($time));
        $minute = date('i',strtotime($time));
        $second = date('s',strtotime($time));

       return $formatDate->setTime($hour,$minute, $second);
    }

    /**
     * Paginate collection.
     *
     * @param Collection $results
     * @param $pageSize
     * @return LengthAwarePaginator
     */
    public function paginateCollection(Collection $results, $pageSize)
    {
        $page = Paginator::resolveCurrentPage('page');

        $total = $results->count();

        return self::paginator($results->forPage($page, $pageSize), $total, $pageSize, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

    }

    /**
     * Create a new length-aware paginator instance.
     *
     * @param  \Illuminate\Support\Collection  $items
     * @param  int  $total
     * @param  int  $perPage
     * @param  int  $currentPage
     * @param  array  $options
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }

}
