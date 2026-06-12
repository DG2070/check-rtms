<?php

namespace App\View\Components\Flow\Partials;

use App\Helper\FiscalYear;
use App\Models\Program;
use App\Models\ProjectActivity;
use App\Models\ProjectDataSQ;
use App\Models\ProjectDetail;
use App\Models\TownList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\Component;

class ControlsComponent extends Component
{
    public function __construct(
        Request $request,
        public $programId = "",
        public $projectId = "",
        public $isSetTarget = false,
        public $selectedProgramId = "",
        public $selectedProjectId = "",
    ) {
        $this->programId = $programId;
        $this->projectId = $projectId;
        $this->isSetTarget = $isSetTarget;

        if ($request->has("programID") && $request->programID != "") {
            $this->selectedProgramId = $request->programID;
        } else {
            $this->selectedProgramId = "";
        }
        if ($request->has("projectID") && $request->projectID != "") {
            $this->selectedProjectId = $request->projectID;
        } else {
            $this->selectedProjectId = "";
        }
    }

    public function render()
    {
        $data["redirect_home"] = false;
        //-- Show all program and projects if user has "Access All Project" permission
        if (auth()->user()->can('Access All Project')) {
            $data["programs"] = Program::get();
            $data["projects"] = ProjectDetail::select(["projectID", "TownName", "programID", "Name"])->get();
        } else {
            //-- Get assigned project activity
            $projectactivity = ProjectActivity::whereJsonContains('main_responsibility', Auth::id())
                ->orWhereJsonContains('supportive_responsibility', Auth::id())
                ->with([
                    "project:projectID,programID"
                ])
                ->get();
            //-- Assigned program_ids
            $program_ids = collect($projectactivity)->map(function ($pro_act) {
                if (!empty($pro_act->project->programID)) {
                    return $pro_act->project->programID;
                }
            })->filter()->toArray();
            //-- Assigned project_ids
            $project_ids = collect($projectactivity)->map(function ($pro_act) {
                if (!empty($pro_act->project->projectID)) {
                    return $pro_act->project->projectID;
                }
            })->filter()->toArray();

            $data["programs"] = Program::whereIn("ID", $program_ids)->get();
            $data["projects"] = ProjectDetail::whereIn("projectID", $project_ids)->select(["projectID", "TownName", "programID", "Name"])->get();
            //-- Check if  user can access selectedProgramId & selectedProjectId
            if ($this->selectedProgramId !== "" && !in_array($this->selectedProgramId, $program_ids)) {
                $data["redirect_home"] = true;
            }
            if ($this->selectedProjectId !== "" && !in_array($this->selectedProjectId, $project_ids)) {
                $data["redirect_home"] = true;
            }
        }

        return view('components.flow.partials.controls-component', [
            "isSetTarget" => $this->isSetTarget,
            "programId" => $this->programId,
            "projectId" => $this->projectId,
            "programs" => $data["programs"],
            "projects" => $data["projects"],
            "townlists" => TownList::select(["ID", "TownName"])->orderBy("TownName")->get()->unique('TownName'),
            'redirect_home' => $data["redirect_home"],
        ]);
    }
    // public function render()
    // {
    //     $data["redirect_home"] = false;
    //     // show all program and projects if user has "Access All Project" permission
    //     if (auth()->user()->can('Access All Project')) {
    //         if ($this->isSetTarget) {
    //             $data["programs"] = Program::select(["ID", "NameLong", "Code", "Name"])->get();
    //             $data["projects"] = ProjectDetail::select(["projectID", "TownName", "programID", "Name"])->get();
    //         } else {
    //             //-- active programs
    //             //get all active programs
    //             $program_ids = ProjectDataSQ::where("fiscal_year", FiscalYear::curentFiscalYear())->with([
    //                 "project:projectID,programID"
    //             ])
    //                 ->get()
    //                 ->unique('project_id')->map(function ($pro_act) {
    //                     if (!empty($pro_act->project->programID))
    //                         return $pro_act->project->programID;
    //                 });
    //             $data["programs"] = Program::whereIn("ID", $program_ids)->select(["ID", "NameLong", "Code", "Name"])->get();
    //             //-- active projects
    //             $active_projects_fy_ids = ProjectDataSQ::where("fiscal_year", FiscalYear::curentFiscalYear())->select("project_id")->get()->unique("project_id")->pluck("project_id");
    //             $data["projects"] = ProjectDetail::whereIn("projectID", $active_projects_fy_ids)->select(["projectID", "programID", "Name", "TownName"])->get();
    //         }
    //     } else {
    //         //get assigned project activity
    //         $projectactivity = ProjectActivity::whereJsonContains('main_responsibility', Auth::id())
    //             ->orWhereJsonContains('supportive_responsibility', Auth::id())
    //             ->with([
    //                 "project:projectID,programID"
    //             ])
    //             ->get();
    //         //assigned program_ids
    //         $program_ids = collect($projectactivity)->map(function ($pro_act) {
    //             if (!empty($pro_act->project->programID)) {
    //                 return $pro_act->project->programID;
    //             }
    //         })->filter()->toArray();
    //         //assigned project_ids
    //         $project_ids = collect($projectactivity)->map(function ($pro_act) {
    //             if (!empty($pro_act->project->projectID)) {
    //                 return $pro_act->project->projectID;
    //             }
    //         })->filter()->toArray();

    //         $data["programs"] = Program::whereIn("ID", $program_ids)->select(["ID", "Code", "NameLong", "FundGrant", "FinancingAgency", "Name"])->get();
    //         if ($this->isSetTarget) {
    //             $data["projects"] = ProjectDetail::whereIn("projectID", $project_ids)->select(["projectID", "TownName", "programID", "Name"])->get();
    //         } else {
    //             $active_projects_fy_ids = ProjectDataSQ::where("fiscal_year", FiscalYear::curentFiscalYear())->select("project_id")->get()->unique("project_id")->pluck("project_id");
    //             $data["projects"] = ProjectDetail::whereIn("projectID", $active_projects_fy_ids)->select(["projectID", "programID", "Name", "TownName"])->get();
    //         }
    //         //check if  user can access selectedProgramId & selectedProjectId
    //         if ($this->selectedProgramId !== "" && !in_array($this->selectedProgramId, $program_ids)) {
    //             $data["redirect_home"] = true;
    //         }
    //         if ($this->selectedProjectId !== "" && !in_array($this->selectedProjectId, $project_ids)) {
    //             $data["redirect_home"] = true;
    //         }
    //     }

    //     return view('components.flow.partials.controls-component', [
    //         "isSetTarget" => $this->isSetTarget,
    //         "programId" => $this->programId,
    //         "projectId" => $this->projectId,
    //         "programs" => $data["programs"],
    //         "projects" => $data["projects"],
    //         "townlists" => TownList::select(["ID", "TownName"])->orderBy("TownName")->get()->unique('TownName'),
    //         'redirect_home' => $data["redirect_home"],
    //     ]);
    // }
}