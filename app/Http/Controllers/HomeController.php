<?php

namespace App\Http\Controllers;

use App\Helper\FinancialMilestone;
use App\Helper\FiscalYear;
use App\Helper\FunctionUtils;
use Illuminate\Http\Request;
use App\Models\{ActivityDetail, Program, ProjectDetail, TownList, DisbursementDetail, ProjectActivity, ProjectDataSQ};
use App\Trait\{LoadDataFromServer, LoadDisbursementFromServer};
use Illuminate\Support\Facades\Http;


class HomeController extends Controller
{

    use LoadDataFromServer, LoadDisbursementFromServer;


    public function loadDataOnSqlFromServer()
    {

        $this->allApiData();

        $this->disbursementData();
    }


    public function index(Request $request)
    {
        // $url = "http://tdf.softavi.com/api/tdf_data/getTdfData?username=tdf_apiuser&password=tdF@piUs3r2o22";
        // $url = "http://tdf.softavi.com/api/tdf_data/getTdfDisbursementData?username=tdf_apiuser&password=tdF@piUs3r2o22";

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

        $data["locations"] = $locations  = TownList::get();

        //  return
        $data["province"] = $this->provinceWiseTargetProgress($province);

        $data["progressInPercentChartData"] = $this->progressInPercentChartData();


        //--province active total projects

        for ($i = 1; $i < 8; $i++) {
            $data["province"][$i - 1]["total"] = 0;
        }

        foreach (ProjectDataSQ::where("fiscal_year", FiscalYear::curentFiscalYear())->with([
            "project", "project.town"
        ])->get() as $projectdatasq) {

            //belongs to certain province via townlist
            if (!empty($projectdatasq->project->town) && !empty($projectdatasq->project->town->Province) && intval($projectdatasq->project->town->Province) < 8) {
                $province_no = intval($projectdatasq->project->town->Province);

                if ($province_no > 0) {
                    $data["province"][$province_no - 1]["total"] = $data["province"][$province_no - 1]["total"] + 1;
                }
            }
        }

        return view('home.index', $data);
    }
    public function provinceWiseTargetProgress($province)
    {
        for ($i = 1; $i < 8; $i++) {
            $province[$i - 1]["FT"] = 0;
            $province[$i - 1]["FP"] = 0;
            $province[$i - 1]["PT"] = 0;
            $province[$i - 1]["PP"] = 0;
            $province[$i - 1]["FT_P"] = 0;
            $province[$i - 1]["FP_P"] = 0;
            $province[$i - 1]["PT_P"] = 0;
            $province[$i - 1]["PP_P"] = 0;
        }

        foreach (ProjectDataSQ::where("fiscal_year", FiscalYear::curentFiscalYear())->with(["project", "project.program", "project.town"])->get() as $projectdatasq) {

            //belongs to certain province via townlist
            if (!empty($projectdatasq->project->town) && !empty($projectdatasq->project->town->Province) && intval($projectdatasq->project->town->Province) < 8) {
                $province_no = intval($projectdatasq->project->town->Province);

                if ($province_no > 0) {
                    $province[$province_no - 1]["FT"] = $province[$province_no - 1]["FT"] + (intval($projectdatasq->FT) ?? 0);
                    $province[$province_no - 1]["FP"] = $province[$province_no - 1]["FP"] + (intval($projectdatasq->FP) ?? 0);
                    $province[$province_no - 1]["PT"] = $province[$province_no - 1]["PT"] + (intval($projectdatasq->PT) ?? 0);
                    $province[$province_no - 1]["PP"] = $province[$province_no - 1]["PP"] + (intval($projectdatasq->PP) ?? 0);
                }
            }
        }


        for ($i = 1; $i < 8; $i++) {

            if ($province[$i - 1]["FT"] != 0) {
                $province[$i - 1]["FT_P"] = 100;
                $province[$i - 1]["FP_P"] = ($province[$i - 1]["FP"] / $province[$i - 1]["FT"]) * 100;
                $province[$i - 1]["FP_P"] = number_format((float)$province[$i - 1]["FP_P"], 2, '.', '');
            }
            if ($province[$i - 1]["PT"] != 0) {
                $province[$i - 1]["PT_P"] = 100;
                $province[$i - 1]["PP_P"] = ($province[$i - 1]["PP"] / $province[$i - 1]["PT"]) * 100;
                $province[$i - 1]["PP_P"] = number_format((float)$province[$i - 1]["PP_P"], 2, '.', '');
            }
        }

        return  $province;
    }

