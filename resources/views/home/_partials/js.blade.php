<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>


<script type="text/javascript" src="/js/nepal-province.js"></script>
<script type="text/javascript" src="/js/province1-district.js"></script>
<script type="text/javascript" src="/js/province2-district.js"></script>
<script type="text/javascript" src="/js/province3-district.js"></script>
<script type="text/javascript" src="/js/province4-district.js"></script>
<script type="text/javascript" src="/js/province5-district.js"></script>
<script type="text/javascript" src="/js/province6-district.js"></script>
<script type="text/javascript" src="/js/province7-district.js"></script>

{{-- TODO move to js resource instead of blade --}}
{{-- map script --}}
<script type="text/javascript">
    window.addEventListener('resize', function(event) {
        const width = window.innerWidth
        console.log(10 + (width - 5000) / 1000);
        map.setZoom(10 + (width - 5000) / 1000);
    });
    const infoBox = document.getElementById('info');
    let zoomValue = window.innerWidth;
    // console.log(10 + (zoomValue - 5000) / 1000);
    // initialize the map

    function formatNepaliAmount(number) {
        // Convert the number to a string
        let numStr = number.toString();

        // Handle numbers less than 1000 (no formatting needed)
        if (numStr.length <= 3) {
            return numStr;
        }

        // Extract the last three digits
        let lastThree = numStr.slice(-3);
        // Extract the rest of the number
        let rest = numStr.slice(0, -3);

        // Add commas to the rest of the digits in groups of two
        rest = rest.replace(/\B(?=(\d{2})+(?!\d))/g, ',');

        // Combine the formatted parts
        return rest + ',' + lastThree;
    }


    const stateNames = <?php echo collect($province)->pluck('ename'); ?>;


    const StatesInfo = [
        <?php foreach($province as $pro): ?> {
            StateName: "{{ $pro['ename'] }}",
            // capital: "Biratnagar",
            // chiefMinister: "Rajendra Kumar Rai",
            // Area: "25,905 km2",
            // district: "14",
            // MetropolitianCities: "  -  ",
            // subMetropolitianCities: "  -  ",
            // Municipality: "  -  ",
            // lg: "  -  ",
            provinceId: "{{ $pro['id'] }}",
            total: "{{ $pro['total'] ?? 0 }}",
            running: "{{ $pro['running'] ?? 0 }}",
            completed: "{{ $pro['completed'] ?? 0 }}",
            halt: "{{ $pro['stopped'] ?? 0 }}",
            FT: "{{ $pro['FT'] ?? 0 }}",
            FP: "{{ $pro['FP'] ?? 0 }}",
            PT: "{{ $pro['PT'] ?? 0 }}",
            PP: "{{ $pro['PP'] ?? 0 }}",
            FT_P: "{{ $pro['FT_P'] ?? 0 }}",
            FP_P: "{{ $pro['FP_P'] ?? 0 }}",
            PT_P: "{{ $pro['PT_P'] ?? 0 }}",
            PP_P: "{{ $pro['PP_P'] ?? 0 }}",
        },
        <?php endforeach; ?>

    ]

    document.getElementById("total_budget").innerHTML = document.getElementById(
        "dashboard_budget_overview_approved_budget_overall").innerHTML
    document.getElementById("financial_target").innerHTML = document.getElementById(
        "dashboard_budget_overview_financial_target_field").innerHTML
    document.getElementById("financial_progress").innerHTML = document.getElementById(
        "dashboard_budget_overview_financial_progress_field").innerHTML
    document.getElementById("physical_target").innerHTML = document.getElementById(
        "dashboard_budget_overview_physical_target_field").innerHTML
    document.getElementById("physical_progress").innerHTML = document.getElementById(
        "dashboard_budget_overview_physical_progress_field").innerHTML



    function getProvinceInfo(id) {


        if (id === 1) {
            document.getElementById("provinceName").innerHTML = StatesInfo[0].StateName;
            document.getElementById("financial_target").innerHTML = formatNepaliAmount(StatesInfo[0].FT)
            document.getElementById("financial_progress").innerHTML = formatNepaliAmount(StatesInfo[0].FP)
            document.getElementById("physical_target").innerHTML = StatesInfo[0].PT_P
            document.getElementById("physical_progress").innerHTML = StatesInfo[0].PP_P

            // document.getElementById("provinceName").innerHTML = StatesInfo[0].StateName;
            // document.getElementById("total").innerHTML = StatesInfo[0].total
            // document.getElementById("running").innerHTML = StatesInfo[0].running
            // document.getElementById("completed").innerHTML = StatesInfo[0].completed
            // document.getElementById("halt").innerHTML = StatesInfo[0].halt
        } else if (id === 2) {
            document.getElementById("provinceName").innerHTML = StatesInfo[1].StateName;
            document.getElementById("financial_target").innerHTML = formatNepaliAmount(StatesInfo[1].FT)
            document.getElementById("financial_progress").innerHTML = formatNepaliAmount(StatesInfo[1].FP)
            document.getElementById("physical_target").innerHTML = StatesInfo[1].PT_P
            document.getElementById("physical_progress").innerHTML = StatesInfo[1].PP_P


            // document.getElementById("total").innerHTML = StatesInfo[1].total
            // document.getElementById("running").innerHTML = StatesInfo[1].running
            // document.getElementById("completed").innerHTML = StatesInfo[1].completed
            // document.getElementById("halt").innerHTML = StatesInfo[1].halt
        } else if (id === 3) {
            document.getElementById("provinceName").innerHTML = StatesInfo[2].StateName;
            document.getElementById("financial_target").innerHTML = formatNepaliAmount(StatesInfo[2].FT)
            document.getElementById("financial_progress").innerHTML = formatNepaliAmount(StatesInfo[2].FP)
            document.getElementById("physical_target").innerHTML = StatesInfo[2].PT_P
            document.getElementById("physical_progress").innerHTML = StatesInfo[2].PP_P

            // document.getElementById("total").innerHTML = StatesInfo[2].total
            // document.getElementById("running").innerHTML = StatesInfo[2].running
            // document.getElementById("completed").innerHTML = StatesInfo[2].completed
            // document.getElementById("halt").innerHTML = StatesInfo[2].halt
        } else if (id === 4) {
            document.getElementById("provinceName").innerHTML = StatesInfo[3].StateName;
            document.getElementById("financial_target").innerHTML = formatNepaliAmount(StatesInfo[3].FT)
            document.getElementById("financial_progress").innerHTML = formatNepaliAmount(StatesInfo[3].FP)
            document.getElementById("physical_target").innerHTML = StatesInfo[3].PT_P
            document.getElementById("physical_progress").innerHTML = StatesInfo[3].PP_P

            // document.getElementById("total").innerHTML = StatesInfo[3].total
            // document.getElementById("running").innerHTML = StatesInfo[3].running
            // document.getElementById("completed").innerHTML = StatesInfo[3].completed
            // document.getElementById("halt").innerHTML = StatesInfo[3].halt
        } else if (id === 5) {
            document.getElementById("provinceName").innerHTML = StatesInfo[4].StateName;
            document.getElementById("financial_target").innerHTML = formatNepaliAmount(StatesInfo[4].FT)
            document.getElementById("financial_progress").innerHTML = formatNepaliAmount(StatesInfo[4].FP)
            document.getElementById("physical_target").innerHTML = StatesInfo[4].PT_P
            document.getElementById("physical_progress").innerHTML = StatesInfo[4].PP_P

            // document.getElementById("total").innerHTML = StatesInfo[4].total
            // document.getElementById("running").innerHTML = StatesInfo[4].running
            // document.getElementById("completed").innerHTML = StatesInfo[4].completed
            // document.getElementById("halt").innerHTML = StatesInfo[4].halt
        } else if (id === 6) {
            document.getElementById("provinceName").innerHTML = StatesInfo[5].StateName;
            document.getElementById("financial_target").innerHTML = formatNepaliAmount(StatesInfo[5].FT)
            document.getElementById("financial_progress").innerHTML = formatNepaliAmount(StatesInfo[5].FP)
            document.getElementById("physical_target").innerHTML = StatesInfo[5].PT_P
            document.getElementById("physical_progress").innerHTML = StatesInfo[5].PP_P

            // document.getElementById("total").innerHTML = StatesInfo[5].total
            // document.getElementById("running").innerHTML = StatesInfo[5].running
            // document.getElementById("completed").innerHTML = StatesInfo[5].completed
            // document.getElementById("halt").innerHTML = StatesInfo[5].halt
        } else {
            document.getElementById("provinceName").innerHTML = StatesInfo[6].StateName;
            document.getElementById("financial_target").innerHTML = formatNepaliAmount(StatesInfo[6].FT)
            document.getElementById("financial_progress").innerHTML = formatNepaliAmount(StatesInfo[6].FP)
            document.getElementById("physical_target").innerHTML = StatesInfo[6].PT_P
            document.getElementById("physical_progress").innerHTML = StatesInfo[6].PP_P

            // document.getElementById("total").innerHTML = StatesInfo[6].total
            // document.getElementById("running").innerHTML = StatesInfo[6].running
            // document.getElementById("completed").innerHTML = StatesInfo[6].completed
            // document.getElementById("halt").innerHTML = StatesInfo[6].halt
        }
    }


    var map = null;

    function fullmap() {

        //        window.addEventListener('resize', function(event) {
        //     const width = window.innerWidth
        //     console.log(10 + (width - 5000) / 1000);
        //     map.setZoom(10 + (width - 5000) / 1000);
        // });
        // const infoBox = document.getElementById('info');
        // let zoomValue = window.innerWidth;
        // console.log(10 + (zoomValue) / 1000);


        map = L.map("map", {
            center: [28.4476377, 84.5810357],
            zoom: (7),
            preferCanvas: true
        });
        // Map Configurations ---------->
        map.attributionControl.setPrefix('EXPLORE THROUGH PROJECTS ALL OVER NEPAL')
        map.touchZoom.disable();
        map.doubleClickZoom.disable();
        map.scrollWheelZoom.disable();
        map.boxZoom.disable();
        map.keyboard.disable();
        map.dragging.disable();

        // load GEOJSON object/array to map
        L.geoJSON(geojsonFeature, {
            onEachFeature: function(feature, layer) {
                // console.log(layer['feature']['properties']['PR_NAME']);
                // layer.bindTooltip(layer['feature']['properties']['PR_NAME'],{permanent:true, direction:'center'}).openTooltip();
                // layer.addTo(map).bindTooltip(layer,{permanent:true, direction:'bottom'}).openTooltip();
                const ProvinceName = StatesInfo[feature?.properties?.PROVINCE - 1].StateName
                const financial_target = StatesInfo[feature?.properties?.PROVINCE - 1].FT
                const financial_progress = StatesInfo[feature?.properties?.PROVINCE - 1].FP
                const physical_target = StatesInfo[feature?.properties?.PROVINCE - 1].PT_P
                const physical_progress = StatesInfo[feature?.properties?.PROVINCE - 1].PP_P
                layer.bindTooltip(ProvinceName, {
                    permanent: true,
                    direction: 'center',
                    className: 'leaflet__tooltip-own'
                }).openTooltip();


                var htm_dsn =
                    '<div> <div>' +
                    ProvinceName +
                    '</div> <div>Financial Target</div> <div>' +
                    financial_target +
                    '</div> <div>Financial Progress</div><div>' +
                    financial_progress +
                    '</div>  <div>Physical Target</div><div> ' +
                    physical_target +
                    '%</div> <div>Physical Progress</div> <div> ' +
                    physical_progress +
                    '% </div></div > '

                layer.on('mouseover', function() {
                    this.bindPopup(htm_dsn).openPopup();
                });
                layer.on('mouseout', function() {
                    this.closePopup();
                });

                layer.setStyle({
                    weight: 2,
                    opacity: 1,
                    color: '#FFF',
                    dashArray: '1',
                    fillOpacity: 1,
                    fillColor: getProvinceColor(StatesInfo[feature?.properties?.PROVINCE - 1]
                        .provinceId),
                })


                function getProvinceColor(province) {
                    switch (parseInt(province)) {
                        case 1:
                            return "red";
                            break;
                        case 2:
                            return "green";
                            break;
                        case 3:
                            return "blue";
                            break;
                        case 4:
                            return "lightblue";
                            break;
                        case 5:
                            return "lightgreen";
                            break;
                        case 6:
                            return "yellow";
                            break;
                        case 7:
                            return "orange";
                            break;
                        default:
                            return "#2969a2";
                            break;
                    }
                }

                function OnFeatureClick(e) {
                    // console.log("hovered");
                    // geojsonFeature.resetStyle(e.target.layer);
                    const ClickedOn = e?.target?.feature?.properties?.PROVINCE
                    document.getElementById("provinceName").innerHTML = ProvinceName


                    ClickedOn && getProvinceInfo(ClickedOn)
                }

                //Can be used to show addExtraLayerWithDetailOnMap
                function mapClick() {
                    console.log("clicked");
                    const ClickedOn = feature?.properties?.PROVINCE //gives state id
                    console.log(ClickedOn);
                    info.update(StatesInfo[ClickedOn - 1]);
                }

                /**
                 * Navigate to List of Projects for Province
                 * when province is clicked on map
                 */
                function showListOfProjectsPageOnMapProvinceClick() {
                    const province_no = feature?.properties?.PROVINCE //gives province clicked id
                    //https://stackoverflow.com/questions/27634285/laravel-4-pass-a-variable-to-route-in-javascript
                    var url = '{{ route('project.province.show', ':id') }}';
                    url = url.replace(':id', province_no);
                    window.location.href = url;
                }

                layer.on({
                    mousemove: OnFeatureClick,
                    click: showListOfProjectsPageOnMapProvinceClick
                })
            },
        }).addTo(map);
        return map;
    }

    //show fullmap first
    var fullmap = fullmap();

    // $("#map").empty();
    // fullmap.remove();

    function provincemap(province_code) {

        var provinceMap, provinceGeoJson, stateGeoJson;
        /**
         **  Initialize map
         **/
        map = L.map('map', {
            scrollWheelZoom: false,
            touchZoom: false,
            doubleClickZoom: false,
            zoomControl: true,
            dragging: true,
            attributionControl: false
        }).setView([28.3949, 84.1240], 8);

        var province_json = province_1;
        switch (parseInt(province_code)) {
            case 1:
                province_json = province_1;
                break;
            case 2:
                province_json = province_2;
                break;
            case 3:
                province_json = province_3;
                break;
            case 4:
                province_json = province_4;
                break;
            case 5:
                province_json = province_5;
                break;
            case 6:
                province_json = province_6;
                break;
            case 7:
                province_json = province_7;
                break;
            default:
                province_json = province_1;
                break;
        }


        provinceGeoJsonMain = L.geoJson(province_json, {
            style: {
                weight: 2,
                opacity: 1,
                color: '#FFF',
                dashArray: '1',
                fillOpacity: 1,
                fillColor: "#2969a2",
            },
            onEachFeature: function(feature, layer) {

                layer.bindTooltip(layer.feature.properties.DISTRICT, {
                    permanent: true,
                    direction: 'center',
                    className: 'leaflet__tooltip-own'
                }).openTooltip();

                layer.on({
                    mouseover: function(e) {
                        var layer = e.target;
                        //layer hover color
                        layer.setStyle({
                            weight: 2,
                            color: '#efefef',
                            dashArray: '',
                            fillOpacity: 0.5,
                            fillColor: '#1d588d'
                        });

                        layer.bindTooltip(ProvinceName, {
                            permanent: true,
                            direction: 'bottom'
                        }).openTooltip();

                        layer.bindTooltip(layer.feature.properties.TARGET, {
                            permanent: false,
                            direction: "center",

                        }).openTooltip()


                        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                            layer.bringToFront();
                        }
                    },
                    mouseout: function(e) {
                        provinceGeoJsonMain.resetStyle(e.target);
                    },
                });
            }
        }).addTo(map);
        // var name = 'Provience'+ province_code;
        // provinceGeoJsonMain.addTo(map).bindTooltip(name,{permanent:true, direction:'center',  className: 'leaflet__tooltip-own' }).openTooltip();
        var bound = provinceGeoJsonMain.getBounds();
        map.fitBounds(bound);
        return map;
    }



    // var provincemap = provincemap();

    // $("#map").empty();
    // provincemap.remove();

    function districtmap(province_json, district_name) {
        var provinceMap, provinceGeoJson, stateGeoJson;
        /**
         **  Initialize map
         **/
        map = L.map('map', {
            scrollWheelZoom: false,
            touchZoom: false,
            doubleClickZoom: false,
            zoomControl: true,
            dragging: true,
            attributionControl: false
        }).setView([28.3949, 84.1240], 8);

        // MAIN LOGIC
        var district_json = null;
        province_json.features.map((feature) => {
            if (feature.properties.TARGET == district_name) {
                console.log(feature);
                district_json = feature;
            }
        })
        //END MAIN LOGIC
        districtGeoJson = L.geoJson(district_json, {
            style: {
                weight: 2,
                opacity: 1,
                color: '#FFF',
                dashArray: '1',
                fillOpacity: 1,
                fillColor: "#2969a2",
            },
            onEachFeature: function(feature, layer) {
                layer.on({
                    mouseover: function(e) {
                        var layer = e.target;

                        //layer hover color
                        layer.setStyle({
                            weight: 2,
                            color: '#efefef',
                            dashArray: '',
                            fillOpacity: 0.5,
                            fillColor: '#1d588d'
                        });

                        //show district name on hover
                        layer.bindTooltip(layer.feature.properties.TARGET, {
                            permanent: false,
                            direction: "center",

                        }).openTooltip()


                        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                            layer.bringToFront();
                        }
                    },
                    mouseout: function(e) {
                        districtGeoJson.resetStyle(e.target);
                    },
                });
            }
        }).addTo(map);

        var bound = districtGeoJson.getBounds();
        map.fitBounds(bound);

        return map;
    }


    // var districtmap = districtmap();
    //    $("#map").empty();
    // districtmap.remove();



    function addExtraLayerWithDetailOnMap() {
        var info = L.control();

        info.onAdd = function(map) {
            this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
            this.update();
            return this._div;
        };

        // method that we will use to update the control based on feature properties passed
        info.update = function(props) {
            console.log(props);
            this._div.innerHTML = (props ?
                ' <div> <h4 class="title">' + props.StateName +
                '</h4> <table> <tr> <td> total </td> <td>' + props.total +
                ' </td> </tr> <tr> <td> running </td> <td>' + props.running +
                ' </td> </tr> <tr> <td> completed </td> <td>' + props.completed +
                ' </td> </tr> <tr> <td> halt </td> <td> ' + props.halt +
                '</td> </tr> </table> </div>' :
                'Hover over a state');
        };

        info.addTo(map);
    }
