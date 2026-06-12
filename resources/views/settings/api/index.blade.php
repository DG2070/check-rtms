@extends('layouts.app')
@section('title', 'User Management')
@section('content')

    {{-- breadcrumb section --}}
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            Home
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        Settings
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Api
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- !ENDS breadcrumb section --}}

    <div class="role-container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-body ">
                        <div class="h6">
                            Manually Sync All TDF Data ( programs/projects)
                        </div>
                        <div class="mb-3">
                            <a href="{{ route('settings.api.fetch.tdf-data') }}" class="btn btn-primary btn-tdf-primary">
                                Start Sync
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body ">
                        <div class="h6">
                            Manually Sync All Disbursement Data (MIS)
                        </div>
                        <div class="mb-3">
                            <a href="{{ route('settings.api.fetch.disbursement-data') }}"
                                class="btn btn-primary btn-tdf-primary">
                                Sync All Disbursement Data
                            </a>
                            {{-- <button class="btn btn-primary btn-tdf-primary" id="sync_all_disbursement_data">
                                Sync All Disbursement Data
                            </button>
                            <div class="spinner-border mt-2  " role="status" id="sync_all_disbursement_data-spinner"
                                style="display: none">
                                <span class="sr-only">Loading...</span>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.27.2/axios.min.js"></script>

    <script>
        $("#sync_all_disbursement_data").on("click", function() {
                    console.log("Sad");
                    $(this).hide()
                    $("#sync_all_disbursement_data-spinner").show()
                    $("#sync_all_disbursement_data-spinner").css({
                        display: "block !important"
                    });

                    axios.get(
                        'http://tdf.softavi.com/api/tdf_data/getTdfData?username=tdf_apiuser&password=tdF@piUs3r2o22', {
                            params: {
                                ID: 12345
                            }
                        })
                        .then(function(response) {
                            console.log(response);
                        });

                    //     $.get("http://tdf.softavi.com/api/tdf_data/getTdfData?username=tdf_apiuser&password=tdF@piUs3r2o22",
                    //         function(data, status) {
                    //             console.log(data);
                    //         });
                    });
    </script>
@endpush
