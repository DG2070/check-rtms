@extends('layouts.app')

@section('title', 'Progress Report')

@section('content')


    {{-- breadcrumb section --}}
    @include('admin.flow._partials.breadcrumb', ['page_title' => 'Progress Report'])
    {{-- !ENDS breadcrumb section --}}

    @include('layouts.includes.errors')


    <div style="background: #EDEFF2; padding: 30px;">

        {{-- controls --}}
        <x-flow.partials.controls-component :programId="$programId" :projectId="$projectId" />
        {{-- !ENDS controls --}}

        {{-- content --}}
        @if (!empty($programId) && !empty($projectId))
            <div class="card card-body">
                <x-flow.progress-report-component :programId="$programId" :projectId="$projectId" />
            </div>
        @endif
        {{-- ! content --}}

    </div>


    @include('layouts.includes.data-table.script')

@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
        integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"
        integrity="sha512-01CJ9/g7e8cUmY0DFTMcUw/ikS799FHiOA0eyHsUWfOetgbx/t6oV4otQ5zXKQyIrQGTHSmRVPIgrgLcZi/WMA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
