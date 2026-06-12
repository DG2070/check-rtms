<?php

namespace App\Http\Controllers\Flow;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProjectDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FlowController extends Controller
{
    public function __construct(
        Request $request,
        public $programId = "",
        public $projectId = "",
        public $isSetTarget = false,
        public $program_name = "",
        public $project_name = "",
        public $fiscal_year = "",
    ) {
        //-- For Fiscal Year
        if ($request->has("fiscal_year") && $request->fiscal_year != "") {
            $this->fiscal_year = $request->fiscal_year;
        }
        //-- For Set Target
        if ($request->has("isSetTarget") && $request->isSetTarget != "") {
            $this->isSetTarget = $request->isSetTarget;
        }
        //-- If not set target
        if (!$this->isSetTarget) {
            //-- Set Program ID
            if ($request->has("programID") && $request->programID != "") {
                $this->programId = $request->programID;
            }
            //-- Set Project ID
            if ($request->has("projectID") && $request->projectID != "") {
                $this->projectId = $request->projectID;
            }
            //-- For Cookie Based Program ID
            // if ($this->programId != "") {
            //     //-- Set cookies
            //     Cookie::queue('s_program_id', $this->programId);
            // } else {
            //     //-- check if cookie value is set
            //     $this->programId = Cookie::get('s_program_id') ?? "";
            // }
            //-- For Cookie Based Project ID
            // if ($this->projectId != "") {
            //     //-- Set cookies
            //     Cookie::queue('s_project_id', $this->projectId);
            // } else {
            //     //-- check if cookie value is set
            //     $this->projectId = Cookie::get('s_project_id') ?? "";
            // }
            //-- For Cookie Based Fiscal Year
            // if ($this->fiscal_year != "") {
            //     //-- Set cookies
            //     Cookie::queue('s_fiscal_year', $this->fiscal_year);
            // } else {
            //     //-- check if cookie value is set
            //     $this->fiscal_year = Cookie::get('s_fiscal_year') ?? "";
            // }
            $this->program_name = $this->programId != "" ? Program::where("ID", $this->programId)->value("NameLong") : "";
            $this->project_name = $this->projectId != "" ? ProjectDetail::where("projectID", $this->projectId)->value("Name") : "";
        }
        //-- Pass the fiscal_year via request
        // $request->merge(["fiscal_year" => $this->fiscal_year]);
    }

    public function setTargetIndex(Request $request)
    {
        $programId = $request->programID ?? '';
        $projectId = $request->projectID ?? '';

        $program_name = $programId != "" ? Program::where("ID", $programId)->value("NameLong") : "";
        $project_name = $projectId != "" ? ProjectDetail::where("projectID", $projectId)->value("Name") : "";

        return view("admin.flow.set-target", [
            'programId' => $programId,
            'projectId' => $projectId,
            'program_name' => $program_name,
            'project_name' => $project_name,
        ]);
    }
    public function targetReportIndex()
    {
        return view("admin.flow.target-report", [
            'programId' => $this->programId,
            'projectId' => $this->projectId,
            'program_name' => $this->program_name,
            'project_name' => $this->project_name,
        ]);
    }
    public function progressInputIndex(Request $request)
    {
        $data["selectedActivityId"] = $request->pi_activity_id ?? '';
        $data["selectedMilestoneId"] = $request->pi_milestone_id ?? '';

        return view("admin.flow.progress-input", [
            'programId' => $this->programId,
            'projectId' => $this->projectId,
            'program_name' => $this->program_name,
            'project_name' => $this->project_name,
            'selectedActivityId' => $data["selectedActivityId"],
            'selectedMilestoneId' => $data["selectedMilestoneId"],
        ]);
    }
    public function progressReportIndex()
    {
        return view("admin.flow.progress-report", [
            'programId' => $this->programId,
            'projectId' => $this->projectId,
            'program_name' => $this->program_name,
            'project_name' => $this->project_name,
        ]);
    }
    public function pmeReviewIndex()
    {
        return view("admin.flow.pme-review", [
            'programId' => $this->programId,
            'projectId' => $this->projectId,
            'program_name' => $this->program_name,
            'project_name' => $this->project_name,
        ]);
    }
    public function pmeFinalReportIndex()
    {
        return view("admin.flow.pme-final-report", [
            'programId' => $this->programId,
            'projectId' => $this->projectId,
            'program_name' => $this->program_name,
            'project_name' => $this->project_name,
        ]);
    }

