<?php

namespace App\Trait;

use App\Helper\DateConverter;
use Illuminate\Support\Facades\Http;
use App\Models\{AllDisbursementFromMis, DisbursementDetail, ProgramDisbursementSummary, ProgramYearlyDisbursement, ProjectYearlyDisbursement};
use Carbon\Carbon;

trait LoadDisbursementFromServer
{


    public static function disbursementData()
    {

        $url = "http://tdf.softavi.com/api/tdf_data/getTdfDisbursementData?username=tdf_apiuser&password=tdF@piUs3r2o22";

        $response = Http::get($url);
        $disbursement = $response->json($key = null);


        /****************************************************/

        $disbursement_details = [];

        foreach (collect($disbursement["disbursementDetails"]) as $dis) :

            if (empty($dis["ID"]) || empty($dis["ProgrammeID"]) || empty($dis["ProjectID"]) || empty($dis["townID"])) continue;

            //check if already in table
            if (DisbursementDetail::where("ID", $dis["ID"])->count() == 0) {
                array_push($disbursement_details, $dis);
            }


        endforeach;

        DisbursementDetail::insert($disbursement_details);


        /*****************************************************/

        $disbursement_summary = [];

        foreach (collect($disbursement["programDisbursementSummary"]) as $summary) :

            if (empty($summary["id"]) || empty($summary["program_id"])) continue;

            //check if already in table
            if (ProgramDisbursementSummary::where("id", $summary["id"])->count() == 0) {
                array_push($disbursement_summary, $summary);
            }

        endforeach;

        ProgramDisbursementSummary::insert($disbursement_summary);


        /****************************************************/

        $program_yearly_disbursement = [];

        foreach (collect($disbursement["programYearlyDisbursement"]) as $program) :

            if (empty($program["id"]) || empty($program["program_id"])) continue;

            //check if already in table
            if (ProgramYearlyDisbursement::where("id", $program["id"])->count() == 0) {
                array_push($program_yearly_disbursement, $program);
            }

        endforeach;

        ProgramYearlyDisbursement::insert($program_yearly_disbursement);


        /*****************************************************/

        $project_yearly_disbursement = [];

        foreach (collect($disbursement["pojectYearlyDisbursement"]) as $project) :

            if (empty($project["prog_id"]) || empty($project["project_id"])) continue;

            //check if already in table
            if (ProjectYearlyDisbursement::where("prog_id", $project["prog_id"])->count() == 0) {
                array_push($project_yearly_disbursement, $project);
            }

        endforeach;

        ProjectYearlyDisbursement::insert($project_yearly_disbursement);
    }

    /**
     *  All disbursement data as per MIS (along with exact day,month,year of disbursement)
     *  it wont duplicate system table/db with old data
     *  pulls data till date
     *
     *  @RETURN TRUE (after completion)
     *
     * Author:Kishor Shrestha (winneecreztha@gmail.com)
     */


    public function actualMisDisbursementDataWithDateMonthYear()
    {
        $end_year =  Carbon::now()->year . "-" .  Carbon::now()->month . "-" . Carbon::now()->day;
        $url = "http://tdf.softavi.com/api/tdf_data/getTdfDisbursementDatabydate?username=tdf_apiuser&password=tdF@piUs3r2o22&start=1800-04-01&end=" . $end_year;

        $response = Http::get($url);
        $disbursement = $response->json($key = null);


        //*****************************************************/

        foreach (collect($disbursement["disbursment_bydate"]) as $disbursement) :

            //check if already in table
            if (
                AllDisbursementFromMis::where("ActivityID", $disbursement["ActivityID"])
                ->where("ActivityID", $disbursement["ActivityID"])
                ->where("Date", $disbursement["Date"])
                ->where("Amount", $disbursement["Amount"])
                ->where("TransactionTypeID", $disbursement["TransactionTypeID"])
                ->where("PaymentType", $disbursement["PaymentType"])
                ->where("Balance", $disbursement["Balance"])
                ->count() == 0
            ) {

                //convert english date to nepali date

                $disbursement_date = Carbon::parse($disbursement["Date"]);
                $nepali_date = DateConverter::fromEnglishDate(
                    $disbursement_date->year,
                    $disbursement_date->month,
                    $disbursement_date->day,
                )->toNepaliDateArray();

                $disbursement["nepali_year"] =  $nepali_date["year"];
                $disbursement["nepali_month"] =  $nepali_date["month"];
                $disbursement["nepali_day"] =  $nepali_date["day"];

                AllDisbursementFromMis::insert([$disbursement]);
            }

        endforeach;

        return true;
    }
}
