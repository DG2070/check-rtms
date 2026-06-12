@extends('layouts.app')

@section('title', 'Programs')

@include('layouts.includes.data-table.style')
<style>
    tbody tr:hover {
        cursor: pointer;
    }
</style>


@section('content')

    {{-- breadcrumb section --}}
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Internal Project List</li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- !ENDS breadcrumb section --}}

    @include('layouts.includes.errors')





    <div class="card shadow-lg border-0">
        <div class="card-body table-card-body">

            {{-- filter --}}
            <div class="m-2 mt-3">
                <div class="row justify-content-between">
                    <div class="col-12 col-md-6">
                        <div class="">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="">
                                        <label>Project Type Filter</label>
                                        <div class="d-flex">
                                            <div class="form-group rounded-select-container" style="min-width: 300px">
                                                <select name="project_filter_type"
                                                    class="form-control select2  project_type_filter_select2"
                                                    style="min-width: 350px">
                                                    <option value="" disabled>--SELECT MONTH--</option>
                                                    @if ($project_filter_type == 'all_projects')
                                                        <option value="all_projects" selected>
                                                            All Projects</option>
                                                    @else
                                                        <option value="all_projects">
                                                            All Projects</option>
                                                    @endif
                                                    @if ($project_filter_type == 'active_projects')
                                                        <option value="active_projects" selected>Active Projects FY
                                                            {{ App\Helper\FiscalYear::curentFullFiscalYear() }}</option>
                                                    @else
                                                        <option value="active_projects">Active Projects FY
                                                            {{ App\Helper\FiscalYear::curentFullFiscalYear() }}</option>
                                                    @endif


                                                </select>
                                            </div>
                                            <div class="ml-2">
                                                <button type="sumbit" class="btn btn-primary btn-tdf-primary">
                                                    Filter
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 text-right">
                        <div class="mt-3">
                            <button type="button" class="btn btn-primary btn-tdf-primary" data-toggle="modal"
                                data-target="#createNewProjectModal">Add New Project For
                                {{ App\Helper\FiscalYear::curentFullFiscalYear() }}</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- !ENDS filter --}}

            <table id="example2" class="table table-hover">
                <thead>
                    <tr>
                        <th width="10%">S.N</th>
                        <th>Project</th>
                        <th>Fiscal Year</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @if (!empty($projects))
                        @foreach ($projects as $key => $item)
                            <tr title="{{ $item['name'] }}" style="cursor:auto">
                                <td>{{ $loop->iteration }}.</td>
                                <td>{{ $item['name'] }}</td>
                                <td>20{{ $item['fiscal_year'] }}</td>

                                <td style="text-align: left">
                                    <a class="btn btn-custom-secondary p-2 "
                                        href="{{ route('internal.project.single.index', ['project_id' => $item->id]) }}">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <button type="submit" class="btn btn-custom-secondary p-2 " data-toggle="modal"
                                        data-target="#editProjectModal-{{ $item->id }}" data-toggle="tooltip"
                                        data-placement="top" title="Edit Project">
                                        <i class="fas fa-pen"></i>
                                    </button>



                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['internal.project.delete', ['internalProject' => $item]],
                                        'style' => 'display:inline',
                                    ]) !!}

                                    <button type="submit" class="btn btn-custom-secondary p-2  delete-project"
                                        data-toggle="tooltip" data-placement="top" title="Delete Project">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>

                                    {!! Form::close() !!}
                                </td>

                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
        </div>
    </div>

    @include('layouts.includes.data-table.script')
    <script>
        $('.cliclable-row').click(function() {
            window.location = $(this).data('href');
        })
    </script>

@endsection

@push('modal')
    {{-- create new activity modal --}}
    <div class="modal fade" id="createNewProjectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="z-index: 1052;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Project For
                        {{ App\Helper\FiscalYear::curentFullFiscalYear() }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('internal.project.store') }}">
                        @csrf
                        <input type="hidden" name="fiscal_year" value="{{ App\Helper\FiscalYear::curentFiscalYear() }}">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Project Name:<span class="text-danger">*</span></label>
                                <input required list="project_name_datalist" type="text" name="name"
                                    class="form-control" placeholder="Project Name">
                                {{-- <datalist id="project_name_datalist">
                                    <option value="Mobilization Advance">Mobilization Advance</option>
                                    <option value="Completion of 10% construction work">Completion of 10% construction work
                                    </option>
                                    <option value="Completion of 60% construction work">Completion of 60% construction work
                                    </option>
                                </datalist> --}}
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Project</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- edit project modal  --}}
    @if (!empty($projects))
        @foreach ($projects as $key => $item)
            <div class="modal fade" id="editProjectModal-{{ $item->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1052;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Project Detail</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('internal.project.update') }}">
                                {{ method_field('PUT') }}
                                @csrf
                                <input type="hidden" name="project_id" value="{{ $item->id }}">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Project Name:<span class="text-danger">*</span></label>
                                        <input required list="project_name_datalist" type="text" name="name"
                                            class="form-control" placeholder="Project Name" value="{{ $item->name }}">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Edit Project</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endpush


@push('script')
    <script>
        $("body").on("click", ".delete-project", function(e) {
            e.preventDefault();
            var target = this;
            if (confirm("Do you really want to delete this project ?")) {
                $(target).closest("form").submit();
            }
        });

        $(".project_type_filter_select2").select2({
            closeOnSelect: true,
        });
    </script>
@endpush


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

    {{-- <style>
        .dataTables_wrapper {
            padding-top: 0px !important;
        }
    </style> --}}
@endsection
