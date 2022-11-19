<?php


if (!function_exists('schedule_payout')) {
    function schedule_payout()
    {
        $now = now();
        $day = $now->day;
        $month = $now->month;
        if ($day >= 1 && $day < 16) {
            $scheduleDay = 16;
            $scheduleMonth = $month;
        } else {
            $scheduleDay = 1;
            $scheduleMonth = $month + 1;
        }

        return $now->setDays($scheduleDay)->setMonth($scheduleMonth);
    }
}