    public function downloadTargetReport(Request $request)
    {
        // return $request;
        $request->validate([
            "fiscal_year" => "required",
            "programId" => "required",
            "projectId" => "required",
        ]);

        $data["program"] = Program::where('ID', $request->programId)
            ->when($request->projectId, function ($q) use ($request) {
                $q->whereHas('project', function ($q) use ($request) {
                    $q->where("projectID", $request->projectId);
                });
            })
            ->with([
                "project" => function ($q) use ($request) {
                    $q->select(["projectID", "TownName", "Name", "programID", "FT", "FP"])
                        ->when($request->projectId, function ($q) use ($request) {
                            $q->where("projectID", $request->projectId);
                        });
                },
                "project.projectActivity" => function ($q) use ($request) {
                    $q->where("fiscal_year", $request->fiscal_year);
                },
                "project.projectActivity.milestone" => function ($q) {
                    $q->orderBy("order", 'asc');
                },
                "project.projectActivity.milestone.timeline",
                "project.projectDataSQ" => function ($q) use ($request) {
                    $q->where("fiscal_year", $request->fiscal_year);
                },
                "project.lastDisbursement:ProjectID,Disbursement,DisbursementPercentage,approved_date,TDFContractedCost",
            ])
            ->first();

        $data["project"] = $data["program"]->project[0];
        $data["fiscalYear"] = $request->fiscal_year;
        $data["programId"] = $request->programId;
        $data["projectId"] = $request->projectId;
        $data["programName"] = $data["program"]->NameLong;
        $data["pdfTitle"] = "[" . $data["project"]->TownName . "] " . $data["project"]->Name . " " . "Target Report - 20" . $request->fiscal_year;
        // return $data;
        //-- PDF File name
        $pdfFileName = Str::slug($data["pdfTitle"]) . ".pdf";
        // Create PDF
        $pdf = PDF::loadView("admin.pdf.sidebar.target-report", $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download($pdfFileName);
    }

    public function downloadProgressReport(Request $request)
    {
        $request->validate([
            "fiscal_year" => "required",
            "programId" => "required",
            "projectId" => "required",
        ]);

        $data["program"] = Program::where('ID', $request->programId)
            ->when($request->projectId, function ($q) use ($request) {
                $q->whereHas('project', function ($q) use ($request) {
                    $q->where("projectID", $request->projectId);
                });
            })
            ->with([
                "project" => function ($q) use ($request) {
                    $q->select(["projectID", "TownName", "Name", "programID", "FT", "FP"])
                        ->when($request->projectId, function ($q) use ($request) {
                            $q->where("projectID", $request->projectId);
                        });
                },
                "project.projectActivity" => function ($q) use ($request) {
                    $q->where("fiscal_year", $request->fiscal_year);
                },
                "project.projectActivity.milestone" => function ($q) {
                    $q->orderBy("order", 'asc');
                },
                "project.projectActivity.milestone.timeline",
                "project.lastDisbursement:ProjectID,Disbursement,DisbursementPercentage,approved_date,TDFContractedCost",
                "project.projectDataSQ" => function ($q) use ($request) {
                    $q->where("fiscal_year", $request->fiscal_year);
                },
            ])
            ->first();
        $data["project"] = $data["program"]->project[0];
        $data["fiscalYear"] = $request->fiscal_year;
        $data["programId"] = $request->programId;
        $data["projectId"] = $request->projectId;
        $data["programName"] = $data["program"]->NameLong;
        $data["pdfTitle"] = "[" . $data["project"]->TownName . "] " . $data["project"]->Name . " " . "Progress Report - 20" . $request->fiscal_year;

        //-- PDF File name
        $pdfFileName = Str::slug($data["pdfTitle"]) . ".pdf";
        //-- Create PDF
        $pdf = PDF::loadView("admin.pdf.sidebar.progress-report", $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download($pdfFileName);
    }

    public function downloadPmeFinalReport(Request $request)
    {
        $request->validate([
            "fiscal_year" => "required",
            "programId" => "required",
            "projectId" => "required",
        ]);

        $data["program"] = Program::where('ID', $request->programId)
            ->when($request->projectId, function ($q) use ($request) {
                $q->whereHas('project', function ($q) use ($request) {
                    $q->where("projectID", $request->projectId);
                });
            })
            ->with([
                "project" => function ($q) use ($request) {
                    $q->select(["projectID", "TownName", "Name", "programID", "FT", "FP"])
                    ->when($request->projectId, function ($q) use ($request) {
                        $q->where("projectID", $request->projectId);
                    });
                },
                "project.projectReview" => function ($q) use ($request) {
                    $q->where("fiscal_year", $request->fiscal_year);
                },
                "project.projectActivity" => function ($q) use ($request) {
                    $q->where("fiscal_year", $request->fiscal_year);
                },
                "project.projectActivity.milestone" => function ($q) {
                    $q->orderBy("order", 'asc');
                },
                "project.projectActivity.milestone.timeline",
                "project.lastDisbursement:ProjectID,Disbursement,DisbursementPercentage,approved_date,TDFContractedCost",
                "project.projectDataSQ" => function ($q) use ($request) {
                    $q->where("fiscal_year", $request->fiscal_year);
                },
            ])
            ->first();


        $data["project"] = $data["program"]->project[0];
        $data["fiscalYear"] = $request->fiscal_year;
        $data["programId"] = $request->programId;
        $data["projectId"] = $request->projectId;
        $data["programName"] = $data["program"]->NameLong;
        $data["pdfTitle"] = "[" . $data["project"]->TownName . "] " . $data["project"]->Name . " " . "PME Final Review Report - 20" . $request->fiscal_year;

        //-- PDF File name
        $pdfFileName = Str::slug($data["pdfTitle"]) . ".pdf";
        //-- Create PDF
        $pdf = PDF::loadView("admin.pdf.sidebar.pme-final-report", $data);
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download($pdfFileName);
    }
}
