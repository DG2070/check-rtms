@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-9 card card-body" style="min-height: 500px;">
            <div id="map" class="map"></div>
        </div>
    </div>


@endsection

@push('script')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>


    {{-- province data --}}
    <script type="text/javascript" src="/js/nepal-province.js"></script>
    <script type="text/javascript" src="/js/province1-district.js"></script>
    <script type="text/javascript" src="/js/province2-district.js"></script>
    <script type="text/javascript" src="/js/province3-district.js"></script>
    <script type="text/javascript" src="/js/province4-district.js"></script>
    <script type="text/javascript" src="/js/province5-district.js"></script>
    <script type="text/javascript" src="/js/province6-district.js"></script>
    <script type="text/javascript" src="/js/province7-district.js"></script>


    <script type="text/javascript">
        var provinceMap, provinceGeoJson, stateGeoJson;
        /**
         **  Initialize map
         **/
        provinceMap = L.map('map', {
            scrollWheelZoom: false,
            touchZoom: false,
            doubleClickZoom: false,
            zoomControl: true,
            dragging: true
        }).setView([28.3949, 84.1240], 8);


        /**
         **  GeoJSON data
         **/
        provinceGeoJson = L.geoJson(provinceData, {
            style: style,
            onEachFeature: onEachFeature
        }).addTo(provinceMap);

        var bound = provinceGeoJson.getBounds();
        provinceMap.fitBounds(bound);

        /**
         *  Functions for map
         **/
        function style(feature) {
            return {
                weight: 2,
                opacity: 1,
                color: '#FFF',
                dashArray: '1',
                fillOpacity: 0.7,
                fillColor: getProvinceColor(feature.properties.Province),
            };
        }

        function highlightFeature(e) {
            var layer = e.target;

            layer.setStyle({
                weight: 2,
                color: 'black',
                dashArray: '',
                fillOpacity: 0.7,
                fillColor: '#efefef'
            });

            if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                layer.bringToFront();
            }
        }

        function getProvinceColor(province) {
            return "grey";
            switch (province) {
                case 1:
                    return 'red';
                    break;
                case 2:
                    return 'green';
                    break;
                case 3:
                    return 'blue';
                    break;
                case 4:
                    return 'lightblue';
                    break;
                case 5:
                    return 'lightgreen';
                    break;
                case 6:
                    return 'yellow';
                    break;
                case 7:
                    return 'orange';
                    break;
                default:
                    return 'skyblue';
                    break;
            }
        }

        function resetHighlight(e) {
            provinceGeoJson.resetStyle(e.target);
            // info.update();
        }

        function zoomToProvince(e,province_code = 0) {
            var json,
                province_number = e.target.feature.properties.Province;

                console.log("province_number");
                console.log(province_number);
                console.log("province_code");
                console.log(province_code);

            provinceMap.fitBounds(e.target.getBounds());
            console.log(stateGeoJson);

            if (stateGeoJson != undefined) {
                stateGeoJson.clearLayers();
            }

            switch (province_number) {
                case 1:
                    json = province_1;
                    break;
                case 2:
                    json = province_2;
                    break;
                case 3:
                    json = province_3;
                    break;
                case 4:
                    json = province_4;
                    break;
                case 5:
                    json = province_5;
                    break;
                case 6:
                    json = province_6;
                    break;
                case 7:
                    json = province_7;
                    break;
                default:
                    json = '';
                    break;
            }
            // provinceMap.removeLayer(stateGeoJson);

            stateGeoJson = L.geoJson(json, {
                style: style,
                onEachFeature: onEachFeature
            }).addTo(provinceMap);

            // provinceMap.removeLayer(stateGeoJson);

            stateGeoJson.eachLayer(function(layer) {
                layer.bindTooltip(layer.feature.properties.DISTRICT, {
                    permanent: true,
                    direction: "center"
                }).openTooltip()
            });
        }

        function onEachFeature(feature, layer) {
            layer.on({
                mouseover: highlightFeature,
                mouseout: resetHighlight,
                click: zoomToProvince
            });
        }

        // zoomToProvince();
        /**
         **  Markers example
         **/
        // var marker = L.marker([27.7172, 85.3240]).addTo(map);
        // marker.bindPopup("This marker is pointing Kathmandu city.");
    </script>
@endpush
