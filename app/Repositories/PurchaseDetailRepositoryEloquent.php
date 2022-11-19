<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PurchaseDetailRepositoryEloquent.
 */
class PurchaseDetailRepositoryEloquent extends BaseRepository implements PurchaseDetailRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return PurchaseDetail::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get Data Detail.
     *
     * @param $courseScheduleId
     * @return mixed
     */
    public function getDataDetail($courseScheduleId)
    {
        return $this->model
            ->join('purchases as pu', 'purchase_details.purchase_id', '=', 'pu.purchase_id')
            ->leftJoin('course_schedules as cs', 'purchase_details.course_schedule_id', '=', 'cs.course_schedule_id')
            ->leftJoin('gifts', 'purchase_details.gift_id', '=', 'gifts.gift_id')
            ->leftJoin('question_tickets', 'purchase_details.question_ticket_id', '=', 'question_tickets.question_ticket_id')
            ->leftJoin('optional_extras', 'purchase_details.optional_extra_id', '=', 'optional_extras.optional_extra_id')
            ->where([
                'pu.course_schedule_id' => $courseScheduleId,
                'pu.canceled_at' => null,
                'pu.user_id' => auth('client')->id(),
                ['purchase_details.item', '!=', DBConstant::PURCHASE_ITEM_COURSE_TYPE]
            ])
            ->groupBy('gifts.gift_id', 'gift_name',
                DB::raw('CASE WHEN purchase_details.course_schedule_id IS NOT NULL THEN cs.minutes_required ELSE 0 END'),
                'option_title', 'purchase_details.optional_extra_id', 'purchase_details.item'
            )
            ->select(
                'gifts.gift_id', 'gifts.name as gift_name',
                'optional_extras.title as option_title', 'purchase_details.optional_extra_id', 'purchase_details.item',
                DB::raw('CASE WHEN purchase_details.course_schedule_id IS NOT NULL THEN cs.minutes_required ELSE 0 END as minutes_required'),
                DB::raw("sum(purchase_details.quantity) as quantity, sum(purchase_details.total_amount) as total_amount")
            )
            ->get();
    }

    /**
     * Get option from list purchase_id
     *
     * @param array $purchaseIds
     * @return mixed
     */
    public function getOptionByPurchaseId(array $purchaseIds)
    {
        return $this->model
            ->whereIn('purchase_id', $purchaseIds)
            ->where('item', DBConstant::PURCHASE_ITEM_OPTION)
            ->get()
            ->pluck('optional_extra_id')
            ->unique()
            ->toArray();
    }

    /**
     * Get option sales.
     *
     * @param $request
     * @param mixed $courseScheduleId
     * @return mixed
     */
    public function getOptionSales($courseScheduleId)
    {
        return $this->model->join(
            'purchases as pu', 'purchase_details.purchase_id', '=', 'pu.purchase_id'
        )->selectRaw(
            'COUNT(purchase_details.item) as count_item, SUM(purchase_details.total_amount) as sum_total_amount'
        )->where([
            'pu.course_schedule_id' => $courseScheduleId,
            'purchase_details.item' => 'option',
            'pu.canceled_at' => NULL
        ])->first();
    }
}
