<?php

namespace App\View\Components\Project;

use App\Models\ProjectDetail;
use App\Models\User;
use Illuminate\View\Component;

class ActivityMilestoneComponent extends Component
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
        $data["users"]  =  User::whereNotIn("email", ["root@tdf.org.np", "admin@sysqube.com"])->get();
        // $data["users"]  =  User::whereHas(
        //     'roles',
        //     function ($q) {
        //         $q->where('name', 'Supportive User')->orWhere('name', 'Admin')->orderBy("name");
        //     }
        // )->get();

        $data["project"] = ProjectDetail::with(["projectActivity.milestone.timeline"])
            ->select(["projectID", "Name", "FT", "FP", "NameLong", "programID"])
            ->where("projectID", $this->projectId)->firstOrFail();

        return view('components.project.activity-milestone-component', [
            "project" =>
            $data["project"],
            "users" =>
            $data["users"],

        ]);
    }
}
