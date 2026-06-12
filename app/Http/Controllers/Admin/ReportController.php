<?php
namespace App\Http\Controllers\Admin;

set_time_limit(5 * 60); // Extend the maximum execution time

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ProjectDetail;

class ReportController extends Controller
{

    public function progressReportDownload(Request $request)
    {
        // return $request;
        $request->validate([
            "fiscal_year" => "required",
            "programId" => "required",
            "projectId" => "sometimes",
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

        $data["fiscalYear"] = $request->fiscal_year;
        $data["programId"] = $request->programId;
        $data["projectId"] = $request->projectId;
        $data["program_name"] = $request->programId != "" ? Program::where("ID", $request->programId)->value("NameLong") : "";

        //-- For Single Project Single File Download
        if ($request->has("projectId") && $request->projectId != "") {

            $data["project"] = $data["program"]->project[0];
            $data["programName"] = $data["program"]->NameLong;
            $data["pdfTitle"] = "[" . $data["project"]->TownName . "] " . $data["project"]->Name . " " . "Progress Report - 20" . $request->fiscal_year;

            //-- PDF File name
            $pdfFileName = Str::slug($data["pdfTitle"]) . ".pdf";
            //-- Create PDF
            $pdf = PDF::loadView("admin.pdf.sidebar.progress-report", $data);
            $pdf->setPaper('A4', 'landscape');

            return $pdf->download($pdfFileName);
        }

        //-- For Multiple Project
        //-- Initialize an array to store PDF file paths
        $pdfFilePaths = [];
        foreach ($data["program"]->project as $project) {
            if (count($project->projectActivity ?? []) == 0) {
                //-- No need to create pdf for project without activity
                continue;
            }
            $programName = $data["program_name"];
            $pdfTitle = "[" . $project->TownName . "] " . $project->Name . " " . "Progress Report - 20" . $data["fiscalYear"];
            //-- PDF File name
            $pdfFileName = Str::slug($pdfTitle) . ".pdf";
            //-- Create PDF
            $pdf = PDF::loadView("admin.pdf.report.progress-report", [
                "programName" => $programName,
                "fiscalYear" => $data["fiscalYear"],
                "pdfTitle" => $pdfTitle,
                "project" => $project,
            ]);
            $pdf->setPaper('A4', 'landscape');

            //-- Save the PDF to a temporary file
            $tempFilePath = storage_path('app/public/temp/' . $pdfFileName);
            $pdf->save($tempFilePath);
            //-- Store the file path in the array
            $pdfFilePaths[] = $tempFilePath;
        }

        if (count($pdfFilePaths) == 0) {
            return back();
        }

        // Zip the PDF files into a single archive
        $zipFileName = 'progress_reports.zip';
        $zipFilePath = storage_path('app/public/temp/' . $zipFileName);
        $zip = new \ZipArchive();
        $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($pdfFilePaths as $filePath) {
            $zip->addFile($filePath, basename($filePath));
        }

        $zip->close();

        // Provide the download link for the ZIP archive and delete the files after sending
        $response = response()->download($zipFilePath, $zipFileName)
            ->deleteFileAfterSend(true);

        // Remove the individual PDF files
        foreach ($pdfFilePaths as $filePath) {
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        return $response;

    }

    public function pmeReviewReportDownload(Request $request)
    {
        // return $request;
        $request->validate([
            "fiscal_year" => "required",
            "programId" => "required",
            "projectId" => "sometimes",
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

        $data["fiscalYear"] = $request->fiscal_year;
        $data["programId"] = $request->programId;
        $data["projectId"] = $request->projectId;
        $data["program_name"] = $request->programId != "" ? Program::where("ID", $request->programId)->value("NameLong") : "";

        //-- For Single Project Single File Download
        if ($request->has("projectId") && $request->projectId != "") {

            $data["project"] = $data["program"]->project[0];
            $data["programName"] = $data["program"]->NameLong;
            $data["pdfTitle"] = "[" . $data["project"]->TownName . "] " . $data["project"]->Name . " " . "PME Final Review Report - 20" . $request->fiscal_year;
            //-- PDF File name
            $pdfFileName = Str::slug($data["pdfTitle"]) . ".pdf";
            //-- Create PDF
            $pdf = PDF::loadView("admin.pdf.sidebar.pme-final-report", $data);
            $pdf->setPaper('A4', 'landscape');

            return $pdf->download($pdfFileName);
        }

        //-- For Multiple Project
        //-- Initialize an array to store PDF file paths
        $pdfFilePaths = [];
        foreach ($data["program"]->project as $project) {
            if (count($project->projectActivity ?? []) == 0) {
                //-- No need to create pdf for project without activity
                continue;
            }
            $programName = $data["program_name"];
            $pdfTitle = "[" . $project->TownName . "] " . $project->Name . " " . "PME Final Review Report - 20" . $data["fiscalYear"];
            //-- PDF File name
            $pdfFileName = Str::slug($pdfTitle) . ".pdf";
            //-- Create PDF
            $pdf = PDF::loadView("admin.pdf.report.pme-final-report", [
                "programName" => $programName,
                "fiscalYear" => $data["fiscalYear"],
                "pdfTitle" => $pdfTitle,
                "project" => $project,
            ]);
            $pdf->setPaper('A4', 'landscape');

            //-- Save the PDF to a temporary file
            $tempFilePath = storage_path('app/public/temp/' . $pdfFileName);
            $pdf->save($tempFilePath);
            //-- Store the file path in the array
            $pdfFilePaths[] = $tempFilePath;
        }

        if (count($pdfFilePaths) == 0) {
            return back();
        }

        // Zip the PDF files into a single archive
        $zipFileName = 'pme_final_reports.zip';
        $zipFilePath = storage_path('app/public/temp/' . $zipFileName);
        $zip = new \ZipArchive();
        $zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($pdfFilePaths as $filePath) {
            $zip->addFile($filePath, basename($filePath));
        }

        $zip->close();

        // Provide the download link for the ZIP archive and delete the files after sending
        $response = response()->download($zipFilePath, $zipFileName)
            ->deleteFileAfterSend(true);

        // Remove the individual PDF files
        foreach ($pdfFilePaths as $filePath) {
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        return $response;

    }

}
