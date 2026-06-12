@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="card shadow-lg border-0 mt-2">
        <div class="card-body">
            <div class="row">
                <div id="info" class="col-md-3 info" value="">
                    <div style="width: 100%">
                        <label class="p-2">फिल्टरहरु</label>
                        <div class="form-group px-2">
                            <label>आर्थिक बर्ष</label>
                            <select class="form-control">
                                <option value="79/80" selected disabled>७८/७९</option>
                            </select>
                        </div>

                        <div class="form-group px-2">
                            <label>प्रदेश</label>
                            <select id="province_select" class="form-control">
                                <option value="no" selected disabled>प्रदेश</option>
                                @foreach ($province as $pro)
                                    <option value="{{ $pro['id'] }}">{{ $pro['nname'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group px-2">
                            <label>जिल्ला</label>
                            <select id="district_select" class="form-control">
                                <option value="" selected disabled>जिल्ला</option>
                                @foreach ($locations as $location)
                                    <option value="{{ route('home', ['project' => $location['District']]) }}">
                                        {{ $location['District'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group px-2">
                            <label>नगर</label>
                            <select id="town_select" class="form-control" id="appendDistrict">
                                <option value="" selected disabled>नगर</option>
                                @foreach ($locations as $location)
                                    <option value="{{ route('home', ['project' => $location['TownName']]) }}">
                                        {{ $location['TownName'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <div class="form-group px-2">
                            <label>वित्तिय संस्था</label>
                            <select class="form-control" id="appendDistrict">
                                <option value="" selected disabled>वित्तिय संस्था</option>

                                @foreach ($financing_agencies as $financing_agency)
                                    <option>
                                        {{ $financing_agency['FinancingAgency'] }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="form-group text-center">
                            <button id="filter_map_view" class="btn btn-primary" style="width:100%">
                                Filter
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-9" style="min-height: 500px;">
                    <div id="map" class="map"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-body">
            <div class="row">
                {{-- bar chart --}}
                <div class="card col-md-12 ">
                    <div class="d-flex justify-content-center">
                        <div class="card-title py-2">
                            परियोजना प्रगति
                        </div>
                    </div>
                    <div class="card-body" style="min-height: 450px">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
                {{-- donut chart --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="donutChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('script')
    @include('layouts.includes.map-script')


    {{-- TODO: switch to components and remove redundancy vars --}}
    <script>
        function filterSetup() {
            let labels = <?php echo collect($province)->pluck('nname'); ?>;
            console.log(labels);


            //change district when province changed
            $("#province_select").change(function() {
                var province_code = $("#province_select").val();
                console.log(province_code);
                //get all district for province selected.
                $.ajax({
                    url: "/api/province/" + province_code + "/district",
                    success: function(result) {
                        console.log(result);
                        if (!result) {
                            alert("Error while fetching district.")
                        }
                        var districts = result;
                        $('#district_select').find('option').remove().end();
                        $('#district_select').append($('<option>', {
                            value: 0,
                            text: "जिल्ला",
                            selected: true,
                            disabled: true

                        }));
                        districts.forEach(district => {
                            //add district name on select
                            $('#district_select').append($('<option>', {
                                value: district,
                                text: district
                            }));
                        });

                    }
                })
            });

            //change town when district changed
            $("#district_select").change(function() {
                var province_code = $("#province_select").val();
                console.log(province_code);
                console.log($(this).val());

                //get all district for province selected.
                $.ajax({
                    method: "POST",
                    url: "/api/town-by-district",
                    data: {
                        district_name: $(this).val(),
                        province_code: province_code,
                    },
                    success: function(result) {
                        console.log(result);
                        if (!result) {
                            alert("Error while fetching town names.")
                        }
                        var towns = result;
                        $('#town_select').find('option').remove().end();
                        $('#town_select').append($('<option>', {
                            value: 0,
                            text: "नगर",
                            selected: true,
                            disabled: true

                        }));
                        towns.forEach(district => {
                            //add district name on select
                            $('#town_select').append($('<option>', {
                                value: district,
                                text: district
                            }));
                        });

                    }
                })
            });


        }
        filterSetup();



        $("#filter_map_view").click(function() {
            //get province
            if ($("#province_select").val() == null || $("#province_select").val() == 0) {
                alert("Select province");
            }
            var province_code = $("#province_select").val();
            //get district
            if ($("#district_select").val() == null || $("#district_select").val() == 0) {
                alert("Select district");
            }
            var district_name = $("#district_select").val();

            //get town name
            if ($("#town_select").val() == null || $("#town_select").val() == 0) {
                alert("Select town");
            }
            var town_name = $("#town_select").val();

            console.log("filter menu");
            console.log(province_code);
            console.log(district_name);
            console.log(town_name);

            $.ajax({
                method: "POST",
                url: "/api/project-stats-by-pdt",
                data: {
                    province_code: province_code,
                    district_name: district_name,
                    town_name: town_name,
                },
                success: function(result) {
                    console.log(result);
                    if (!result) {
                        alert("Error while fetching town names.")
                    }
                    var stats_data = result;
                    console.log(stats_data["total"]);

                    var total = stats_data["total"];
                    var running = stats_data["running"];
                    var completed = stats_data["completed"];
                    var stopped = stats_data["stopped"];


                    $("#total").html(total);
                    $("#running").html(running);
                    $("#completed").html(completed);
                    $("#halt").html(stopped);
                }
            })



        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

    <script>
        let labels = <?php echo collect($province)->pluck('nname'); ?>;
        let datas = <?php echo collect($province)->pluck('total'); ?>;
        let running_projects_data = <?php echo collect($province)->pluck('running'); ?>;
        let completed_projects_data = <?php echo collect($province)->pluck('completed'); ?>;
        let stopped_projects_data = <?php echo collect($province)->pluck('stopped'); ?>;


        $(function() {
            //-------------
            //- DONUT CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.

            var donutChartCanvas = $('#donutChart').get(0).getContext('2d');

            var donutData = {
                labels: labels,
                datasets: [{
                    data: datas,
                    backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#932ab6',
                        '#d0d6de'
                    ],
                }]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }

            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions

            })

             //-------------
            //- PIE CHART -
            //-------------
            var piechartcanvas = $('#pieChart').get(0).getContext('2d');

            var donutData = {
                labels: ["< 60%","> 70%","60 - 70"],
                datasets: [{
                    data: ["90","20","20",],
                    backgroundColor: ["red","green","yellow"
                    ],
                }]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }

            new Chart(piechartcanvas, {
                type: 'pie',
                data: donutData,
                options: donutOptions

            })


            //-------------
            //- BAR CHART -
            //-------------

            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barData = {
                labels: labels,
                datasets: [{
                    label: 'Total',
                    data: datas,
                    backgroundColor: ['#f56954', '#f56954', '#f56954', '#f56954', '#f56954', '#f56954',
                        '#f56954'
                    ],
                }, {
                    label: 'Running',
                    data: running_projects_data,
                    backgroundColor: ['#00a65a', '#00a65a', '#00a65a', '#00a65a', '#00a65a', '#00a65a',
                        '#00a65a'
                    ],
                }, {
                    label: 'Completed',
                    data: completed_projects_data,
                    backgroundColor: ['#f39c12', '#f39c12', '#f39c12', '#f39c12', '#f39c12', '#f39c12',
                        '#f39c12'
                    ],
                }, {
                    label: 'Stopped',
                    data: stopped_projects_data,
                    backgroundColor: ['#00c0ef', '#00c0ef', '#00c0ef', '#00c0ef', '#00c0ef', '#00c0ef',
                        '#00c0ef'
                    ],
                }]
            }
            var barOptions = {
                maintainAspectRatio: false,
                responsive: true,
                onClick: handelClick
            }
            var barchart = new Chart(barChartCanvas, {
                type: 'bar',
                data: barData,
                options: barOptions,
            })

            function handelClick(evt) {
                var status = [
                    "all",
                    "running",
                    "completed",
                    "stopped"
                ]
                var activeElement = barchart.getElementAtEvent(evt);
                var province_code = activeElement[0]._index + 1;
                var data_set_index = activeElement[0]._datasetIndex;;
                var url = "/projects/province/" + province_code + "?status=" + status[data_set_index];
                console.log(url);
                window.location.href = url;

            }

        })
    </script>
@endpush
