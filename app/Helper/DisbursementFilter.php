<?php
/*
 * Copyright © 2022 by SysQube Technology, All rights reserved.
 *
 * Author : Kishor Shrestha (winneecreztha@gmail.com)
 */

namespace App\Helper;

use App\Models\ActivityDetail;

class DisbursementFilter
{
    /**
     * Calculates total amount disbursed for a project till year
     * Made for "Project status as of the end of FY 2078/79" section
     *  @param $year  (eg: 2078/79)
     *  @param $program_id
     *  @param $project_id
     *
     *  @return $total_disbursement (amount in INT or NA if its 0)
     */
    public static function totalDisbursementForProjectAsOfYear($year, $program_id, $project_id)
    {
        $fiscial_years = [];
        // Assuming $year is in the format "2080/81"
        $yearParts = explode('/', $year);
        if (count($yearParts) === 2) {
            // Convert the first part (2080) to an integer and add it to the array
            $startYear = intval($yearParts[0]);
            $fiscial_years[] = $startYear;
            // Convert the end part (81) to (2081) and add it to the array as integer
            $endYear =   intval("20" . $yearParts[1]);
            $fiscial_years[] = $endYear;
        } else {
            abort(404, "Invalid Year");
        }
        // dd($fiscial_years);
        $total_disbursement = 0;
        $secondary_year_valid_month = [1, 2, 3];

        $activity_detail = ActivityDetail::where("programID", $program_id)->where("projectID", $project_id)->with([
            "allProjectDisbursementData"
        ])->first();
        // dd( $activity_detail);


        if (!empty($activity_detail)  && !empty($activity_detail->allProjectDisbursementData)) {
            foreach ($activity_detail->allProjectDisbursementData as $disbursement) {
                if ($disbursement->IsDisbursement == 1) {

                    //validate secondary year
                    if (intval($disbursement->nepali_year) >  $fiscial_years[1]) {
                        continue;
                    }

                    if (intval($disbursement->nepali_year) <  $fiscial_years[1]) {
                        $total_disbursement = $total_disbursement + $disbursement->Amount;
                    }


                    if (intval($disbursement->nepali_year) ==  $fiscial_years[1]) {
                        if (in_array($disbursement->nepali_month, $secondary_year_valid_month)) {
                            $total_disbursement = $total_disbursement + $disbursement->Amount;
                        }
                    }
                }
            }
        }
        $total_disbursement = abs($total_disbursement);
        if ($total_disbursement == 0) {
            return "NA";
        } else {
            return $total_disbursement;
        }
    }

    /**
     * Year wise disbursement data for a project in 12 months
     * takes in 2078/2079 2079/2080
     *
     * returns disbursement by month data for that fiscial year
     */
    public static function disbursementsForProjectByFiscialYear($fiscial_year, $program_id, $project_id)
    {
        $fiscial_years = [];
        // Assuming $year is in the format "2080/81"
        $yearParts = explode('/', $fiscial_year);
        if (count($yearParts) === 2) {
            // Convert the first part (2080) to an integer and add it to the array
            $startYear = intval($yearParts[0]);
            $fiscial_years[] = $startYear;
            // Convert the end part (81) to (2081) and add it to the array as integer
            $endYear =   intval("20" . $yearParts[1]);
            $fiscial_years[] = $endYear;
        }
        // dd($fiscial_years);
        $primary_year_valid_months = [4, 5, 6, 7, 8, 9, 10, 11, 12];
        $secondary_year_valid_month = [1, 2, 3];


        $valid_disbursements_for_fiscial_year = [];

        // ** Get Disbursement Data From activityDetail of project with financing type as L
        // ** L is for Loan and G is for Grant
        $activity_detail = ActivityDetail::where([
                ['projectID', '=', $project_id],
                ['programID', '=', $program_id],
                ['FinancingType', '=', 'L'],
            ])
            ->with([
                "allProjectDisbursementData"
            ])->first();


        if (!empty($activity_detail)  && !empty($activity_detail->allProjectDisbursementData)) {
            foreach ($activity_detail->allProjectDisbursementData as $disbursement) {
                //check if year & month is withing fiscial year
                if (in_array($disbursement->nepali_year, $fiscial_years)) {

                    //validate months for primary_year
                    if ($disbursement->nepali_year ==  $fiscial_years[0]) {
                        if (in_array($disbursement->nepali_month, $primary_year_valid_months)) {
                            if ($disbursement->IsDisbursement == 1) {
                                array_push($valid_disbursements_for_fiscial_year, $disbursement);
                            }
                        }
                    }
                    //validate months for secondary_year
                    if ($disbursement->nepali_year ==  $fiscial_years[1]) {
                        if (in_array($disbursement->nepali_month, $secondary_year_valid_month)) {
                            if ($disbursement->IsDisbursement == 1) {
                                array_push($valid_disbursements_for_fiscial_year, $disbursement);
                            }
                        }
                    }
                }
            }
        }

        $disbursement_by_months = [
            "4" => 0,
            "5" => 0,
            "6" => 0,
            "7" => 0,
            "8" => 0,
            "9" => 0,
            "10" => 0,
            "11" => 0,
            "12" => 0,
            "1" => 0,
            "2" => 0,
            "3" => 0,
        ];

        foreach ($valid_disbursements_for_fiscial_year as   $disbursement) {
            if (in_array($disbursement->nepali_month, array_keys($disbursement_by_months))) {
                $disbursement_by_months[$disbursement->nepali_month] = $disbursement_by_months[$disbursement->nepali_month] + abs($disbursement->Amount);
            }
        }

        return $disbursement_by_months;
    }

