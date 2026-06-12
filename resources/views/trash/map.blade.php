@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6 card card-body" style="min-height: 500px;">
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
        mainmap = L.map('map', {
            scrollWheelZoom: false,
            touchZoom: false,
            doubleClickZoom: false,
            zoomControl: true,
            dragging: true,
            attributionControl: false
        }).setView([28.3949, 84.1240], 8);

        stateGeoJson = L.geoJson(province_1, {
            style: style,
            onEachFeature: onEachFeature
        }).addTo(mainmap);

        var bound = stateGeoJson.getBounds();
        mainmap.fitBounds(bound);


        // stateGeoJson.eachLayer(function(layer) {
        //     layer.bindTooltip(layer.feature.properties.TARGET, {
        //         permanent: true,
        //         direction: "center"
        //     }).openTooltip()
        // });


        /**
         **  GeoJSON data
         **/
        // provinceGeoJson = L.geoJson(provinceData, {
        //     style: style,
        //     onEachFeature: onEachFeature
        // }).addTo(provinceMap);

        // var bound = provinceGeoJson.getBounds();
        // provinceMap.fitBounds(bound);

        /**
         *  Functions for map
         **/
        function style(feature) {
            return {
                weight: 2,
                opacity: 1,
                color: '#FFF',
                dashArray: '1',
                fillOpacity: 1,
                fillColor: getProvinceColor(feature.properties.Province),
            };
        }

        //hovered
        function highlightFeature(e) {
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
            // layer.bindTooltip(layer.feature.properties.TARGET, {
            //     permanent: false,
            //     direction: "center",

            // }).openTooltip()
            layer.bindTooltip(layer.feature.properties.TARGET, {
                permanent: false,
                direction: "center",

            }).openTooltip()


            if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                layer.bringToFront();
            }
        }

        function getProvinceColor(province) {
            return "#2969a2";
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
            stateGeoJson.resetStyle(e.target);
        }

        function zoomToProvince(e, province_code = 0) {


            console.log("json");
            console.log(json);
            stateGeoJson = L.geoJson(province_1, {
                style: style,
                onEachFeature: onEachFeature
            }).addTo(mainmap);

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
