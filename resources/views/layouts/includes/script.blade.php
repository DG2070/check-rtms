@toastr_js
@toastr_render
<script src="{{ asset('assets/js/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/adminlte.js') }}"></script>
<script src="{{ asset('assets/js/nepali.datepicker.v3.7.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('plugins/chart/Chart.min.js') }}"></script>
<script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
<script src="{{ asset('assets/js/geojson.js') }}"></script>
<!-- <script src="{{ asset('assets/js/mapScript.js') }}"></script> -->


<link rel="stylesheet" href="{{ asset('/plugins/expand-fullscreen-largetable/largetable.css') }}">
<script src="{{ asset('/plugins/expand-fullscreen-largetable/largetable.js') }}"></script>


<style>
    /* for table large btn  */
    .largetable-maximize-btn {
        top: 10px !important;
        bottom: 0 !important;

        display: block !important;
    }
</style>

<script>
    $(document).ready(function() {
        if ($(".fullscreen_table")[0]) {

            $(".fullscreen_table")
                .largetable({
                    enableMaximize: true,
                }).on("toggleMaximize", function() {
                    console.log("toggleMaximize event");
                    $(".largetable-maximize-btn").css("display", "block !important");
                })
                .on("maximize", function() {
                    console.log("maximize event");
                    $(".largetable-maximize-btn").css("display", "block !important");
                })
                .on("unmaximize", function() {
                    console.log("unmaximize event");
                    $(".largetable-maximize-btn").css("display", "block !important");
                });
        }
    });
</script>
