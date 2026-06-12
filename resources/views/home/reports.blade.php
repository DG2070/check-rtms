@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')


    {{-- breadcrumb section --}}
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Reports
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- !ENDS breadcrumb section --}}



    <div class="card card-body mt-0 pt-2">
        {{-- program selection filter --}}
        <div>
            <div class="rounded-select-container">
                <form action="">
                    <div class="">
                        <div class="row ">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Program</label>
                                    <select class="form-control select2" id="program_select" name="program" required>
                                        <option value="" selected disabled>--SELECT PROGRAM--</option>
                                        @if (!empty($programs))
                                            @foreach ($programs as $pro)
                                                <option value="{{ $pro->ID }}"
                                                    {{ $program_id == $pro->ID ? 'selected' : '' }}>
                                                    {{ $pro->NameLong }} [ {{ $pro->Code }} ]
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Month</label>
                                    @php
                                        $months = ['Shrawan', 'Bhadra', 'Asoj', 'Kartik', 'Mangsir', 'Poush', 'Magh', 'Falgun', 'Chaitra', 'Baishakh', 'Jestha', 'Ashadh'];
                                    @endphp
                                    <select class="form-control select2" id="month_select" name="month" required>
                                        <option value="" selected disabled>--SELECT MONTH--</option>

                                        @foreach ($months as $month)
                                            <option value="{{ $month }}"
                                                {{ $month == request('month') ? 'selected' : '' }}>
                                                {{ $month }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="d-block">&nbsp;</label>
                                    <button type="submit"
                                        class="btn btn-primary btn-tdf-primary tdf-border-small">Open</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- !ENDS program selection filter --}}

        {{-- main content --}}

        <canvas id="dashboard_budget_overview_chart" style="height: 70vh"></canvas>
        <canvas id="dashboard_project_wise_budget_overview_chart" style="height: 70vh"></canvas>

        {{-- !ENDS main content --}}

    </div>





@endsection


@push('script')
    <script>
        /**************PROGRAM************/
        $('#program_select').select2({
            closeOnSelect: true,
        });
        $('#month_select').select2({
            closeOnSelect: true,
        });
    </script>



    @if (!empty(request('month')))
        <script>
            var monthWiseData_names = @json($monthWiseData_names);
            var monthWiseData_FT_Ps = @json($monthWiseData_FT_Ps);
            var monthWiseData_FP_Ps = @json($monthWiseData_FP_Ps);
            var monthWiseData_PT_Ps = @json($monthWiseData_PT_Ps);
            var monthWiseData_PP_Ps = @json($monthWiseData_PP_Ps);

            console.log(monthWiseData_FT_Ps);


            var finance_target_data = {
                label: 'Financial Target',
                backgroundColor: "blue",
                borderColor: "blue",
                fill: false,
                data: monthWiseData_FT_Ps,
            };

            var finance_progress_data = {
                label: 'Financial Progress',

                backgroundColor: "red",
                borderColor: "red",
                fill: false,
                data: monthWiseData_FP_Ps,

            };

            var physical_target_data = {
                label: 'Physical Target',
                backgroundColor: "green",
                borderColor: "green",
                fill: false,
                data: monthWiseData_PT_Ps,
            };

            var physical_progress_data = {
                label: 'Physical Progress',

                backgroundColor: "yellow",
                borderColor: "yellow",
                fill: false,
                data: monthWiseData_PP_Ps,

            };


            var home_budget_overview_chart_321 = {
                type: 'bar',
                data: {
                    labels: monthWiseData_names,
                    datasets: [
                       finance_target_data, finance_progress_data, physical_target_data, physical_progress_data,
                    ]
                },
                options: {
                    responsive: true,
                    title: {
                        // display: true,
                        // text: 'Chart.js Line Chart - Logarithmic'
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Months'
                            },

                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                            },
                        }]
                    }
                }
            };

            var dashboard_budget_overview_chart = new Chart($('#dashboard_budget_overview_chart').get(0).getContext(
                '2d'), home_budget_overview_chart_321);
        </script>
    @else
        <script>
            var financialtarget_values_permonth = @json($financial_target_per_month_in_percent);
            var financialprogress_values_permonth = @json($financial_progress_per_month_in_percent);
            var physical_target_values_permonth = @json($physical_target_per_month_in_percent);
            var physical_progress_values_permonth = @json($physical_progress_per_month_in_percent);

            // var datasets

            var finance_target_data = {
                label: 'Financial Target',
                backgroundColor: "blue",
                borderColor: "blue",
                fill: false,
                data: financialtarget_values_permonth,
            };

            var finance_progress_data = {
                label: 'Financial Progress',

                backgroundColor: "red",
                borderColor: "red",
                fill: false,
                data: financialprogress_values_permonth,

            };

            var physical_target_data = {
                label: 'Physical Target',
                backgroundColor: "green",
                borderColor: "green",
                fill: false,
                data: physical_target_values_permonth,
            };

            var physical_progress_data = {
                label: 'Physical Progress',

                backgroundColor: "yellow",
                borderColor: "yellow",
                fill: false,
                data: physical_progress_values_permonth,

            };


            var home_budget_overview_chart_321 = {
                type: 'bar',
                data: {
                    labels: ['Shrawan', 'Bhadra', 'Asoj', 'Kartik', 'Mangsir', 'Poush', 'Magh', 'Falgun', 'Chaitra',
                        'Baishakh', 'Jestha', 'Ashadh'
                    ],
                    datasets: [
                        finance_target_data, finance_progress_data, physical_target_data, physical_progress_data,
                    ]
                },
                options: {
                    responsive: true,
                    title: {
                        // display: true,
                        // text: 'Chart.js Line Chart - Logarithmic'
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Months'
                            },

                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                            },
                        }]
                    }
                }
            };

            var dashboard_budget_overview_chart = new Chart($('#dashboard_budget_overview_chart').get(0).getContext(
                '2d'), home_budget_overview_chart_321);



            /** RE BUILD Chart according to selected option chart type */
            // $("#dashboard_budget_overview_chart_type_filter").on("change", function() {

            //     if (this.value == "finance") {
            //         dashboard_budget_overview_chart.data.datasets = [];
            //         dashboard_budget_overview_chart.data.datasets.push(finance_target_data);
            //         dashboard_budget_overview_chart.data.datasets.push(finance_progress_data);
            //         dashboard_budget_overview_chart.update();
            //     }
            //     if (this.value == "physical") {
            //         dashboard_budget_overview_chart.data.datasets = [];
            //         dashboard_budget_overview_chart.data.datasets.push(physical_target_data);
            //         dashboard_budget_overview_chart.data.datasets.push(physical_progress_data);
            //         dashboard_budget_overview_chart.update();
            //     }
            // });
        </script>
    @endif

