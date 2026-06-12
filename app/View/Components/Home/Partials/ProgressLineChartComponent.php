<?php

namespace App\View\Components\Home\Partials;

use App\Helper\DateConverter;
use App\Helper\FiscalYear;
use App\Models\ProjectActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class ProgressLineChartComponent extends Component
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
            $total_target_per_month,
            $total_progress_per_month,
            $total_target_per_month_sum,
            $total_progress_per_month_sum,

            $till_date_total_target_per_month,
            $till_date_total_progress_per_month,
            $till_date_total_target_per_month_sum,
            $till_date_total_progress_per_month_sum,
        ] = $this->totalTargetAndProgressCurrentYearByMonth();


        return view('components.home.partials.progress-line-chart-component', [
            "total_target_per_month" => $total_target_per_month,
            "total_progress_per_month" => $total_progress_per_month,
            "total_target_per_month_sum" => $total_target_per_month_sum,
            "total_progress_per_month_sum" => $total_progress_per_month_sum,
            "fiscal_year" => $this->fiscal_year,
            "till_date_total_target_per_month" => $till_date_total_target_per_month,
            "till_date_total_progress_per_month" => $till_date_total_progress_per_month,
            "till_date_total_target_per_month_sum" => $till_date_total_target_per_month_sum,
            "till_date_total_progress_per_month_sum" => $till_date_total_progress_per_month_sum,

        ]);
    }

    public function totalTargetAndProgressCurrentYearByMonth()
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

        //--get curent month based on tdf timeline format
        $dateconverter =  DateConverter::fromEnglishDate(Carbon::now()->year, Carbon::now()->month, Carbon::now()->day);
        $month = $dateconverter->toFormattedNepaliDateArray()['month_in_english'];

        $tdf_months_data = [
            'Shrawan', 'Bhadra', 'Asoj', 'Kartik', 'Mangsir', 'Poush', 'Magh', 'Falgun', 'Chaitra',
            'Baishakh', 'Jestha', 'Ashadh'
        ];
        $tdf_month = array_search($month, $tdf_months_data);

        //initialize array
        $curent_month_based_timelines = [];
        for ($i = 0; $i < $tdf_month; $i++) {
            array_push($curent_month_based_timelines, [
                "target" => 0,
                "progress" => 0,
            ]);
        }

        //get project activity
        if (Auth::user()->can("Access All Project")|| auth()->user()->hasAnyRole(['ED'])) {
            //All Project Activities
            $projectactivitys = ProjectActivity::where("fiscal_year", $this->fiscal_year)->with([
                "project:projectID,programID",
                "milestone.timeline"
            ])
                ->get();
        } else {

            //Assigned Project Activities
            $projectactivitys = ProjectActivity::where("fiscal_year", $this->fiscal_year)->where(function ($query) {
                $query->whereJsonContains('main_responsibility', Auth::id())
                    ->orWhereJsonContains('supportive_responsibility', Auth::id());
            })->with([
                "project:projectID,programID",
                "milestone.timeline"
            ])
                ->get();
        }

        foreach ($projectactivitys as $project_activity) {
            if (!empty($project_activity->milestone)) {
                foreach ($project_activity->milestone as $milestone) {
                    if (!empty($milestone->timeline) && !empty($milestone->timeline->timeline)) {

                        for ($i = 1; $i < 13; $i++) {

                            //-for full year T/P
                            if (!empty($milestone->timeline->timeline) &&  $milestone->timeline->timeline[strval($i)] != "") {
                                $timelines[$i - 1]["target"] = $timelines[$i - 1]["target"] + 1;
                            }
                            if (!empty($milestone->timeline->progress_input_data) &&  $milestone->timeline->progress_input_data[strval($i)] != "") {
                                $timelines[$i - 1]["progress"] = $timelines[$i - 1]["progress"] + 1;
                            }

                            //-- for till date T/P
                            if ($i <= $tdf_month) {
                                if (!empty($milestone->timeline->timeline) &&  $milestone->timeline->timeline[strval($i)] != "") {
                                    $curent_month_based_timelines[$i - 1]["target"] = $curent_month_based_timelines[$i - 1]["target"] + 1;
                                }
                                if (!empty($milestone->timeline->progress_input_data) &&  $milestone->timeline->progress_input_data[strval($i)] != "") {
                                    $curent_month_based_timelines[$i - 1]["progress"] = $curent_month_based_timelines[$i - 1]["progress"] + 1;
                                }
                            }
                        }
                    }
                }
            }
        }


        $timeline_collection = collect($timelines);
        $target_sum = $timeline_collection->sum("target");
        $progress_sum = $timeline_collection->sum("progress");
        array_splice($timelines, 0, 0, array([
            "target" =>
            null,
            "progress" =>
            null,
        ]));
        $timeline_collection = collect($timelines);


        $tilldate_timeline_collection = collect($curent_month_based_timelines);
        $tilldate_target_sum = $tilldate_timeline_collection->sum("target");
        $tilldate_progress_sum = $tilldate_timeline_collection->sum("progress");
        array_splice($curent_month_based_timelines, 0, 0, array([
            "target" =>
            null,
            "progress" =>
            null,
        ]));
        $tilldate_timeline_collection = collect($curent_month_based_timelines);


        return [
            $timeline_collection->pluck("target"),
            $timeline_collection->pluck("progress"),

            $target_sum,
            $progress_sum,

            $tilldate_timeline_collection->pluck("target"),
            $tilldate_timeline_collection->pluck("progress"),
            $tilldate_target_sum,
            $tilldate_progress_sum,

        ];
    }
}
