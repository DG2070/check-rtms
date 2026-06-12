@extends('layouts.app')

@section('title', 'Physical Progress List')

@include('layouts.includes.data-table.style')

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
                        Physical Progress of {{ $project->Name }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- !ENDS breadcrumb section --}}



    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @include('layouts.includes.errors')


    <x-project.physical-progress-component :projectId="$project_id" />

    @include('layouts.includes.data-table.script')

@endsection
