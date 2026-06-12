<?php

namespace App\View\Components\Project;

use App\Models\Program;
use App\Models\ProjectDetail;
use Illuminate\View\Component;

class ProgressReportComponent extends Component
{
    public $programId;
    public $projectId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($programId, $projectId)
    {
        $this->programId = $programId;
        $this->projectId = $projectId;
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
                    $q->select(["projectID", "Name", "programID", "FT", "FP"])
                        ->when($this->projectId, function ($q) {
                            $q->where("projectID", $this->projectId);
                        });
                },
                "project.projectActivity.milestone.timeline",
                // "project.lastDisbursement:ProjectID,DisbursementPercentage,approved_date,TDFContractedCost"
            ])
            ->first();


        return view('components.project.progress-report-component', [
            "programId" => $this->programId,
            "projectId" => $this->projectId,
            "program" => $data["program"],
            "is_pdf" => $data["is_pdf"],
        ]);
    }
}
