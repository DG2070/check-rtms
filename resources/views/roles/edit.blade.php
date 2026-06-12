@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <div class="row mb-3">
                    <div class="col-md-9">
                        <h4>Edit role</h4>
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
            {!! Form::model($role, ['method' => 'PATCH', 'route' => ['roles.update', $role->id]]) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Role name:</label>
                        {!! Form::text('name', null, ['placeholder' => 'Enter role name', 'class' => 'form-control', 'id' => 'name']) !!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Select Permissions:</label>
                        <div class="row">
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
                                            {{-- @dump($value->id) --}}
                                            <label>
                                                <input type="checkbox" name="permission[]" value="{{ $value->id }}"
                                                    class="name child-checkbox" data-id="{{ $key }}"
                                                    {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                {{ $value->sub_title }}
                                            </label>
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
