<?php

namespace App\View\Components\Project;

use App\Models\ProjectDetail;
use App\Models\ProjectReview;
use Illuminate\View\Component;

class PmeReportInputComponent extends Component
{
    public $projectId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $data["project"] = ProjectDetail::with(["projectActivity.milestone", "program", "progress"])
        ->select(["projectID", "Name", "NameLong", "programID"])
        ->where("projectID", $this->projectId)->firstOrFail();
        $data["reviews"] = ProjectReview::where("project_id",$this->projectId)->first();

        return view('components.project.pme-report-input-component',[
            "project"=>$data["project"],
            "reviews"=>$data["reviews"],
        ]);
    }
}
