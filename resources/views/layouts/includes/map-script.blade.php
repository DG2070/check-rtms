<script type="text/javascript">
    window.addEventListener('resize', function(event) {
        const width = window.innerWidth
        console.log(10 + (width - 5000) / 1000);
        map.setZoom(10 + (width - 5000) / 1000);
    });
    const infoBox = document.getElementById('info');
    let zoomValue = window.innerWidth;
    console.log(10 + (zoomValue - 5000) / 1000);
    // initialize the map
    var map = L.map("map", {
        center: [28.4476377, 84.5810357],
        zoom: (10 + (zoomValue - 5000) / 1000),
        preferCanvas: true
    });

    // Map Configurations ---------->
    map.attributionControl.setPrefix('Town Development Fund Projects Monitoring')
    map.touchZoom.disable();
    map.doubleClickZoom.disable();
    map.scrollWheelZoom.disable();
    map.boxZoom.disable();
    map.keyboard.disable();
    map.dragging.disable();

    // load GEOJSON object/array to map
    L.geoJSON(geojsonFeature, {
        onEachFeature: function(feature, layer) {
            const stateNames = <?php echo collect($province)->pluck('nname'); ?>;

            const labels = [
                "राजधानी:",
                "सम्माननीय मुख्यमन्त्री",
                "कुल क्षेत्रफल",
                "जिल्ला",
                "महानगरपािलका:",
                "उपमहानगरपािलका:",
                "नगरपािलका:",
                "गाउँपािलका:"
            ]
            const StatesInfo = [
                <?php foreach($province as $pro): ?> {
                    StateName: "{{ $pro['nname'] }}",
                    capital: "Biratnagar",
                    chiefMinister: "Rajendra Kumar Rai",
                    Area: "25,905 km2",
                    district: "14",
                    MetropolitianCities: "  -  ",
                    subMetropolitianCities: "  -  ",
                    Municipality: "  -  ",
                    lg: "  -  ",
                    provinceId: "{{ $pro['id'] }}",
                    total: "{{ $pro['total'] ?? 0 }}",
                    running: "{{ $pro['running'] ?? 0 }}",
                    completed: "{{ $pro['completed'] ?? 0 }}",
                    halt: "{{ $pro['stopped'] ?? 0 }}"
                },
                <?php endforeach; ?>

            ]
            const ProvinceName = feature?.properties?.PR_NAME
            if (feature.properties) layer.bindTooltip(ProvinceName, {
                direction: "top"
            }) // bind tooltip to each feature
            const ProvinceColors = ["#0F52BA"]
            // const ProvinceColors = ["#215D93"]
            const formula = Math.floor(Math.random() * ProvinceColors
                .length) // get a random index from the array
            layer.setStyle({
                fillColor: ProvinceColors[formula],
                fillOpacity: 1,
                weight: 2,
                opacity: 1,
                color: 'white',
                dashArray: '1',
                fillOpacity: 0.7
            })
            document.getElementById("provinceName").innerHTML = "प्रदेश"

            function OnFeatureClick(e) {
                // console.log("hovered");
                // geojsonFeature.resetStyle(e.target.layer);
                const ClickedOn = e?.target?.feature?.properties?.PROVINCE
                document.getElementById("provinceName").innerHTML = ProvinceName

                function getProvinceInfo(id) {

                    // layer.setStyle({fillColor : ProvinceColors[id]}) // to set one color for every layer
                    if (id === 1) {
                        // document.getElementById("provinceName").innerHTML = StatesInfo[0].StateName;
                        document.getElementById("total").innerHTML = StatesInfo[0].total
                        document.getElementById("running").innerHTML = StatesInfo[0].running
                        document.getElementById("completed").innerHTML = StatesInfo[0].completed
                        document.getElementById("halt").innerHTML = StatesInfo[0].halt
                        // document.getElementById("secondvalue").innerHTML = StatesInfo[0].chiefMinister
                        // document.getElementById("thirdvalue").innerHTML = StatesInfo[0].Area
                        // document.getElementById("fourthvalue").innerHTML = StatesInfo[0].district
                        // document.getElementById("fifthvalue").innerHTML = StatesInfo[0].MetropolitianCities
                        // document.getElementById("sixthvalue").innerHTML = StatesInfo[0].subMetropolitianCities
                        // document.getElementById("seventhvalue").innerHTML = StatesInfo[0].Municipality
                        // document.getElementById("eighthvalue").innerHTML = StatesInfo[0].lg
                    } else if (id === 2) {
                        // document.getElementById("provinceName").innerHTML = StatesInfo[1].StateName;
                        document.getElementById("total").innerHTML = StatesInfo[1].total
                        document.getElementById("running").innerHTML = StatesInfo[1].running
                        document.getElementById("completed").innerHTML = StatesInfo[1].completed
                        document.getElementById("halt").innerHTML = StatesInfo[1].halt
                        // document.getElementById("secondvalue").innerHTML = StatesInfo[1].chiefMinister
                        // document.getElementById("thirdvalue").innerHTML = StatesInfo[1].Area
                        // document.getElementById("fourthvalue").innerHTML = StatesInfo[1].district
                        // document.getElementById("fifthvalue").innerHTML = StatesInfo[1].MetropolitianCities
                        // document.getElementById("sixthvalue").innerHTML = StatesInfo[1].subMetropolitianCities
                        // document.getElementById("seventhvalue").innerHTML = StatesInfo[1].Municipality
                        // document.getElementById("eighthvalue").innerHTML = StatesInfo[1].lg
                    } else if (id === 3) {
                        // document.getElementById("provinceName").innerHTML = StatesInfo[2].StateName;
                        document.getElementById("total").innerHTML = StatesInfo[2].total
                        document.getElementById("running").innerHTML = StatesInfo[2].running
                        document.getElementById("completed").innerHTML = StatesInfo[2].completed
                        document.getElementById("halt").innerHTML = StatesInfo[2].halt
                        // document.getElementById("secondvalue").innerHTML = StatesInfo[2].chiefMinister
                        // document.getElementById("thirdvalue").innerHTML = StatesInfo[2].Area
                        // document.getElementById("fourthvalue").innerHTML = StatesInfo[2].district
                        // document.getElementById("fifthvalue").innerHTML = StatesInfo[2].MetropolitianCities
                        // document.getElementById("sixthvalue").innerHTML = StatesInfo[2].subMetropolitianCities
                        // document.getElementById("seventhvalue").innerHTML = StatesInfo[2].Municipality
                        // document.getElementById("eighthvalue").innerHTML = StatesInfo[2].lg
                    } else if (id === 4) {
                        // document.getElementById("provinceName").innerHTML = StatesInfo[3].StateName;
                        document.getElementById("total").innerHTML = StatesInfo[3].total
                        document.getElementById("running").innerHTML = StatesInfo[3].running
                        document.getElementById("completed").innerHTML = StatesInfo[3].completed
                        document.getElementById("halt").innerHTML = StatesInfo[3].halt
                        // document.getElementById("secondvalue").innerHTML = StatesInfo[3].chiefMinister
                        // document.getElementById("thirdvalue").innerHTML = StatesInfo[3].Area
                        // document.getElementById("fourthvalue").innerHTML = StatesInfo[3].district
                        // document.getElementById("fifthvalue").innerHTML = StatesInfo[3].MetropolitianCities
                        // document.getElementById("sixthvalue").innerHTML = StatesInfo[3].subMetropolitianCities
                        // document.getElementById("seventhvalue").innerHTML = StatesInfo[3].Municipality
                        // document.getElementById("eighthvalue").innerHTML = StatesInfo[3].lg
                    } else if (id === 5) {
                        // document.getElementById("provinceName").innerHTML = StatesInfo[4].StateName;
                        document.getElementById("total").innerHTML = StatesInfo[4].total
                        document.getElementById("running").innerHTML = StatesInfo[4].running
                        document.getElementById("completed").innerHTML = StatesInfo[4].completed
                        document.getElementById("halt").innerHTML = StatesInfo[4].halt
                        // document.getElementById("secondvalue").innerHTML = StatesInfo[4].chiefMinister
                        // document.getElementById("thirdvalue").innerHTML = StatesInfo[4].Area
                        // document.getElementById("fourthvalue").innerHTML = StatesInfo[4].district
                        // document.getElementById("fifthvalue").innerHTML = StatesInfo[4].MetropolitianCities
                        // document.getElementById("sixthvalue").innerHTML = StatesInfo[4].subMetropolitianCities
                        // document.getElementById("seventhvalue").innerHTML = StatesInfo[4].Municipality
                        // document.getElementById("eighthvalue").innerHTML = StatesInfo[4].lg
                    } else if (id === 6) {
                        // document.getElementById("provinceName").innerHTML = StatesInfo[5].StateName;
                        document.getElementById("total").innerHTML = StatesInfo[5].total
                        document.getElementById("running").innerHTML = StatesInfo[5].running
                        document.getElementById("completed").innerHTML = StatesInfo[5].completed
                        document.getElementById("halt").innerHTML = StatesInfo[5].halt
                        // document.getElementById("secondvalue").innerHTML = StatesInfo[5].chiefMinister
                        // document.getElementById("thirdvalue").innerHTML = StatesInfo[5].Area
                        // document.getElementById("fourthvalue").innerHTML = StatesInfo[5].district
                        // document.getElementById("fifthvalue").innerHTML = StatesInfo[5].MetropolitianCities
                        // document.getElementById("sixthvalue").innerHTML = StatesInfo[5].subMetropolitianCities
                        // document.getElementById("seventhvalue").innerHTML = StatesInfo[5].Municipality
                        // document.getElementById("eighthvalue").innerHTML = StatesInfo[5].lg
                    } else {
                        // document.getElementById("provinceName").innerHTML = StatesInfo[6].StateName;
                        document.getElementById("total").innerHTML = StatesInfo[6].total
                        document.getElementById("running").innerHTML = StatesInfo[6].running
                        document.getElementById("completed").innerHTML = StatesInfo[6].completed
                        document.getElementById("halt").innerHTML = StatesInfo[6].halt
                        // document.getElementById("secondvalue").innerHTML = StatesInfo[6].chiefMinister
                        // document.getElementById("thirdvalue").innerHTML = StatesInfo[6].Area
                        // document.getElementById("fourthvalue").innerHTML = StatesInfo[6].district
                        // document.getElementById("fifthvalue").innerHTML = StatesInfo[6].MetropolitianCities
                        // document.getElementById("sixthvalue").innerHTML = StatesInfo[6].subMetropolitianCities
                        // document.getElementById("seventhvalue").innerHTML = StatesInfo[6].Municipality
                        // document.getElementById("eighthvalue").innerHTML = StatesInfo[6].lg
                    }
                }
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
                // click: mapClick
                // click: OnFeatureClick
            })
        },
    }).addTo(map)




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
