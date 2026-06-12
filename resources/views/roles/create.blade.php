@extends('layouts.app')
@section('title', 'Create Role')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <div class="row mb-3">
                    <div class="col-md-9">
                        <h4>Create role</h4>
                    </div>
                    <div class="col-md-3 d-flex justify-content-end">
                        @can('Role-index')
                            <a class="btn btn-custom-primary" href="{{ route('roles.index') }}">View Roles</a>
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
            {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Role name:</label>
                        <input type="text" name="name" id="name" placeholder="Enter role name"
                            class="form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Select Permissions:</label>
                        <div class="row">
                            <div class="form-check">
                                <label>
                                    <input type="checkbox" name="permission[]" class="select-all-check parent-checkbox-">
                                    <span>Progress Input</span>
                                </label>
                                <br>
                                {{-- @foreach ($permission as $value)
                                            <label class="ml-2 font-weight-normal">
                                                <input type="checkbox" name="permission[]" value="{{ $value->id }}"
                                                    class="name child-checkbox" data-id="{{ $key }}">

                                                {{ $value->sub_title }}</label>
                                            <br />
                                        @endforeach --}}
                            </div>

                            @foreach ($grouped_permissions as $key => $permission)
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <div class="form-check">
                                        <label>
                                            <input type="checkbox" name="" id="select_{{ $key }}"
                                                class="select-all-check parent-checkbox-{{ $key }}"
                                                data-id="{{ $key }}">
                                            <span>{{ $key }}</span>
                                        </label>
                                        <br>
                                        @foreach ($permission as $value)
                                            <label class="ml-2 font-weight-normal">
                                                <input type="checkbox" name="permission[]" value="{{ $value->id }}"
                                                    class="name child-checkbox" data-id="{{ $key }}">
                                                {{-- {{ Form::checkbox('permission[]', $value->id, false, ['class' => 'name']) }} --}}
                                                {{ $value->sub_title }}</label>
                                            <br />
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <button type="submit" class="btn btn-custom-primary">Submit</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>


    @include('roles.checkall-script')
@endsection
