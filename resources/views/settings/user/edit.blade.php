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
                    <li class="breadcrumb-item">
                        <a href="{{ route('settings.user.index') }}">
                            User Management
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Edit
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- !ENDS breadcrumb section --}}

    <div class="user-permission-container">
        <div class="row justify-content-center">
            {{-- user details --}}
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body ">
                        <div class="main_title mb-3">
                            User Detail
                        </div>
                        <form method="POST" action="{{ route('settings.user.update', $user) }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Full Name:<span class="text-danger">*</span></label>
                                    <input required type="text" name="name" class="form-control"
                                        placeholder="Full Name" value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Email:<span class="text-danger">*</span></label>
                                    <input required type="text" name="email" class="form-control" placeholder="Email"
                                        value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Password:<span class="text-danger">(optional)</span></label>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Confirm Password:<span class="text-danger">(optional)</span></label>
                                    <input type="password" name="confirm-password" class="form-control"
                                        placeholder="Confirm Password">
                                </div>
                            </div>
                             <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Primary/Main Role:<span class="text-danger">(optional)</span></label>
                                    <select name="role" class="form-control">
                                        <option selected disabled>Select Role</option>
                                        @if (!empty($roles))
                                            @foreach ($roles as $item)
                                                @php
                                                    $user_belongs_to_role = false;
                                                @endphp

                                                @foreach ($user->roles ?? [] as $user_role)
                                                    @if ($user_role->id == $item->id)
                                                        @php
                                                            $user_belongs_to_role = true;
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                @if ($user_belongs_to_role)
                                                    <option value="{{ $item->id }}" selected>{{ $item->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Department Name:<span class="text-danger">(optional)</span></label>
                                    <select name="department" class="form-control">
                                        <option selected disabled>Select Department</option>
                                        @if (!empty($departments))
                                            @foreach ($departments as $item)
                                                @php
                                                    $user_belongs_to_department = false;
                                                @endphp

                                                @foreach ($user->departments ?? [] as $user_department)
                                                    @if ($user_department->id == $item->id)
                                                        @php
                                                            $user_belongs_to_department = true;
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                @if ($user_belongs_to_department)
                                                    <option value="{{ $item->id }}" selected>{{ $item->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Divison Name:<span class="text-danger">(optional)</span></label>
                                    <select name="divison" class="form-control">
                                        <option selected disabled>Select Divison</option>
                                        @if (!empty($divisons))
                                            @foreach ($divisons as $item)
                                                @php
                                                    $user_belongs_to_division = false;
                                                @endphp

                                                @foreach ($user->divisons ?? [] as $user_divison)
                                                    @if ($user_divison->id == $item->id)
                                                        @php
                                                            $user_belongs_to_division = true;
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                @if ($user_belongs_to_division)
                                                    <option value="{{ $item->id }}" selected>{{ $item->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Section Name:<span class="text-danger">(optional)</span></label>
                                    <select name="section" class="form-control">
                                        <option selected disabled>Select Section</option>
                                        @if (!empty($sections))
                                            @foreach ($sections as $item)
                                                @php
                                                    $user_belongs_to_section = false;
                                                @endphp

                                                @foreach ($user->sections ?? [] as $user_section)
                                                    @if ($user_section->id == $item->id)
                                                        @php
                                                            $user_belongs_to_section = true;
                                                        @endphp
                                                    @endif
                                                @endforeach

                                                @if ($user_belongs_to_section)
                                                    <option value="{{ $item->id }}" selected>{{ $item->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary">Update User Data</button>

                        </form>

                    </div>
                </div>
            </div>
            {{-- !ENDS user details --}}
            <div class="col-12 col-md-6">
                {{-- permissions container --}}
                <div id="user_permissions">
                    <div class="card card-body">
                        <div>
                            <div class="main_title mb-3">
                                User Permissions
                            </div>
                            <div>
                                <form method="POST" action="{{ route('settings.user.assign.permissions', $user) }}">
                                    @csrf
                                    <div class="form-group">
                                        <div class="row">
                                            @if (!empty($permissions))
                                                @foreach ($permissions as $key => $permission)
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-check">
                                                            <label>
                                                                <input type="checkbox" name="permissions[]"
                                                                    value="{{ $permission->id }}"
                                                                    {{ $user->hasPermissionTo($permission->id) ? 'checked' : '' }}>
                                                                <span
                                                                    class="permission_name pl-2">{{ $permission->name }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update User Permissions</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- !ENDS permissions container --}}
            </div>
        </div>
    </div>



@endsection
