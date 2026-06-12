<?php

namespace App\View\Components\Project;

use App\Models\Program;
use App\Models\ProjectDetail;
use Illuminate\View\Component;

class ProgressInputComponent extends Component
{
    public $programId;
    public $projectId;
    public $activityId;
    public $milestoneId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($programId, $projectId, $activityId, $milestoneId)
    {
        $this->programId = $programId;
        $this->projectId = $projectId;
        $this->activityId = $activityId;
        $this->milestoneId = $milestoneId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $data["programs"] = Program::select(["ID", "NameLong"])->get();
        $data["projects"] = ProjectDetail::select(["projectID", "programID", "Name"])->get()->toArray();
        $data["is_pdf"] = false;

        $data["program"] = Program::
            // where('ID', $request->program)->
            when($this->projectId, function ($q) {
                $q->whereHas('project', function ($q) {
                    $q->where("projectID", $this->projectId);
                });
            })
            ->with([
                "project" => function ($q) {
                    $q->select(["projectID", "Name", "TownName", "programID", "FT", "FP"])
                        ->when($this->projectId, function ($q) {
                            $q->where("projectID", $this->projectId);
                        });
                },
                "project.projectActivity.milestone.timeline",
                // "project.lastDisbursement:ProjectID,DisbursementPercentage,approved_date,TDFContractedCost"
            ])
            ->first();


        return view('components.project.progress-input-component', [
            "programId" => $this->programId,
            "projectId" => $this->projectId,
            "activityId" => $this->activityId,
            "milestoneId" => $this->milestoneId,
            "program" => $data["program"],
            "is_pdf" => $data["is_pdf"],
        ]);
    }
}
