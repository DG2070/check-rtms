<?php

namespace App\View\Components\Flow;

use App\Helper\FiscalYear;
use App\Models\Program;
use Illuminate\View\Component;


class PmeFinalReportComponent extends Component
{
    public function __construct(public $programId, public $projectId, public $fiscal_year = null)
    {
        $this->programId = $programId;
        $this->projectId = $projectId;
        $this->fiscal_year = request("fiscal_year", FiscalYear::curentFiscalYear());
    }

    public function render()
    {
        $data["program"] = Program::where('ID', $this->programId)
            ->when($this->projectId, function ($q) {
                $q->whereHas('project', function ($q) {
                    $q->where("projectID", $this->projectId);
                });
            })
            ->with([
                "project" => function ($q) {
                    $q->select(["projectID", "TownName", "Name", "programID", "FT", "FP"])
                        ->when($this->projectId, function ($q) {
                            $q->where("projectID", $this->projectId);
                        });
                },
                "project.projectReview" => function ($q) {
                    $q->where("fiscal_year", $this->fiscal_year);
                },
                "project.projectActivity" => function ($q) {
                    $q->where("fiscal_year", $this->fiscal_year);
                },
                "project.projectActivity.milestone" => function ($q) {
                    $q->orderBy("order", 'asc');
                },
                "project.projectActivity.milestone.timeline",
                "project.lastDisbursement:ProjectID,Disbursement,DisbursementPercentage,approved_date,TDFContractedCost",
                "project.projectDataSQ" => function ($q) {
                    $q->where("fiscal_year", $this->fiscal_year);
                },
            ])
            ->first();



        return view('components.flow.pme-final-report-component', [
            "program" => $data["program"],
            "selectedProgram" => $this->programId,
            "selectedProject" => $this->projectId,
            "fiscalYear" => $this->fiscal_year,
        ]);
    }
}