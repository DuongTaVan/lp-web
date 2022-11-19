<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PurchaseRepository.
 *
 * @package namespace App\Repositories;
 */
interface PurchaseRepository extends RepositoryInterface
{
    /**
     * Get Stripe settlements (Not captured || captured) to be canceled.
     *
     * @param $courseScheduleId
     * @param $status
     * @return mixed
     */
    public function getStripeSettlement($courseScheduleId, $status);

    /**
     * @param $orderNo
     * @return mixed
     */
    public function getPurchaseByOrderNo($orderNo);

    /**
     * Get first use buy course
     *
     * @param $courseScheduleId
     * @return mixed
     */
    public function getFirstPurchaseCourse($courseScheduleId);

    /**
     * Get user purchase by userId courseScheduleId
     *
     * @param $userId
     * @param $courseScheduleId
     * @return mixed
     */
    public function getPurchaseByUserCourseSchedule($userId, $courseScheduleId);

    /**
     * Get user pay course schedule success .
     *
     * @param $courseScheduleId
     * @return mixed
     */
    public function getUserPayCourseScheduleSuccess($courseScheduleId);
}
