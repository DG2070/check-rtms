<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TDF | @yield('title')</title>

    {{-- fav --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">


    @include('layouts.includes.headlinks')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    @stack('css')
    @yield('style')

</head>

<body class="hold-transition sidebar-mini sidebar-collapse">

    <!-- GLOBAL-LOADER -->
    <div id="global-loader" class="global-loader d-none">
        <div class="global-loader--content">
            <img src="{{ asset('images/logo/tdf_small.svg') }}" class="loader-img" alt="Loader">
            <div class="mt-2">
                Loading....
            </div>
        </div>
    </div>
    <!-- /GLOBAL-LOADER -->
    @yield('modal')
    @stack('modal')

    <div class="wrapper">

        @include('layouts.includes.navbar')

        @include('layouts.includes.sidebar')

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            @if (request()->is('home'))
                                <div class="">
                                @else
                                    <div class="px-1 px-md-3 pt-4">
                            @endif

                            @yield('content')

                        </div>
                    </div>
                </div>
        </div>
        </section>
    </div>

    @include('layouts.includes.footer')

    <aside class="control-sidebar control-sidebar-dark"></aside>

    </div>
    @include('layouts.includes.script')

    @include('common.messages')

    <script type="text/javascript">
        $(function() {
            $("[rel='tooltip']").tooltip();
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
    <script src="{{ asset('/dashboard/js/app.js') }}"></script>
    @stack('script')
    @yield('script')


</body>

</html>
