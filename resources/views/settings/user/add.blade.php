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
                        Add
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- !ENDS breadcrumb section --}}

    <div class="role-container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-7">
                <div class="card">
                    <div class="card-body ">


                        <form method="POST" action="{{ route('settings.user.store') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Full Name:<span class="text-danger">*</span></label>
                                    <input required type="text" name="name" class="form-control"
                                        placeholder="Full Name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Email:<span class="text-danger">*</span></label>
                                    <input required type="text" name="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Password:<span class="text-danger">*</span></label>
                                    <input required type="password" name="password" class="form-control"
                                        placeholder="Password">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Confirm Password:<span class="text-danger">*</span></label>
                                    <input required type="password" name="confirm-password" class="form-control"
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
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Add New User</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
