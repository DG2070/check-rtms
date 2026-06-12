<?php

namespace App\Helper;

use Illuminate\Support\Facades\Http;

class FunctionUtils{


    public static function allApiData(){

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
        return $all_data;

    }


    public static function disbursementData(){

        $url = "http://tdf.softavi.com/api/tdf_data/getTdfDisbursementData?username=tdf_apiuser&password=tdF@piUs3r2o22";

        $response = Http::get($url);
        $disbursement = $response->json($key = null);
        // dd($disbursement);
        return $disbursement;

    }


    public static function getApiPrograms($all_data){

        // $all_data = $all_data;

        $programs = $all_data['programs'];
        // dd($programs);
        $details = $all_data['prgDetails'];
        $programs_data = [];

        foreach($programs as $key => $program):

            $detail = $details[$key]??[];
            $program_data = $program;

            if($program['code'] == $detail['Code']):
                $program_data = $program + $detail;
            endif;

            array_push($programs_data, $program_data);

        endforeach;

        return $programs_data;

    }


    public static function getApiLocations($all_data){

        $all_data = $all_data;
        $towns = $all_data['TownList'];

        return $towns;

    }


    public static function getApiProjects($all_data){

        $all_data = $all_data;
        $projects = $all_data['prjDetails'];

        return $projects;

    }


    public static function getApiActivities($all_data){

        $all_data = $all_data;
        $activities = $all_data['activityDetails'];

        return $activities;

    }


    public static function getApiDisbursements($disbursement){

        $disbursement = $disbursement;
        // dd($disbursement);
        $activities = $disbursement['disbursementDetails'];

        return $activities;

    }
    
}
