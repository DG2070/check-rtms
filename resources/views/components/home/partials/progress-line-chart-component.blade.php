<div class="home-progress-line-chart-container ">
    <div class="card">
        <div class="card-body pb-2">

            <div class="row align-items-center">
                <div class="col-12 col-md-8">
                    <canvas id="home_progress_line_chart"></canvas>
                </div>

                <div class="col-12 col-md-2">
                    <div class="card bg-light mb-0" style="height: 450px;position: relative;">
                        <div class="card-body">
                            <div class="py-2">
                                <div>
                                    <h5 class="total_title">
                                        Milestone Wise Up To Date Progress FY
                                        {{ App\Helper\FiscalYear::curentFullFiscalYear() }}
                                    </h5>
                                    <div class="" style="margin-top: 40px">
                                        @php
                                            //for divide by zero error
                                            $progress_percent = 0;
                                            if ($till_date_total_progress_per_month_sum != 0 && $till_date_total_target_per_month_sum != 0) {
                                                $progress_percent = ($till_date_total_progress_per_month_sum / $till_date_total_target_per_month_sum) * 100;
                                            }
                                        @endphp

                                        <div class="progress-circle-container">
                                            <div class="d-flex align-items-center">
                                                <!-- Progress bar 1 -->
                                                <div class="progress mx-auto progress_stats"
                                                    data-value=' {{ $progress_percent }}'>
                                                    <span class="progress-left">
                                                        <span class="progress-bar border-primary"></span>
                                                    </span>
                                                    <span class="progress-right">
                                                        <span class="progress-bar border-primary"></span>
                                                    </span>
                                                    <div
                                                        class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                                        <div class="h2 font-weight-bold">
                                                            {{ number_format((float) $progress_percent, 2, '.', '') }}
                                                            <sup class="small">%</sup>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END -->
                                            </div>
                                        </div>
                                    </div>

                                    <div style="margin-top: 30px;position: absolute;bottom:0;left:5%;width:90%">
                                        <table class="table table-striped">
                                            <tr>
                                                <td style="width: 50%">Target</td>
                                                <td class="text-left">{{ $till_date_total_target_per_month_sum }}</td>
                                            </tr>
                                            <tr style="background-color: rgba(0, 0, 0, .05);">
                                                <td style="width: 50%">Progress</td>
                                                <td class="text-left">{{ $till_date_total_progress_per_month_sum }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-2">
                    <div class="card bg-light mb-0" style="height: 450px;position: relative;">
                        <div class="card-body">
                            <div class="py-2">
                                <div>
                                    <h5 class="total_title">
                                        Milestone Wise Overall Progress FY
                                        {{ App\Helper\FiscalYear::curentFullFiscalYear() }}
                                    </h5>
                                    <div class="" style="margin-top: 40px">
                                        @php
                                            //for divide by zero error
                                            $progress_percent = 0;
                                            if ($total_progress_per_month_sum != 0 && $total_target_per_month_sum != 0) {
                                                $progress_percent = ($total_progress_per_month_sum / $total_target_per_month_sum) * 100;
                                            }
                                        @endphp

                                        <div class="progress-circle-container">
                                            <div class="d-flex align-items-center">
                                                <!-- Progress bar 1 -->
                                                <div class="progress mx-auto progress_stats"
                                                    data-value=' {{ $progress_percent }}'>
                                                    <span class="progress-left">
                                                        <span class="progress-bar border-primary"></span>
                                                    </span>
                                                    <span class="progress-right">
                                                        <span class="progress-bar border-primary"></span>
                                                    </span>
                                                    <div
                                                        class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                                                        <div class="h2 font-weight-bold">
                                                            {{ number_format((float) $progress_percent, 2, '.', '') }}
                                                            <sup class="small">%</sup>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END -->
                                            </div>
                                        </div>
                                    </div>

                                    <div style="margin-top: 30px;position: absolute;bottom:0;left:5%;width:90%">
                                        <table class="table table-striped">
                                            <tr>
                                                <td style="width: 50%">Target</td>
                                                <td class="text-left">{{ $total_target_per_month_sum }}</td>
                                            </tr>
                                            <tr style="background-color: rgba(0, 0, 0, .05);">
                                                <td style="width: 50%">Progress</td>
                                                <td class="text-left">{{ $total_progress_per_month_sum }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>


                </div>


            </div>

        </div>
    </div>




    @push('script')
        <script>
            // console.log({{ $total_target_per_month }});
            // const ctx = document.getElementById('myChart').getContext('2d');
            var home_progress_line_chart_config = {
                type: 'line',
                data: {
                    labels: ['','Shrawan', 'Bhadra', 'Asoj', 'Kartik', 'Mangsir', 'Poush', 'Magh', 'Falgun', 'Chaitra',
                        'Baishakh', 'Jestha', 'Ashadh'
                    ],
                    datasets: [{
                        label: 'Targets',

                        backgroundColor: "blue",
                        borderColor: "blue",

                        fill: false,
                        data: {{ $total_target_per_month ?? [] }},
                    }, {
                        label: 'Progress',
                        backgroundColor: "red",
                        borderColor: "red",
                        fill: false,
                        // data: {{ $total_progress_per_month ?? [] }},
                        data: {{ $till_date_total_progress_per_month ?? [] }},

                    }]
                },
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Milestone Wise Monthly Progress Chart FY {{ \App\Helper\FiscalYear::curentFullFiscalYear() }} (Project)'
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            beginAtZero :false,
                            scaleLabel: {
                                display: true,
                                labelString: 'Months'
                            },

                        }],
                        yAxes: [{
                            display: true,
                            //type: 'logarithmic',
                            scaleLabel: {
                                display: true,
                                // labelString: 'Index Returns'
                            },
                            // ticks: {
                            //     min: 0,
                            //     max: 500,

                            //     // forces step size to be 5 units
                            //     stepSize: 100
                            // }
                        }]
                    }
                }
            };


            var home_progress_line_chart = new Chart($('#home_progress_line_chart').get(0).getContext(
                '2d'), home_progress_line_chart_config);
        </script>
    @endpush
