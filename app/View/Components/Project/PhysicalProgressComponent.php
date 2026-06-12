<?php

namespace App\View\Components\Project;

use App\Models\ProjectDetail;
use App\Models\PhysicalProgress;
use Illuminate\View\Component;

class PhysicalProgressComponent extends Component
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
        $data["project"] = ProjectDetail::where("projectID", $this->projectId)->firstOrFail();

        $data["progress"] = PhysicalProgress::where("project_id", $this->projectId)->get() ?? [];

        return view('components.project.physical-progress-component', [
            "project" => $data["project"],
            "progress" => $data["progress"],
        ]);
    }
}
