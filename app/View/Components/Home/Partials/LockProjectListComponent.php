<?php

namespace App\View\Components\Home\Partials;

use App\Helper\FiscalYear;
use App\Models\ProjectDataSQ;
use Illuminate\View\Component;

class LockProjectListComponent extends Component
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
        //get all locked projects

       $project_datas = ProjectDataSQ::where("fiscal_year", FiscalYear::curentFiscalYear())->where("is_locked",true)->
        with([
            "lockedUser",
            "project",
            "project.program",
            "project.curentFiscialYearProjectDataSQ",
        ])
        ->get();


        return view('components.home.partials.lock-project-list-component',[
            "project_datas" => $project_datas
        ]);
    }
}
