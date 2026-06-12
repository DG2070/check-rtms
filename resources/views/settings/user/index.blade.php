@extends('layouts.app')
@section('title', 'User Management')
@section('content')

    {{-- breadcrumb section --}}
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            Home
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        User Management
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- !ENDS breadcrumb section --}}

    <div class="role-container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body ">

                        <div class="mb-3">
                            <a href="{{ route('settings.user.add') }}" class="btn btn-primary btn-tdf-primary">
                                Add New User
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="10%">SN</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Role</th>
                                        <th>Permissions</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($users))
                                        @foreach ($users as $item)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}.</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>
                                                    @if (!empty($item->departments))
                                                        @foreach ($item->departments as $k => $v)
                                                            {{ $k != 0 ? ', ' : '' }}<span>{{ $v->name }}</span>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!empty($item->getRoleNames()))
                                                        @foreach ($item->getRoleNames() as $k => $v)
                                                            {{ $k != 0 ? ', ' : '' }}<span>{{ $v }}</span>
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $item->permissions->count() }}
                                                </td>
                                                <td>
                                                    <div>

                                                        <a href="{{ route('settings.user.single', $item) }}"
                                                            class="btn btn-dark">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['settings.user.delete', $item],
                                                            'style' => 'display:inline',
                                                        ]) !!}
                                                        <button type="submit" class="btn btn-danger delete-user">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                        {!! Form::close() !!}
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@push('script')
    <script>
        $("body").on("click", ".delete-user", function(e) {
            e.preventDefault();
            var target = this;
            if (confirm("Do you really want to delete this user?")) {
                $(target).closest('form').submit();
            }
        });
    </script>
@endpush

@push('modal')
    {{-- create new roll modal --}}
    <div class="modal fade" id="createNewRoleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="z-index: 1052;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('settings.role.store') }}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Role Name:<span class="text-danger">*</span></label>
                                <input required type="text" name="name" class="form-control" placeholder="Role">

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    {{-- create new permisssion modal --}}
    @if (!empty($roles))
        @foreach ($roles as $item)
            <div class="modal fade" id="edit-role-{{ $item->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1052;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('settings.role.update', $item) }}">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Role Name:<span class="text-danger">*</span></label>
                                        <input required type="text" name="name" class="form-control"
                                            placeholder="Role" value="{{ $item->name }}">

                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endpush
