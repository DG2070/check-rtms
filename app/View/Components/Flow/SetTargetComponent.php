<?php

namespace App\View\Components\Flow;

use App\Helper\FiscalYear;
use App\Models\ActivityDetail;
use App\Models\Milestone;
use App\Models\ProjectDataSQ;
use App\Models\ProjectDetail;
use App\Models\User;
use Illuminate\View\Component;

class SetTargetComponent extends Component
{
    public function __construct(public $projectId, public $fiscal_year = null)
    {
        $this->projectId = $projectId;
        $this->fiscal_year = request("fiscal_year", FiscalYear::curentFiscalYear());
    }

    public function render()
    {
        $data["users"] = User::whereNotIn("email", ["root@tdf.org.np", "admin@sysqube.com"])->get();

        $data["project"] = ProjectDetail::with([
            "projectActivity" => function ($q) {
                $q->where("fiscal_year", $this->fiscal_year);
            },
            "projectActivity.milestone" => function ($q) {
                $q->orderBy("order", 'asc');
            },
            "projectActivity.milestone.timeline",
            "projectDataSQ" => function ($q) {
                $q->where("fiscal_year", $this->fiscal_year);
            },
            "projectDataSQ.user"
        ])
            ->select(["projectID", "TownName", "Name", "FT", "FP", "NameLong", "programID"])
            ->where("projectID", $this->projectId)->firstOrFail();

        // dd($data["project"]);

        //TODO: optimize
        if (!empty($data["project"]) && !empty($data["project"]["projectDataSQ"]) && count($data["project"]["projectDataSQ"]) > 0) {
            $data["project"]["projectDataSQ"] = $data["project"]["projectDataSQ"][0];
        } else {
            $data["project"]["projectDataSQ"] = null;
        }

        if (!empty($data["project"]->projectDataSQ)) {
            $this->defaultDataForProjectDataSQ($data["project"]);
        }

        $target_locked = false;
        if (!empty($data["project"]->projectDataSQ) && $data["project"]->projectDataSQ->is_locked) {
            $target_locked = true;
        }

        $activities_data = [];
        $milestones_data = [];

        foreach ($data["project"]->projectActivity ?? [] as $act) {
            //-- Activity data
            array_push(
                $activities_data,
                array(
                    "activity_id" => $act->id,
                    "activity_name" => $act->activity,
                )
            );

            foreach ($act->milestone ?? [] as $mile) {
                //-- Milestone data
                array_push(
                    $milestones_data,
                    array(
                        "activity_id" => $mile->project_activity_id,
                        "edit" => 1,
                        "milestone_order" => $mile->order,
                        "milestone_name" => $mile->milestone,
                        "milestone_id" => $mile->id,
                        "milestone_is_text" => $mile->is_text,
                        "performance_indicator" => $mile->performance_indicator,
                    )
                );
            }
        }

        //--old milestones
        $old_milestones_name = Milestone::select(['milestone'])->groupBy('milestone')->get()->pluck('milestone');

        //--old performance indicator
        $old_performance_indicator_name = Milestone::select(['performance_indicator'])->groupBy('performance_indicator')->get()->pluck('performance_indicator');

        return view('components.flow.set-target-component', [
            "project" => $data["project"],
            "users" => $data["users"],
            "target_locked" => $target_locked,
            "milestones_data" => $milestones_data,
            "activities_data" => $activities_data,
            "old_milestones_name" => $old_milestones_name,
            "old_performance_indicator_name" => $old_performance_indicator_name,
            "fiscal_year" => $this->fiscal_year,
        ]);
    }

    public function defaultDataForProjectDataSQ($project)
    {
        $projectdatasq = ProjectDataSQ::where('project_id', $this->projectId)->where('fiscal_year', $this->fiscal_year)->first();
        $activity = ActivityDetail::where("programID", $project->programID)->where("projectID", $this->projectId)->first();
        if ($activity) {
            if (empty($projectdatasq->approved_cost) || $projectdatasq->approved_cost == 0) {
                $projectdatasq->approved_cost = $activity->TDFMatchApproved;
                $projectdatasq->save();
            }
            if (empty($projectdatasq->contractual_cost) || $projectdatasq->contractual_cost == 0) {
                $projectdatasq->contractual_cost = $activity->TDFMatchContracted;
                $projectdatasq->save();
            }
            if (empty($projectdatasq->aggrement_date) || $projectdatasq->aggrement_date == 0) {
                $projectdatasq->aggrement_date = $activity->DateOfSigningFinancialAgreementTDF;
                $projectdatasq->save();
            }
        }
    }
}