    public function progressInPercentChartData()
    {
        $dataset = [
            0, 0, 0
        ];


        foreach (ProjectDataSQ::where("fiscal_year", FiscalYear::curentFiscalYear())->with([
            "project",
            "project.projectActivity",
            "project.projectActivity.milestone",
            "project.projectReview",
        ])->get() as $projectdatasq) {


            $milestone_count_for_project = 0;
            $achived_no_of_milestones = 0;
            $target = 0;

            foreach ($projectdatasq->project->projectActivity as $projectActivity) {
                $milestone_count_for_project = $milestone_count_for_project + count($projectActivity->milestone);
            }

            if (!empty($projectdatasq->project->projectReview->target)) {
                //check if pme has atleast reviewed one
                foreach ($projectdatasq->project->projectReview->target as $key => $value) {
                    if ($value == 'achived') {
                        $achived_no_of_milestones++;
                    }
                }
            }

            if ($milestone_count_for_project != 0) {
                $target = ($achived_no_of_milestones / $milestone_count_for_project) * 100;
                $target = round($target, 0);
            }


            // return $projectdatasq;
            if ($target < 40) {
                $dataset[0] = $dataset[0] + 1;
            } elseif ($target > 80) {
                $dataset[1] = $dataset[1] + 1;
            } else {
                $dataset[2] = $dataset[2] + 1;
            }
        }


        return  $dataset;
    }

    public function homeReports(Request $request)
    {
        $data["program_id"] = $request->program ?? '';

        //get all active programs
        $program_ids = ProjectDataSQ::where("fiscal_year", FiscalYear::curentFiscalYear())->with([
            "project:projectID,programID"
        ])
            ->get()
            ->unique('project_id')->map(function ($pro_act) {
                if (!empty($pro_act->project->programID))
                    return $pro_act->project->programID;
            });
        $data["programs"] = Program::whereIn("ID", $program_ids)->select(["ID", "Code", "NameLong", "FundGrant", "FinancingAgency"])->get();


        if (!empty($data["programs"]) &&  empty($data["program_id"])) {
            $data["program_id"] = $data["programs"][0]->ID;
        }

        $months = ['Shrawan', 'Bhadra', 'Asoj', 'Kartik', 'Mangsir', 'Poush', 'Magh', 'Falgun', 'Chaitra', 'Baishakh', 'Jestha', 'Ashadh'];

        if ($request->has('month') &&  in_array($request->month, $months)) {

            $key_month_index = array_search($request->month, $months);

            [
                $monthWiseData_names,
                $monthWiseData_FT_Ps,
                $monthWiseData_FP_Ps,
                $monthWiseData_PT_Ps,
                $monthWiseData_PP_Ps,
            ] =  $this->singleMonthAllProjectsData($data["program_id"], $key_month_index + 1);
        } else {
            [
                $financial_target_per_month_in_percent,
                $financial_progress_per_month_in_percent,
                $physical_target_per_month_in_percent,
                $physical_progress_per_month_in_percent,
            ] =  $this->programMonthlyDatasInPercent($data["program_id"]);
        }



        return view("home.reports", [
            "programs" => $data["programs"],
            "program_id" => $data["program_id"],

            "financial_target_per_month_in_percent" => $financial_target_per_month_in_percent ?? [],
            "financial_progress_per_month_in_percent" =>
            $financial_progress_per_month_in_percent ?? [],
            "physical_target_per_month_in_percent" => $physical_target_per_month_in_percent
                ?? [],
            "physical_progress_per_month_in_percent" =>
            $physical_progress_per_month_in_percent ?? [],
            "monthWiseData_names" =>
            $monthWiseData_names ?? [],
            "monthWiseData_FT_Ps" =>
            $monthWiseData_FT_Ps ?? [],
            "monthWiseData_FP_Ps" =>
            $monthWiseData_FP_Ps ?? [],
            "monthWiseData_PT_Ps" =>
            $monthWiseData_PT_Ps ?? [],
            "monthWiseData_PP_Ps" =>
            $monthWiseData_PP_Ps ?? [],
        ]);
    }


