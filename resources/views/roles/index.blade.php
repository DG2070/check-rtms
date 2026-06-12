@extends('layouts.app')
@section('title', 'Role Management')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <div class="row mb-3">
                    <div class="col-md-9">
                        <h4>Role Management</h4>
                    </div>
                    <div class="col-md-3 d-flex justify-content-end">
                        @can('Role-create')
                            <a class="btn btn-custom-primary" href="{{ route('roles.create') }}">Create Role</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card shadow-lg border-0">
        <div class="card-body table-card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th width="10%">No</th>
                        <th>Name</th>
                        <th style="text-align: right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ ++$i }}.</td>
                            <td>{{ $role->name }}</td>
                            <td style="text-align: right">
                                @can('Role-show')
                                    <a class="btn btn-custom-secondary" href="{{ route('roles.show', $role->id) }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endcan
                                @can('Role-edit')
                                    <a class="btn btn-primary" href="{{ route('roles.edit', $role->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                                @can('Role-destroy')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style' => 'display:inline']) !!}
                                    <button type="submit" class="btn btn-danger delete-row">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    {{-- {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-custom-rounded']) !!} --}}
                                    {!! Form::close() !!}
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3 custom-pagination-div">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
@endsection
