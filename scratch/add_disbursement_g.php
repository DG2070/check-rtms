<?php

$file = 'app/Helper/DisbursementFilter.php';
$content = file_get_contents($file);

$newMethod = <<<'METHOD'

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
METHOD;

$pos = strrpos($content, '}');
$newContent = substr($content, 0, $pos) . $newMethod . "\n}\n";

file_put_contents($file, $newContent);

