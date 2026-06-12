@extends('layouts.app')

@section('title', 'Projects')

@include('layouts.includes.data-table.style')

@php
    $projects = $data['projects'];
@endphp

@section('content')

    {{-- breadcrumb section --}}
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('programs.index') }}">Programs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        @if (!empty(request('program')))
                            Projects of {{ $projects[0]->program->NameLong ?? '' }}
                        @else
                            List of Projects
                        @endif
                    </li>
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
                            <input type="hidden" name="program" value="{{ request('program') ?? '' }}">
                            <label>Project Type Filter</label>
                            <div class="d-flex">
                                <div class="form-group rounded-select-container" style="min-width: 300px">
                                    <select name="project_filter_type"
                                        class="form-control select2  program_type_filter_select2" style="min-width: 350px">
                                        <option value="" disabled>--SELECT MONTH--</option>
                                        @if ($project_filter_type == 'all_project')
                                            <option value="all_project" selected>
                                                All Projects</option>
                                        @else
                                            <option value="all_project">
                                                All Projects</option>
                                        @endif
                                        @if ($project_filter_type == 'active_project')
                                            <option value="active_project" selected>Active Projects FY
                                                {{ App\Helper\FiscalYear::curentFullFiscalYear() }}</option>
                                        @else
                                            <option value="active_project">Active Projects FY
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

            <table id="example2" class="table table-hover">
                <thead>
                    <tr>
                        <th width="2%">S.N</th>
                        <th width="25%">Name</th>
                        <th width="15%">Town Name</th>
                        <th class="text-center">Progress</th>
                        {{-- <th width="10%" style="text-align: center">Activities</th>
                        <th width="10%" style="text-align: center">Physical Progress</th>
                        <th width="10%" style="text-align: center">Program Report</th> --}}
                        {{-- <th width="20%" class="text-center">Operations</th> --}}
                    </tr>
                </thead>
                <tbody>

                    @foreach ($projects as $key => $project)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $project['Name'] }}</td>

                            <td>{{ $project['TownName'] }}</td>

                            <td>
                                <div class="table-progress mb-2" title="Financial progress">
                                    @php
                                        $financial_progress = 0;
                                        if (isset($project->projectDataSQ[0]->FT) && $project->projectDataSQ[0]->FT != 0 && isset($project->projectDataSQ[0]->FP) && $project->projectDataSQ[0]->FP != 0) {
                                            $financial_progress = ($project->projectDataSQ[0]->FP / $project->projectDataSQ[0]->FT) * 100;
                                        }
                                    @endphp
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            style="width: {{ $financial_progress }}%;"
                                            aria-valuenow="{{ $financial_progress }}" aria-valuemin="0"
                                            aria-valuemax="100">
                                        </div>
                                    </div>
                                    <span class="progress-des">
                                        <strong>
                                            Financial
                                            Progress
                                        </strong>{{ floor($financial_progress) }}%
                                    </span>
                                </div>
                                <div class="table-progress mb-2" title="Physical progress">
                                    @php
                                        $physical_progress = 0;
                                        if (isset($project->projectDataSQ[0]->PT) && $project->projectDataSQ[0]->PT != 0 && isset($project->projectDataSQ[0]->PP) && $project->projectDataSQ[0]->PP != 0) {
                                            $physical_progress = ($project->projectDataSQ[0]->PP / $project->projectDataSQ[0]->PT) * 100;
                                        }
                                    @endphp

                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar"
                                            style="width: {{ $physical_progress }}%;"
                                            aria-valuenow="{{ $physical_progress }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <span class="progress-des">
                                        <strong>Physical
                                            Progress</strong>{{ floor($physical_progress) }}%
                                    </span>
                                </div>
                            </td>

                            {{-- <td style="text-align: right">
                                <div class="d-flex justify-content-center" style="gap: 4px;">
                                    <a class="btn btn-custom-secondary"
                                        href="/programs/new?programID={{ $project['programID'] }}&projectID={{ $project['projectID'] }}">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    @if (request('program') >= 200000 && (Auth::user()->hasRole('Sysqube-Super-Admin') || Auth::user()->hasRole('Super-Admin') || Auth::user()->hasRole('Admin')))
                                        {!! Form::open([
                                            'method' => 'DELETE',
                                            'route' => ['projects.delete', $project['projectID']],
                                            'style' => 'display:inline',
                                        ]) !!}
                                        <button type="submit" class="btn btn-custom-secondary delete-project"
                                            data-toggle="tooltip" data-placement="top" title="Delete Project">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>

                                        {!! Form::close() !!}
                                    @endif
                                </div>
                            </td> --}}
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>


    @if (request('program') >= 200000)
        <div>
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['programs.delete', request('program')],
                'style' => 'display:inline',
            ]) !!}
            <button type="submit" class="btn btn-danger delete my-3" id="delete-program">
                <i class="fas fa-trash-alt"></i> Delete Program
            </button>
            {!! Form::close() !!}

        </div>
    @endif



    @include('layouts.includes.data-table.script')

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();

            // Delete row from table
            $("#delete-program").on("click", function(e) {
                e.preventDefault();
                var target = this;
                if (confirm("Do you really want to delete this program ?")) {
                    $(target).closest("form").submit();
                }
            });
            $("body").on("click", ".delete-project", function(e) {
                e.preventDefault();
                var target = this;
                if (confirm("Do you really want to delete this project ?")) {
                    $(target).closest("form").submit();
                }
            });

        })
    </script>

@endsection
