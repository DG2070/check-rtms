@extends('auth.layouts.app')
@section('content')
    <section class="main-wrapper">
        <div class="page-wrapper full-page"
            style="background: url({{ asset('images/auth-login-bg.jpg') }});background-repeat: no-repeat;background-size: cover;background-position:center">
            <div class="page-content d-flex align-items-center justify-content-center">
                <div class="row w-100 mx-0 auth-page">
                    <div class="col-md-8 col-xl-6 mx-auto">
                        <div class="card">
                            <div class="row">
                                <div class="col-md-4 pe-md-0">
                                    <div class="auth-side-wrapper" {{-- style="background-image: none;" --}}
                                        style="background-image: url({{ asset('/images/textile-1.webp') }});">
                                        <p class="text-muted">
                                            {{-- <div class="mt-5 ml-3">
                                            <a href="/">
                                                <img src="{{ asset('/images/logo/logo-orginal.svg') }}" alt="logo"
                                                    width="200px">
                                            </a>
                                        </div> --}}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-8 ps-md-0">
                                    <div class="auth-form-wrapper px-4 py-4">
                                        {{-- <div class="auth-form-wrapper px-4 py-5"> --}}
                                        <a href="/">
                                            <img src="{{ asset('/images/logo/logo-orginal.svg') }}" alt="logo"
                                                width="200px">
                                        </a>
                                        {{-- <a href="/" class="  d-block mb-2"
                                            style="font-weight: 700;font-size: 25px;color: #000865;"> Login </a> --}}
                                        <h5 class="text-muted fw-normal mb-3 mt-3" style="color: #000865 !important;font-weight: 700 !important;font-size: 22px;">Real Time Monitoring System (RTMS)</h5>
                                        @if (session()->has('error-message'))
                                            <div class="alert alert-warning">
                                                {{ session()->get('error-message') }}
                                            </div>
                                        @endif
                                        <form action="{{ route('login') }}" method="post">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="userEmail" class="form-label">Email address</label>
                                                <input name="email" type="email" class="form-control" id="userEmail"
                                                    placeholder="Email" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="userPassword" class="form-label">Password</label>
                                                <input name="password" type="password" class="form-control"
                                                    id="userPassword" autocomplete="current-password" placeholder="Password"
                                                    required>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input type="checkbox" name="remember" class="form-check-input"
                                                    id="authCheck">
                                                <label class="form-check-label" for="authCheck">
                                                    Remember me
                                                </label>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <button type="submit"
                                                    class="btn btn-primary me-2 mb-2 mb-md-0 text-white">Login</button>
                                                @if (Route::has('password.request'))
                                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                                        {{ __('Forgot Your Password?') }}
                                                    </a>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
