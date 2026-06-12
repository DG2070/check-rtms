<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PMEReviewReportExport;
use App\Exports\ProgressReportExport;
use App\Helper\FiscalYear;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProgramStoreRequest;
use App\Models\{Program, ProjectDetail, ProjectReview, ActivityDetail, DisbursementDetail, ProjectActivity, PhysicalProgress, Timeline, Milestone, ProjectDataSQ};
use App\Models\TownList;
// use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use Str;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $program_filter_type = "active_program";

        if ($request->has("program_filter_type") && $request->program_filter_type != "") {
            if ($request->program_filter_type == "all_program") {
                $program_filter_type = "all_program";
            }
        }

        if ($program_filter_type == "active_program") {

            $program_ids = ProjectActivity::where("fiscal_year", FiscalYear::curentFiscalYear())->with([
                "project:projectID,programID"
            ])
                ->get()
                ->unique('project_id')->map(function ($pro_act) {
                    if (!empty($pro_act->project->programID))
                        return $pro_act->project->programID;
                });
            $data["programs"] = Program::whereIn("ID", $program_ids)->select(["ID", "Code", "NameLong", "FundGrant", "FinancingAgency"])->orderBy("NameLong")->get();


            // show all active program and projects if user has "Access All Project" permission
            if (auth()->user()->can('Access All Project') || auth()->user()->hasAnyRole(['ED'])) {

                $program_ids = ProjectDataSQ::where("fiscal_year", FiscalYear::curentFiscalYear())->with([
                    "project:projectID,programID"
                ])
                    ->get()
                    ->unique('project_id')->map(function ($pro_act) {
                        if (!empty($pro_act->project->programID))
                            return $pro_act->project->programID;
                    });
                $data["programs"] = Program::whereIn("ID", $program_ids)->select(["ID", "Code", "NameLong", "FundGrant", "FinancingAgency"])->orderBy("NameLong")->get();
            } else {
                // show all active program which are assigned
                $program_ids = ProjectDataSQ::where("fiscal_year", FiscalYear::curentFiscalYear())
                    ->where(function ($query) {
                        $query->whereJsonContains('main_responsibility', Auth::id())
                            ->orWhereJsonContains('supportive_responsibility', Auth::id());
                    })
                    ->with([
                        "project:projectID,programID"
                    ])
                    ->get()->unique('project_id')->map(function ($pro_act) {
                        if (!empty($pro_act->project->programID))
                            return $pro_act->project->programID;
                    });


                $data["programs"] = Program::whereIn("ID", $program_ids)->select(["ID", "Code", "NameLong", "FundGrant", "FinancingAgency"])->orderBy("NameLong")->get();
            }
        } else {

            // show all program and projects if user has "Access All Project" permission
            if (auth()->user()->can('Access All Project') || auth()->user()->hasAnyRole(['ED'])) {

                $data["programs"] = Program::select(["ID", "Code", "NameLong", "FundGrant", "FinancingAgency"])->orderBy("NameLong")->get();
            } else {
                //get assigned projects
                $program_ids = ProjectActivity::whereJsonContains('main_responsibility', Auth::id())
                    ->orWhereJsonContains('supportive_responsibility', Auth::id())
                    ->with([
                        "project:projectID,programID"
                    ])
                    ->get()
                    ->unique('project_id')->map(function ($pro_act) {
                        if (!empty($pro_act->project->programID))
                            return $pro_act->project->programID;
                    });

                $data["programs"] = Program::whereIn("ID", $program_ids)->select(["ID", "Code", "NameLong", "FundGrant", "FinancingAgency"])->orderBy("NameLong")->get();
            }
        }

        return view("admin.programs.index", compact("data", "program_filter_type"));
    }

    public function progressReportFilter(Request $request)
    {
        $data["fiscal_year"] = $request->fiscal_year ?? FiscalYear::curentFiscalYear();
        $data["fiscalYear"] =  $data["fiscal_year"];
        $data["selectedProgram"] = $request->program ?? '';
        $data["selectedProject"] = $request->project ?? '';
        $data["is_pdf"] = false;

        $data["programs"] = Program::select(["ID", "NameLong", "Code", "Name"])->get();
        $data["projects"] = ProjectDetail::select(["projectID", "TownName", "programID", "Name"])->get()->toArray();


        $data["program"] = Program::where('ID', $request->program)
            ->when($request->project, function ($q) use ($request) {
                $q->whereHas('project', function ($q) use ($request) {
                    $q->where("projectID", $request->project);
                });
            })
            ->with([
                "project" => function ($q) use ($request) {
                    $q->select(["projectID", "Name", "TownName", "programID", "FT", "FP"])
                        ->when($request->project, function ($q) use ($request) {
                            $q->where("projectID", $request->project);
                        });
                },
                "project.projectActivity" => function ($q) use ($request) {
                    $q->where("fiscal_year", $request->fiscal_year);
                },
                "project.projectActivity.milestone.timeline",
                "project.lastDisbursement:ProjectID,Disbursement,DisbursementPercentage,approved_date,TDFContractedCost",
                "project.projectDataSQ" => function ($q) use ($data) {
                    $q->where("fiscal_year", $data["fiscal_year"]);
                },
                "project.activityDetail" => function ($q) use ($request) {
                    $q->where("programID", $request->program);
                },
                "project.activityDetail.allDisbursementFromMisOnlyDisbursement",

            ])
            ->first();

        return view("admin.report.progress-report", $data);
    }
    public function downloadFile(Request $request)
    {
        $project = $request->project ?? '';

        $data["fiscal_year"] = $request->fiscal_year ?? FiscalYear::curentFiscalYear();
        $data["fiscalYear"] =  $data["fiscal_year"];
        $data["selectedProgram"] = $request->program ?? '';
        $data["selectedProject"] = $request->project ?? '';
        $data["is_pdf"] = false;

        $data["programs"] = Program::select(["ID", "NameLong", "Code", "Name"])->get();
        $data["projects"] = ProjectDetail::select(["projectID", "TownName", "programID", "Name"])->get()->toArray();


        $data["program"] = Program::where('ID', $request->program)
            ->when($request->project, function ($q) use ($request) {
                $q->whereHas('project', function ($q) use ($request) {
                    $q->where("projectID", $request->project);
                });
            })
            ->with([
                "project" => function ($q) use ($request) {
                    $q->select(["projectID", "Name", "TownName", "programID", "FT", "FP"])
                        ->when($request->project, function ($q) use ($request) {
                            $q->where("projectID", $request->project);
                        });
                },
                "project.projectActivity.milestone.timeline",
                "project.lastDisbursement:ProjectID,Disbursement,DisbursementPercentage,approved_date,TDFContractedCost",
                "project.projectDataSQ" => function ($q) {
                    $q->where("fiscal_year", '79/80');
                },
                "project.activityDetail" => function ($q) use ($request) {
                    $q->where("programID", $request->program);
                },
                "project.activityDetail.allDisbursementFromMisOnlyDisbursement",

            ])
            ->first();
        $pdf = PDF::loadView('admin.pdf.progress-report1', $data);
        $pdf->setPaper('A4', 'landscape');

        $pdf->render();
        $pdfContent = $pdf->output();

        //     // Set the response headers
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
        // Create a response with the PDF content and headers
        return Response::make($pdfContent, 200, $headers);
        //  return  $pdf->download("export.pdf");
    }

    public function downloadProgressReport(Request $request)
    {
        try {
            $data["programs"] = Program::select(["ID", "NameLong"])->get();
            $data["projects"] = ProjectDetail::select(["projectID", "TownName", "programID", "Name"])->get()->toArray();
            $data["is_pdf"] = true;
            $data["program"] = Program::where('ID', $request->program)
                ->when($request->project, function ($q) use ($request) {
                    $q->whereHas('project', function ($q) use ($request) {
                        $q->where("projectID", $request->project);
                    });
                })
                ->with([
                    "project" => function ($q) use ($request) {
                        $q->select(["projectID", "TownName", "Name", "programID", "FT", "FP"])
                            ->when($request->project, function ($q) use ($request) {
                                $q->where("projectID", $request->project);
                            });
                    },
                    "project.projectActivity.milestone.timeline",
                    // "project.lastDisbursement:ProjectID,DisbursementPercentage,approved_date,TDFContractedCost"
                ])
                ->first();

            $pdf = PDF::loadView('admin.pdf.progress-report', $data);
            $pdf->setPaper('A4', 'landscape');
            $file_name = strtolower(str_replace(" ", "-", $data["program"]->NameLong ?? 'report') . '-' . Str::random(10)) . '.pdf';

            return $pdf->stream($file_name);
        } catch (\Exception $erro) {

            $request->session()->flash("error", "Try Again ! ! !");

            return redirect()->back();
        }
    }

    public function exportProgressReport(Request $request)
    {
        try {

            $program = Program::where('ID', $request->program)
                ->when($request->project, function ($q) use ($request) {
                    $q->whereHas('project', function ($q) use ($request) {
                        $q->where("projectID", $request->project);
                    });
                })
                ->with([
                    "project" => function ($q) use ($request) {
                        $q->select(["projectID", "TownName", "Name", "programID", "FT", "FP"])
                            ->when($request->project, function ($q) use ($request) {
                                $q->where("projectID", $request->project);
                            });
                    },
                    "project.projectActivity.milestone.timeline",
                    "project.projectDataSQ" => function ($q) {
                        $q->where("fiscal_year", '79/80');
                    },
                    // "project.lastDisbursement:ProjectID,DisbursementPercentage,approved_date,TDFContractedCost"
                ])
                ->first();
            // dd($program);
            $file_name = strtolower(str_replace(" ", "-", $program->NameLong ?? 'report') . '-' . Str::random(10)) . '.xlsx';
            return Excel::download(new ProgressReportExport($program, $request->selected_months), $file_name);
        } catch (\Exception $erro) {
            $request->session()->flash("error", "Try Again ! ! !");

            return redirect()->back();
        }
    }

    public function pmeReviewReportFilter(Request $request)
    {
        $data["fiscal_year"] = $request->fiscal_year ?? FiscalYear::curentFiscalYear();
        $data["fiscalYear"] =  $data["fiscal_year"];
        $data["selectedProgram"] = $request->program ?? '';
        $data["selectedProject"] = $request->project ?? '';
        $data["is_pdf"] = false;
        $data["programs"] = Program::select(["ID", "NameLong", "Code", 'Name'])->get();
        $data["projects"] = ProjectDetail::select(["projectID", "TownName", "programID", "Name"])->get()->toArray();

        $data["program"] = Program::where('ID', $request->program)
            ->when($request->project, function ($q) use ($request) {
                $q->whereHas('project', function ($q) use ($request) {
                    $q->where("projectID", $request->project);
                });
            })
            ->with([
                "project" => function ($q) use ($request) {
                    $q->select(["projectID", "TownName", "Name", "programID"])
                        ->when($request->project, function ($q) use ($request) {
                            $q->where("projectID", $request->project);
                        });
                },
                "project.projectReview" =>function ($q) use ($request) {
                    $q->where("fiscal_year", $request->fiscal_year);
                },
                "project.projectActivity" => function ($q) use ($request) {
                    $q->where("fiscal_year", $request->fiscal_year);
                },
                "project.projectActivity.milestone",
                "project.lastDisbursement",
                "project.projectDataSQ" => function ($q) use ($data) {
                    $q->where("fiscal_year", $data["fiscal_year"]);
                },
            ])
            ->first();

        return view("admin.report.pme-review-report", $data);
    }

    public function downloadPMEReport(Request $request)
    {
        try {
            $data["programs"] = Program::select(["ID", "NameLong"])->get();
            $data["projects"] = ProjectDetail::select(["projectID", "programID", "Name"])->get()->toArray();
            $data["is_pdf"] = true;
            $data["program"] = Program::where('ID', $request->program)
                ->when($request->project, function ($q) use ($request) {
                    $q->whereHas('project', function ($q) use ($request) {
                        $q->where("projectID", $request->project);
                    });
                })
                ->with([
                    "project" => function ($q) use ($request) {
                        $q->select(["projectID", "Name", "programID"])
                            ->when($request->project, function ($q) use ($request) {
                                $q->where("projectID", $request->project);
                            });
                    },
                    "project.projectReview",
                    "project.projectActivity.milestone",
                    "project.lastDisbursement",
                    "project.projectDataSQ" => function ($q) {
                        $q->where("fiscal_year", '79/80');
                    },
                ])
                ->first();

            $pdf = PDF::loadView('admin.pdf.pme-review-report', $data);
            $pdf->setPaper('A4', 'landscape');
            $file_name = strtolower(str_replace(" ", "-", $data["program"]->NameLong ?? 'report') . '-' . Str::random(10)) . '.pdf';

            return $pdf->stream($file_name);
        } catch (\Exception $error) {

            $request->session()->flash("error", "Try Again ! ! !");

            return redirect()->back();
        }
    }

    public function exportPMEReport(Request $request)
    {
        try {
            $program = Program::where('ID', $request->program)
                ->when($request->project, function ($q) use ($request) {
                    $q->whereHas('project', function ($q) use ($request) {
                        $q->where("projectID", $request->project);
                    });
                })
                ->with([
                    "project" => function ($q) use ($request) {
                        $q->select(["projectID", "Name", "programID", "FT", "FP"])
                            ->when($request->project, function ($q) use ($request) {
                                $q->where("projectID", $request->project);
                            });
                    },
                    "project.projectReview",
                    "project.projectActivity.milestone.timeline",
                    "project.lastDisbursement:ProjectID,Disbursement,DisbursementPercentage,approved_date,TDFContractedCost",
                    "project.projectDataSQ" => function ($q) {
                        $q->where("fiscal_year", '79/80');
                    },
                    // "project.lastDisbursement:ProjectID,DisbursementPercentage,approved_date,TDFContractedCost"
                ])
                ->first();




            $file_name = strtolower(str_replace(" ", "-", $program->NameLong ?? 'report') . '-' . Str::random(10)) . '.xlsx';
            return Excel::download(new PMEReviewReportExport($program, $request->selected_months), $file_name);
        } catch (\Exception $error) {

            $request->session()->flash("error", "Try Again ! ! !");

            return redirect()->back();
        }
    }

    public function newProgramIndex(Request $request)
    {
        $data["fiscal_year"] = $request->fiscal_year ?? '';
        $data["selectedProgramId"] = $request->programID ?? '';
        $data["selectedProjectId"] = $request->projectID ?? '';
        $data["selectedActivityId"] = $request->pi_activity_id ?? '';
        $data["selectedMilestoneId"] = $request->pi_milestone_id ?? '';

        $data["program_name"] = $data["selectedProgramId"] != "" ? Program::where("ID", $data["selectedProgramId"])->value("NameLong") : "";
        $data["project_name"] = $data["selectedProjectId"] != "" ? ProjectDetail::where("projectID", $data["selectedProjectId"])->value("Name") : "";

        $data["programs"] = [];
        $data["projects"] = [];
        $data["townlist"] = TownList::select(["ID", "TownName"])->orderBy("TownName")->get()->unique('TownName');


        // show all program and projects if user has "Access All Project" permission
        if (auth()->user()->can('Access All Project')) {
            $data["programs"] = Program::select(["ID", "Name", "NameLong", "Code"])->get();
            $data["projects"] = ProjectDetail::select(["projectID", "TownName", "programID", "Name"])->get();
        } else {
            //get assigned project activity
            $projectactivity = ProjectActivity::whereJsonContains('main_responsibility', Auth::id())
                ->orWhereJsonContains('supportive_responsibility', Auth::id())
                ->with([
                    "project:projectID,programID"
                ])
                ->get();
            //assigned program_ids
            $program_ids = collect($projectactivity)->map(function ($pro_act) {
                if (!empty($pro_act->project->programID)) {
                    return $pro_act->project->programID;
                }
            })->filter()->toArray();
            //assigned project_ids
            $project_ids = collect($projectactivity)->map(function ($pro_act) {
                if (!empty($pro_act->project->projectID)) {
                    return $pro_act->project->projectID;
                }
            })->filter()->toArray();

            $data["programs"] = Program::whereIn("ID", $program_ids)->select(["ID", "Code", "Name", "NameLong", "FundGrant", "FinancingAgency"])->get();
            $data["projects"] = ProjectDetail::whereIn("projectID", $project_ids)->select(["projectID", "TownName", "programID", "Name"])->get();


            if ($data["selectedProgramId"] != "" && $data["selectedProjectId"] != "") {
                //check if  user can access selectedProgramId & selectedProjectId
                if (!in_array($data["selectedProgramId"], $program_ids)) {
                    toastr()->error("Invalid Request eid:3022");
                    return redirect()->route("home");
                }
                if (!in_array($data["selectedProjectId"], $project_ids)) {
                    toastr()->error("Invalid Request eid:3023");
                    return redirect()->route("home");
                }
            }
        }


        return view(
            "admin.programs.new.index",
            [
                'fiscal_year' => $data["fiscal_year"],
                'selectedProgramId' => $data["selectedProgramId"],
                'selectedProjectId' => $data["selectedProjectId"],
                'selectedActivityId' => $data["selectedActivityId"],
                'selectedMilestoneId' => $data["selectedMilestoneId"],
                'programs' => $data["programs"],
                'projects' => $data["projects"],
                'townlists' => $data["townlist"],
                'program_name' => $data["program_name"],
                'project_name' => $data["project_name"],
            ]
        );
    }

    public function addNewProgram(ProgramStoreRequest $request)
    {
        // return $request;
        $ID = $this->getNewIdForProgram();

        $collection = collect($request->validated())->except('_token');
        $uses_sq_system = 1;
        $merge = $collection->merge(compact('ID', 'uses_sq_system'));

        Program::create($merge->all());

        $request->session()->flash("success", "Program Created");


        return redirect()->route("programs.new");
    }

    function getNewIdForProgram()
    {
        $id = 0;
        $id = Program::withTrashed()->orderBy("id", "desc")->first()->ID;
        if ($id < 200000) {
            $id = 200000;
        } else {
            $id = $id + 1;
        }

        return $id;
    }

    public function softDeleteProgram($id)
    {
        if ($id < 200000) {
            toastr()->error("You can't delete this program");
            return redirect()->back();
        }
        Program::where("ID", $id)->delete();
        return redirect()->route('programs.index')
            ->with('success', 'Program Deleted successfully');
    }
}