    /**
     * Year wise disbursement data for a project in 12 months (For 'G' row)
     * Filtering by TransactionTypeID == 4 instead of IsDisbursement == 1
     */
    public static function disbursementsForProjectByFiscialYearG($fiscial_year, $program_id, $project_id)
    {
        $fiscial_years = [];
        // Assuming $year is in the format "2080/81"
        $yearParts = explode('/', $fiscial_year);
        if (count($yearParts) === 2) {
            $startYear = intval($yearParts[0]);
            $fiscial_years[] = $startYear;
            $endYear = intval("20" . $yearParts[1]);
            $fiscial_years[] = $endYear;
        }
        
        $primary_year_valid_months = [4, 5, 6, 7, 8, 9, 10, 11, 12];
        $secondary_year_valid_month = [1, 2, 3];

        $valid_disbursements_for_fiscial_year = [];

        $activity_detail = ActivityDetail::where([
                ['projectID', '=', $project_id],
                ['programID', '=', $program_id],
                ['FinancingType', '=', 'L'],
            ])
            ->with([
                "allDisbursementDataFromMis"
            ])->first();

        if (!empty($activity_detail)  && !empty($activity_detail->allDisbursementDataFromMis)) {
            foreach ($activity_detail->allDisbursementDataFromMis as $disbursement) {
                if (in_array($disbursement->nepali_year, $fiscial_years)) {
                    if ($disbursement->nepali_year ==  $fiscial_years[0]) {
                        if (in_array($disbursement->nepali_month, $primary_year_valid_months)) {
                            if ($disbursement->TransactionTypeID == 4) {
                                array_push($valid_disbursements_for_fiscial_year, $disbursement);
                            }
                        }
                    }
                    if ($disbursement->nepali_year ==  $fiscial_years[1]) {
                        if (in_array($disbursement->nepali_month, $secondary_year_valid_month)) {
                            if ($disbursement->TransactionTypeID == 4) {
                                array_push($valid_disbursements_for_fiscial_year, $disbursement);
                            }
                        }
                    }
                }
            }
        }

        $disbursement_by_months = [
            "4" => 0, "5" => 0, "6" => 0, "7" => 0, "8" => 0, "9" => 0, 
            "10" => 0, "11" => 0, "12" => 0, "1" => 0, "2" => 0, "3" => 0,
        ];

        foreach ($valid_disbursements_for_fiscial_year as $disbursement) {
            if (in_array($disbursement->nepali_month, array_keys($disbursement_by_months))) {
                $disbursement_by_months[$disbursement->nepali_month] = $disbursement_by_months[$disbursement->nepali_month] + abs($disbursement->Amount);
            }
        }

        return $disbursement_by_months;
    }


    public static function totalDisbursementForProjectCurrentWithFiscialYear($fiscial_year, $program_id, $project_id)
    {

        $total_disbursement = 0;

        $activity_detail = ActivityDetail::where("programID", $program_id)->where("projectID", $project_id)->with([
            "allProjectDisbursementData"
        ])->first();

        return $activity_detail->allProjectDisbursementData;


        if (!empty($activity_detail)  && !empty($activity_detail->allProjectDisbursementData)) {
            foreach ($activity_detail->allProjectDisbursementData as $disbursement) {
                if ($disbursement->IsDisbursement == 1) {
                    $total_disbursement = $total_disbursement + $disbursement->Amount;
                }
            }
        }
        $total_disbursement = abs($total_disbursement);
        if ($total_disbursement == 0) {
            return "NA";
        } else {
            return $total_disbursement;
        }
    }
}
