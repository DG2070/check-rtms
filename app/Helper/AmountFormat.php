<?php
/*
 * Copyright © 2022 by SysQube Technology, All rights reserved.
 *
 * Author : Kishor Shrestha (winneecreztha@gmail.com)
 */

namespace App\Helper;


class AmountFormat
{

    /**
     *
     */
    public static function formatNepaliAmount($number)
    {
        $number = (string)$number; // Convert to string
        $len = strlen($number);
        if ($len <= 3) {
            return $number; // No formatting needed for numbers less than 1000
        }

        // Split the number into two parts: last 3 digits and the rest
        $lastThree = substr($number, -3);
        $rest = substr($number, 0, -3);

        // Add commas to the rest of the digits
        $restWithCommas = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest);

        return $restWithCommas . ',' . $lastThree;
    }
}
