<?php

namespace App\Http\Controllers\Admin\Program;

use App\Http\Controllers\Controller;
use App\Models\ProjectDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AjaxController extends Controller
{
    public function activityMilestoneView(Request $request)
    {
        // return $request;
        $program_id = $request->program_id;
        $project_id = $request->project_id;

        if (!$request->has("project_id") || empty($request->project_id)) {
            return response()->json([
                'error'   => 'Select a project',
            ]);
        }

        $data["project"] = ProjectDetail::with(["projectActivity.milestone.timeline"])
            ->select(["projectID", "Name", "FT", "FP", "NameLong", "programID"])
            ->where("projectID", $project_id)->firstOrFail();



        return response()->json([
            'success'   => 'Ajax request submitted successfully',
            'view' => view('admin.progress.components.program-report-input', [
                'project'          => $data["project"],
            ])->render(),
        ]);


        // return View::make("components.project.activity-milestone-component")
        //     // ->with("product", $product)
        //     ->render();
    }
}
