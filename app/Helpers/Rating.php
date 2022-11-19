<?php

if (!function_exists('ratingProcess')) {
    /**
     * format Month Year
     *
     * @param $date
     * @return string
     */
    function ratingProcess($avgRating)
    {
        return floor($avgRating * 10) / 10;
    }
}
