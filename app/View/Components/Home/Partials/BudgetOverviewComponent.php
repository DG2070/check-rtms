<?php

namespace App\View\Components\Home\Partials;

use App\Helper\FinancialMilestone;
use App\Helper\FiscalYear;
use App\Models\Department;
use App\Models\ProgramDisbursementSummary;
use App\Models\ProjectActivity;
use App\Models\ProjectDataSQ;
use App\Models\ProjectDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class BudgetOverviewComponent extends Component
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
        // $program_disbursement_summary = ProgramDisbursementSummary::all();
        // $data["total_disbursement_amount"] = $program_disbursement_summary->sum('total_disbursement_amount');

        if (Auth::user()->hasAnyRole(["Department-Head"])) {

            [
                $financialtarget_values_permonth,
                $financialprogress_values_permonth,
                $physical_target_values_permonth,
                $physical_progress_values_permonth,
                $approved_budget_overall,
                $financial_target,
                $financial_progress,
                $physical_target,
                $physical_progress,
            ] = $this->totalBudgetForCurrentYearByMonthFOrDepartmentHead();
        } else {

            [
                $financialtarget_values_permonth,
                $financialprogress_values_permonth,
                $physical_target_values_permonth,
                $physical_progress_values_permonth,
                $approved_budget_overall,
                $financial_target,
                $financial_progress,
                $physical_target,
                $physical_progress,
            ] = $this->totalBudgetForCurrentYearByMonth();
        }



        return view('components.home.partials.budget-overview-component', [
            // "total_disbursement_amount" => $data["total_disbursement_amount"],
            "approved_budget_overall" => $approved_budget_overall,
            "financial_target" =>  $financial_target,
            "financial_progress" =>  $financial_progress,
            "physical_target" =>  $physical_target,
            "physical_progress" =>  $physical_progress,
            "financialtarget_values_permonth" => $financialtarget_values_permonth,
            "financialprogress_values_permonth" => $financialprogress_values_permonth,
            "physical_target_values_permonth" => $physical_target_values_permonth,
            "physical_progress_values_permonth" => $physical_progress_values_permonth,
        ]);
    }



    public function totalBudgetForCurrentYearByMonth()
    {
        $timelines = [
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
        ];
        $physical_timelines = [
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
        ];
        //get project activity

        if (Auth::user()->can("Access All Project")) {
            //All Project Activities
            $projectactivitys = ProjectActivity::where("fiscal_year", $this->fiscal_year)->with([
                "project:projectID,programID",
                "milestone.timeline"
            ])->get();
        } else {

            //Assigned Project Activities
            $projectactivitys = ProjectActivity::where("fiscal_year", $this->fiscal_year)->where(function ($query) {
                $query->whereJsonContains('main_responsibility', Auth::id())
                    ->orWhereJsonContains('supportive_responsibility', Auth::id());
            })->with([
                "project:projectID,programID",
                "milestone.timeline"
            ])
                ->get();
        }

        foreach ($projectactivitys as $project_activity) {
            if (!empty($project_activity->milestone)) {
                foreach ($project_activity->milestone ?? [] as $milestone) {

                    //check if financial target
                    if (in_array(strtolower(trim($milestone->milestone)), FinancialMilestone::milestoneNames())) {
                        if (!empty($milestone->timeline)) {
                            for ($i = 1; $i < 13; $i++) {
                                if (!empty($milestone->timeline->timeline) && $milestone->timeline->timeline[strval($i)] != "") {
                                    $timelines[$i - 1]["target"] = $timelines[$i - 1]["target"] + intval($milestone->timeline->timeline[strval($i)]);
                                }

                                if (!empty($milestone->timeline->progress_input_data) && $milestone->timeline->progress_input_data[strval($i)] != "") {
                                    $timelines[$i - 1]["progress"] = $timelines[$i - 1]["progress"] + $milestone->timeline->progress_input_data[strval($i)];
                                }
                            }
                        }
                    }

                    //check if physical target
                    if (str_contains(strtolower(trim($milestone->milestone)), 'physical target')) {

                        if (!empty($milestone->timeline)) {
                            for ($i = 1; $i < 13; $i++) {
                                if (!empty($milestone->timeline->timeline) && $milestone->timeline->timeline[strval($i)] != "") {
                                    $physical_timelines[$i - 1]["target"] = $physical_timelines[$i - 1]["target"] + intval($milestone->timeline->timeline[strval($i)]);
                                }

                                if (!empty($milestone->timeline->progress_input_data) && $milestone->timeline->progress_input_data[strval($i)] != "") {
                                    $physical_timelines[$i - 1]["progress"] = $physical_timelines[$i - 1]["progress"] + $milestone->timeline->progress_input_data[strval($i)];
                                }
                            }
                        }
                    }
                }
            }
        }

        $finance_timeline_collection = collect($timelines);
        $physical_timeline_collection = collect($physical_timelines);

        //get all project ids
        $projectactivitys_collection =  collect($projectactivitys);
        $project_ids = $projectactivitys_collection->pluck("project_id")->filter();

        //get ProjectDataSQ by project_ids
        $project_data_sq =  ProjectDataSQ::where("fiscal_year", $this->fiscal_year)->whereIn("project_id", $project_ids)->get();

        return [
            $finance_timeline_collection->pluck("target"),
            $finance_timeline_collection->pluck("progress"),
            $physical_timeline_collection->pluck("target"),
            $physical_timeline_collection->pluck("progress"),
            $project_data_sq->sum("approved_budget"),
            $project_data_sq->sum("FT"),
            $project_data_sq->sum("FP"),
            $project_data_sq->sum("PT"),
            $project_data_sq->sum("PP"),
        ];
    }
    public function totalBudgetForCurrentYearByMonthFOrDepartmentHead()
    {
        $timelines = [
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
        ];
        $physical_timelines = [
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
        ];


        //get all departmnet user ids
        $user_ids = [];


        $user =  User::with("departments")->where("id", Auth::id())->first();
        if (count($user->departments) > 0) {
            $depatment = Department::where("id", $user->departments[0]->id)->with("users")->first();
            $user_ids  = collect($depatment->users)->pluck("id");
        }

        //get assigned project activity for department users
        $projectactivitys = ProjectActivity::where("fiscal_year", $this->fiscal_year)->where(function ($query) use ($user_ids) {
            $query->whereJsonContains('main_responsibility', $user_ids)
                ->orWhereJsonContains('supportive_responsibility', $user_ids);
        })->with([
            "project:projectID,programID"
        ])
            ->get();


        foreach ($projectactivitys as $project_activity) {
            if (!empty($project_activity->milestone)) {
                foreach ($project_activity->milestone ?? [] as $milestone) {

                    if (str_contains(strtolower($milestone->milestone), 'financial target') || str_contains(strtolower($milestone->milestone), 'disbursement target')) {

                        if (!empty($milestone->timeline)) {
                            for ($i = 1; $i < 13; $i++) {
                                if (!empty($milestone->timeline->timeline) && $milestone->timeline->timeline[strval($i)] != "") {
                                    $timelines[$i - 1]["target"] = $timelines[$i - 1]["target"] + intval($milestone->timeline->timeline[strval($i)]);
                                }

                                if (!empty($milestone->timeline->progress_input_data) && $milestone->timeline->progress_input_data[strval($i)] != "") {
                                    $timelines[$i - 1]["progress"] = $timelines[$i - 1]["progress"] + $milestone->timeline->progress_input_data[strval($i)];
                                }
                            }
                        }
                    }
                    if (str_contains(strtolower($milestone->milestone), 'physical target')) {

                        if (!empty($milestone->timeline)) {
                            for ($i = 1; $i < 13; $i++) {
                                if (!empty($milestone->timeline->timeline) && $milestone->timeline->timeline[strval($i)] != "") {
                                    $physical_timelines[$i - 1]["target"] = $physical_timelines[$i - 1]["target"] + intval($milestone->timeline->timeline[strval($i)]);
                                }

                                if (!empty($milestone->timeline->progress_input_data) && $milestone->timeline->progress_input_data[strval($i)] != "") {
                                    $physical_timelines[$i - 1]["progress"] = $physical_timelines[$i - 1]["progress"] + $milestone->timeline->progress_input_data[strval($i)];
                                }
                            }
                        }
                    }
                }
            }
        }

        $finance_timeline_collection = collect($timelines);
        $physical_timeline_collection = collect($physical_timelines);

        //get all project ids
        $projectactivitys_collection =  collect($projectactivitys);
        $project_ids = $projectactivitys_collection->pluck("project_id")->filter();

        //get ProjectDataSQ by project_ids
        $project_data_sq =  ProjectDataSQ::where("fiscal_year", $this->fiscal_year)->whereIn("project_id", $project_ids)->get();

        return [
            $finance_timeline_collection->pluck("target"),
            $finance_timeline_collection->pluck("progress"),
            $physical_timeline_collection->pluck("target"),
            $physical_timeline_collection->pluck("progress"),
            $project_data_sq->sum("approved_budget"),
            $project_data_sq->sum("FT"),
            $project_data_sq->sum("FP"),
            $project_data_sq->sum("PT"),
            $project_data_sq->sum("PP"),
        ];
    }
}
