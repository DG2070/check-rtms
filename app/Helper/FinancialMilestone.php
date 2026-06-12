<?php
/*
 * Copyright © 2022 by SysQube Technology, All rights reserved.
 *
 * Author : Kishor Shrestha (winneecreztha@gmail.com)
 */

namespace App\Helper;


class FinancialMilestone
{
    /**
     *
     */
    public static function milestoneNames()
    {
        $dataset = [
            "financial target",
            "disbursement target",
            "final disbursement",
            "financial disbursement",
            "Disbursement Target (Final Bill Payment )",
        ];


        return array_map(function ($value) {
            return strtolower($value);
        }, $dataset);
    }
}
