<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Town Development Fund</title>
    {{-- fav --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    {{-- <link href="{{ asset('/css/app.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('/dashboard/css/login.css') }}" rel="stylesheet">

</head>

<body>

    <div id="app" class="main-login-section">
        <div class="navbar" style="padding: 8px 10px;">
            <div class="container-sm">
                <a href="/">
                    <img src="{{ asset('/images/logo/tdf.svg') }}" alt="logo" width="200px">
                </a>
            </div>
        </div>
        <div class="bg_img " style="background-image: url({{ asset('/images/login/everest.jpg') }});">
            <div class="overlay">
                <div class="container-sm main-content d-flex align-items-center justify-content-center">
                    <div class="row ">
                        <div class="col-sm-12 col-lg-7">
                            <div class="normal-content d-flex align-items-center justify-content-center h-100">

                                <div>
                                    <h4 class="header">
                                        Real Time Monitoring System (RTMS)
                                    </h4>
                                    <p class="text">
                                        Real-Time Monitoring System (RTMS) has been developed to provide annual progress of TDF projects.RTMS visualizes the realtime data of the financial and physical progress of a particular project.
                                        {{-- <ul class=" text-white">
                                        <li>
                                            List of different Town Operational Plans for different Economic Years
                                        </li>
                                        <li>
                                            Intuitive information about the current state of the nature of projects.
                                        </li>
                                        <li>
                                            A detailed description of a single project. The tender price, agreement has
                                            started, the work is completed, etc.
                                        </li>
                                        <li>
                                            Physical and financial progress of each project.
                                        </li>
                                    </ul> --}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-5">
                            <div class="login-form ">
                                <div class="card shadow-lg border-0  py-3 px-4">
                                    <div class="card-body">
                                        @yield('content')

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div id="app" class="h-100 d-flex align-items-center justify-content-center">
        <main class="w-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card shadow-lg border-0">
                            <div class="card-body p-5">
                                <div class="row justify-content-around align-items-center">
                                    <div
                                        class="col-md-4 flex flex-col justify-content-between align-content-center text-center">
                                        <img src="{{ asset('./images/logo/tdf_long.svg') }}" alt="TDF"
                                            class="img-fluid mb-4">
                                        <h4 class="text-center">Town Development Fund</h4>
                                        <p class="text-center">Real time project activity <br> monitoring system</p>
                                    </div>
                                    <div class="col-md-6">
                                        @yield('content')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div> --}}

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous">
    </script>


</body>

</html>
