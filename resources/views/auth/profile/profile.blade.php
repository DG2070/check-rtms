@extends('layouts.app')
@section('title', 'Update profile')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <div class="row mb-3">
                    <div class="col-md-9">
                        <h4>Update profile</h4>
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
            {!! Form::open(['route' => 'profile.update-profile', 'method' => 'POST']) !!}
            <div class="row">
               {{-- Get user profile data for updating  --}}
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}"
                            placeholder="Name">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}"
                            placeholder="Email">
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <button type="submit" class="btn btn-custom-primary">Update</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
