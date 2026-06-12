<?php

namespace App\View\Components\Home\Partials;

use App\Helper\FiscalYear;
use App\Models\ProjectActivity;
use App\Models\ProjectDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class AllProjectComponent extends Component
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
        //get project activity
        $projectactivity = ProjectActivity::where("fiscal_year", $this->fiscal_year)->with([
            "project:projectID,programID"
        ])
            ->get();
        $projectactivity =
            //assigned project_ids
            $project_ids = collect($projectactivity)->map(function ($pro_act) {
                if (!empty($pro_act->project->projectID)) {
                    return $pro_act->project->projectID;
                }
            })->filter()->toArray();
        $data["projects"] = ProjectDetail::with([
            "town",
            "program" => function ($q) {
                $q->select(["ID", "Name", "NameLong", "Code"]);
            },
            "curentFiscialYearProjectDataSQ",
            "projectActivity",

        ])->whereIn("projectID", $project_ids)
        // ->select(["projectID", "TownName","programID","Name", "Province"])
        ->get();

        // dd($data['projects'][0]->town->Province);

        return view('components.home.partials.all-project-component', [
            "projects" => $data["projects"],
        ]);
    }
}
