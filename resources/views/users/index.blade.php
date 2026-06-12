@extends('layouts.app')
@section('title', 'User Management')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <div class="row mb-3">
                    <div class="col-md-9">
                        <h4>User Management</h4>
                    </div>
                    <div class="col-md-3 d-flex justify-content-end">
                        @can('User-create')
                            <a class="btn btn-custom-primary" href="{{ route('users.create') }}">Create User</a>
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
                        <th>Email</th>
                        <th>Roles</th>
                        <th style="text-align: right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $user)
                        <tr>
                            <td>{{ ++$i }}.</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $k => $v)
                                        {{ $k != 0 ? ', ' : '' }}<span>{{ $v }}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td style="text-align: right">
                                {{-- @can('User-show')
                                    <a class="btn btn-custom-secondary" href="{{ route('users.show', $user->id) }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endcan --}}
                                @can('User-edit')
                                    <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                                @can('User-destroy')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' => 'display:inline']) !!}
                                    <button type="submit" class="btn btn-danger delete-row">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    {!! Form::close() !!}
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3 custom-pagination-div">
                {{ $data->links() }}
            </div>
        </div>
    </div>
@endsection
