<?php

namespace App\View\Components\Home\Partials;

use App\Models\User;
use App\Models\Program;
use App\Helper\FiscalYear;
use App\Models\Department;
use App\Models\ProjectDataSQ;
use App\Models\ProjectDetail;
use Illuminate\View\Component;
use App\Models\ProjectActivity;
use App\Helper\FinancialMilestone;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OverallChartComponent extends Component
{
    public $fiscal_year;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->fiscal_year = FiscalYear::curentFiscalYear();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        [
            $approved_budget_overall,
            $financial_target,
            $financial_progress,
            $physical_target,
            $physical_progress,
        ] = $this->totalBudgetForCurrentYearByMonth();

        // Log:
        // info($approved_budget_overall);

        [
            $program_names,
            $program_FT_P,
            $program_FP_P,
            $program_PT_P,
            $program_PP_P,

            $program_FT,
            $program_FP,
            $program_PT,
            $program_PP,
        ] = $this->chartDataForActiveProgram();


        $physical_target = 0;
        $physical_progress = 0;
        if (count($program_PT->toArray()) > 0) {
            $physical_target = 100;


            $total_physical_target =  array_sum($program_PT->toArray());
            $total_physical_progress =  array_sum($program_PP->toArray());

            if ($total_physical_target  != 0) {
                $physical_progress = ($total_physical_progress / $total_physical_target) * 100;
                $physical_progress = number_format((float)$physical_progress, 2, '.', '');
            }
        }


        // dd($program_FT);
        return view('components.home.partials.overall-chart-component', [


            "program_names" => $program_names,
            "program_FT_P" => $program_FT_P,
            "program_FP_P" => $program_FP_P,
            "program_PT_P" => $program_PT_P,
            "program_PP_P" => $program_PP_P,

            "approved_budget_overall" => $approved_budget_overall,
            "financial_target" =>  $financial_target,
            "financial_progress" =>  $financial_progress,
            "physical_target" =>  $physical_target,
            "physical_progress" =>  $physical_progress,


            // "approved_budget_overall" => $approved_budget_overall,
            // "financial_target" =>  $financial_target,
            // "financial_progress" =>  $financial_progress,
            // "physical_target" =>  $physical_target,
            // "physical_progress" =>  $physical_progress,
            // "financialtarget_values_permonth" => $financialtarget_values_permonth,
            // "financialprogress_values_permonth" => $financialprogress_values_permonth,
            // "physical_target_values_permonth" => $physical_target_values_permonth,
            // "physical_progress_values_permonth" => $physical_progress_values_permonth,
        ]);
    }

    public function chartDataForActiveProgram()
    {
        $active_program_data = collect($this->activeProgramData());

        return [
            $active_program_data->pluck("Name"),
            $active_program_data->pluck("FT_P"),
            $active_program_data->pluck("FP_P"),
            $active_program_data->pluck("PT_P"),
            $active_program_data->pluck("PP_P"),
            $active_program_data->pluck("FT"),
            $active_program_data->pluck("FP"),
            $active_program_data->pluck("PT"),
            $active_program_data->pluck("PP"),
        ];
    }

    public function activeProgramData()
    {
        $active_program_datas = [];

        foreach (ProjectDataSQ::where("fiscal_year", $this->fiscal_year)->with(["project", "project.program"])->get() as $projectdatasq) {

            //check if program data already pushed
            if (array_key_exists($projectdatasq->project->programID, $active_program_datas)) {
                //only update FT,FP,PT,PP data
                $active_program_datas[$projectdatasq->project->programID]["FT"] = $active_program_datas[$projectdatasq->project->programID]["FT"] + (intval($projectdatasq->FT) ?? 0);
                $active_program_datas[$projectdatasq->project->programID]["FP"] = $active_program_datas[$projectdatasq->project->programID]["FP"] + (intval($projectdatasq->FP) ?? 0);
                $active_program_datas[$projectdatasq->project->programID]["PT"] = $active_program_datas[$projectdatasq->project->programID]["PT"] + (intval($projectdatasq->PT) ?? 0);
                $active_program_datas[$projectdatasq->project->programID]["PP"] = $active_program_datas[$projectdatasq->project->programID]["PP"] + (intval($projectdatasq->PP) ?? 0);
            } else {
                //initial push
                $active_program_datas[$projectdatasq->project->programID] = [
                    "programID" => $projectdatasq->project->programID,
                    "Name" => $projectdatasq->project->program->Name,
                    "NameLong" => $projectdatasq->project->program->NameLong,
                    "Code" => $projectdatasq->project->program->Code,
                    "FT" => intval($projectdatasq->FT) ?? 0,
                    "FP" => intval($projectdatasq->FP) ?? 0,
                    "PT" => intval($projectdatasq->PT) ?? 0,
                    "PP" => intval($projectdatasq->PP) ?? 0,
                ];
            }
        }

        foreach ($active_program_datas as $program_id => $active_program_data) {

            $active_program_datas[$program_id]["FT_P"] = 0;
            $active_program_datas[$program_id]["FP_P"] = 0;
            if ($active_program_datas[$program_id]["FT"] != 0) {
                $active_program_datas[$program_id]["FT_P"] = 100;
                $active_program_datas[$program_id]["FP_P"] = ($active_program_datas[$program_id]["FP"] / $active_program_datas[$program_id]["FT"]) * 100;
                $active_program_datas[$program_id]["FP_P"] =  number_format((float)$active_program_datas[$program_id]["FP_P"], 2, '.', '');
            }

            // $active_program_datas[$program_id]["FP_P"] = ($active_program_datas[$program_id]["FP"] / $active_program_datas[$program_id]["FT"]) * 100;
            // $active_program_datas[$program_id]["FP_P"] = number_format((float) $active_program_datas[$program_id]["FP_P"], 2, '.', '')   ;
            $active_program_datas[$program_id]["PT_P"] = 0;
            $active_program_datas[$program_id]["PP_P"] = 0;
            if ($active_program_datas[$program_id]["PT"] != 0) {
                $active_program_datas[$program_id]["PT_P"] = 100;
                $active_program_datas[$program_id]["PP_P"] = ($active_program_datas[$program_id]["PP"] / $active_program_datas[$program_id]["PT"]) * 100;
                $active_program_datas[$program_id]["PP_P"] =  number_format((float)$active_program_datas[$program_id]["PP_P"], 2, '.', '');
            }
            // $active_program_datas[$program_id]["PP_P"] = number_format((float) $active_program_datas[$program_id]["PP_P"], 2, '.', '')   ;
        }

        return $active_program_datas;
    }

    public function totalBudgetForCurrentYearByMonth()
    {
        $project_data_sq =  ProjectDataSQ::where('fiscal_year', $this->fiscal_year)
            // ->whereColumn('approved_budget', 'FT')
            ->get();

        return [
            $project_data_sq->sum("approved_budget"),
            $project_data_sq->sum("FT"),
            $project_data_sq->sum("FP"),
            $project_data_sq->sum("PT"),
            $project_data_sq->sum("PP"),
        ];
    }
    // public function totalBudgetForCurrentYearByMonth()
    // {
    //     $timelines = [
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //     ];
    //     $physical_timelines = [
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //         [
    //             "target" => 0,
    //             "progress" => 0,
    //         ],
    //     ];
    //     //get project activity

    //     if (Auth::user()->can("Access All Project")) {
    //         //All Project Activities
    //         $projectactivitys = ProjectActivity::where("fiscal_year", $this->fiscal_year)->with([
    //             "project:projectID,programID",
    //             "milestone.timeline"
    //         ])->get();
    //     } else {

    //         //Assigned Project Activities
    //         $projectactivitys = ProjectActivity::where("fiscal_year", $this->fiscal_year)->where(function ($query) {
    //             $query->whereJsonContains('main_responsibility', Auth::id())
    //                 ->orWhereJsonContains('supportive_responsibility', Auth::id());
    //         })->with([
    //             "project:projectID,programID",
    //             "milestone.timeline"
    //         ])
    //             ->get();
    //     }

    //     foreach ($projectactivitys as $project_activity) {
    //         if (!empty($project_activity->milestone)) {
    //             foreach ($project_activity->milestone ?? [] as $milestone) {

    //                 if (in_array(strtolower(trim($milestone->milestone)),  FinancialMilestone::milestoneNames())) {

    //                     if (!empty($milestone->timeline)) {
    //                         for ($i = 1; $i < 13; $i++) {
    //                             if (!empty($milestone->timeline->timeline) && $milestone->timeline->timeline[strval($i)] != "") {
    //                                 $timelines[$i - 1]["target"] = $timelines[$i - 1]["target"] + intval($milestone->timeline->timeline[strval($i)]);
    //                             }

    //                             if (!empty($milestone->timeline->progress_input_data) && $milestone->timeline->progress_input_data[strval($i)] != "") {
    //                                 $timelines[$i - 1]["progress"] = $timelines[$i - 1]["progress"] + $milestone->timeline->progress_input_data[strval($i)];
    //                             }
    //                         }
    //                     }
    //                 }
    //                 if (str_contains(strtolower(trim($milestone->milestone)), 'physical target')) {

    //                     if (!empty($milestone->timeline)) {
    //                         for ($i = 1; $i < 13; $i++) {
    //                             if (!empty($milestone->timeline->timeline) && $milestone->timeline->timeline[strval($i)] != "") {
    //                                 $physical_timelines[$i - 1]["target"] = $physical_timelines[$i - 1]["target"] + intval($milestone->timeline->timeline[strval($i)]);
    //                             }

    //                             if (!empty($milestone->timeline->progress_input_data) && $milestone->timeline->progress_input_data[strval($i)] != "") {
    //                                 $physical_timelines[$i - 1]["progress"] = $physical_timelines[$i - 1]["progress"] + $milestone->timeline->progress_input_data[strval($i)];
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     $finance_timeline_collection = collect($timelines);
    //     $physical_timeline_collection = collect($physical_timelines);

    //     //get all project ids
    //     // $projectactivitys_collection =  collect($projectactivitys);
    //     // $project_ids = $projectactivitys_collection->pluck("project_id")->filter();

    //     //get ProjectDataSQ for fiscal year
    //     // $project_data_sq =  ProjectDataSQ::whereIn("project_id", $project_ids)
    //     //     ->where(function ($query) {
    //     //         $query->where('fiscal_year', $this->fiscal_year);
    //     //     })
    //     // ->get();

    //     $project_data_sq =  ProjectDataSQ::where('fiscal_year', $this->fiscal_year)
    //         ->whereColumn('approved_budget', 'FT')->get();

    //     return [
    //         $project_data_sq->sum("approved_budget"),
    //         $project_data_sq->sum("FT"),
    //         $project_data_sq->sum("FP"),
    //         $project_data_sq->sum("PT"),
    //         $project_data_sq->sum("PP"),
    //     ];
    // }
}


/**
 * Project ID (SUS)
 *
 *
 *
 *
 */
