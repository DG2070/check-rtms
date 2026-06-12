@extends('auth.layouts.app')

@section('content')
    <h3 class="header mb-4">{{ __('Confirm Password') }}</h3>

    {{ __('Please confirm your password before continuing.') }}

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-3">
            <label for="password" class="col-md-4 col-form-label">{{ __('Password') }}</label>

            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="row mb-0 mt-4">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary custom-btn">
                    {{ __('Confirm Password') }}
                </button>

                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </div>
    </form>
@endsection
