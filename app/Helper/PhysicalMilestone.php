<?php
/*
 * Copyright © 2022 by SysQube Technology, All rights reserved.
 *
 * Author : Kishor Shrestha (winneecreztha@gmail.com)
 */

namespace App\Helper;


class PhysicalMilestone
{

    /**
     *
     */
    public static function milestoneNames()
    {
        $dataset = [
            "physical target",
        ];

        return array_map(function ($value) {
            return strtolower($value);
        }, $dataset);
    }
}
