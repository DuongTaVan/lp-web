<?php

namespace App\Traits;

use App\Enums\DBConstant;

/**
 * Trait TopLabelTrait
 * @package App\Traits
 */
trait TopLabelTrait
{
    public function progressLabel(&$result)
    {
        $userId = auth('client')->id();

        foreach ($result as $course) {
            $allCourseSchedules = $course->courseSchedules;

            $isPurchase = 0;

            $scheduleStatus = $allCourseSchedules->filter(function ($cs) use (&$isPurchase, $userId) {
                $userPurchased = $this->purchaseRepository->findWhere([
                    'user_id' => $userId,
                    'status' => DBConstant::PURCHASES_STATUS_NOT_CAPTURED,
                    'course_schedule_id' => $cs->course_schedule_id
                ])->count();

                if ($userPurchased) {
                    $isPurchase++;
                }

                return $cs['status'] === DBConstant::COURSE_SCHEDULES_STATUS_OPEN
                    && $cs['purchase_deadline'] > now()->format('Y-m-d H:i:s')
                    && $cs['num_of_applicants'] < $cs['fixed_num'];
            });

            if ($isPurchase > 1) {
                $course['isPurchase'] = true;
            } else {
                $course['isPurchase'] = false;
            }

            $countSchedule = count($scheduleStatus);
            $course['countLoginPurchased'] = $countSchedule - $isPurchase;

            if ($isPurchase = $allCourseSchedules->count()) {
                $course['loginPurchased'] = true;
            } else {
                $course['loginPurchased'] = false;
            }
            if ($countSchedule > 0) {
                $course['count_open'] = $countSchedule;
                $course['is_restock'] = false;
            } else {
                $course['is_restock'] = true;
            }
        }

        return $result;
    }
}
