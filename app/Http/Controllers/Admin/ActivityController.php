<?php

namespace App\Http\Controllers\Admin;

use App\Helper\FunctionUtils;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityDetail;


class ActivityController extends Controller
{


    public function index(Request $request)
    {

        // $all_data = FunctionUtils::allApiData();

        // $activities = FunctionUtils::getApiActivities($all_data);

        $data["activities"] = ActivityDetail::select([
            "programName", "projectID", "projectName", "TownName",
            "activityCode", "ApprovedTotal"
        ])->get();

        if ($request->has('project') && $request->project != '') :
            $data["activities"] = collect($data["activities"])->where('projectID', $request->project)->toArray();
        endif;

        return view('admin.activities.index', compact('data'));
    }
}