</script>
{{-- !ENDS map script --}}


<script>
    $("#dashboard_filter_district_select--col").css('display', "none")


    $("#dashboard_filter_province_select").on("change", function() {
        var province_code = $("#dashboard_filter_province_select").val();
        console.log(province_code, 'sadasd');



        // show province map
        $("#map").empty();
        if (map != null)
            map.remove();
        provincemap(province_code);

        $("#dashboard_filter_district_select--col").css('display', "flex")
        $("#dashboard_filter_district_select--col .select2-container--default").css("width", "200px");

        //   $("#dashboard_filter_district_select--col").removeClass('d-none')
        // $("#dashboard_filter_district_select--col").show();
        // $(".select2-container--default").css("width","200px");


    });

    $("#dashboard_filter_district_select").on("change", function() {


        var district_name = $(this).val();
        var province_code = $("#dashboard_filter_province_select").val();

        if (province_code == null) return

        var province_json = province_1;
        switch (parseInt(province_code)) {
            case 1:
                province_json = province_1;
                break;
            case 2:
                province_json = province_2;
                break;
            case 3:
                province_json = province_3;
                break;
            case 4:
                province_json = province_4;
                break;
            case 5:
                province_json = province_5;
                break;
            case 6:
                province_json = province_6;
                break;
            case 7:
                province_json = province_7;
                break;
            default:
                province_json = province_1;
                break;
        }

        // show province map
        $("#map").empty();
        if (map != null)
            map.remove();
        // districtmap("BHOJPUR");
        districtmap(province_json, district_name.toUpperCase());



    });
