@extends('layouts.app')

@section('title', 'PME Review')

@section('content')


    {{-- breadcrumb section --}}
    @include('admin.flow._partials.breadcrumb', ['page_title' => 'PME Review'])
    {{-- !ENDS breadcrumb section --}}

    @include('layouts.includes.errors')


    <div style="background: #EDEFF2; padding: 30px;">

        {{-- controls --}}
        <x-flow.partials.controls-component :programId="$programId" :projectId="$projectId" />
        {{-- !ENDS controls --}}



        {{-- content --}}
        @if (!empty($programId) && !empty($projectId))
            <div class="card card-body">
                <x-flow.pme-review-component :programId="$programId" :projectId="$projectId" />
            </div>
        @endif
        {{-- ! content --}}

    </div>


    @include('layouts.includes.data-table.script')

@endsection
