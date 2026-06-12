<?php
/*
 * Copyright © 2022 by SysQube Technology, All rights reserved.
 *
 * Author : Kishor Shrestha (winneecreztha@gmail.com)
 */

namespace App\Helper;

use Illuminate\Support\Facades\Log;

// TODO: Refactor this class
class FlowProjectMilestone
{
    public static function calculateTargetAndProgressFromMilestone($milestones, $months)
    {
        $ft_fp_pt_pp = [
            'financial_target' => 0,
            'financial_progress' => 0,
            'physical_target' => 0,
            'physical_progress' => 0,
        ];

        foreach ($milestones ?? [] as $milestone) {


            // ** Check if milestone if for financial milestone
            if (in_array(strtolower(trim($milestone->milestone)), FinancialMilestone::milestoneNames())) {

                // ** Calculate Financial Target
                foreach ($milestone->timeline->timeline ?? [] as $timeline_month => $timeline_value) {
                    if (!empty($timeline_value) && in_array($timeline_month, $months)) {
                        $ft_fp_pt_pp['financial_target'] = $ft_fp_pt_pp['financial_target'] +  floatval($timeline_value);
                    }
                }
                // ** Calculate Financial Progress
                foreach ($milestone->timeline->progress_input_data ?? [] as $timeline_month => $timeline_value) {
                    if (!empty($timeline_value) && in_array($timeline_month, $months)) {
                        $ft_fp_pt_pp['financial_progress'] = $ft_fp_pt_pp['financial_progress'] +  floatval($timeline_value);
                    }
                }
            }

            foreach ($milestone->timeline->timeline ?? [] as $timeline_month => $timeline_value) {
                if (!empty($timeline_value) && in_array($timeline_month, $months)) {
                    //--check if its physical milestone
                    if (in_array(strtolower(trim($milestone->milestone)), PhysicalMilestone::milestoneNames())) {
                        $ft_fp_pt_pp['physical_target'] = $ft_fp_pt_pp['physical_target'] +  floatval($timeline_value);
                        //-- For progress
                        if (!empty($milestone->timeline->progress_input_data)) {
                            $ft_fp_pt_pp['physical_progress'] = $ft_fp_pt_pp['physical_progress'] +  floatval($milestone->timeline->progress_input_data[$timeline_month]);
                        }
                    }
                }
            }

        }

        return $ft_fp_pt_pp;
    }
}