</script>


{{-- TODO: switch to components and remove redundancy vars --}}
<script>
    function filterSetup() {
        let labels = <?php echo collect($province)->pluck('ename'); ?>;
        // console.log(labels);


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

{{-- Chart script --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

<script>
    let labels = <?php echo collect($province)->pluck('ename'); ?>;
    let datas = <?php echo collect($province)->pluck('total'); ?>;

    let progressInPercentChartData = @json($progressInPercentChartData);

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
            title: {
                display: true,
                text: 'Total No of Project Province Wise'
            },
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
            labels: ["< 40%", "> 80%", "40 - 80"],
            datasets: [{
                data: progressInPercentChartData,
                backgroundColor: ["red", "green", "yellow"],
            }]
        }
        var donutOptions = {
            maintainAspectRatio: false,
            responsive: true,
            title: {
                display: true,
                text: 'Project Status Zone ( Pme Review )'
            },
        }

        new Chart(piechartcanvas, {
            type: 'pie',
            data: donutData,
            options: donutOptions

        })


        //-------------
        //- BAR CHART -
        //-------------

        // var barChartCanvas = $('#barChart').get(0).getContext('2d')
        // var barData = {
        //     labels: labels,
        //     datasets: [{
        //         label: 'Total',
        //         data: datas,
        //         backgroundColor: ['#f56954', '#f56954', '#f56954', '#f56954', '#f56954', '#f56954',
        //             '#f56954'
        //         ],
        //     }, {
        //         label: 'Running',
        //         data: running_projects_data,
        //         backgroundColor: ['#00a65a', '#00a65a', '#00a65a', '#00a65a', '#00a65a', '#00a65a',
        //             '#00a65a'
        //         ],
        //     }, {
        //         label: 'Completed',
        //         data: completed_projects_data,
        //         backgroundColor: ['#f39c12', '#f39c12', '#f39c12', '#f39c12', '#f39c12', '#f39c12',
        //             '#f39c12'
        //         ],
        //     }, {
        //         label: 'Stopped',
        //         data: stopped_projects_data,
        //         backgroundColor: ['#00c0ef', '#00c0ef', '#00c0ef', '#00c0ef', '#00c0ef', '#00c0ef',
        //             '#00c0ef'
        //         ],
        //     }]
        // }
        // var barOptions = {
        //     maintainAspectRatio: false,
        //     responsive: true,
        //     onClick: handelClick
        // }
        // var barchart = new Chart(barChartCanvas, {
        //     type: 'bar',
        //     data: barData,
        //     options: barOptions,
        // })

        // function handelClick(evt) {
        //     var status = [
        //         "all",
        //         "running",
        //         "completed",
        //         "stopped"
        //     ]
        //     var activeElement = barchart.getElementAtEvent(evt);
        //     var province_code = activeElement[0]._index + 1;
        //     var data_set_index = activeElement[0]._datasetIndex;;
        //     var url = "/projects/province/" + province_code + "?status=" + status[data_set_index];
        //     console.log(url);
        //     window.location.href = url;

        // }

    })
</script>

{{-- !ENDS Chart script --}}
