@extends('layouts.app')

@section('title', 'Search')

@include('layouts.includes.data-table.style')


@section('content')
    {{-- breadcrumb section --}}
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Search
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- !ENDS breadcrumb section --}}

    @include('layouts.includes.errors')

    <div class="search-section">
        <div class="card shadow-lg border-0">
            <div class="card-body table-card-body">
                <table id="search_everywhere_datatable" class="table table-hover">
                    <thead>
                        <tr>
                            <th width="5%">S.N</th>
                            <th>Type</th>
                            <th>Data</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($search_datas))
                            @foreach ($search_datas as $search_data)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>
                                        <div class="text-uppercase">
                                            {{ $search_data['type_field'] }}</div>
                                    </td>
                                    <td>
                                        <div>
                                            <table class="table table-striped inner-search-table">
                                                @foreach ($search_data['data'] as $key => $value)
                                                    <tr>
                                                        <td width="20%">
                                                            @if ($key == 'NameLong')
                                                                Fullname
                                                            @elseif ($key == 'FinancingAgency')
                                                                Financing Agency
                                                            @else
                                                                {{ $key }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $value }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </td>
                                    <td style="text-align: center">
                                        @if ($search_data['type_field'] == 'program')
                                            {{-- <a class="btn btn-custom-secondary"
                                                href="{{ route('projects.index', ['program' => $search_data['data']['ID']]) }}">
                                                <i class="fas fa-eye"></i>
                                            </a> --}}
                                        @endif
                                        @if ($search_data['type_field'] == 'project')
                                        {{-- <a class="btn btn-custom-secondary"
                                                href="/programs/new?programID={{ $search_data['data']['programID'] }}&projectID={{ $search_data['data']['projectID'] }}">
                                                <i class="fas fa-eye"></i>
                                            </a> --}}

                                            {{-- <div class="d-flex justify-content-center" style="gap: 4px;">
                                                <a class="btn btn-custom-secondary" data-toggle="tooltip"
                                                    data-placement="top" title="Add Physical Progress"
                                                    href="{{ route('project.physicalProgress', ['id' => $search_data['data']['projectID']]) }}">
                                                    <i class="fas fa-plus"></i>
                                                </a>

                                                <a class="btn btn-custom-secondary" data-toggle="tooltip"
                                                    data-placement="top" title="Progress Report Input"
                                                    href="{{ route('project.inputProgramReport.create', ['id' => $search_data['data']['projectID']]) }}">
                                                    <i class="fa-solid fa-file-circle-plus"></i>
                                                </a>

                                                <a class="btn btn-custom-secondary" data-toggle="tooltip"
                                                    data-placement="top" title="PME Report Input"
                                                    href="{{ route('project.milestone.review', ['id' => $search_data['data']['projectID']]) }}">
                                                    <i class="fa-solid fa-file-signature"></i>
                                                </a>
                                            </div> --}}
                                        @endif


                                    </td>
                                    {{-- <td style="text-align: right">

                                        <a class="btn btn-custom-secondary"
                                            @if ($search_data['type_field'] == 'program') href="{{ route('projects.index', ['program' => $search_data['data']['ID']]) }}"
                                        @elseif ($search_data['type_field'] == 'project')



 href=""
                                        @else
                                             href="#" @endif>
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td> --}}
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @include('layouts.includes.data-table.script')

@endsection
