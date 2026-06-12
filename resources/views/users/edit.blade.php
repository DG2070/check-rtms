@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <div class="row mb-3">
                    <div class="col-md-9">
                        <h4>Edit user</h4>
                    </div>
                    <div class="col-md-3 d-flex justify-content-end">
                        @can('User-index')
                            <a class="btn btn-custom-primary" href="{{ route('users.index') }}">View Users</a>
                        @endcan
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
            {!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.update', $user->id]]) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control', 'id' => 'name']) !!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control', 'id' => 'email']) !!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="password">Password:</label>
                        {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control', 'id' => 'password']) !!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="confirm">Confirm Password:</label>
                        {!! Form::password('confirm-password', ['placeholder' => 'Confirm Password', 'class' => 'form-control', 'id' => 'confirm']) !!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="roles">Role:</label>
                        {!! Form::select('roles[]', $roles, $userRole, ['class' => 'form-control', 'id' => 'roles']) !!}
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
