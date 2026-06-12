@extends('layouts.app')
@section('title', 'Role Management')
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
                        Role Management
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- !ENDS breadcrumb section --}}

    <div class="role-container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-body ">

                        <div class="mb-3">
                            <button type="button" class="btn btn-primary btn-tdf-primary" data-toggle="modal"
                                data-target="#createNewRoleModal">Add New Role</button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="10%">SN</th>
                                        <th>Role Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($roles))
                                        @foreach ($roles as $item)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}.</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    <div>
                                                        <button type="button" class="btn btn-dark" data-toggle="modal"
                                                            data-target="#edit-role-{{ $item->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>

                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['settings.role.delete', $item],
                                                            'style' => 'display:inline',
                                                        ]) !!}
                                                        <button type="submit" class="btn btn-danger delete-role">
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
        $("body").on("click", ".delete-role", function(e) {
            e.preventDefault();
            var target = this;
            if (confirm("Do you really want to delete this role?")) {
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
