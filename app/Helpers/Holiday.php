<?php

use Japanese\Holiday\Repository as HolidayRepository;

if (!function_exists('holiday')) {
    function holiday($scheduleDate, $inputDate = null)
    {
        $holidayRepository = new HolidayRepository();

        $newDate = now()->parse($scheduleDate);

        for($i = 0; $i < 3; $i++) {
            $newDate->addDay();
            while ($newDate->isSaturday() || $newDate->isSunday() || $holidayRepository->isHoliday($newDate->format('Y-m-d'))) {
                $newDate->addDay();
            }
        }

        return $newDate->format('Y-m-d');
    }
}
