<div class="home-finnancial-target-progress-container">
    <div class="card">
        <div class="card-body pb-2">


            <div class="row ">
                <div class="col-12 col-md-4 col-xl-3">
                    <div class="d-flex align-items-start mb-3">
                        <div class="flex-grow-1">
                            <h5 class="card-title font-weight-bold">Overview FY
                                {{ App\Helper\FiscalYear::curentFullFiscalYear() }}</h5>
                        </div>
                    </div>
                    <div class="card bg-light mb-0" style="height: 480px">
                        <div class="card-body">
                            <div class="py-2">
                                <div class="">
                                    <h5 class="total_title">Total Budget FY
                                        {{ App\Helper\FiscalYear::curentFullFiscalYear() }}:</h5>
                                    <h2 class="mt-2 total_title_data">
                                        <span class="" data-total="{{ $approved_budget_overall ?? '' }}"
                                            id="dashboard_budget_overview_approved_budget_overall">
                                            {{ App\Helper\AmountFormat::formatNepaliAmount($approved_budget_overall) ?? '' }}
                                        </span>
                                    </h2>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mt-4">
                                            <h5 class="total_title">Financial Target :</h5>
                                            <h2 class="mt-2 total_title_data">
                                                <span class="" data-total="{{ $financial_target ?? '' }}"
                                                    id="dashboard_budget_overview_financial_target_field">
                                                    {{ App\Helper\AmountFormat::formatNepaliAmount($financial_target) ?? '' }}
                                                </span>
                                            </h2>
                                        </div>
                                        <div class="mt-4">
                                            <h5 class="total_title">Financial Progress :</h5>
                                            <h2 class="mt-2 total_title_data">
                                                <span class="" data-total="{{ $financial_progress ?? '' }}"
                                                    id="dashboard_budget_overview_financial_progress_field">
                                                    {{ App\Helper\AmountFormat::formatNepaliAmount($financial_progress) ?? '' }}
                                                    ({{ $financial_target != 0 ? number_format((float) ($financial_progress / $financial_target) * 100, 2, '.', '') : '' }})%
                                                </span>
                                            </h2>
                                        </div>
                                        <div class="mt-4">
                                            <h5 class="total_title">Physical Target : <span
                                                    class="badge badge-info mb-1" title="(converted to 100%)">
                                                    <i class="fa fa-info"></i>
                                                </span></h5>
                                            <h2 class="mt-2 total_title_data">
                                                <span class="" data-total="{{ $physical_target ?? '' }}"
                                                    id="dashboard_budget_overview_physical_target_field"
                                                    title="{{ $physical_target ?? '' }}">
                                                    {{ $physical_target ?? 0 }}
                                                </span>%
                                            </h2>
                                        </div>
                                        <div class="mt-4">
                                            <h5 class="total_title">Physical Progress :</h5>
                                            <h2 class="mt-2 total_title_data">
                                                <span class="" data-total="{{ $physical_progress ?? '' }}"
                                                    id="dashboard_budget_overview_physical_progress_field"title="{{ $physical_progress ?? '' }}">
                                                    {{ $physical_progress ?? 0 }}
                                                </span>%
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 col-md-8 col-xl-9">

                    <canvas id="dashboard_budget_overview_chart"></canvas>
                </div>
            </div>

            <div class="text-right">
                <a href="{{ route('home.reports') }}">
                    More Report
                </a>
            </div>

        </div>

    </div>
</div>


@push('script')
    <script>
        var program_names = @json($program_names);
        var program_FT_P = @json($program_FT_P);
        var program_FP_P = @json($program_FP_P);
        var program_PT_P = @json($program_PT_P);
        var program_PP_P = @json($program_PP_P);
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
    </script>

    <script>
        // var datasets

        var finance_target_data = {
            label: 'Financial Target',
            backgroundColor: "blue",
            borderColor: "blue",
            fill: false,
            data: program_FT_P,
        };

        var finance_progress_data = {
            label: 'Financial Progress',

            backgroundColor: "red",
            borderColor: "red",
            fill: false,
            data: program_FP_P,

        };

        var physical_target_data = {
            label: 'Physical Target',
            backgroundColor: "green",
            borderColor: "green",
            fill: false,
            data: program_PT_P,
        };

        var physical_progress_data = {
            label: 'Physical Progress',

            backgroundColor: "yellow",
            borderColor: "yellow",
            fill: false,
            data: program_PP_P,

        };


        var home_budget_overview_chart_321 = {
            type: 'bar',
            data: {
                labels: program_names,
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
                            labelString: 'Progress of physcial and financial'
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
@endpush
