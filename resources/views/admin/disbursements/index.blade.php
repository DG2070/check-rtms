@extends('layouts.app')

@section('title', 'disbursements')

@include('layouts.includes.data-table.style')

@section('content')
    {{-- breadcrumb section --}}
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Disbursements
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- !ENDS breadcrumb section --}}


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <div class="search-container home-search-container mb-4">
        <form action="" method="GET">
            <div class="row no-gutters align-items-center">
                <div class="col col-md-12">
                    <input required name="search_query" class="form-control border-secondary rounded-pill pr-5"
                        type="Search" placeholder="Search" id="disbursement_search"
                        @if (!empty(request('search_query')) && request('search_query') != '') value="{{ request('search_query') }}"@else @endif>
                </div>
                <div class="col-auto">
                    <button id="disbursement_search_button"
                        class="btn btn-outline-light text-dark border-0 rounded-pill ml-n5" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>


    <div class="card shadow-lg border-0">
        <div class="card-body table-card-body table-responsive">
            <div class="h6">
                Total Listed : {{ count($disbursements ?? 0) }}
            </div>
            <table id="example 2" class="table table-hover">
                <thead>
                    <tr>
                        <th>ActivityID</th>
                        <th>Date</th>
                        <th>Code</th>
                        <th>ProjectName</th>

                        <th>Amount</th>
                        <th>Balance</th>
                        <th>Name</th>
                        <th>TownName</th>

                        <th>IsDisbursement</th>
                        <th>TransactionTypeID</th>
                        <th>PaymentType</th>
                        <th>IsRepayment</th>

                        <th>IsIntCap</th>
                        <th>MicrobankTransactionType</th>
                        <th>SN</th>
                        <th>nepali_year</th>
                        <th>nepali_month</th>

                        <th>nepali_day</th>

                    </tr>
                </thead>
                <tbody>

                    @if (!empty($disbursements))

                        @foreach ($disbursements as $disbursement)
                            <tr>
                                <td>{{ $disbursement->ActivityID }}</td>
                                <td>{{ $disbursement->Date }}</td>
                                <td>{{ $disbursement->Code }}</td>
                                <td>{{ $disbursement->ProjectName }}</td>

                                <td>{{ $disbursement->Amount }}</td>
                                <td>{{ $disbursement->Balance }}</td>
                                <td>{{ $disbursement->Name }}</td>
                                <td>{{ $disbursement->TownName }}</td>

                                <td>{{ $disbursement->IsDisbursement }}</td>
                                <td>{{ $disbursement->TransactionTypeID }}</td>
                                <td>{{ $disbursement->PaymentType }}</td>
                                <td>{{ $disbursement->IsRepayment }}</td>

                                <td>{{ $disbursement->IsIntCap }}</td>
                                <td>{{ $disbursement->MicrobankTransactionType }}</td>
                                <td>{{ $disbursement->SN }}</td>
                                <td>{{ $disbursement->nepali_year }}</td>

                                <td>{{ $disbursement->nepali_month }}</td>
                                <td>{{ $disbursement->nepali_day }}</td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-4">
                @if (!empty($disbursements))
                    {!! $disbursements->links() !!}
                @endif
            </div>

        </div>
    </div>

    @include('layouts.includes.data-table.script')

@endsection
