@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')


    {{-- counters --}}
    @if (Auth::user()->hasAnyRole(['Sysqube-Super-Admin', 'Super-Admin', 'ED', 'Department-Head']))
        <div class="">
            <x-home.partials.counters-component />
        </div>
    @endif


    {{-- map --}}
    @if (Auth::user()->hasAnyRole(['Sysqube-Super-Admin', 'Super-Admin', 'ED']))
        @include('home._partials.map')
    @endif

    {{-- !ENDS map --}}


    {{-- budget overview --}}
    <div class="mt-2">
        <x-home.partials.overall-chart-component />
    </div>



    {{-- !ENDScounters --}}

    {{-- budget overview --}}
    {{-- @if (Auth::user()->hasAnyRole(['Sysqube-Super-Admin', 'Super-Admin', 'ED', 'Department-Head', 'Department-User']))
        <div class="mt-2">
            <x-home.partials.budget-overview-component />
        </div>
    @endif --}}

    {{-- progress line chart --}}
    @if (Auth::user()->hasAnyRole(['Sysqube-Super-Admin', 'Super-Admin', 'ED', 'Department-Head', 'Department-User']))
        <div class="mb-5">
            <x-home.partials.progress-line-chart-component />
        </div>
    @endif
    {{-- !ENDS progress line chart --}}

    {{-- internal progress line chart --}}
    @if (auth()->user()->can('Access Internal Projects') ||
        auth()->user()->can('Access All Internal Projects') ||
        Auth::user()->hasAnyRole(['Sysqube-Super-Admin', 'Super-Admin', 'ED']))
        <div class="mb-5">
            <x-home.internal.partials.internal-progress-line-chart-component />
        </div>
    @endif
    {{-- !ENDS internal progress line chart --}}



    {{-- charts --}}
    @if (Auth::user()->hasAnyRole(['Sysqube-Super-Admin', 'Super-Admin', 'ED']))
        @include('home._partials.charts')
    @endif

    {{-- !ENDS charts --}}

    {{-- program FT/FP chart --}}
    <div class="mt-2">
        <x-home.partials.program-targer-progress-chart-component />
    </div>



    {{-- all projects --}}
    @if (Auth::user()->hasAnyRole(['Sysqube-Super-Admin', 'Super-Admin', 'ED']))
        <x-home.partials.all-project-component />
    @endif
    {{-- !ENDS all projects --}}

    {{-- all locked projects --}}
    @if (Auth::user()->hasAnyRole(['Sysqube-Super-Admin', 'Super-Admin', 'ED']))
        <x-home.partials.lock-project-list-component />
    @endif
    {{-- !ENDS all locked projects --}}

    {{-- all projects by department --}}
    {{-- ONLY for department head else it will break --}}
    @if (Auth::user()->hasAnyRole(['Department-Head']))
        <x-home.partials.all-project-by-department-component />
    @endif
    {{-- !ENDS all projects by department --}}

    {{-- assigned projects --}}
    @if (!Auth::user()->hasAnyRole(['Sysqube-Super-Admin', 'Super-Admin', 'ED']))
        <x-home.partials.assigned-project-component />
    @endif
    {{-- !ENDS assigned projects --}}




@endsection

@push('css')
    @include('home._partials.css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endpush


@push('script')
    {{-- @include('layouts.includes.map-script') --}}
    @include('home._partials.js')
    <script>
        $(function() {
            /**
             *   For Home Filters
             */

            // Select2 setups
            $(".dashboard_filter_select2").select2({
                closeOnSelect: true,
            });

            //change district when province changed
            $("#dashboard_filter_province_select").on("change", function() {
                var province_code = $("#dashboard_filter_province_select").val();
                //show province stats on right side
                getProvinceInfo(parseInt(province_code));
                console.log("province_code");
                console.log(province_code);
                //get all district for province selected.
                $.ajax({
                    url: "/api/province/" + province_code + "/district",
                    success: function(result) {
                        // console.log(result);
                        if (!result) {
                            alert("Error while fetching district.");
                        }
                        var districts = result;
                        $("#dashboard_filter_district_select")
                            .find("option")
                            .remove()
                            .end();
                        $("#dashboard_filter_district_select").append(
                            $("<option>", {
                                value: null,
                                text: "--SELECT DISTRICT--",
                                selected: true,
                                disabled: true,
                            })
                        );
                        districts.forEach((district) => {
                            //add district name on select
                            $("#dashboard_filter_district_select").append(
                                $("<option>", {
                                    value: district,
                                    text: district,
                                })
                            );
                        });
                    },
                });


            });

            //change town when district changed
            $("#dashboard_filter_district_select").on("change", function() {
                var province_code = $("#dashboard_filter_province_select").val();
                // console.log(province_code);
                // console.log($(this).val());

                //change api_endpoint depending on province_code
                var api_endpoint = "/api/town-by-district";
                if (province_code != null) {
                    api_endpoint = "/api/town-by-district-province";
                }

                //get all district
                $.ajax({
                    method: "POST",
                    url: api_endpoint,
                    data: {
                        district_name: $(this).val(),
                        province_code: province_code,
                    },
                    success: function(result) {
                        // console.log(result);
                        if (!result) {
                            alert("Error while fetching town names.");
                        }
                        var towns = result;
                        $("#dashboard_filter_town_select")
                            .find("option")
                            .remove()
                            .end();
                        $("#dashboard_filter_town_select").append(
                            $("<option>", {
                                value: null,
                                text: "--SELECT TOWN--",
                                selected: true,
                                disabled: true,
                            })
                        );
                        towns.forEach((district) => {
                            //add district name on select
                            $("#dashboard_filter_town_select").append(
                                $("<option>", {
                                    value: district,
                                    text: district,
                                })
                            );
                        });
                    },
                });
            });

            function getStats() {}
        });
    </script>

    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.dashboardTable').DataTable();
        });
    </script>
@endpush