    public function singleMonthAllProjectsData($program_id, $timeline_month_number)
    {
        $projects = [];

        $program = Program::where("ID", $program_id)->with([
            "project",
            "project.projectActivity.milestone.timeline",
        ])->first();

        if ($program) {
            foreach ($program->project ?? [] as $project) {

                $project_FT = 0;
                $project_FP = 0;
                $project_PT = 0;
                $project_PP = 0;

                if (ProjectDataSQ::where("project_id", $project->projectID)->where('fiscal_year', FiscalYear::curentFiscalYear())->exists()) {

                    foreach ($project->projectActivity ?? [] as $project_activity) {
                        if (!empty($project_activity->milestone)) {
                            foreach ($project_activity->milestone ?? [] as $milestone) {

                                //check if financial target
                                if (in_array(strtolower(trim($milestone->milestone)), FinancialMilestone::milestoneNames())) {
                                    if (!empty($milestone->timeline)) {

                                        if (!empty($milestone->timeline->timeline) && $milestone->timeline->timeline[strval($timeline_month_number)] != "") {
                                            $project_FT = intval($milestone->timeline->timeline[strval($timeline_month_number)]);
                                        }

                                        if (!empty($milestone->timeline->progress_input_data) && $milestone->timeline->progress_input_data[strval($timeline_month_number)] != "") {
                                            $project_FP =  $milestone->timeline->progress_input_data[strval($timeline_month_number)];
                                        }
                                    }
                                }

                                //check if physical target
                                if (str_contains(strtolower(trim($milestone->milestone)), 'physical target')) {

                                    if (!empty($milestone->timeline)) {
                                        if (!empty($milestone->timeline->timeline) && $milestone->timeline->timeline[strval($timeline_month_number)] != "") {
                                            $project_PT =    intval($milestone->timeline->timeline[strval($timeline_month_number)]);
                                        }

                                        if (!empty($milestone->timeline->progress_input_data) && $milestone->timeline->progress_input_data[strval($timeline_month_number)] != "") {
                                            $project_PP =    $milestone->timeline->progress_input_data[strval($timeline_month_number)];
                                        }
                                    }
                                }
                            }
                        }
                    }

                    //   array_push($projects, array(
                    //     'name' => $project->Name,
                    //     'project_FT' => $project_FT,
                    //     'project_FP' => $project_FP,
                    //     'project_PT' => $project_PT,
                    //     'project_PP' => $project_PP,
                    // ));

                    $FT_P = 0;
                    $FP_P = 0;
                    $PT_P = 0;
                    $PP_P = 0;

                    if ($project_FT > 0) {
                        $FT_P = 100;
                        $FP_P = ($project_FP / $project_FT) * 100;
                        $FP_P = number_format((float) $FP_P, 2, '.', '');
                    }
                    if ($project_PT > 0) {
                        $PT_P = 100;
                        $PP_P = ($project_PP / $project_PT) * 100;
                        $PP_P = number_format((float) $PP_P, 2, '.', '');
                    }

                    array_push($projects, array(
                        'name' => $project->Name,
                        'FT_P' => $FT_P,
                        'FP_P' => $FP_P,
                        'PT_P' => $PT_P,
                        'PP_P' => $PP_P,
                    ));
                }
            }
        }
        $projects_collection = collect($projects);


        return [
            $projects_collection->pluck("name")->toArray(),
            $projects_collection->pluck("FT_P")->toArray(),
            $projects_collection->pluck("FP_P")->toArray(),
            $projects_collection->pluck("PT_P")->toArray(),
            $projects_collection->pluck("PP_P")->toArray(),
        ];


        dd($projects);
    }
    public function programMonthlyDatasInPercent($program_id)
    {
        [
            $financialtarget_values_permonth,
            $financialprogress_values_permonth,
            $physical_target_values_permonth,
            $physical_progress_values_permonth,
        ] =  $this->programMonthlyDatas($program_id, true);

        $financial_target_per_month_in_percent = [];
        $financial_progress_per_month_in_percent = [];
        $physical_target_per_month_in_percent = [];
        $physical_progress_per_month_in_percent = [];
        for ($i = 0; $i < 12; $i++) {
            $financial_target_per_month_in_percent[$i] = 0;
            if (!empty($financialtarget_values_permonth[$i])) {
                $financial_target_per_month_in_percent[$i] =  100;
            }

            $financial_progress_per_month_in_percent[$i] = 0;
            if ($financialprogress_values_permonth[$i] != 0) {
                $financial_progress_per_month_in_percent[$i] =  ($financialprogress_values_permonth[$i] / $financialtarget_values_permonth[$i]) * 100;
                $financial_progress_per_month_in_percent[$i] =  number_format((float) $financial_progress_per_month_in_percent[$i], 2, '.', '');
            }

            $physical_target_per_month_in_percent[$i] = 0;
            if (!empty($physical_target_values_permonth[$i])) {
                $physical_target_per_month_in_percent[$i] =  100;
            }

            $physical_progress_per_month_in_percent[$i] = 0;
            if ($physical_target_values_permonth[$i] != 0) {
                $physical_progress_per_month_in_percent[$i] =  ($physical_progress_values_permonth[$i] / $physical_target_values_permonth[$i]) * 100;
                $physical_progress_per_month_in_percent[$i] =  number_format((float) $physical_progress_per_month_in_percent[$i], 2, '.', '');
            }
        }
        return [
            $financial_target_per_month_in_percent,
            $financial_progress_per_month_in_percent,
            $physical_target_per_month_in_percent,
            $physical_progress_per_month_in_percent,

        ];
    }
    public function programMonthlyDatas($program_id, $array_output)
    {
        $timelines = [
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
        ];
        $physical_timelines = [
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
            [
                "target" => 0,
                "progress" => 0,
            ],
        ];

        $program = Program::where("ID", $program_id)->with([
            "project",
            "project.projectActivity.milestone.timeline",
        ])->first();

        if ($program) {
            foreach ($program->project ?? [] as $project) {
                foreach ($project->projectActivity ?? [] as $project_activity) {
                    if (!empty($project_activity->milestone)) {
                        foreach ($project_activity->milestone ?? [] as $milestone) {

                            //check if financial target
                            if (in_array(strtolower(trim($milestone->milestone)), FinancialMilestone::milestoneNames())) {
                                if (!empty($milestone->timeline)) {
                                    for ($i = 1; $i < 13; $i++) {
                                        if (!empty($milestone->timeline->timeline) && $milestone->timeline->timeline[strval($i)] != "") {
                                            $timelines[$i - 1]["target"] = $timelines[$i - 1]["target"] + intval($milestone->timeline->timeline[strval($i)]);
                                        }

                                        if (!empty($milestone->timeline->progress_input_data) && $milestone->timeline->progress_input_data[strval($i)] != "") {
                                            $timelines[$i - 1]["progress"] = $timelines[$i - 1]["progress"] + $milestone->timeline->progress_input_data[strval($i)];
                                        }
                                    }
                                }
                            }

                            //check if physical target
                            if (str_contains(strtolower(trim($milestone->milestone)), 'physical target')) {

                                if (!empty($milestone->timeline)) {
                                    for ($i = 1; $i < 13; $i++) {
                                        if (!empty($milestone->timeline->timeline) && $milestone->timeline->timeline[strval($i)] != "") {
                                            $physical_timelines[$i - 1]["target"] = $physical_timelines[$i - 1]["target"] + intval($milestone->timeline->timeline[strval($i)]);
                                        }

                                        if (!empty($milestone->timeline->progress_input_data) && $milestone->timeline->progress_input_data[strval($i)] != "") {
                                            $physical_timelines[$i - 1]["progress"] = $physical_timelines[$i - 1]["progress"] + $milestone->timeline->progress_input_data[strval($i)];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $finance_timeline_collection = collect($timelines);
        $physical_timeline_collection = collect($physical_timelines);

        if ($array_output) {
            return [
                $finance_timeline_collection->pluck("target")->toArray(),
                $finance_timeline_collection->pluck("progress")->toArray(),
                $physical_timeline_collection->pluck("target")->toArray(),
                $physical_timeline_collection->pluck("progress")->toArray(),
            ];
        }
        return [
            $finance_timeline_collection->pluck("target"),
            $finance_timeline_collection->pluck("progress"),
            $physical_timeline_collection->pluck("target"),
            $physical_timeline_collection->pluck("progress"),
        ];
    }




    public function aboutIndex()
    {
        return view("about");
    }
}