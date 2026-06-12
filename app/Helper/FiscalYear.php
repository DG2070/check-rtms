<?php
/*
 * Copyright © 2022 by SysQube Technology, All rights reserved.
 *
 * Author : Kishor Shrestha (winneecreztha@gmail.com)
 */

namespace App\Helper;

use Carbon\Carbon;

class FiscalYear
{
    /**
     *  returns fiscal year in BS in following format
     *  "79/80"
     *  "80/81"
     */
    public static function curentFiscalYear()
    {
        $primaryYear = 0;
        $secondaryYear = 0;
        $primary_year_valid_months = [4, 5, 6, 7, 8, 9, 10, 11, 12];
        $secondary_year_valid_month = [1, 2, 3];

        $todayDate = now();
        $nepali_date = DateConverter::fromEnglishDate(
            $todayDate->year,
            $todayDate->month,
            $todayDate->day,
        )->toNepaliDateArray();

        //-- Check if year is in primary year
        if (in_array($nepali_date['month'], $primary_year_valid_months)) {
            $primaryYear = $nepali_date['year'];
            $secondaryYear = $nepali_date['year'] + 1;
        } else {
            //-- It will belong to seconday year
            $primaryYear = $nepali_date['year'] - 1;
            $secondaryYear = $nepali_date['year'];
        }

        return substr(strval($primaryYear), -2) . "/" . substr(strval($secondaryYear), -2);
    }
    /**
     *  returns fiscal year in BS in following format
     *  "2079/80"
     *  "2080/81"
     */
    public static function curentFullFiscalYear()
    {
        $primaryYear = 0;
        $secondaryYear = 0;
        $primary_year_valid_months = [4, 5, 6, 7, 8, 9, 10, 11, 12];
        $secondary_year_valid_month = [1, 2, 3];

        $todayDate = now();
        $nepali_date = DateConverter::fromEnglishDate(
            $todayDate->year,
            $todayDate->month,
            $todayDate->day,
        )->toNepaliDateArray();

        //-- Check if year is in primary year
        if (in_array($nepali_date['month'], $primary_year_valid_months)) {
            $primaryYear = $nepali_date['year'];
            $secondaryYear = $nepali_date['year'] + 1;
        } else {
            //-- It will belong to seconday year
            $primaryYear = $nepali_date['year'] - 1;
            $secondaryYear = $nepali_date['year'];
        }

        return "20" . substr(strval($primaryYear), -2) . "/" . substr(strval($secondaryYear), -2);
    }

    /**
     * Calculate the previous fiscal year from the given fiscal year.
     *
     * @param string $fiscalYear The input fiscal year in the format "XX/YY".
     * @return string The previous fiscal year in the format "XX/YY".
     */
    public static function previousFYFromGivenFY($fiscalYear)
    {
        // Explode the fiscal year into two parts
        $parts = explode('/', $fiscalYear);

        // Get the first part and subtract 1 to get the previous fiscal year's first part
        $previous_first_part = (int) $parts[0] - 1;

        // Get the second part and subtract 1 to get the previous fiscal year's second part
        $previous_second_part = (int) $parts[1] - 1;

        // Combine the parts to form the previous fiscal year
        $oldfiscalYear = $previous_first_part . '/' . $previous_second_part;

        // Return the previous fiscal year
        return $oldfiscalYear;
    }

}