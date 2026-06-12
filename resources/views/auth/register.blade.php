@extends('auth.layouts.app')

@section('content')

    <p class="text-center">
        Contact TDF Admin to Register New user
    </p>
    {{-- <h3 class="header mb-4">{{ __('Register') }}</h3>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="col-form-label">{{ __('Name') }}</label>

            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ old('name') }}" required autocomplete="name" autofocus>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="col-form-label">{{ __('Email Address') }}</label>

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="col-form-label">{{ __('Password') }}</label>

            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="new-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>

            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                autocomplete="new-password">
        </div>

        <div class="row mb-0 mt-5">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary custom-btn">
                    {{ __('Register') }}
                </button>

                @if (Route::has('login'))
                    <a class="btn btn-link" href="{{ route('login') }}">
                        {{ __('Already a member?') }}
                    </a>
                @endif
            </div>
        </div>
    </form> --}}
@endsection
