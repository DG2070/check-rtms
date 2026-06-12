{{-- <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-free/css/all.min.css') }}"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
    integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
    crossorigin="" />

@stack('styles')
<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
@toastr_css
<link href="{{ asset('assets/css/nepali.datepicker.v3.7.min.css') }}" rel="stylesheet" type="text/css" />

<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    .fieldset-custom-height {
        min-height: 600px;
    }
</style>
<script src="{{ asset('assets/js/jquery/jquery.min.js') }}"></script>


<link href="{{ asset('/dashboard/css/app.css') }}" rel="stylesheet">

