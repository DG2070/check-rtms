@extends('layouts.app')

@section('title', 'Programs')

@section('content')
    {{-- breadcrumb section --}}
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('internal.project.index') }}">Internal Project List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $project->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- !ENDS breadcrumb section --}}

    @include('layouts.includes.errors')

    <div style="background: #EDEFF2;  ">
        {{-- content --}}
        <style>
            /* TODO: move to css file */
            .nav-item .active {
                background-color: #22826e !important;
            }
        </style>
        <div class="content-container " id="content_container">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-3 tab-card">
                        <div class="card-header tab-card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="newProgramTabs" role="tablist">
                                @include('admin.internal.projects.single._partials.tabs-head')
                            </ul>
                        </div>

                        <div class="tab-content" id="newProgramTabsContent">
                            @include('admin.internal.projects.single._partials.tabs-content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ! content --}}
    </div>
@endsection

@section('modal')

    <div class="modal fade" id="createNewActivityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="z-index: 1052;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Activities/Milestones FY
                        20{{ $project->fiscal_year }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('internal.project.single.milestone.create') }}">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        <input type="hidden" name="fiscal_year" value="{{ $project->fiscal_year }}">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Activity/Milestone Name:<span class="text-danger">*</span></label>
                                <input required list="activity_datalist" type="text" name="activity_milestone"
                                    class="form-control" placeholder="Activity/Milestone Name">
                            </div>
                            <div class="form-group  col-md-12">
                                <label>Is Subjective Timeline?<span class="text-danger">*</span></label>
                                <select name="is_text" class="form-control" required>
                                    <option value="no" selected>No</option>
                                    <option value="yes">Yes</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Approved Budget:<span class="text-danger">(optional)</span></label>
                                <input type="text" name="approved_budget" class="form-control"
                                    placeholder="Approved Budget">
                            </div>
                            <div class="form-group col-md-12">
                                <label>Performance Indicator:<span class="text-danger">(optional)</span></label>
                                <input type="text" name="performance_indicator" class="form-control"
                                    placeholder="Performance Indicator">
                            </div>

                            <div class="form-group col-md-12">
                                <label>Main Responsibilities:<span class="text-danger">(optional)</span> </label>
                                <div>
                                    <select class="form-control responsibility_user " id="main_responsibility_user"
                                        style="z-index: 1052;" name="main_responsibility[]" multiple="multiple">
                                        <option value="" disabled>--SELECT USER--</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Supportive Responsibilities:<span class="text-danger">(optional)</span> </label>
                                <div>
                                    <select class="form-control responsibility_user" id="supportive_responsibility_user"
                                        style="z-index: 1052;" name="supportive_responsibility[]" multiple="multiple">
                                        <option value="" disabled>--SELECT USER--</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add New Activities/Milestones</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- edit milestone modal --}}
    @if (!empty($project_datas))
        @foreach ($project_datas as $item)
            <div class="modal fade" id="editMilestoneModal-{{ $item->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1052;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Activity/Milestone
                                {{ $item->activity_milestone }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('internal.project.single.milestone.update') }}">
                                @csrf

                                <input type="hidden" name="internal_project_data_id" value="{{ $item->id }}">
                                <input type="hidden" name="internal_project_id" value="{{ $project->id }}">
                                <input type="hidden" name="fiscal_year" value="{{ $project->fiscal_year }}">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Activity/Milestone Name:<span class="text-danger">*</span></label>
                                        <input required list="activity_datalist" type="text" name="activity_milestone"
                                            class="form-control" placeholder="Activity/Milestone Name"
                                            value="{{ $item->activity_milestone }}">
                                    </div>
                                    <div class="form-group  col-md-12">
                                        <label>Is Subjective Timeline?<span class="text-danger">*</span></label>
                                        <select name="is_text" class="form-control" required>
                                            @if ($item->is_text == 'yes')
                                                <option value="yes" selected>Yes</option>
                                                <option value="no">No</option>
                                            @else
                                                <option value="yes">Yes</option>
                                                <option value="no" selected>No</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Approved Budget:<span class="text-danger">(optional)</span></label>
                                        <input type="text" name="approved_budget" class="form-control"
                                            placeholder="Approved Budget" value="{{ $item->approved_budget }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Performance Indicator:<span class="text-danger">(optional)</span></label>
                                        <input type="text" name="performance_indicator" class="form-control"
                                            placeholder="Performance Indicator"
                                            value="{{ $item->performance_indicator }}">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Main Responsibilities:<span class="text-danger">(optional)</span> </label>
                                        <div>
                                            @php
                                                $main_responsibility = $item->main_responsibility ?? [];
                                            @endphp
                                            <select class="form-control responsibility_user "
                                                id="main_responsibility_user" style="z-index: 1052;"
                                                name="main_responsibility[]" multiple="multiple">
                                                <option value="" disabled>--SELECT USER--</option>
                                                @foreach ($users as $user)
                                                    @if (in_array($user->id, $main_responsibility))
                                                        <option value="{{ $user->id }}" selected>
                                                            {{ $user->name }}</option>
                                                    @else
                                                        <option value="{{ $user->id }}">
                                                            {{ $user->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Supportive Responsibilities:<span class="text-danger">(optional)</span>
                                        </label>
                                        <div>
                                            @php
                                                $supportive_responsibility = $item->supportive_responsibility ?? [];
                                            @endphp
                                            <select class="form-control responsibility_user"
                                                id="supportive_responsibility_user" style="z-index: 1052;"
                                                name="supportive_responsibility[]" multiple="multiple">
                                                <option value="" disabled>--SELECT USER--</option>
                                                @foreach ($users as $user)
                                                    @if (in_array($user->id, $supportive_responsibility))
                                                        <option value="{{ $user->id }}" selected>
                                                            {{ $user->name }}</option>
                                                    @else
                                                        <option value="{{ $user->id }}">
                                                            {{ $user->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Activity/Milestone</button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection


@section('script')
    {{-- Responsibilities scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />



    <script>
        $(document).ready(function() {
            $('.responsibility_user').select2({
                closeOnSelect: true,
            });

            $('.clickable-box').click(function() {

                $(this).find("input").prop("checked", !$(this).find("input").prop("checked"));
                $(this).toggleClass('background-blue');

            });
            $("body").on("click", ".delete-milestone", function(e) {
                e.preventDefault();
                var target = this;
                if (confirm("Do you really want to delete this milestone ?")) {
                    $(target).closest("form").submit();
                }
            });


        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            function activateTabByRequest() {
                var tabID = "#activities_milestones"; //default tab
                @if (!empty(request('tab_selected')))
                    tabID = "{{ request('tab_selected') }}"
                @endif
                $('a[href="' + tabID + '"]').tab('show');
            }

            activateTabByRequest();


            $(".tdf_tab").on("click", function() {
                var tabValue = $(this).attr("href");
                if (tabValue != null) {
                    $("#tab_selected").val(tabValue);
                    $(".quater_tab_selected").val(tabValue);
                    //set url params for tab_selected
                    setGetParam("tab_selected", tabValue)

                }
                // console.log($("#tab_selected").val());
            });


            // https://stackoverflow.com/a/50861534
            function setGetParam(key, value) {
                if (history.pushState) {
                    var params = new URLSearchParams(window.location.search);
                    params.set(key, value);
                    var newUrl = window.location.origin +
                        window.location.pathname +
                        '?' + params.toString();
                    window.history.pushState({
                        path: newUrl
                    }, '', newUrl);
                }
            }


        });
    </script>
@endsection

@section('style')

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
            width: 20px;
        }
    </style>
    <style>
        .table .thead-blue th {
            color: #fff;
            background-color: #225e95;
            border-color: #588bb9;
        }

        .background-blue {
            background-color: #225e95 !important;
        }


        .select2-dropdown {
            z-index: 2054 !important;
        }

        .select2-container--default {
            width: 100% !important;
        }

        .select2-selection__choice {
            color: white !important;
            background: #2969a2 !important;
            font-size: 14px !important;
            padding: 5px 10px !important;
        }
    </style>


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
