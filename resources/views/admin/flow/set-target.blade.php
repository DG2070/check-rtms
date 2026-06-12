@extends('layouts.app')

@section('title', 'Set Target')

@section('content')


    {{-- breadcrumb section --}}
    @include('admin.flow._partials.breadcrumb', ['page_title' => 'Set Target'])
    {{-- !ENDS breadcrumb section --}}

    @include('layouts.includes.errors')


    <div style="background: #EDEFF2; padding: 30px;">

        {{-- controls --}}
        <x-flow.partials.controls-component :programId="$programId" :projectId="$projectId" :isSetTarget="true" />
        {{-- !ENDS controls --}}



        {{-- content --}}
        @if (!empty($programId) && !empty($projectId))
            <x-flow.set-target-component :projectId="$projectId" />
        @endif
        {{-- ! content --}}

    </div>


    @include('layouts.includes.data-table.script')

@endsection
