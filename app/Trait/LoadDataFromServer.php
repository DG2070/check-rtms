<?php

namespace App\Trait;

use Illuminate\Support\Facades\Http;
use App\Models\{Program, ProjectDetail, TownList, ActivityDetail};


trait LoadDataFromServer
{
    /**
     * Fetch Programs/ Projects eveything from TDF system
     * it wont duplicate system table/db with old data even if called infinitly
     *
     * @RETURN TRUE (after completion)
     *
     * Author:Kishor Shrestha (winneecreztha@gmail.com)
     *
     */
    public static function allApiData()
    {

        $url = "http://tdf.softavi.com/api/tdf_data/getTdfData?username=tdf_apiuser&password=tdF@piUs3r2o22";

        $response = Http::get($url);
        $all_data = $response->json($key = null);
        // dd($all_data['disbursementDetails']);
        // dd($all_data);
        // dump($all_data['programs'][1]);
        // dump($all_data['prgDetails'][1]);
        // dump($all_data['TownList'][1]);
        // dump(collect($all_data['prjDetails'])->groupBy('projectID'));
        // dump(collect($all_data['activityDetails'])->where("projectID" , "286"));
        // dd(collect($all_data['disbursementDetails'])->where("ProjectID" , "286"));

        $programs = [];

        foreach (collect($all_data["prgDetails"]) as $key => $pro) :

            if (empty($pro["ID"])) continue;

            //check if already in table
            if (Program::where("ID", $pro["ID"])->count() == 0) {
                array_push($programs, $pro);
            }

        endforeach;

        Program::insert($programs);



        $towns = [];

        foreach (collect($all_data["TownList"]) as $town) :

            if (empty($town["ID"])) continue;

            //check if already in table
            if (TownList::where("ID", $town["ID"])->count() == 0) {
                array_push($towns, $town);
            }

        endforeach;

        TownList::insert($towns);



        $project_details = [];

        foreach (collect($all_data["prjDetails"]) as $proj) :

            if (empty($proj["projectID"])) continue;

            //check if already in table
            if (ProjectDetail::where("projectID", $proj["projectID"])->count() == 0) {
                array_push($project_details, $proj);
            }

        endforeach;

        ProjectDetail::insert($project_details);


        $activities = [];

        foreach (collect($all_data['activityDetails']) as $act) :

            if (empty($act["programID"]) || empty($act["townId"]) || empty($act["projectID"])) continue;

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

        return true;
    }
}
