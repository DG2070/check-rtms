@extends('layouts.app')

@section('title', 'P.M.E Review Report')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

    <style>
        s .table .thead-blue th {
            color: #fff;
            background-color: #225e95;
            border-color: #588bb9;
        }

        th,
        td {
            vertical-align: middle !important;
        }

        .custom-container {
            width: 100%;
            height: auto;
            margin: auto;
            background: #edeff2;
            padding-left: 30px;
            padding-right: 30px;
            padding-bottom: 30px;
        }

        .background-blue {
            background-color: #225e95 !important;
        }

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
            width: 20px
        }
    </style>

    {{-- breadcrumb section --}}
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        P.M.E Report Performance
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- !ENDS breadcrumb section --}}

    @include('layouts.includes.errors')
    @php
        $quaterfilter = new App\Helper\QuaterFilter();
    @endphp


    <div style="background: #EDEFF2; padding: 30px;">

        <div class="rounded-select-container">

            <form method="GET" action="">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fiscal Year</label>
                            <select class="form-control select2" name="fiscal_year" required>
                                <option value="" disabled>--Select Fiscal Year--</option>
                                @php
                                    $currentFiscalYear = App\Helper\FiscalYear::curentFiscalYear();
                                    $fiscalYears = \App\Models\ProjectDataSQ::where('fiscal_year', '!=', App\Helper\FiscalYear::curentFiscalYear())
                                        ->distinct('fiscal_year')
                                        ->pluck('fiscal_year');
                                    //-- Add current FY if it doesnt exists
                                    if (!$fiscalYears->contains($currentFiscalYear)) {
                                        $fiscalYears = collect($fiscalYears);
                                        $fiscalYears->push($currentFiscalYear);
                                    }
                                @endphp
                                @foreach ($fiscalYears ?? [] as $rfiscalYear)
                                    <option value="{{ $rfiscalYear }}"
                                        {{ !empty(request()->fiscal_year) && request()->fiscal_year == $rfiscalYear ? 'selected' : '' }}>
                                        {{ '20' . $rfiscalYear }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Program</label>
                            <select class="form-control select2" name="program" onchange="getProject(this.value, null)"
                                required>
                                <option value="" selected disabled>--SELECT PROGRAM--</option>
                                @foreach ($programs as $pro)
                                    <option value="{{ $pro->ID }}"
                                        {{ $selectedProgram == $pro->ID ? 'selected' : '' }}>
                                        {{ $pro->NameLong }} [ {{ $pro->Name }} ]
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Project</label>
                            <select class="form-control select2" name="project" id="appendProject">
                                <option value="" selected>--SELECT PROJECT--</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary rounded-0">Open</button>
                            <a href="{{ route('pme.report.filter') }}" class="btn btn-danger rounded-0 ml-2">Clear</a>
                        </div>
                    </div>
                </div>
            </form>


        </div>
        @if ($program && $program->project && count($program->project) > 0)
            <div class="card card-body">
                {{-- quater filter --}}
                <div class="rounded-select-container">
                    <form method="GET" action="">
                        @if (!empty(request('program')) && request('program') != '')
                            <input type="hidden" name="program" value="{{ request('program') }}">
                        @endif
                        @if (!empty(request('fiscal_year')) && request('fiscal_year') != '')
                            <input type="hidden" name="fiscal_year" value="{{ request('fiscal_year') }}">
                        @endif
                        @if (!empty(request('project')) && request('project') != '')
                            <input type="hidden" name="project" value="{{ request('project') }}">
                        @endif
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group select2-multiple">
                                    <label>Filter Quaters</label>
                                    <select class="form-control select2 report-month-filter" name="selected_months[]"
                                        multiple>

                                        @for ($month = 1; $month < 13; $month++)
                                            @if (in_array($month, $quaterfilter->showMonths()))
                                                <option value="{{ $month }}" selected>
                                                    {{ $month }}</option>
                                            @else
                                                <option value="{{ $month }}">
                                                    {{ $month }}</option>
                                            @endif
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex">
                                    <div class="form-group pt-3 mt-3">
                                        <button type="submit" class="btn btn-primary rounded-0">Filter</button>
                                    </div>
                                    <div class="form-group pt-3 mt-3 ml-2">
                                        <button type="button"
                                            class="btn btn-dark rounded-0 reset_quater_filters">Reset</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                {{-- !ENDS quater filter --}}

                @include('admin.report.components.pme-report-table')

                <div class="text-right d-flex justify-content-end">
                    <form action="{{ route('pme.report.download') }}" method="POST" class="mx-2">
                        @csrf
                        <input type="hidden" name="fiscal_year" value="{{ $fiscal_year }}">
                        <input type="hidden" name="programId" value="{{ $selectedProgram }}">
                        <input type="hidden" name="projectId" value="{{ $selectedProject }}">
                        <button class="btn btn-primary ">
                            Export
                        </button>
                    </form>

                    {{-- <a href="{{ route('export.pme.report', ['program' => "$selectedProgram", 'project' => "$selectedProject", 'selected_months' => $quaterfilter->showMonths()]) }}"
                        class="btn btn-primary">Excel Export</a> --}}
                </div>
            </div>
        @endif

    </div>



    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2({
                closeOnSelect: true
            });
        });

        const projects = <?php echo json_encode($projects); ?>;

        const selectedProgram = "{{ $selectedProgram ?? '' }}";
        const selectedProject = "{{ $selectedProject ?? '' }}";
        if (selectedProgram) {
            getProject(selectedProgram, selectedProject);
        }

        function getProject(program_id, project_id = '') {
            let project = [];
            let html = `<option value="" selected>--SELECT PROJECT--</option>`;

            projects.forEach(prog => {
                if (prog.programID == program_id) {
                    if (project_id == prog.projectID) {
                        console.log('asd');
                        html += `<option value="${prog.projectID}" selected>${prog.Name}</option>`;
                    } else {
                        html += `<option value="${prog.projectID}">${prog.Name} [ ${prog.TownName} ]</option>`;
                    }
                }
            });

            $("select#appendProject").html(html);

        }

        function downloadPMEReport() {

            $("input#year_id").val({{ request('fiscal_year') }});
            $("input#program_id").val({{ request('program') }});
            $("input#project_id").val({{ request('project') }});

            document.querySelector("form#download-pme-report").submit();

        }
    </script>


@endsection
