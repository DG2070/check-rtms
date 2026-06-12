<div class="home-finnancial-target-progress-container">
    <div class="card">
        <div class="card-body pb-2">


            <div class="row ">
                <div class="col-12 col-md-4 col-xl-4">
                    <div class="d-flex align-items-start mb-3">
                        <div class="flex-grow-1">
                            <h5 class="card-title font-weight-bold">Budget Overview</h5>
                        </div>
                    </div>
                    <div class="card bg-light mb-0" style="height: 480px">
                        <div class="card-body">
                            <div class="py-2">
                                <div class="">
                                    <h5 class="total_title">Total Budget FY
                                        {{ App\Helper\FiscalYear::curentFullFiscalYear() }}:</h5>
                                    <h2 class="mt-2 total_title_data">
                                        <span class="">
                                            {{ $approved_budget_overall ?? '' }}
                                        </span>
                                    </h2>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mt-4">
                                            <h5 class="total_title">Financial Target :</h5>
                                            <h2 class="mt-2 total_title_data">
                                                <span class="" data-total="{{ $financial_target ?? '' }}"
                                                    id="dashboard_budget_overview_financial_target_field">
                                                    {{ $financial_target ?? '' }}
                                                </span>
                                            </h2>
                                        </div>
                                        <div class="mt-4">
                                            <h5 class="total_title">Financial Progress :</h5>
                                            <h2 class="mt-2 total_title_data">
                                                <span class="" data-total="{{ $financial_progress ?? '' }}"
                                                    id="dashboard_budget_overview_financial_progress_field">
                                                    {{ $financial_progress ?? '' }}
                                                </span>
                                            </h2>
                                        </div>
                                        <div class="mt-4">
                                            <h5 class="total_title">Physical Target :</h5>
                                            <h2 class="mt-2 total_title_data">
                                                <span class="" data-total="{{ $physical_target ?? '' }}"
                                                    id="dashboard_budget_overview_physical_target_field">
                                                    {{ $physical_target ?? '' }}
                                                </span>
                                            </h2>
                                        </div>
                                        <div class="mt-4">
                                            <h5 class="total_title">Physical Progress :</h5>
                                            <h2 class="mt-2 total_title_data">
                                                <span class="" data-total="{{ $physical_progress ?? '' }}"
                                                    id="dashboard_budget_overview_physical_progress_field">
                                                    {{ $physical_progress ?? '' }}
                                                </span>
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mt-4">
                                            <label>Month Filter</label>
                                            <select id="dashboard_budget_overview_filter_month"
                                                class="form-control select2 dashboard_budget_overview_filter_select2">
                                                <option value="" disabled>--SELECT MONTH--</option>
                                                <option value="all" selected>
                                                    ALL</option>
                                                <option value="1">Shrawan</option>
                                                <option value="2">Bhadra</option>
                                                <option value="3">Asoj</option>
                                                <option value="4">Kartik</option>
                                                <option value="5">Mangsir</option>
                                                <option value="6"> Poush</option>
                                                <option value="7"> Magh</option>
                                                <option value="8"> Falgun</option>
                                                <option value="9">Chaitra</option>
                                                <option value="10">Baishakh</option>
                                                <option value="11">Jestha</option>
                                                <option value="12">Ashadh</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 col-md-8 col-xl-8">
                    <div class="row justify-content-end">
                        <div class="col-md-5">
                            <div class="form-group d-flex align-items-center">
                                <div class="mr-2">
                                    <label> Filter</label>
                                </div>
                                <select id="dashboard_budget_overview_chart_type_filter"
                                    class="form-control select2 dashboard_budget_overview_chart_type_filter_select2">
                                    <option value="" disabled>--SELECT CHART TYPE--</option>
                                    <option value="finance">Finance Target & Progress Chart</option>
                                    <option value="physical">Physical Target & Progress Chart</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <canvas id="dashboard_budget_overview_chart"></canvas>
                </div>
            </div>

        </div>

    </div>
</div>


@push('script')
    <script>
        // console.log("financialtarget_values_permonth");
        // console.log({{ $financialtarget_values_permonth }});
        // console.log("financialprogress_values_permonth");
        // console.log({{ $financialprogress_values_permonth }});
        // console.log({{ $physical_target_values_permonth }});
        // console.log({{ $physical_progress_values_permonth }});


        var financialtarget_values_permonth = {{ $financialtarget_values_permonth ?? [] }};
        var financialprogress_values_permonth = {{ $financialprogress_values_permonth ?? [] }};
        var physical_target_values_permonth = {{ $physical_target_values_permonth ?? [] }};
        var physical_progress_values_permonth = {{ $physical_progress_values_permonth ?? [] }};

        // console.log(financialtarget_values_permonth);
        // console.log(financialprogress_values_permonth);
        // console.log(physical_target_values_permonth);
        // console.log(physical_progress_values_permonth);
    </script>

    <script>
        /** Select2 For Filter */
        // dashboard_budget_overview_filter_select2
        $(".dashboard_budget_overview_filter_select2").select2({
            closeOnSelect: true,
        });
        $(".dashboard_budget_overview_chart_type_filter_select2").select2({
            closeOnSelect: true,
        });

        $("#dashboard_budget_overview_filter_month").on("change", function() {
            // console.log(this.value);
            if (this.value == "all") {
                $("#dashboard_budget_overview_financial_target_field").html($(
                    "#dashboard_budget_overview_financial_target_field").data("total"))
                $("#dashboard_budget_overview_financial_progress_field").html($(
                    "#dashboard_budget_overview_financial_progress_field").data("total"))
                $("#dashboard_budget_overview_physical_target_field").html($(
                    "#dashboard_budget_overview_physical_target_field").data("total"))
                $("#dashboard_budget_overview_physical_progress_field").html($(
                    "#dashboard_budget_overview_physical_progress_field").data("total"))
                return
            }

            $("#dashboard_budget_overview_financial_target_field").html(financialtarget_values_permonth[this.value -
                1])
            $("#dashboard_budget_overview_financial_progress_field").html(financialprogress_values_permonth[this
                .value - 1])
            $("#dashboard_budget_overview_physical_target_field").html(physical_target_values_permonth[this.value -
                1])
            $("#dashboard_budget_overview_physical_progress_field").html(physical_progress_values_permonth[this
                .value - 1])
        });
    </script>

    <script>
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
                    finance_target_data, finance_progress_data,
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
        $("#dashboard_budget_overview_chart_type_filter").on("change", function() {

            if (this.value == "finance") {
                dashboard_budget_overview_chart.data.datasets = [];
                dashboard_budget_overview_chart.data.datasets.push(finance_target_data);
                dashboard_budget_overview_chart.data.datasets.push(finance_progress_data);
                dashboard_budget_overview_chart.update();
            }
            if (this.value == "physical") {
                dashboard_budget_overview_chart.data.datasets = [];
                dashboard_budget_overview_chart.data.datasets.push(physical_target_data);
                dashboard_budget_overview_chart.data.datasets.push(physical_progress_data);
                dashboard_budget_overview_chart.update();
            }
        });
    </script>
@endpush