@endpush

@section('style')
    <style>
        s .table .thead-blue th {
            color: #fff;
            background-color: #225e95;
            border-color: #588bb9;
        }

        th,
        td {
            vertical-align: middle !important;
        }

        .custom-container {
            width: 100%;
            height: auto;
            margin: auto;
            background: #edeff2;
            padding-left: 30px;
            padding-right: 30px;
            padding-bottom: 30px;
        }

        .background-blue {
            background-color: #225e95 !important;
        }

        .select2-hidden-accessible {
            border: 0 !important;
            clip: rect(0 0 0 0) !important;
            height: 1px !important;
            margin: -1px !important;
            overflow: hidden !important;
            padding: 0 !important;
            position: absolute !important;
            width: 1px !important;
        }

        .form-control {
            display: block;
            width: 100%;
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        }

        .select2-container--default .select2-selection--single,
        .select2-selection .select2-selection--single {
            border: 1px solid #d2d6de;
            border-radius: 0;
            padding: 6px 12px;
            height: 34px;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaa;
            border-radius: 4px;
        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 28px;
            user-select: none;
            -webkit-user-select: none;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-right: 10px;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: 0;
            padding-right: 0;
            height: auto;
            margin-top: -3px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 28px;
        }

        .select2-container--default .select2-selection--single,
        .select2-selection .select2-selection--single {
            border: 1px solid #d2d6de;
            border-radius: 0 !important;
            padding: 6px 12px;
            height: 40px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 6px !important;
            right: 1px;
            width: 20px;
        }
    </style>
    <style>
        .table .thead-blue th {
            color: #fff;
            background-color: #225e95;
            border-color: #588bb9;
        }

        .background-blue {
            background-color: #225e95 !important;
        }


        .select2-dropdown {
            z-index: 2054 !important;
        }

        .select2-container--default {
            width: 100% !important;
        }

        .select2-selection__choice {
            color: white !important;
            background: #2969a2 !important;
            font-size: 14px !important;
            padding: 5px 10px !important;
        }
    </style>
@endsection
