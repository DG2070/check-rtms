<?php

namespace App\View\Components\Home\Partials;

use App\Helper\FiscalYear;
use App\Models\Department;
use App\Models\ProjectActivity;
use App\Models\ProjectDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class AllProjectByDepartmentComponent extends Component
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
        //get all departmnet user ids
        $user_ids = [];


        $user =  User::with("departments")->where("id", Auth::id())->first();
        if (count($user->departments) > 0) {
            $depatment = Department::where("id", $user->departments[0]->id)->with("users")->first();
            $user_ids  = collect($depatment->users)->pluck("id");
        }



        //get assigned project activity for department users
        $projectactivity = ProjectActivity::where("fiscal_year", $this->fiscal_year)->where(function ($query) use ($user_ids) {
            $query->whereJsonContains('main_responsibility', $user_ids)
                ->orWhereJsonContains('supportive_responsibility', $user_ids);
        })->with([
            "project:projectID,programID"
        ])
            ->get();

        //assigned project_ids
        $project_ids = collect($projectactivity)->map(function ($pro_act) {
            if (!empty($pro_act->project->projectID)) {
                return $pro_act->project->projectID;
            }
        })->filter()->toArray();

        $data["projects"] = ProjectDetail::with([
            "program" => function ($q) {
                $q->select(["ID", "Name", "NameLong", "Code"]);
            },
            "curentFiscialYearProjectDataSQ",

        ])->whereIn("projectID", $project_ids)->select(["projectID", "TownName", "programID", "Name"])->get();

        return view('components.home.partials.all-project-by-department-component', [
            "projects" => $data["projects"],
            "data" => $projectactivity
        ]);
    }
}
