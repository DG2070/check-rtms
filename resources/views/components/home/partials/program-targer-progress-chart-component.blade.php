<div class="">
    <div class="card">
        <div class="card-body pb-2">
            <div class="row justify-content-center">
                <div class="col-12">
                    <canvas id="dashboard_program_ft_fp"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


@push('script')
    <script>
        var program_names = @json($program_names);
        var program_FT_P = @json($program_FTs);
        var program_FP_P = @json($program_FPs);
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


        var dashboard_program_ft_fp = {
            type: 'bar',
            data: {
                labels: program_names,
                datasets: [
                    finance_target_data, finance_progress_data,
                ]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Program Financial Target & Financial Progress'
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Financial Target & Financial Progress'
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

        new Chart($('#dashboard_program_ft_fp').get(0).getContext(
            '2d'), dashboard_program_ft_fp);
    </script>
@endpush
