<?php

namespace App\View\Components\Flow;

use App\Helper\FiscalYear;
use App\Models\Program;
use App\Models\ProjectReview;
use Illuminate\View\Component;


class PmeReviewComponent extends Component
{
    public function __construct(public $programId, public $projectId, public $fiscal_year = null)
    {
        $this->programId = $programId;
        $this->projectId = $projectId;
        $this->fiscal_year = request("fiscal_year", FiscalYear::curentFiscalYear());
    }

    public function render()
    {
        //-- TODO: doesnt work
        // $this->automatePmeReview();

        $data["program"] = Program::where('ID', $this->programId)
            ->when($this->projectId, function ($q) {
                $q->whereHas('project', function ($q) {
                    $q->where("projectID", $this->projectId);
                });
            })
            ->with([
                "project" => function ($q) {
                    $q->select(["projectID", "TownName", "Name", "programID", "FT", "FP"])
                        ->when($this->projectId, function ($q) {
                            $q->where("projectID", $this->projectId);
                        });
                },
                "project.projectReview" => function ($q) {
                    $q->where("fiscal_year", $this->fiscal_year);
                },
                "project.projectActivity" => function ($q) {
                    $q->where("fiscal_year", $this->fiscal_year);
                },
                "project.projectActivity.milestone" => function ($q) {
                    $q->orderBy("order", 'asc');
                },
                "project.projectActivity.milestone.timeline",
                "project.lastDisbursement:ProjectID,Disbursement,DisbursementPercentage,approved_date,TDFContractedCost",
                "project.projectDataSQ" => function ($q) {
                    $q->where("fiscal_year", $this->fiscal_year);
                },
            ])
            ->first();

        return view('components.flow.pme-review-component', [
            "program" => $data["program"],
            "fiscalYear" => $this->fiscal_year,
        ]);
    }

    public function automatePmeReview()
    {
        $automate = false;

        $program = Program::where('ID', $this->programId)
            ->when($this->projectId, function ($q) {
                $q->whereHas('project', function ($q) {
                    $q->where("projectID", $this->projectId);
                });
            })
            ->with([
                "project" => function ($q) {
                    $q->select(["projectID", "Name", "programID", "FT", "FP"])
                        ->when($this->projectId, function ($q) {
                            $q->where("projectID", $this->projectId);
                        });
                },
                "project.projectReview",
                "project.projectActivity.milestone.timeline",
                "project.lastDisbursement:ProjectID,Disbursement,DisbursementPercentage,approved_date,TDFContractedCost",
                "project.projectDataSQ" => function ($q) {
                    $q->where("fiscal_year", $this->fiscal_year);
                },
            ])
            ->first();

        //if all milestone have either achived or unachieved then dont auto mate
        foreach ($program->project as $pro_key => $project) {
            foreach ($project->projectActivity as $pro_act) {
                foreach ($pro_act->milestone as $key2 => $mile) {
                    $projectreview = ProjectReview::where("project_id", $this->projectId)->where("fiscal_year", FiscalYear::curentFiscalYear())->first();
                    if ($projectreview) {
                        if (count($projectreview->target) != count($pro_act->milestone)) {
                            $automate = true;
                        }
                    }
                }
            }
        }

        if ($automate == false) {
            return "no need to automate/ now user can overide";
        }

        //Start automate
        foreach ($program->project as $pro_key => $project) {
            foreach ($project->projectActivity as $pro_act) {
                foreach ($pro_act->milestone as $key2 => $mile) {

                    if ($mile->timeline) {

                        $timeline_achived_not_achived = "not_achived";

                        $total_target_for_milestone = 0;
                        $total_progress_for_milestone = 0;
                        foreach ($mile->timeline->timeline ?? [] as $timeline_month => $time) {
                            if ($time != "") {
                                $total_target_for_milestone++;
                            }
                            if (!empty($mile->timeline->progress_input_data) && !empty($mile->timeline->progress_input_data[$timeline_month]) && $mile->timeline->progress_input_data[$timeline_month] != "") {
                                $total_progress_for_milestone++;
                            }
                        }

                        if ($total_target_for_milestone == $total_progress_for_milestone) {
                            //all target are achieved
                            $timeline_achived_not_achived = "achived";
                        }

                        //update achived not_achived
                        $projectreview = ProjectReview::where("project_id", $project->projectID)->where("fiscal_year", FiscalYear::curentFiscalYear())->first();
                        if ($projectreview) {
                            $new_target_data = [];

                            $milestone_contains_in_target = false;

                            foreach ($projectreview->target as $milestone_id => $target_data) {
                                if ($milestone_id == $mile->id) {
                                    $milestone_contains_in_target = true;
                                    $new_target_data[strval($milestone_id)] = $timeline_achived_not_achived;
                                } else {
                                    $new_target_data[strval($milestone_id)] = $target_data;
                                }
                            }
                            // if (!$milestone_contains_in_target) {
                            //     $new_target_data[strval($mile->id)] = $target_data;
                            // }
                            $projectreview->target = $new_target_data;
                            $projectreview->save();
                        } else {
                            //create new one
                            ProjectReview::create([
                                "project_id" => $project->projectID,
                                "fiscal_year" => FiscalYear::curentFiscalYear(),
                                "target" => [
                                    strval($mile->id) => $timeline_achived_not_achived
                                ],
                                "progress" => [],
                                "remarks" => [],
                            ]);
                        }


                        // dd($all_progress_achieved_in_timeline);
                        // dd($total_progress_for_milestone);
                    }
                }
            }
        }
    }
}