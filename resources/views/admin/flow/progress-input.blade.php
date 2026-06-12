@extends('layouts.app')

@section('title', 'Progress Input')

@section('content')


    {{-- breadcrumb section --}}
    @include('admin.flow._partials.breadcrumb', ['page_title' => 'Progress Input'])
    {{-- !ENDS breadcrumb section --}}

    @include('layouts.includes.errors')


    <div style="background: #EDEFF2; padding: 30px;">

        {{-- controls --}}
        <x-flow.partials.controls-component :programId="$programId" :projectId="$projectId" />
        {{-- !ENDS controls --}}



        {{-- content --}}
        @if (!empty($programId) && !empty($projectId))
            <div class="card card-body">
                <x-flow.progress-input-component :programId="$programId" :projectId="$projectId" :activityId="$selectedActivityId" :milestoneId="$selectedMilestoneId" />
            </div>
        @endif
        {{-- ! content --}}

    </div>


    @include('layouts.includes.data-table.script')

@endsection
