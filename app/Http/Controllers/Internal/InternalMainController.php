<?php

namespace App\Http\Controllers\Internal;

use Str;
use App\Models\User;
use App\Helper\FiscalYear;
use Illuminate\Http\Request;
use App\Models\InternalProject;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\InternalProjectData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;

use App\Exports\InternalProgressReportExport;
use App\Exports\InternalPMEReviewReportExport;


class InternalMainController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->can('Access Internal Projects') || Auth::user()->can('Access All Internal Projects')) {
                return $next($request);
            }
            toastr()->error("You dont have required access");
            return redirect()->route("home");
        });
    }
    public function projectsIndex(Request $request)
    {
        $project_filter_type = "active_projects";

        if ($request->has("project_filter_type") && $request->project_filter_type != "") {
            if ($request->project_filter_type == "all_projects") {
                $project_filter_type = "all_projects";
            }
        }

        if (Auth::user()->can("Access All Internal Projects")) {
            if ($project_filter_type == "active_projects") {
                $projects = InternalProject::where("fiscal_year", FiscalYear::curentFiscalYear())->get();
            } else {
                $projects = InternalProject::all();
            }
        } else {

            //--Assigned internal Project data ids
            $internal_project_data_ids = InternalProjectData::where(function ($query) {
                $query->whereJsonContains('main_responsibility', strval(Auth::id()))
                    ->orWhereJsonContains('supportive_responsibility', strval(Auth::id()));
            })->select('internal_project_id')->get(["internal_project_id"])->unique("internal_project_id")->filter()->toArray();

            if ($project_filter_type == "active_projects") {
                $projects = InternalProject::where("fiscal_year", FiscalYear::curentFiscalYear())
                    ->whereIn("id", array_column($internal_project_data_ids, 'internal_project_id'))
                    ->get();
            } else {
                $projects = InternalProject::whereIn("id", array_column($internal_project_data_ids, 'internal_project_id'))
                    ->get();
            }
        }

        return view("admin.internal.projects.index", [
            "projects" => $projects,
            "project_filter_type" => $project_filter_type,
        ]);
    }

    public function createProject(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'fiscal_year' => 'required',
        ]);

        if (InternalProject::where("name", $request->name)->where("fiscal_year", $request->fiscal_year)->count() > 0) {
            return redirect()->route("internal.project.index")
                ->with('error', 'Project with fiscal year exists');
        }

        InternalProject::create([
            "name" => $request->name,
            "fiscal_year" => $request->fiscal_year,
            "created_by_user_id" => Auth::id(),
        ]);


        return redirect()->route("internal.project.index")
            ->with('success', 'Project Created successfully');
    }

    public function updateProject(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'name' => 'required',
        ]);

        $project = InternalProject::find($request->project_id);
        if ($project) {

            $project->update([
                "name" => $request->name
            ]);
        }

        return redirect()->route("internal.project.index")
            ->with('success', 'Project Edit successfully');
    }
    public function deleteProject(InternalProject $internalProject)
    {


        foreach (InternalProjectData::where("internal_project_id", $internalProject->id)->get() as $projectdata) {

            $projectdata->deleted_by_user_id = Auth::id();
            $projectdata->save();
            $projectdata->delete();
        }

        $internalProject->deleted_by_user_id = Auth::id();
        $internalProject->save();
        $internalProject->delete();


        return redirect()->route("internal.project.index")
            ->with('success', 'Project Deleted successfully');
    }

    public function singleProjectIndex($project_id)
    {
        $project = InternalProject::find($project_id);
        if (!$project) {
            return redirect()->route("internal.project.index")->with('error', 'Project not found');
        }
        $data["users"] = User::whereNotIn("email", ["root@tdf.org.np", "admin@sysqube.com"])->get();

        // $this->automatePME($project_id);

        $project_datas = InternalProjectData::where("internal_project_id", $project_id)->where("fiscal_year", $project->fiscal_year)->get();

        return view("admin.internal.projects.single.index", [
            "project" => $project,
            "users" => $data["users"],
            "project_datas" => $project_datas,
        ]);
    }
    public function createActivitiesMilestones(Request $request)
    {
        $request->validate([
            'project_id' => 'required',
            'fiscal_year' => 'required',
            'activity_milestone' => 'required',
            'is_text' => 'required',
        ]);


        // return $request->project_id;
        $project = InternalProject::find($request->project_id);
        if ($project) {

            if (InternalProjectData::where("internal_project_id", $project->id)->where("activity_milestone", $request->activity_milestone)->where("fiscal_year", $request->fiscal_year)->count() > 0) {
                return redirect()->route("internal.project.single.index", ["project_id" => $project->id])
                    ->with('error', 'Activity/Milestone with fiscal year exists');
            }

            InternalProjectData::create([
                'internal_project_id' => $project->id,
                'fiscal_year' => $request->fiscal_year,
                'activity_milestone' => $request->activity_milestone,
                'is_text' => $request->is_text,
                'approved_budget' => $request->approved_budget,
                'performance_indicator' => $request->performance_indicator,
                'main_responsibility' => $request->main_responsibility,
                'supportive_responsibility' => $request->supportive_responsibility,
                'created_by_user_id' => Auth::id(),
            ]);


            return redirect()->route("internal.project.single.index", ["project_id" => $project->id])->with('success', 'Activity/Milestone Added Successfully');
        }

        return redirect()->route("internal.project.index")->with('error', 'Project not found');
    }
    public function updateActivitiesMilestones(Request $request)
    {
        $request->validate([
            'internal_project_data_id' => 'required',
            'internal_project_id' => 'required',
            'fiscal_year' => 'required',
            'activity_milestone' => 'required',
            'is_text' => 'required',
        ]);

        $project = InternalProject::find($request->internal_project_id);
        if ($project) {


            $projectdata = InternalProjectData::find($request->internal_project_data_id);

            if ($projectdata) {

                $projectdata->activity_milestone = $request->activity_milestone;
                $projectdata->is_text = $request->is_text;
                $projectdata->approved_budget = $request->approved_budget;
                $projectdata->performance_indicator = $request->performance_indicator;
                $projectdata->main_responsibility = $request->main_responsibility;
                $projectdata->supportive_responsibility = $request->supportive_responsibility;
                $projectdata->save();

                return redirect()->route("internal.project.single.index", ["project_id" => $project->id])->with('success', 'Activity/Milestone Updated Successfully');
            } else {
                return redirect()->route("internal.project.index")->with('error', 'Project Data not found');
            }
        }

        return redirect()->route("internal.project.index")->with('error', 'Project not found');
    }
    public function deleteActivitiesMilestones($internal_project_data_id)
    {
        $projectdata = InternalProjectData::find($internal_project_data_id);

        if ($projectdata) {

            $project_id = $projectdata->internal_project_id;
            $projectdata->deleted_by_user_id = Auth::id();
            $projectdata->save();
            $projectdata->delete();

            return redirect()->route("internal.project.single.index", ["project_id" => $project_id])->with('success', 'Activity/Milestone Deleted Successfully');
        }

        return redirect()->route("internal.project.index")->with('error', 'Project Data not found');
    }

    public function updateActivitiesMilestonesTimelineTarget(Request $request)
    {
        // return $request;
        foreach ($request->timeline_target ?? [] as $internal_project_data_id => $timeline_target) {
            $projectdata = InternalProjectData::find($internal_project_data_id);
            if ($projectdata) {

                $new_timeline_target = [];
                for ($i = 1; $i < 13; $i++) {

                    if (empty($timeline_target[$i])) {
                        $new_timeline_target[$i] = "";
                    } else {
                        $new_timeline_target[$i] = $timeline_target[$i];
                    }
                }
                $projectdata->timeline_target = $new_timeline_target;
                $projectdata->save();
            }
        }
        return redirect()->back()->with('success', 'Timeline Updated Successfully');
    }

    public function updatePmeReview(Request $request)
    {

        foreach ($request->progress ?? [] as $internal_project_data_id => $value) {
            $projectdata = InternalProjectData::find($internal_project_data_id);
            if ($projectdata) {

                if (!empty($value)) {
                    $projectdata->progress = $value;
                    $projectdata->save();
                }
            }
        }
        foreach ($request->pme_target_review ?? [] as $internal_project_data_id => $value) {
            $projectdata = InternalProjectData::find($internal_project_data_id);
            if ($projectdata) {
                if (!empty($value)) {
                    $projectdata->pme_target_review = $value;
                    $projectdata->save();
                }

            }
        }
        foreach ($request->pme_target_remarks ?? [] as $internal_project_data_id => $value) {
            $projectdata = InternalProjectData::find($internal_project_data_id);
            if ($projectdata) {
                $projectdata->pme_target_remarks = $value;
                $projectdata->save();
            }
        }
        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function updateTProgressInputimelineProgress(Request $request)
    {
        // return $request;

        foreach ($request->internal_project_data_id as $key => $internal_project_data_id) {
            $projectdata = InternalProjectData::find($internal_project_data_id);
            if ($projectdata) {

                $new_timeline_progress = [];
                for ($i = 1; $i < 13; $i++) {
                    $new_timeline_progress[$i] = isset($request->progressinput[$key][$i]) && $request->progressinput[$key][$i] ? $request->progressinput[$key][$i] : "";
                }

                $projectdata->timeline_progress = $new_timeline_progress;
                $projectdata->save();
            }
        }


        // foreach ($request->progressinput ?? [] as $internal_project_data_id => $timeline_progress) {
        //     $projectdata = InternalProjectData::find($internal_project_data_id);
        //     if ($projectdata) {

        //         $new_timeline_progress = [];
        //         for ($i = 1; $i < 13; $i++) {

        //             if (empty($timeline_progress[$i])) {
        //                 $new_timeline_progress[$i] = "";
        //             } else {
        //                 $new_timeline_progress[$i] = $timeline_progress[$i];
        //             }
        //         }
        //         // return $new_timeline_progress;
        //         $projectdata->timeline_progress = $new_timeline_progress;
        //         $projectdata->save();
        //     }
        // }
        foreach ($request->remarks ?? [] as $internal_project_data_id => $timeline_remarks) {
            $projectdata = InternalProjectData::find($internal_project_data_id);
            if ($projectdata) {
                $projectdata->remark = $timeline_remarks;
                $projectdata->save();
            }
        }

        foreach ($request->timeline_disbursement_progress ?? [] as $internal_project_data_id => $timeline_disbursement_progress_data) {
            $projectdata = InternalProjectData::find($internal_project_data_id);
            if ($projectdata) {
                $projectdata->timeline_disbursement_progress = $timeline_disbursement_progress_data;
                $projectdata->save();
            }
        }

        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function storeProgressInputMilestoneProgressRemark(Request $request)
    {
        // return $request;

        //check if timeline exists
        $timeline = InternalProjectData::find($request->timeline_id);
        if ($timeline) {
            for ($i = 1; $i <= 12; $i++) {
                //get current remarks
                if (!empty($timeline->timeline_remarks)) {
                    // add to record
                    if (intval($request->timeline_mnth) == $i) {
                        $data['remarks'][$i] = $request->remark;
                    } else {
                        $data['remarks'][$i] = $timeline->timeline_remarks[strval($i)];
                    }
                } else {
                    // create new record
                    if (intval($request->timeline_mnth) == $i) {
                        $data['remarks'][$i] = $request->remark;
                    } else {
                        $data['remarks'][$i] = "";
                    }
                }
            }
            $timeline->timeline_remarks = $data['remarks'];
            $timeline->save();

            return redirect()->back()->with('success-v2', 'Saved successfully');
        }

        toastr()->error("Invalid Timeline");
        return redirect()->back();
    }



    public function automatePME($project_id)
    {
        $automate = false;

        $project_datas = InternalProjectData::where("internal_project_id", $project_id)->where("fiscal_year", FiscalYear::curentFiscalYear())->get();

        //if all milestone have either achived or unachieved then dont auto mate
        foreach ($project_datas as $project_data) {
            if (empty($project_data->pme_target_review)) {
                $automate = true;
            }
        }

        if ($automate == false) {
            return "no need to automate/ now user can overide";
        }

        if (!empty($project_datas)) {
            foreach ($project_datas as $item) {
                if ($item->timeline_target) {
                    $timeline_achived_not_achived = 'not_achived';

                    $total_target_for_milestone = 0;
                    $total_progress_for_milestone = 0;
                    foreach ($item->timeline_target ?? [] as $timeline_month => $time) {
                        if ($time != '') {
                            $total_target_for_milestone++;
                        }
                        if (!empty($item->timeline_progress) && !empty($item->timeline_progress[$timeline_month]) && $item->timeline_progress[$timeline_month] != '') {
                            $total_progress_for_milestone++;
                        }
                    }

                    if ($total_target_for_milestone == $total_progress_for_milestone) {
                        //all target are achieved
                        $timeline_achived_not_achived = 'achived';
                    }

                    //update achived not_achived
                    $item->pme_target_review = $timeline_achived_not_achived;
                    $item->save();
                }
            }
        }
    }

    public function exportProgressReport(Request $request)
    {
        // return $request;
        $project = InternalProject::find($request->project_id);
        if ($project) {

            try {

                $project_datas = InternalProjectData::where("internal_project_id", $request->project_id)->where("fiscal_year", $project->fiscal_year)->get();


                $file_name = strtolower(str_replace(" ", "-", $project->name ?? 'report') . '-' . Str::random(10)) . '.xlsx';
                return Excel::download(new InternalProgressReportExport($project, $project_datas, $request->selected_months), $file_name);
            } catch (\Exception $erro) {
                $request->session()->flash("error", "Try Again ! ! !");

                return redirect()->back();
            }
        }

        return redirect()->route("internal.project.index")->with('error', 'Project not found');
    }
    public function exportPmeFinalReport(Request $request)
    {
        // return $request;
        $project = InternalProject::find($request->project_id);
        if ($project) {

            try {

                $project_datas = InternalProjectData::where("internal_project_id", $request->project_id)->where("fiscal_year", $project->fiscal_year)->get();


                $file_name = strtolower(str_replace(" ", "-", $project->name ?? 'report') . '-' . Str::random(10)) . '.xlsx';
                return Excel::download(new InternalPMEReviewReportExport($project, $project_datas, $request->selected_months), $file_name);
            } catch (\Exception $erro) {
                $request->session()->flash("error", "Try Again ! ! !");

                return redirect()->back();
            }
        }

        return redirect()->route("internal.project.index")->with('error', 'Project not found');
    }

    // Export data in pdfs
    public function pdfTargetReport(Request $request)
    {
        $project_id = $request->projectId;
        $project = InternalProject::find($project_id);
        if (!$project) {
            return redirect()->route("internal.project.index")->with('error', 'Project not found');
        }
        $data["users"] = User::whereNotIn("email", ["root@tdf.org.np", "admin@sysqube.com"])->get();

        // $this->automatePME($project_id);

        $project_datas = InternalProjectData::where("internal_project_id", $project_id)->where("fiscal_year", $project->fiscal_year)->get();

        // share data to view
        $pdf = mb_convert_encoding(View::make('admin.pdf.internal.target-report', [
            "project" => $project,
            "users" => $data["users"],
            "project_datas" => $project_datas,
        ]), 'HTML-ENTITIES', 'UTF-8');
        libxml_use_internal_errors(true);
        return PDF::loadHtml($pdf)->setPaper('A4', 'landscape')->download('internal_target_report.pdf');
    }

    public function pdfProgressReport(Request $request)
    {
        $project_id = $request->projectId;
        $project = InternalProject::find($project_id);
        if ($project) {

            $data["users"] = User::whereNotIn("email", ["root@tdf.org.np", "admin@sysqube.com"])->get();

            // $this->automatePME($project_id);

            $project_datas = InternalProjectData::where("internal_project_id", $project_id)->where("fiscal_year", $project->fiscal_year)->get();

            // share data to view
            $pdf = mb_convert_encoding(View::make('admin.pdf.internal.progress-report', [
                "project" => $project,
                "users" => $data["users"],
                "project_datas" => $project_datas,
            ]), 'HTML-ENTITIES', 'UTF-8');
            libxml_use_internal_errors(true);
            return PDF::loadHtml($pdf)->setPaper('A4', 'landscape')->download('internal_progress_report.pdf');
        }

        return redirect()->route("internal.project.index")->with('error', 'Project not found');
    }
    public function printPmeFinalReport(Request $request)
    {
        $project_id = $request->projectId;
        $project = InternalProject::find($project_id);
        if ($project) {

            $data["users"] = User::whereNotIn("email", ["root@tdf.org.np", "admin@sysqube.com"])->get();

            // $this->automatePME($project_id);

            $project_datas = InternalProjectData::where("internal_project_id", $project_id)->where("fiscal_year", $project->fiscal_year)->get();

            // share data to view
            $pdf = mb_convert_encoding(View::make('admin.pdf.internal.pme-final-report', [
                "project" => $project,
                "users" => $data["users"],
                "project_datas" => $project_datas,
            ]), 'HTML-ENTITIES', 'UTF-8');
            libxml_use_internal_errors(true);
            return PDF::loadHtml($pdf)->setPaper('A4', 'landscape')->download('internal_progress_report.pdf');
            // return Response::make($pdfContent, 200, $headers);
        }

        return redirect()->route("internal.project.index")->with('error', 'Project not found');
    }
}
