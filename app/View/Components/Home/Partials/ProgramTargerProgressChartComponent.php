<?php

namespace App\View\Components\Home\Partials;

use App\Helper\FiscalYear;
use App\Models\ProjectDataSQ;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Log;

class ProgramTargerProgressChartComponent extends Component
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
        [
            $program_names,
            $program_FTs,
            $program_FPs,
        ] = $this->chartDataForActiveProgram();

        // Log::info($program_FTs);
        // Log::info($program_FPs);
        // dd($this->chartDataForActiveProgram());

        return view('components.home.partials.program-targer-progress-chart-component', [

            "program_names" => $program_names,
            "program_FTs" => $program_FTs,
            "program_FPs" => $program_FPs,
        ]);
    }


    public function chartDataForActiveProgram()
    {
        $active_program_data = collect($this->activeProgramData());

        return [
            $active_program_data->pluck("Name"),
            $active_program_data->pluck("FT"),
            $active_program_data->pluck("FP"),
        ];
    }

    public function activeProgramData()
    {
        $active_program_datas = [];

        foreach (ProjectDataSQ::where("fiscal_year", $this->fiscal_year)->with(["project", "project.program"])->get() as $projectdatasq) {

            //check if program data already pushed
            if (array_key_exists($projectdatasq->project->programID, $active_program_datas)) {
                //only update FT,FP,PT,PP data
                $active_program_datas[$projectdatasq->project->programID]["FT"] = $active_program_datas[$projectdatasq->project->programID]["FT"] + (intval($projectdatasq->FT) ?? 0);
                $active_program_datas[$projectdatasq->project->programID]["FP"] = $active_program_datas[$projectdatasq->project->programID]["FP"] + (intval($projectdatasq->FP) ?? 0);
            } else {
                //initial push
                $active_program_datas[$projectdatasq->project->programID] = [
                    "Name" => $projectdatasq->project->program->Name,
                    "FT" => intval($projectdatasq->FT) ?? 0,
                    "FP" => intval($projectdatasq->FP) ?? 0,
                ];
            }
        }


        return $active_program_datas;
    }
}
