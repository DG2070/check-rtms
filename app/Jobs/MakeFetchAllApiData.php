<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Http;
use App\Models\{Program, ProjectDetail, TownList, ActivityDetail};

/**
 * Fetch Programs/ Projects eveything from TDF system
 * it wont duplicate system table/db with old data even if called infinitly
 *
 * Author:Kishor Shrestha (winneecreztha@gmail.com)
 *
 */

class MakeFetchAllApiData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 1200;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            //-- Increase memory limit
            ini_set('memory_limit', '256M');

            $url = env('MIS_URL', 'http://mis.tdf.org.np')."/api/tdf_data/getTdfData?username=tdf_apiuser&password=tdF@piUs3r2o22";

            $response = Http::withoutVerifying()
                ->withOptions([
                    'verify' => false,
                    'config' => [
                        // 'cookies' => true,
                        'curl' => [
                            CURLOPT_SSL_VERIFYHOST => false,
                            CURLOPT_SSL_VERIFYPEER => false
                        ]
                    ]
                ])
                ->get($url);
            $all_data = $response->json($key = null);

            $programs = [];

            foreach (collect($all_data["prgDetails"]) as $key => $pro):

                if (empty($pro["ID"]))
                    continue;

                //check if already in table
                if (Program::where("ID", $pro["ID"])->count() == 0) {
                    array_push($programs, $pro);
                }

            endforeach;

            Program::insert($programs);



            $towns = [];

            foreach (collect($all_data["TownList"]) as $town):

                if (empty($town["ID"]))
                    continue;

                //check if already in table
                if (TownList::where("ID", $town["ID"])->count() == 0) {
                    array_push($towns, $town);
                }

            endforeach;

            TownList::insert($towns);



            $project_details = [];

            foreach (collect($all_data["prjDetails"]) as $proj):

                if (empty($proj["projectID"]))
                    continue;

                //check if already in table
                if (ProjectDetail::where("projectID", $proj["projectID"])->count() == 0) {
                    array_push($project_details, $proj);
                }

            endforeach;

            ProjectDetail::insert($project_details);


            $activities = [];

            foreach (collect($all_data['activityDetails']) as $act):

                if (empty($act["programID"]) || empty($act["townId"]) || empty($act["projectID"]))
                    continue;

                unset($act["ProjectName"]);

                //check if already in table
                if (
                    ActivityDetail::where("programID", $act["programID"])
                        ->where("projectID", $act["projectID"])
                        ->where("activityCode", $act["activityCode"])
                        ->where("Type", $act["Type"])
                        ->where("FinancingType", $act["FinancingType"])
                        ->count() == 0
                ) {
                    array_push($activities, $act);
                }


            endforeach;

            ActivityDetail::insert($activities);

        } catch (\Throwable $th) {
            report($th);
        }
    }
}