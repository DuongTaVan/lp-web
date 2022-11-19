<?php

if (!function_exists('CurrencyFormat')) {
    /**
     * Format currency
     *
     * @param $price
     * @return string
     */
    function formatCurrency($price) : string
    {
        if (isset($price)) {
            return "¥".number_format($price);
        }

        return "";
    }
}
