@extends('layouts.app')

@section('title', 'Progress Report Performance Review')

@include('layouts.includes.data-table.style')

@section('content')
    <style>
        th,
        td {
            vertical-align: middle !important;
        }
    </style>
    {{-- breadcrumb section --}}
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('programs.index') }}">Programs</a></li>
                    <li class="breadcrumb-item"><a
                            href="/projects?program={{ $project['programID'] }}">{{ $project['NameLong'] }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Progress Report Performance for {{ $project->Name }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- !ENDS breadcrumb section --}}


    @include('layouts.includes.errors')


    <x-project.pme-report-input-component :projectId="$project_id" />


@endsection
