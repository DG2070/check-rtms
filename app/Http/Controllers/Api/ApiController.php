<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TownList;
use App\Models\ActivityDetail;
use App\Models\DisbursementDetail;
use App\Models\Milestone;
use App\Models\ProjectDataSQ;
use App\Models\ProjectDetail;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * get district names from province code
     */
    public function getDistrictForProvince($province_code)
    {
        return response(TownList::select("District")->whereNotNull("District")->where("Province", sprintf("%02d", strval($province_code)))
            ->distinct("District")->pluck("District"), 200);
    }

    /**
     * get townname from district name & province code
     */
    public function getTownForDistrictWithProvince(Request $request)
    {
        $request->validate([
            'province_code' => 'required',
            'district_name' => 'required',
        ]);

        return response(TownList::select("TownName")
            ->whereNotNull("District")
            ->where("Province", sprintf("%02d", strval($request->province_code)))
            ->where("District", $request->district_name)
            ->distinct("TownName")
            ->pluck("TownName"), 200);
    }
    /**
     * get townname from district name only
     */
    public function getTownForDistrict(Request $request)
    {
        $request->validate([
            'district_name' => 'required',
        ]);

        return response(TownList::select("TownName")
            ->whereNotNull("District")
            ->where("District", $request->district_name)
            ->distinct("TownName")
            ->pluck("TownName"), 200);
    }
    public function getProjectStatByPDT(Request $request)
    {
        $request->validate([
            'province_code' => 'required',
            'district_name' => 'required',
            'town_name' => 'required',
        ]);


        $activities = ActivityDetail::select("id", "townID", "TownName", "projectID")->get();
        //TOTAL
        $total_ProjectID = collect($activities)
            ->whereIn("TownName", $request->town_name)
            ->pluck("projectID");
        $data["total"] = count($total_ProjectID);
        //RUNNING
        $running_ProjectID
            = DisbursementDetail::whereIn("ProjectID", $total_ProjectID)
            ->where("Stopped", 0)
            ->where(
                "DisbursementPercentage",
                "<",
                100
            )
            ->distinct("ProjectID")->pluck("projectID");
        $data["running"] = count($running_ProjectID);
        //STOPPED
        $stopped_projectId =  DisbursementDetail::whereIn("ProjectID", $total_ProjectID)
            ->where("Stopped", 1)
            ->distinct("ProjectID")->pluck("projectID");
        $data["stopped"] = count($stopped_projectId);
        //COMPLETED
        $completed_projectId =
            DisbursementDetail::whereIn("ProjectID", $total_ProjectID)
            ->where("Stopped", 0)
            ->where(
                "DisbursementPercentage",
                ">",
                99
            )
            ->distinct("ProjectID")->pluck("projectID");
        $data["completed"] = count($completed_projectId);




        return response([
            "total_projectID" => $total_ProjectID,
            "total" => $data["total"],
            "running_projectID" => $running_ProjectID,
            "running" =>  $data["running"],
            "completed_projectID" => $completed_projectId,
            "completed" => $data["completed"],
            "stopped_projectId" => $stopped_projectId,
            "stopped" =>  $data["stopped"],
        ], 200);
    }
    /**
     * Update Project FT PT (financial targer & physical target) by project Id
     */
    public function updateProjectFtPt(Request $request, $project_id)
    {
        $request->validate([
            'ft' => 'required',
            'pt' => 'required',
            'project_data_sq_id' => 'required',
        ]);

        $project_data_sq =  ProjectDataSQ::where("id", $request->project_data_sq_id)->where("project_id", $project_id)->first();

        if ($project_data_sq) {
            $project_data_sq->FT = $request->ft;
            $project_data_sq->PT = $request->pt;
            $project_data_sq->save();
            return response([
                "message" => "Ok"
            ], 200);
        }

        return response([
            "message" => "Project not found"
        ], 404);
    }

    public function setTargetUploadMilestones(Request $request, $project_id)
    {
        $request->validate([
            'milestones' => 'required',
            'removed_milestone_ids' => 'required',
        ]);

        if (ProjectDetail::where("projectID", $project_id)->exists()) {

            //-- For removed milestones
            foreach (json_decode($request->removed_milestone_ids) as  $milestone_id) {
                Milestone::where('id', $milestone_id)->delete();
            }

            foreach (json_decode($request->milestones) as $key => $item) {
                $order_no = $key + 1;

                if ($item->activity_id == 0) {
                    continue;
                }
                if ($item->milestone_name == '') {
                    continue;
                }

                if ($item->milestone_id == 0) {
                    //create new milestone
                    $milestone = new Milestone();
                } else {
                    $milestone = Milestone::find($item->milestone_id);
                    if (empty($milestone)) {
                        continue;
                    }
                }


                $milestone->project_activity_id = $item->activity_id;
                $milestone->milestone = $item->milestone_name;
                $milestone->performance_indicator = $item->performance_indicator;
                $milestone->is_text = $item->milestone_is_text;
                $milestone->order = $order_no;
                $milestone->save();
            }
            return response([
                "message" => "Ok",
            ], 200);
        }

        return response([
            "message" => "Project not found"
        ], 404);
    }
}
