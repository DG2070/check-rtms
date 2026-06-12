@extends('layouts.app')

@section('title', 'Activities')

@include('layouts.includes.data-table.style')

@php
$activities = $data['activities'];
@endphp

@section('content')
    {{-- breadcrumb section --}}
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Activities
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
                        <th width="5%">S.N</th>
                        <th>Program Name</th>
                        <th>Project Name</th>
                        <th>Town</th>
                        <th>Activity Code</th>
                        <th>Approved Total</th>
                        <th style="text-align: right">Disbursements</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($activities as $activity)
                        <tr>
                            <td>{{ $loop->iteration }}.</td>

                            <td>{{ $activity['programName'] ?? '' }}</td>

                            <td>{{ $activity['projectName'] ?? '' }}</td>

                            <td>{{ $activity['TownName'] ?? '' }}</td>

                            <td>{{ $activity['activityCode'] }}</td>

                            <td>{{ $activity['ApprovedTotal'] }}</td>

                            <td style="text-align: right">
                                @can('Disbursement-index')
                                    <a class="btn btn-custom-secondary"
                                        href="{{ route('disbursements.index', ['activity' => $activity['activityCode']]) }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    @include('layouts.includes.data-table.script')

@endsection
