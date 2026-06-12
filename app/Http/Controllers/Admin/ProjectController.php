<?php

namespace App\Http\Controllers\Admin;

// use App\Helper\FunctionUtils;

use App\Helper\FinancialMilestone;
use App\Helper\FiscalYear;
use App\Helper\PhysicalMilestone;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Requests\ProjectStoreRequest;
use Illuminate\Http\Request;
use App\Models\ProjectDetail;
use App\Models\PhysicalProgress;
use App\Models\ProjectActivity;
use App\Models\Milestone;
use App\Models\Timeline;
use App\Models\ProjectReview;
use App\Models\Program;
use App\Models\ProjectDataSQ;
use App\Trait\ImageUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{

    use ImageUpload;

    public function __construct()
    {
        //remove all old project activity responsibility users
        // ProjectActivity::all()->map(function ($pro_act) {
        //     $pro_act->main_responsibility = NULL;
        //     $pro_act->supportive_responsibility = NULL;
        //     $pro_act->save();
        // });

        //remove all old project reviews
        // ProjectReview::all()->map(function ($pro_act) {

        //     $pro_act->delete();
        // });
    }

    public function index(Request $request)
    {
        $only_projects = true;
        $project_filter_type = "active_project";

        if ($request->has('program') && $request->program != '') {
            $only_projects = false;

            //check if program exists
            if (!Program::where("ID", $request->program)->exists()) {
                return redirect()->route('home')->with('success', 'Program not found');
            }
        }

        if ($only_projects) {
            $data["projects"] = ProjectDetail::with([
                "disbursement:ProjectID,DisbursementPercentage,approved_date,TDFContractedCost",
                "lastprogress:project_id,physical_progress",
            ])
                ->select("projectID", "programID", "Name", "NameLong", "TownName")
                ->get();
        } else {
            if ($request->has("project_filter_type") && $request->project_filter_type != "") {
                if ($request->project_filter_type == "all_project") {
                    $project_filter_type = "all_project";
                }
            }
            //projects for program
            $data["projects"] = $this->projectsForProgram($request->program, $project_filter_type);
        }

        return view('admin.projects.index', compact("data", "project_filter_type"));
    }

    function projectsForProgram($programID, $project_filter_type)
    {
        $data["projects"] = [];
        if ($project_filter_type == "active_project") {
            //filter by fiscial year
            //get all active project ids
            $active_projects_fy_ids = ProjectDataSQ::where("fiscal_year", FiscalYear::curentFiscalYear())->select("project_id")->get()->unique("project_id")->pluck("project_id");


            //check if user can access all project or only assigned projects
            if (auth()->user()->can('Access All Project') || auth()->user()->hasAnyRole(['ED'])) {
                $data["projects"] = ProjectDetail::with([
                    "lastprogress:project_id,physical_progress",
                    "program:ID,Name,NameLong",
                    "lastDisbursement:ProjectID,DisbursementPercentage,approved_date,TDFContractedCost",
                    "projectReview",
                    "projectDataSQ" => function ($q) {
                        $q->where("fiscal_year", FiscalYear::curentFiscalYear());
                    },

                ])
                    // ->select("projectID", "programID", "Name", "NameLong", "TownName", "projectReview")
                    ->whereIn("projectID", $active_projects_fy_ids)
                    ->where("programID", $programID)
                    ->get();
            } else {
                $data["projects"] = ProjectDetail::with([
                    "lastprogress:project_id,physical_progress", "program:ID,Name,NameLong",
                    "lastDisbursement:ProjectID,DisbursementPercentage,approved_date,TDFContractedCost",
                    "projectReview",
                    "projectActivity" => function ($q) {
                        $q->whereJsonContains("main_responsibility", Auth::id())->orWhereJsonContains("supportive_responsibility", Auth::id());
                    },
                ])
                    ->whereIn("projectID", $active_projects_fy_ids)
                    ->where("programID", $programID)
                    ->get()->map(function ($project) {
                        if (
                            count($project->projectActivity) > 0
                        )
                            return $project;
                    })->filter();
            }
        }
        if ($project_filter_type == "all_project") {

            //check if user can access all project or only assigned projects
            if (auth()->user()->can('Access All Project') || auth()->user()->hasAnyRole(['ED'])) {
                $data["projects"] = ProjectDetail::with([
                    "lastprogress:project_id,physical_progress", "program:ID,Name,NameLong",
                    "lastDisbursement:ProjectID,DisbursementPercentage,approved_date,TDFContractedCost",
                    "projectReview",

                ])
                    // ->select("projectID", "programID", "Name", "NameLong", "TownName", "projectReview")
                    ->where("programID", $programID)
                    ->get();
            } else {
                $data["projects"] = ProjectDetail::with([
                    "lastprogress:project_id,physical_progress", "program:ID,Name,NameLong",
                    "lastDisbursement:ProjectID,DisbursementPercentage,approved_date,TDFContractedCost",
                    "projectReview",
                    "projectActivity" => function ($q) {
                        $q->whereJsonContains("main_responsibility", Auth::id())->orWhereJsonContains("supportive_responsibility", Auth::id());
                    },
                ])
                    ->where("programID", $programID)
                    ->get()->map(function ($project) {
                        if (count($project->projectActivity) > 0)
                            return $project;
                    })->filter();
            }
        }
        return $data["projects"];
    }

    public function physicalProgress($project_id)
    {

        $data["project"] = ProjectDetail::where("projectID", $project_id)->firstOrFail();

        // $data["progress"] = physicalProgress::where("project_id", $project_id)->get() ?? [];

        return view("admin.projects.progress-list", [
            "project_id" => $project_id,
            "project" =>  $data["project"]
        ]);
    }

    public function createPhysicalProgress($project_id)
    {

        $data["project"] = ProjectDetail::select(["projectID", "Name"])
            ->where("projectID", $project_id)->firstOrFail();

        return view("admin.progress.physical-progress", $data);
    }

    public function storePhysicalProgress(Request $request, $project_id)
    {

        $request->validate([
            "visitor_details" => "required|array|min:1",
            "visitor_details.name.*" => "required",
            "visitor_details.designation.*" => "required",
            "from_date" => "required|date",
            "to_date" => "required|date||after_or_equal:from_date", //
            "status"  => "required",
            "authority_name" => "required",
            // "authority_email" => "required|email",
            // "authority_contact" => "required",
            "activity_performed" => "required",
            "physical_progress" => "required",
            "files.*" => "nullable|file|mimes:png,pdf,jpg,jpeg|max:2048"
        ], [
            "visitor_details.name.*.required" => "Visitor Name is Required ! !",
            "visitor_details.designation.*.required" => "Visitor Designation is Required ! !"
        ]);


        DB::beginTransaction();

        try {

            $data = $request->only(["visitor_details", "from_date", "to_date", "status", "authority_name", "authority_email", "authority_contact", "activity_performed", "physical_progress", "document_uploads"]);

            $project = ProjectDetail::select(["projectID", "Name"])
                ->where("projectID", $project_id)->firstOrFail();

            $data['project_id'] = $project->projectID;

            foreach ($request->document_uploads['name'] ?? [] as $key => $name) :

                if ($request->hasFile("files." . $key)) :

                    $file_name = $this->singleImageUpload($request->file("files")[$key], "uploads/progress/");

                    $data["document_uploads"]["file"][] = $file_name;

                endif;

            endforeach;

            PhysicalProgress::create($data);

            DB::commit();

            $request->session()->flash("success", "Physical Progress Data Submitted ");

            return redirect()->route("project.physicalProgress", $project->projectID);
        } catch (\Exception $error) {

            DB::rollback();
            dd($error);
        }
    }

    public function editPhysicalProgress(Request $request, $id, PhysicalProgress $progress)
    {
        $project = ProjectDetail::
            // select(["projectID", "Name"])->
            where("projectID", $id)->firstOrFail();


        return view("admin.progress.edit-physical-progress", compact("project", "progress"));
    }

    public function updatePhysicalProgress(Request $request, $id, PhysicalProgress $progress)
    {
        $request->validate([
            "visitor_details" => "required|array|min:1",
            "visitor_details.name.*" => "required",
            "visitor_details.designation.*" => "required",
            "from_date" => "required|date",
            "to_date" => "required|date||after_or_equal:from_date", //
            // "status"  => "required",
            "authority_name" => "required",
            // "authority_email" => "required|email",
            // "authority_contact" => "required",
            "activity_performed" => "required",
            "physical_progress" => "required",
            "files.*" => "nullable|file|mimes:png,jpg,jpeg|max:2048"
        ], [
            "visitor_details.name.*.required" => "Visitor Name is Required ! !",
            "visitor_details.designation.*.required" => "Visitor Designation is Required ! !"
        ]);


        DB::beginTransaction();

        try {

            $data = $request->only(["visitor_details", "current_status", "from_date", "to_date", "status", "authority_name", "authority_email", "authority_contact", "activity_performed", "physical_progress", "document_uploads"]);

            $project = ProjectDetail::select(["projectID", "Name"])
                ->where("projectID", $id)->firstOrFail();

            $data['project_id'] = $project->projectID;

            foreach ($request->document_uploads['name'] ?? [] as $key => $name) :

                if ($request->hasFile("files." . $key)) :

                    $old_file = $progress->document_uploads['file'][$key] ?? '';
                    $file_name = $this->singleImageUpload($request->file("files")[$key], "uploads/progress/");

                    if (!empty($file_name)) @unlink("uploads/progress/" . $old_file);

                    $data["document_uploads"]["file"][$key] = $file_name;

                endif;

            endforeach;

            $progress->update($data);

            DB::commit();

            $request->session()->flash("success", "Physical Progress Data Updated ");

            return redirect()->route("project.physicalProgress", $project->projectID);
        } catch (\Exception $error) {

            DB::rollback();
            return redirect()->back();
        }
    }

    public function createInputProgramReport(Request $request, $project_id)
    {

        $data["project"] = ProjectDetail::with(["projectActivity.milestone.timeline"])
            ->select(["projectID", "Name", "FT", "FP", "NameLong", "programID"])
            ->where("projectID", $project_id)->firstOrFail();

        // return $data;

        return view("admin.progress.program-report-input", [
            "project_id" => $project_id,
            "project" => $data["project"]
        ]);
    }

    public function storeMainActivity(Request $request, $project_id)
    {
        $request->validate([
            "fiscal_year" => "required",
            "activity" => "required|max:191",
            "main_responsibility" => "required|array",
            "supportive_responsibility" => "required|array"
        ]);

        $data["project"] = ProjectDetail::select(["projectID", "Name"])
            ->where("projectID", $project_id)->firstOrFail();

        if (!$data["project"]) {
            $request->session()->flash("error", "Unable to store main activity !!!");
            return redirect()->back()->withInput($request->all());
        }

        try {
            $main_responsibility = [];
            foreach ($request->main_responsibility as $main_responsibility_user_id) {
                array_push($main_responsibility, intval($main_responsibility_user_id));
            }
            $supportive_responsibility = [];
            foreach ($request->supportive_responsibility as $supportive_responsibility_user_id) {
                array_push($supportive_responsibility, intval($supportive_responsibility_user_id));
            }

            ProjectActivity::create([
                "project_id" => $data['project']->projectID,
                "activity"   => $request->activity,
                "main_responsibility" => $main_responsibility,
                "supportive_responsibility" => $supportive_responsibility,
                "fiscal_year" => $request->fiscal_year,
            ]);

            //-- TODO: Can be optimized
            $projectdatasq =  ProjectDataSQ::where("project_id", $project_id)
                ->where("fiscal_year", $request->fiscal_year)->first();
            if (!$projectdatasq) {
                ProjectDataSQ::create([
                    "project_id" => $project_id,
                    "fiscal_year" => $request->fiscal_year
                ]);
            }

            $request->session()->flash("success", "Project Activity Added Successfully ! ! !");
            return redirect()->back();
        } catch (\Exception $error) {

            $request->session()->flash("error", "Something Went Wrong, Try Again ! ! !");

            return redirect()->back()->withInput($request->all());
        }
    }

    public function updateMainActivity(Request $request, $project_id, $activity_id)
    {
         $request->validate([
            "fiscal_year" => "required",
            "activity" => "required|max:191",
            "main_responsibility" => "required|array",
            "supportive_responsibility" => "required|array"
        ]);

        $data["project"] = ProjectDetail::select(["projectID", "Name"])
            ->where("projectID", $project_id)->firstOrFail();

        try {
            $main_responsibility = [];
            foreach ($request->main_responsibility as $main_responsibility_user_id) {
                array_push($main_responsibility, intval($main_responsibility_user_id));
            }
            $supportive_responsibility = [];
            foreach ($request->supportive_responsibility as $supportive_responsibility_user_id) {
                array_push($supportive_responsibility, intval($supportive_responsibility_user_id));
            }

            $data = [
                "project_id" => $data['project']->projectID,
                "activity"   => $request->activity,
                "main_responsibility" => json_encode($main_responsibility),
                "supportive_responsibility" => json_encode($supportive_responsibility),
                "fiscal_year" => $request->fiscal_year,
            ];

            ProjectActivity::where('id', $activity_id)->update($data);

            $request->session()->flash("success", "Project Activity Updated Successfully ! ! !");
            return redirect()->back();
        } catch (\Exception $error) {

            $request->session()->flash("error", "Something Went Wrong, Try Again ! ! !");

            return redirect()->back()->withInput($request->all());
        }
    }

    public function deleteActivity($activity_id)
    {

        // if (!Auth::user()->hasAnyRole(['Sysqube-Super-Admin', 'Super-Admin'])) {
        //     toastr()->error("You dont have required access");
        //     return redirect()->route("home");
        // }
        if (!Auth::user()->can("Set Target")) {
            toastr()->error("You dont have required access");
            return redirect()->route("home");
        }

        ProjectActivity::find($activity_id)->delete();
        Milestone::where("project_activity_id", $activity_id)->delete();

        return redirect()->back()
            ->with('success', 'Activity deleted successfully');
    }

    public function storeMilestone(Request $request, $project_id)
    {
        $request->validate([
            'milestone' => 'required|max:180',
            'performance_indicator' => 'required|max:180',
        ]);

        $data["project"] = ProjectDetail::select(["projectID", "Name"])
            ->where("projectID", $project_id)->firstOrFail();

        $request->validate([
            "activity" => "required|exists:project_activities,id",
            "milestone" => "required|max:191",
            "performance_indicator" => "required|max:191"
        ]);

        try {
            $data = [
                "project_activity_id" => $request->activity,
                "milestone" => $request->milestone,
                "performance_indicator" => $request->performance_indicator,
                "is_text" => $request->is_text
            ];

            Milestone::create($data);

            $request->session()->flash("success", "Milestone Added Successfully ! ! !");

            return redirect()->back();
        } catch (\Exception $error) {
            $request->session()->flash("error", "Something Went Wrong, Try Again ! ! !");
            return redirect()->back()->withInput($request->all());
        }
    }

    public function updateMilestone(Request $request, $project_id, $milestone_id)
    {
        $request->validate([
            'milestone' => 'required|max:180',
            'performance_indicator' => 'required|max:180',
        ]);

        $data["project"] = ProjectDetail::select(["projectID", "Name"])
            ->where("projectID", $project_id)->firstOrFail();

        $request->validate([
            "activity" => "required|exists:project_activities,id",
            "milestone" => "required|max:191",
            "performance_indicator" => "required|max:191"
        ]);

        try {
            $data = [
                "project_activity_id" => $request->activity,
                "milestone" => $request->milestone,
                "performance_indicator" => $request->performance_indicator,
                "is_text" => $request->is_text
            ];

            Milestone::where('id', $milestone_id)->update($data);
            $request->session()->flash("success", "Milestone Updated Successfully ! ! !");

            return redirect()->back();
        } catch (\Exception $error) {
            $request->session()->flash("error", "Something Went Wrong, Try Again ! ! !");
            return redirect()->back()->withInput($request->all());
        }
    }

    public function storeTimeline(Request $request, $project_id)
    {
        $this->validate($request, [
            'fiscal_year' => 'required',
        ]);
        $project = ProjectDetail::select(["projectID", "Name", "programID"])
            ->where("projectID", $project_id)->firstOrFail();

        try {
            $data = [];
            foreach ($request->milestone_id ?? [] as $key => $milestone_id) {
                $data[$key]['milestone_id'] = $milestone_id;
                for ($i = 1; $i <= 12; $i++) {
                    $data[$key]['timeline'][$i] = isset($request->timeline[$key][$i]) && $request->timeline[$key][$i] ? $request->timeline[$key][$i] : "";
                }
            }

            foreach ($data as $key_milestone_id => $data_value) {
                if (!empty($data_value["timeline"])) {

                    $mile = Milestone::find($key_milestone_id);
                    //-- Check if financial target ( financial target exceed warning)
                    if ($mile && in_array(strtolower(trim($mile->milestone)), FinancialMilestone::milestoneNames())) {
                        $approved_budget = 0;
                        $projectdatasq = ProjectDataSQ::where("project_id", $project->projectID)
                            ->where("fiscal_year", $request->fiscal_year)
                            ->first();
                        if ($projectdatasq) {
                            $approved_budget = $projectdatasq->approved_budget;
                        }

                        $total_financial_target = 0;
                        foreach ($data_value["timeline"] as $month => $target_data) {
                            if ($target_data != "") {
                                $total_financial_target = $total_financial_target +  intval($target_data);
                            }
                        }


                        //total financial target should not cross approved budget
                        if ($total_financial_target > $approved_budget) {
                            $request->session()->flash("error-v2", "Financial Target exceded Approved budget!");
                            $request->session()->flash("error", "Financial Target exceded Approved budget!");
                            return redirect()->back();
                        }
                    }

                    //-- Check if physical target  ( physical target exceed warning)
                    if ($mile && in_array(strtolower(trim($mile->milestone)), PhysicalMilestone::milestoneNames())) {

                        $allowed_physical_target = 0;
                        $projectdatasq = ProjectDataSQ::where("project_id", $project->projectID)
                            ->where("fiscal_year", $request->fiscal_year)
                            ->first();
                        if ($projectdatasq) {
                            $allowed_physical_target = 100 -  $projectdatasq->physical_progress;
                        }


                        $total_physical_target = 0;
                        foreach ($data_value["timeline"] as $month => $target_data) {
                            if ($target_data != "") {
                                $total_physical_target = $total_physical_target +  intval($target_data);
                            }
                        }


                        //total financial target should not cross approved budget
                        if ($total_physical_target > $allowed_physical_target) {
                            $request->session()->flash("error-v2", "Physical Target exceded  !");
                            $request->session()->flash("error", "Physical Target exceded  !");
                            return redirect()->back();
                        }
                    }

                    Timeline::updateOrCreate(
                        [
                            'milestone_id' => $key_milestone_id,
                        ],
                        [
                            "timeline" => $data_value["timeline"]
                        ]
                    );
                }
            }

            ProjectDataSQ::updateOrCreate(
                [
                    'project_id' => $project_id,
                    'fiscal_year' => $request->fiscal_year
                ],
                [
                    'FT' => $request->FT,
                    'PT' => $request->PT,
                ]
            );

            $request->session()->flash("success", "Timeline Saved Successfully ! ! !");

            return redirect()->back();
        } catch (\Exception $error) {
            $request->session()->flash("error", "Something Went Wrong, Try Again ! ! !");
            return redirect()->back()->withInput($request->all());
        }
    }

    public function showInputProgramReport($project_id)
    {
        $data["project"] = ProjectDetail::with([
            "projectActivity.milestone.timeline", "program",
            "lastDisbursement:ProjectID,DisbursementPercentage,approved_date,TDFContractedCost"
        ])
            ->withCount('projectActivity')
            ->select(["projectID", "Name", "programID"])
            ->where("projectID", $project_id)->firstOrFail();

        $data["physical_progress"] = PhysicalProgress::select(["id", "physical_progress"])
            ->where("project_id", $data["project"]->projectID)
            ->latest()->first();

        return view("admin.progress.program-report-performance", $data);
    }

    public function reviewProjectMilestone($project_id)
    {
        $data["project"] = ProjectDetail::with(["projectActivity.milestone", "program", "progress"])
            ->select(["projectID", "Name", "NameLong", "programID"])
            ->where("projectID", $project_id)->firstOrFail();
        $data["reviews"] = ProjectReview::where("project_id", $project_id)->first();


        return view("admin.progress.progress-report-performance-review", [
            "project_id" => $project_id,
            "project" =>  $data["project"]

        ]);
    }

    public function storeProjectMilestoneReview(Request $request, $project_id)
    {
        $this->validate($request, [
            'fiscal_year' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $project = ProjectDetail::where(["projectID" => $project_id])->firstOrFail();

            $data = [];
            $data["project_id"] = $project->projectID;

            $data["progress"] = [];
            foreach ($request->progress ?? [] as $id => $value) {
                if (!empty($value)) {
                    $data["progress"][$id] = $value;
                }
            }
            $data["target"] = [];
            foreach ($request->target ?? [] as $id => $value) {
                if (!empty($value)) {
                    $data["target"][$id] = $value;
                }
            }
            $data["remarks"] = [];
            foreach ($request->remarks ?? [] as $id => $value) {
                if (!empty($value)) {
                    $data["remarks"][$id] = $value;
                }
            }

            if (!empty($data)) {
                ProjectReview::updateOrCreate([
                    "project_id" => $project_id,
                    "fiscal_year" => $request->fiscal_year,
                ], $data);
            }

            DB::commit();
            $request->session()->flash("success", "Project Review Successfully Updated ! ! !");

            return redirect()->back();
        } catch (\Exception $error) {
            DB::rollback();
            $request->session()->flash("error", "Something Went Wrong, Try Again ! ! !");
            return redirect()->back()->withInput($request->all());
        }
    }

    public function projectReportPerformance(Request $request, $project_id)
    {

        if (!ProjectDetail::where(["projectID" => $project_id])->exists()) :

            $request->session()->flash("error", "Project Details Not Found ! ! !");
            return redirect()->back();

        endif;

        $data["project"] = ProjectDetail::with(["projectActivity.milestone", "program"])
            ->select(["projectID", "Name", "programID"])
            ->where("projectID", $project_id)->firstOrFail();

        $data["progress"] = PhysicalProgress::where("project_id", $project_id)->latest()->first();

        $data["reviews"] = ProjectReview::where("project_id", $project_id)->first();

        return view("admin.progress.progress-report-performance", $data);
    }

    /**
     * List of province projects by province_code
     *
     */
    public function showProjectListByProvince($province_code, Request $request)
    {
        $project_filter_type = "active_project";
        $data["province_overview_data"] = [
            "FT" => 0,
            "FP" => 0,
            "PT" => 0,
            "PP" => 0,
            "FT_P" => 0,
            "FP_P" => 0,
            "PT_P" => 0,
            "PP_P" => 0,
            "project_ids" => [],
        ];

        if ($request->has("status") && $request->status != "") {
            if ($request->status == "all_project") {
                $project_filter_type = "all_project";
            }
        }
        //TODO:need a helper to convert province code to province general data
        $province = [
            [
                "id" => 01, "ename" => "Province 1", "nname" => "प्रदेश नं. १"
            ],
            [
                "id" => 02, "ename" => "Madhesh Province", "nname" => "मधेश प्रदेश"
            ],
            [
                "id" => 03, "ename" => "Bagmati Province", "nname" => "वाग्मती प्रदेश"
            ],
            [
                "id" => 04, "ename" => "Gandaki Province", "nname" => "गण्डकी प्रदेश"
            ],
            [
                "id" => 05, "ename" => "Lumbini Province", "nname" => "लुम्बिनी प्रदेश"
            ],
            [
                "id" => 06, "ename" => "Karnali Province", "nname" => "कर्णाली प्रदेश"
            ],
            [
                "id" => 07, "ename" => "Sudurpashchim Province", "nname" => "सुदूरपश्चिम प्रदेश"
            ]
        ];

        //for overview card
        $data["province_overview_data"] =  $this->provinceWiseProjectsStats($province_code, $project_filter_type);

        //for table list
        $data["projects"] =  ProjectDetail::with([
            "lastprogress:project_id,physical_progress",
            "program:ID,Name,NameLong,FinancingAgency",
            "lastDisbursement:ProjectID,DisbursementPercentage,approved_date,TDFContractedCost"
        ])
            ->select("projectID", "programID", "Name", "NameLong", "TownName", "townID")
            ->whereIn("projectID", $data["province_overview_data"]["project_ids"])
            ->get();

        $data["province_data"] =  collect($province)->where("id", sprintf("%02d", strval($province_code)))->first();
        if (empty($data["province_data"]))
            abort(404, "Invalid Province Code");

        return view('admin.projects.province.project-list', [
            "province_data" => $data["province_data"],
            "province_overview_data" => $data["province_overview_data"],
            "project_filter_type" => $project_filter_type,
            "projects" => $data["projects"],

        ]);
    }

    public function provinceWiseProjectsStats($province_code, $project_type)
    {
        $fiscalYear = request("fiscal_year",FiscalYear::curentFiscalYear());
        $province_code = intval($province_code);
        $province = [
            "FT" => 0,
            "FP" => 0,
            "PT" => 0,
            "PP" => 0,
            "FT_P" => 0,
            "FP_P" => 0,
            "PT_P" => 0,
            "PP_P" => 0,
            "project_ids" => []
        ];

        if ($project_type == "active_project") {
            $projectdatasqs = ProjectDataSQ::where("fiscal_year", $fiscalYear)->with(["project", "project.program", "project.town"])->get();
        } else {
            $projectdatasqs = ProjectDataSQ::with(["project", "project.program", "project.town"])->get();
        }
        foreach ($projectdatasqs as $projectdatasq) {

            //belongs to certain province via townlist
            if (!empty($projectdatasq->project->town) && !empty($projectdatasq->project->town->Province) && intval($projectdatasq->project->town->Province) == $province_code) {
                $province_no = $province_code;

                $province["FT"] = $province["FT"] + (intval($projectdatasq->FT) ?? 0);
                $province["FP"] = $province["FP"] + (intval($projectdatasq->FP) ?? 0);
                $province["PT"] = $province["PT"] + (intval($projectdatasq->PT) ?? 0);
                $province["PP"] = $province["PP"] + (intval($projectdatasq->PP) ?? 0);

                array_push($province["project_ids"], $projectdatasq->project_id);
            }
        }
        //for percentage
        if ($province["FT"] != 0) {
            $province["FT_P"] = 100;
            $province["FP_P"] = ($province["FP"] / $province["FT"]) * 100;
            $province["FP_P"] = number_format((float)   $province["FP_P"], 2, '.', '');
        }
        if ($province["PT"] != 0) {
            $province["PT_P"] = 100;
            $province["PP_P"] = ($province["PP"] / $province["PT"]) * 100;
            $province["PP_P"] = number_format((float)   $province["PP_P"], 2, '.', '');
        }

        return  $province;
    }


    public function addNewProject(ProjectStoreRequest $request)
    {
        $projectID = $this->getNewIdForProject();
        // $programID =

        $collection = collect($request->validated())->except('_token');

        // if (condition) {
        //     # code...
        // }
        // $townlist = TownList::find($request->townID);

        $merge = $collection->merge(compact('projectID'));

        $project_detail = ProjectDetail::create($merge->all());
        $project_detail->uses_sq_system = true;
        // $project_detail->TownName = $townlist->TownName;
        $project_detail->save();

        $request->session()->flash("success", "Project Created");


        return redirect()->route("programs.new");
    }

    //TODO: change to traits or custom helpers
    function getNewIdForProject()
    {
        $id = 0;
        $id = ProjectDetail::withTrashed()->orderBy("projectID", "desc")->first()->projectID;
        if ($id < 200000) {
            $id = 200000;
        } else {
            $id = $id + 1;
        }

        return $id;
    }

    public function storeProgressInputMilestoneProgress(Request $request)
    {
        // return $request;
         $this->validate($request, [
             'projectID' => 'required',
            'fiscal_year' => 'required',
            'activityId' => 'required',
        ]);

        $fiscalYear = $request->fiscal_year ?? FiscalYear::curentFiscalYear();

        $project = ProjectDetail::select(["projectID", "Name", "programID"])
            ->where("projectID", $request->projectID)->first();
        if (!$project) {
            return back();
        }
        //-- Get all old milestone from activity id
        $projectActivity = ProjectActivity::where("id",$request->activityId)->with('milestone')->first();
            if(!$projectActivity){
                return back();
            }

        DB::beginTransaction();
        try {
            $data = [];
            foreach ($request->milestone_id ?? [] as $key => $milestone_id) {
                $data[$key]['milestone_id'] = $milestone_id;

                //-- Timeline Progress Input For Milestone
                for ($i = 1; $i <= 12; $i++) {
                    $data[$key]['progressinput'][$i] = isset($request->progressinput[$key][$i]) && $request->progressinput[$key][$i] ? $request->progressinput[$key][$i] : "";
                    $data[$key]['progressinput'][$i] = $data[$key]['progressinput'][$i] == "on" ? "1" : $data[$key]['progressinput'][$i];
                }
                $progress_input_data = $data[$key]['progressinput'];

                //-- Timeline Progress Remark For Milestone
                for ($i = 1; $i <= 12; $i++) {
                    $data[$key]['timeline_progress_remark'][$i] = isset($request->timeline_progress_remark[$key][$i]) && $request->timeline_progress_remark[$key][$i] ? $request->timeline_progress_remark[$key][$i] : "";
                    $data[$key]['timeline_progress_remark'][$i] = $data[$key]['timeline_progress_remark'][$i] == "on" ? "1" : $data[$key]['timeline_progress_remark'][$i];
                }
                $timeline_progress_remark = $data[$key]['timeline_progress_remark'];

                $timeline = Timeline::find($request->timeline_id[$milestone_id]);
                if ($timeline) {
                    $timeline->progress_input_data = $progress_input_data;
                    $timeline->remarks = $timeline_progress_remark;
                    $timeline->save();
                }

                //for milestone remark
                $mile = Milestone::find($milestone_id);
                if ($mile) {
                    $mile->remark = $request->milestone_remark[$key];
                    $mile->save();
                    //for FP/PP

                    //check if financial target
                    if (in_array(strtolower(trim($mile->milestone)), FinancialMilestone::milestoneNames())) {
                        $total_financial_progress = 0;
                        foreach ($progress_input_data as $month => $progress_data) {
                            if ($progress_data != "") {
                                $total_financial_progress = $total_financial_progress + intval($progress_data);
                            }
                        }

                        ProjectDataSQ::updateOrCreate(
                            [
                                'project_id' => $project->projectID,
                                'fiscal_year' => $fiscalYear
                            ],
                            [
                                "FP" => $total_financial_progress,
                            ]
                        );
                    }
                    //check if physical target
                    if (in_array(strtolower(trim($mile->milestone)), PhysicalMilestone::milestoneNames())) {
                        $total_physcial_progress = 0;
                        foreach ($progress_input_data as $month => $progress_data) {
                            if ($progress_data != "") {
                                $total_physcial_progress = $total_physcial_progress + intval($progress_data);
                            }
                        }

                        ProjectDataSQ::updateOrCreate(
                            [
                                'project_id' => $project->projectID,
                                'fiscal_year' => $fiscalYear
                            ],
                            [
                                "PP" => $total_physcial_progress,
                            ]
                        );
                    }
                }
            }

            $request->session()->flash("success", "Progress Updated Successfully ! ! !");
            DB::commit();

        return redirect()->back();
        } catch (\Exception $error) {
             DB::rollBack();
            $request->session()->flash("error", "Something Went Wrong, Try Again ! ! !");

            return redirect()->back()->withInput($request->all());
        }

    }

    public function storeProgressInputMilestoneProgressRemark(Request $request)
    {
        // return $request;

        //check if timeline exists
        $timeline = Timeline::find($request->timeline_id);
        if ($timeline) {
            for ($i = 1; $i <= 12; $i++) {
                //get current remarks
                if (!empty($timeline->remarks)) {
                    // add to record
                    if (intval($request->timeline_mnth) == $i) {
                        $data['remarks'][$i] = $request->remark;
                    } else {
                        $data['remarks'][$i] = $timeline->remarks[strval($i)];
                    }
                } else {
                    // create new record
                    if (intval($request->timeline_mnth) == $i) {
                        $data['remarks'][$i] = $request->remark;
                    } else {
                        $data['remarks'][$i] = "";
                    }
                }
            }
            $timeline->remarks = $data['remarks'];
            $timeline->save();

            return redirect()->back()->with('success-v2', 'Saved successfully');
        }

        toastr()->error("Invalid Timeline");
        return redirect()->back();
    }
    public function storeProgressInputMilestoneRemark(Request $request)
    {
        //check if milestone exists
        $milestone = Milestone::find($request->milestone_id);
        if ($milestone) {

            $milestone->remark = $request->remark;
            $milestone->save();

            return redirect()->back()->with('success-v2', 'Saved successfully');
        }

        toastr()->error("Invalid Milestone");
        return redirect()->back();
    }

    public function softDeleteProject($id)
    {
        if ($id < 200000) {
            toastr()->error("You can't delete this project");
            return redirect()->back();
        }
        ProjectDetail::where("projectID", $id)->delete();
        return redirect()->back()
            ->with('success', 'Project Deleted successfully');
    }
}