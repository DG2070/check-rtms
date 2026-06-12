@extends('layouts.app')

@section('title', 'Projects')

@include('layouts.includes.data-table.style')

@section('content')
    @include('layouts.includes.errors')

    <div class="province-projects-section">
        <div class="row">
            <div class="col-12 col-md-9">
                <div class="province-project-datatable-container">
                    @include('admin.projects.province.data-table-list')
                </div>
            </div>
            <div class="col-12 col-md-3">
                {{-- overview & chart section --}}
                <div class="overview-chart-container home-finnancial-target-progress-container card shadow-lg border-0">
                    <div class="card-body">
                        <div class="project_name h8">
                            <strong>Overview</strong>
                        </div>

                        <div class="card bg-light mb-0 mt-3 ">
                            <div class="card-body">
                                <div class=" ">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class=" ">
                                                <h5 class="total_title">Financial Target :</h5>
                                                <h2 class="mt-2 total_title_data">
                                                    <span class="">
                                                        {{ $province_overview_data['FT'] ?? '0' }}
                                                    </span>
                                                </h2>
                                            </div>
                                            <div class="mt-4">
                                                <h5 class="total_title">Financial Progress :</h5>
                                                <h2 class="mt-2 total_title_data">
                                                    <span class="">
                                                        {{ $province_overview_data['FP'] ?? '0' }}
                                                    </span>
                                                </h2>
                                            </div>
                                            <div class="mt-4">
                                                <h5 class="total_title">Physical Target : <span
                                                        class="badge badge-info mb-1" title="(converted to 100%)">
                                                        <i class="fa fa-info"></i>
                                                    </span></h5>
                                                <h2 class="mt-2 total_title_data">
                                                    <span class="">
                                                        {{ $province_overview_data['PT_P'] ?? '0' }}
                                                    </span>%
                                                </h2>
                                            </div>
                                            <div class="mt-4">
                                                <h5 class="total_title">Physical Progress :</h5>
                                                <h2 class="mt-2 total_title_data">
                                                    <span class="">
                                                        {{ $province_overview_data['PP_P'] ?? '0' }}
                                                    </span>%
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="project-status mt-2">


                            {{-- <table class="table no-border">
                                <tr>
                                    <td>
                                        <div class="project-status__single">
                                            <div class="status_count">
                                                {{ $province_overview_stat['total'] }}
                                            </div>
                                            <div class="status_title">
                                                Total
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="project-status__single">
                                            <div class="status_count">
                                                <div class="stat-color-box" style="background: #00a65a"></div>
                                                {{ $province_overview_stat['running'] }}
                                            </div>
                                            <div class="status_title">
                                                Running
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="project-status__single">
                                            <div class="status_count">
                                                <div class="stat-color-box" style="background: #f39c12"></div>
                                                {{ $province_overview_stat['completed'] }}
                                            </div>
                                            <div class="status_title">
                                                Completed
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="project-status__single">
                                            <div class="status_count">
                                                <div class="stat-color-box" style="background: #f56954"></div>
                                                {{ $province_overview_stat['stopped'] }}
                                            </div>
                                            <div class="status_title">
                                                Stopped
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            </table> --}}
                        </div>
                        {{-- <div class="chart-container mt-3">

                            <canvas id="pie-chart"></canvas>
                        </div> --}}
                    </div>
                </div>
                {{-- !ENDS overview & chart section --}}
            </div>
        </div>
    </div>




@endsection

{{-- @push('css')
    <style>
        .status_count {
            font-size: 22px;
            font-weight: bold;
            display: flex;
            justify-content: start;
            justify-items: center;
        }

        .status_title {
            font-size: 12px;
            text-transform: uppercase;
        }

        .stat-color-box {
            width: 10px;
            height: 10px;
        }
    </style>
@endpush --}}


{{-- @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

    <script>
        $(function() {

            function drawChart() {
                var pieChartCanvas = $('#pie-chart').get(0).getContext('2d');

                var donutData = {
                    labels: ["Running", "Completed", "Stopped", "Unknown"],
                    datasets: [{
                        data: [{{ $province_overview_stat['running'] }},
                            {{ $province_overview_stat['completed'] }},
                            {{ $province_overview_stat['stopped'] }},
                            {{ $province_overview_stat['total'] - ( $province_overview_stat['stopped'] + $province_overview_stat['completed']  + $province_overview_stat['running']) }}   ,
                        ],
                        backgroundColor: ['#00a65a', '#f39c12', '#f56954', '#000'],
                    }]
                }
                var donutOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                }

                new Chart(pieChartCanvas, {
                    type: 'pie',
                    data: donutData,
                    options: donutOptions
                })
            }

            drawChart();

        })
    </script>
@endpush --}}
