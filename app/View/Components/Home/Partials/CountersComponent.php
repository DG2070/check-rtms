<?php

namespace App\View\Components\Home\Partials;

use App\Helper\FiscalYear;
use App\Models\Department;
use App\Models\InternalProject;
use App\Models\Milestone;
use App\Models\Program;
use App\Models\ProgramDisbursementSummary;
use App\Models\ProjectActivity;
use App\Models\ProjectDataSQ;
use App\Models\ProjectDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class CountersComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // TOTAL DEPARTMENTS
        $data["department_count"] = Department::count();

        $data["user_count"] = $this->getUserCount();

        $program_disbursement_summary = ProgramDisbursementSummary::all();
        $data["total_disbursement_amount"] = $program_disbursement_summary->sum('total_disbursement_amount');

        //all program
        $data["all_program_count"] = Program::count();

        $program_ids = ProjectDataSQ::where("fiscal_year", FiscalYear::curentFiscalYear())->with([
            "project:projectID,programID"
        ])
            ->get()
            ->unique('project_id')->map(function ($pro_act) {
                if (!empty($pro_act->project->programID))
                    return $pro_act->project->programID;
            });
        // dd($program_ids);
        $data["active_program_count"] = count(array_unique($program_ids->toArray()));
        //all project
        $data["all_project_count"] = ProjectDetail::count();
        $data["active_project_count"] = ProjectDataSQ::where("fiscal_year", FiscalYear::curentFiscalYear())->get()->unique("project_id")->count();

        //all internal projects
        $data["all_internal_project_count"] = InternalProject::where("fiscal_year", FiscalYear::curentFiscalYear())->count();



        return view('components.home.partials.counters-component', [
            "department_count" => $data["department_count"],
            "user_count" => $data["user_count"],
            "total_disbursement_amount" => $data["total_disbursement_amount"],
            "all_program_count" => $data["all_program_count"],
            "active_program_count" => $data["active_program_count"],
            "all_project_count" => $data["all_project_count"],
            "active_project_count" => $data["active_project_count"],
            "all_internal_project_count" => $data["all_internal_project_count"],
        ]);
    }

    public function getUserCount()
    {
        if (Auth::user()->hasAnyRole(['Department-Head'])) {

            $user = User::with("departments")->where("id", Auth::id())->first();
            if (count($user->departments) > 0) {
                $depatment = Department::where("id", $user->departments[0]->id)->with("users")->first();
                return count($depatment->users);
            }
            return 0;
        }
        return User::whereNotIn("email", ["admin@sysqube.com", "root@tdf.org.np"])->count();
    }
}