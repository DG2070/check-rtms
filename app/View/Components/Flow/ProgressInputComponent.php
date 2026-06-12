<?php

namespace App\View\Components\Flow;

use App\Helper\FiscalYear;
use App\Models\Program;
use App\Models\ProjectDetail;
use Illuminate\View\Component;

class ProgressInputComponent extends Component
{
    public function __construct(public $programId, public $projectId, public $activityId, public $milestoneId, public $fiscal_year = null)
    {
        $this->programId = $programId;
        $this->projectId = $projectId;
        $this->activityId = $activityId;
        $this->milestoneId = $milestoneId;
        $this->fiscal_year = request("fiscal_year", FiscalYear::curentFiscalYear());
    }

    public function render()
    {
        $data["is_pdf"] = false;

        $data["program"] = Program::when($this->projectId, function ($q) {
            $q->whereHas('project', function ($q) {
                $q->where("projectID", $this->projectId);
            });
        })
            ->with([
                "project" => function ($q) {
                    $q->select(["projectID", "TownName", "Name", "TownName", "programID", "FT", "FP"])
                        ->when($this->projectId, function ($q) {
                            $q->where("projectID", $this->projectId);
                        });
                },
                "project.projectActivity" => function ($q) {
                    $q->where("fiscal_year", $this->fiscal_year);
                },
                "project.projectActivity.milestone" => function ($q) {
                    $q->orderBy("order", 'asc');
                },
                "project.projectActivity.milestone.timeline",
            ])
            ->first();

        // dump($data["program"]);

        return view('components.flow.progress-input-component', [
            "programId" => $this->programId,
            "projectId" => $this->projectId,
            "activityId" => $this->activityId,
            "milestoneId" => $this->milestoneId,
            "program" => $data["program"],
            "is_pdf" => $data["is_pdf"],
            "fiscalYear" => $this->fiscal_year,
        ]);
    }
}