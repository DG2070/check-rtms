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

        provinceGeoJsonMain = L.geoJson(province_1, {
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
        }).addTo(mainmap);

        var bound = provinceGeoJsonMain.getBounds();
        mainmap.fitBounds(bound);
    </script>
@endpush
