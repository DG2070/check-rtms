@extends('layouts.app')
@section('title', 'Change password')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <div class="row mb-3">
                    <div class="col-md-9">
                        <h4>Change password</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card shadow-lg border-0">
        <div class="card-body px-5">
            {!! Form::open(['route' => 'profile.update-password', 'method' => 'POST']) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" class="form-control" name="current_password" id="current_password"
                            placeholder="Current Password">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="New Password">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation"
                            id="password_confirmation" placeholder="Confirm Password">
                    </div>
                </div>

                <div class="col-md-12 mt-2">
                    <button type="submit" class="btn btn-custom-primary">Submit</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
