<?php

namespace App\Helpers;

class NumberFormatHelper {
    public static function formatToComaDecimalSeparator($number) {
        return number_format($number, 2, ',', '.');
    }

    public static function formatToDotDecimalSeparator($number) {
        return number_format($number, 2, '.', ',');
    }
}
