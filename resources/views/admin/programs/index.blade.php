@extends('layouts.app')

@section('title', 'Programs')

@include('layouts.includes.data-table.style')
<style>
    tbody tr:hover {
        cursor: pointer;
    }
</style>

@php
    $programs = $data['programs'];
@endphp

@section('content')

    {{-- breadcrumb section --}}
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Programs List</li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- !ENDS breadcrumb section --}}

    @include('layouts.includes.errors')

    <div class="card shadow-lg border-0">
        <div class="card-body table-card-body">

            <div class="mt-3 ml-3 mb-0">
                <div class="row">
                    <div class="col-md-12">
                        <form action="">
                            <label>Program Type Filter</label>
                            <div class="d-flex">
                                <div class="form-group rounded-select-container" style="min-width: 300px">
                                    <select name="program_filter_type"
                                        class="form-control select2  program_type_filter_select2" style="min-width: 350px">
                                        <option value="" disabled>--SELECT MONTH--</option>
                                        @if ($program_filter_type == 'all_program')
                                            <option value="all_program" selected>
                                                All Programs</option>
                                        @else
                                            <option value="all_program">
                                                All Programs</option>
                                        @endif
                                        @if ($program_filter_type == 'active_program')
                                            <option value="active_program" selected>Active Programs FY
                                                {{ App\Helper\FiscalYear::curentFullFiscalYear() }}</option>
                                        @else
                                            <option value="active_program">Active Programs FY
                                                {{ App\Helper\FiscalYear::curentFullFiscalYear() }}</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="ml-2">
                                    <button type="sumbit" class="btn btn-primary btn-tdf-primary tdf-border-small">
                                        Filter
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>


            <div class="mt-0">
                <table id="example2" class="table table-hover">
                    <thead>
                        <tr>
                            <th width="10%">S.N</th>
                            <th>Program</th>
                            <th>Code</th>
                            <th>Financing Agency</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($programs as $key => $program)
                            <tr class="cliclable-row" title="{{ $program['NameLong'] }}"
                                data-href="{{ route('projects.index', ['program' => $program['ID']]) }}">
                                <td>{{ $loop->iteration }}.</td>
                                <td style="width: 20%;">{{ $program['NameLong'] }}</td>
                                <td style="width: 20%;">{{ $program['Code'] }}</td>
                                <td style="width: 20%;">{{ $program['FinancingAgency'] }}</td>
                                {{-- <td style="width: 20%;">Rs. {{ number_format($program['FundGrant'] * 1000) }}</td> --}}
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('layouts.includes.data-table.script')
    <script>
        $('.cliclable-row').click(function() {
            window.location = $(this).data('href');
        })

        $(".program_type_filter_select2").select2({
            closeOnSelect: true,
        });
    </script>

@endsection


@section('style')
    <style>
        .select2-hidden-accessible {
            border: 0 !important;
            clip: rect(0 0 0 0) !important;
            height: 1px !important;
            margin: -1px !important;
            overflow: hidden !important;
            padding: 0 !important;
            position: absolute !important;
            width: 1px !important;
        }

        .form-control {
            display: block;
            width: 100%;
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
        }

        .select2-container--default .select2-selection--single,
        .select2-selection .select2-selection--single {
            border: 1px solid #d2d6de;
            border-radius: 0;
            padding: 6px 12px;
            height: 34px;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaa;
            border-radius: 4px;
        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 28px;
            user-select: none;
            -webkit-user-select: none;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-right: 10px;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: 0;
            padding-right: 0;
            height: auto;
            margin-top: -3px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 28px;
        }

        .select2-container--default .select2-selection--single,
        .select2-selection .select2-selection--single {
            border: 1px solid #d2d6de;
            border-radius: 0 !important;
            padding: 6px 12px;
            height: 40px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 6px !important;
            right: 1px;
            width: 20px;
        }
    </style>

    <style>
        .dataTables_wrapper {
            padding-top: 0px !important;
        }
    </style>
@endsection
