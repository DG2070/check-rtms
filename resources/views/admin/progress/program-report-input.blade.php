@extends('layouts.app')

@section('title', 'Program Report Input')

{{-- @include('layouts.includes.data-table.style') --}}

@section('content')
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
                        Program Report Input for {{ $project->Name }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- !ENDS breadcrumb section --}}


    @include('layouts.includes.errors')

    <x-project.activity-milestone-component :projectId="$project_id" />


@endsection

@push('css')
    <style>
        .activity-milestone-container {
            width: 100%;
            height: auto;
            margin: auto;
            background: #edeff2;
            padding-left: 30px;
            padding-right: 30px;
            padding-bottom: 30px;
        }
    </style>
@endpush
