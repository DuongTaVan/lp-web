<?php

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PurchaseRepository;
use App\Models\Purchase;
use App\Validators\PurchaseValidator;

/**
 * Class PurchaseRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PurchaseRepositoryEloquent extends BaseRepository implements PurchaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Purchase::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get Stripe settlements (Not captured || captured) to be canceled.
     *
     * @param $courseScheduleId
     * @param $status
     * @return mixed
     */
    public function getStripeSettlement($courseScheduleId, $status)
    {
        return $this->model
            ->join('settlements', 'settlements.purchase_id', '=', 'purchases.purchase_id')
            ->where('purchases.course_schedule_id', $courseScheduleId)
            ->where('purchases.status', $status)
            ->get();
    }

    /**
     * Get purchase by order_no
     * @param $orderNo
     */
    public function getPurchaseByOrderNo($orderNo)
    {
        return $this->model
            ->with(['purchaseDetails' => function ($query) {
                $query->whereNotNull('optional_extra_id');
            }, 'purchaseDetails.optionalExtra'])
            ->where('order_no', $orderNo)->first();
    }

    /**
     * Get first use buy course
     *
     * @param $courseScheduleId
     * @return mixed
     */
    public function getFirstPurchaseCourse($courseScheduleId)
    {
        return $this->model
            ->join('settlements', 'settlements.purchase_id', '=', 'purchases.purchase_id')
            ->where('purchases.course_schedule_id', $courseScheduleId)
            ->whereIn('purchases.status', [DBConstant::PURCHASES_STATUS_NOT_CAPTURED, DBConstant::PURCHASES_STATUS_CAPTURED])
            ->orderBy('purchases.created_at', 'asc')
            ->select('purchases.created_at')
            ->first();
    }

    /**
     * Get user purchase by userId courseScheduleId
     *
     * @param $userId
     * @param $courseScheduleId
     * @return mixed
     */
    public function getPurchaseByUserCourseSchedule($userId, $courseScheduleId)
    {
        return $this->model
            ->where('user_id', $userId)
            ->where('course_schedule_id', $courseScheduleId)
            ->whereIn('status', [DBConstant::PURCHASES_STATUS_CAPTURED, DBConstant::PURCHASES_STATUS_CANCELED_AFTER_CAPTURE, DBConstant::PURCHASES_STATUS_NOT_CAPTURED])
            ->select('user_id')
            ->first();
    }

    /**
     * Get user pay course schedule success .
     *
     * @param $courseScheduleId
     * @return mixed
     */
    public function getUserPayCourseScheduleSuccess($courseScheduleId)
    {
        return $this->model
            ->join('purchase_details', 'purchase_details.purchase_id', 'purchases.purchase_id')
            ->where('purchase_details.item', '=', Constant::COURSE_TEXT)
            ->where([
                'purchases.course_schedule_id' => $courseScheduleId,
                'purchases.status' => DBConstant::PURCHASES_STATUS_CAPTURED
            ])->get();
    }
}
