@extends('layouts.app')

@section('title', 'Town List')

@include('layouts.includes.data-table.style')

@section('content')
    {{-- breadcrumb section --}}
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Town List
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- !ENDS breadcrumb section --}}


    @include('layouts.includes.errors')

    <div class="card shadow-lg border-0">
        <div class="card-body table-card-body">
            <table id="example2" class="table table-hover">
                <thead>
                    <tr>
                        <th width="10%">S.N</th>
                        <th>Town</th>
                        <th>Province</th>
                        <th>District</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($locations as $location)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $location->TownName }}</td>
                            <td>{{ $location->Province }}</td>
                            <td>{{ $location->District }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    @include('layouts.includes.data-table.script')

@endsection
