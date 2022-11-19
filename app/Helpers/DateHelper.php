<?php

use Carbon\CarbonPeriod;

if (!function_exists('getAllMonth')) {
    /**
     * Get All Month
     *
     * @param $firstMonth
     * @param $lastMonth
     * @return array[]
     */
    function getAllMonth($firstMonth, $lastMonth): array
    {
        $period = CarbonPeriod::create($firstMonth, '1 month', $lastMonth);

        // Iterate over the period
        $dates = [];
        foreach ($period as $key => $date) {
            $dates[$key]['date'] = $date->format('Y-m');
            $dates[$key]['text'] = $date->format('Y年m月');
        }

        return $dates;
    }
}

if (!function_exists('getHoursMinute')) {
    /**
     * Get All Hours Minute
     *
     * @param $number
     */
    function getHoursMinute($number)
    {
            $hr = floor($number/60);
            $min = $number % 60;
            $allocateMessage = $hr . '時間'. $min . '分';
            return $allocateMessage;
    }
}

if (!function_exists('convertStringBase36')) {
    function convertStringBase36(): string
    {
        for ($i = 0; $i < 19; $i ++) {
            $randomInt[] = rand(0, 9);
        }

        // randomInt is 19 character number
        $convertBase36 = base_convert(implode("", $randomInt), 10, 36);

        return strtoupper(substr($convertBase36, 0, 4) .'-'.substr($convertBase36, 4, 4).'-'.substr($convertBase36, 8, 4));
    }
}

if (!function_exists('formatTimeFrame')) {
    /**
     * Format time frame.
     *
     * @param $startDateTime
     * @param $minusRequired
     * @return array[]
     */
    function formatTimeFrame($startDateTime, $minusRequired)
    {
        $allocateMessage = '';
        $time = now()->parse($startDateTime);
        $endTime = $time->addMinutes($minusRequired);
        $allocateMessage .= now()->parse($startDateTime)->format('H:i') . ' - ' . $endTime->format('H:i') . ' ';

        return $allocateMessage;
    }
}

if (!function_exists('formatMonthYear')) {
    /**
     * format Month Year
     *
     * @param $date
     * @return string
     */
    function formatMonthYear($date): string
    {
        $date = \Carbon\Carbon::parse($date);

        return $date->month.'月'.$date->day.'日';
    }
}

if (!function_exists('formatDayTime')) {
    /**
     * format time
     *
     * @param $date
     * @return string
     */
    function formatDayTime($date): string
    {
        return \Carbon\Carbon::parse($date)->tz(config('app.timezone'))->format('H:i');
    }
}

if (!function_exists('formatTime')) {
    /**
     * Format time
     *
     * @param $time
     * @param string $format
     * @return string
     */
    function formatTime($time, $format = 'Y/m/d') {
        return \Carbon\Carbon::parse($time)->tz(config('app.timezone'))->format($format);
    }
}
