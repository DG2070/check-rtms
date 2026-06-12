@extends('auth.layouts.app')

@section('content')
    <h3 class="header mb-4">{{ __('Reset Password') }}</h3>

    <form method="POST" action="{{ route('password.email') }}">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @csrf

        <div class="mb-3">
            <label for="email" class="col-form-label">{{ __('Email Address') }}</label>

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="row mb-0 mt-4">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary custom-btn">
                    {{ __('Send Password Reset Link') }}
                </button>

                @if (Route::has('login'))
                    <a class="btn btn-link" href="{{ route('login') }}">
                        {{ __('Login?') }}
                    </a>
                @endif
            </div>
        </div>
    </form>
@endsection
