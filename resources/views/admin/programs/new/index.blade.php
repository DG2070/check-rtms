@extends('layouts.app')

@section('title', 'New Program')

@section('content')


    {{-- breadcrumb section --}}
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    @if ($program_name != '')
                        <li class="breadcrumb-item"><a
                                href="{{ route('projects.index', ['program' => $selectedProgramId]) }}">
                                {{ $program_name }}
                            </a></li>
                    @endif
                    @if ($project_name != '')
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $project_name }}
                        </li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>
    {{-- !ENDS breadcrumb section --}}

    @include('layouts.includes.errors')


    <div style="background: #EDEFF2; padding: 30px;">

        {{-- controls --}}
        @include('admin.programs.new.partials.controls')
        {{-- !ENDS controls --}}

        {{-- content --}}
        @if (!empty(request('programID')) && !empty(request('projectID')))
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
                                    @include('admin.programs.new.partials.tabs-head')
                                </ul>
                            </div>

                            <div class="tab-content" id="newProgramTabsContent">
                                @include('admin.programs.new.partials.tabs-content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- ! content --}}

    </div>


    @include('layouts.includes.data-table.script')

@endsection


@push('css')
    @include('admin.programs.new.partials.css')
    <link rel="stylesheet" href="{{ asset('/plugins/expand-fullscreen-largetable/largetable.css') }}">
@endpush
@push('script')
    @include('admin.programs.new.partials.js')
    <script src="{{ asset('/plugins/expand-fullscreen-largetable/largetable.js') }}"></script>
@endpush

@push('modal')
    {{-- create new program modal --}}
    <div class="modal fade" id="createNewProgramModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="z-index: 1052;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Program</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('programs.store') }}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Fiscal Year: <span class="text-danger">*</span></label>
                                <input type="text" name="fiscal_year" class="form-control " readonly value="79/80" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Program Name: <span class="text-danger">*</span></label>
                                <input type="text" name="Name" placeholder="eg:TDP 1, TDP 2, GTZ, UEIP"
                                    class="form-control" required />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Name Long: <span class="text-danger">*</span></label>
                                <input type="text" name="NameLong"
                                    placeholder="eg:Town Development Program - Phase 1, District Health Project, Urban and Environmental Improvement Project - Phase 1"
                                    class="form-control" required />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Code: </label>
                                <input type="text" name="Code" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Financing Agency: </label>
                                <input type="text" name="FinancingAgency" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Date Of Agreement Adjustment: </label>
                                <input type="text" name="DateOfAgreementAdjustment" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Fund Loan: </label>
                                <input type="text" name="FundLoan" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Fund Soft Loan: </label>
                                <input type="text" name="FundSoftLoan" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Fund Grant: </label>
                                <input type="text" name="FundGrant" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Interest For Administration: </label>
                                <input type="text" name="InterestForAdministration" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Service Charge Study: </label>
                                <input type="text" name="ServiceChargeStudy" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Service Charge Construction: </label>
                                <input type="text" name="ServiceChargeConstruction" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Service Charge Supervision: </label>
                                <input type="text" name="ServiceChargeSupervision" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Date Of Financing Agreement: </label>
                                <input type="text" name="DateOfFinancingAgreement" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Date Of Funds Disbursed: </label>
                                <input type="text" name="DateOfFundsDisbursed" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Programme Interest: </label>
                                <input type="text" name="ProgrammeInterest" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Programme Capitalisation: </label>
                                <input type="text" name="ProgrammeCapitalisation" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Programme Maturity: </label>
                                <input type="text" name="ProgrammeMaturity" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Programme Constant Annuity: </label>
                                <input type="text" name="ProgrammeConstantAnnuity" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Programme Grace Period: </label>
                                <input type="text" name="ProgrammeGracePeriod" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Loan Activity Interest: </label>
                                <input type="text" name="LoanActivityInterest" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Loan Activity Capitalisation: </label>
                                <input type="text" name="LoanActivityCapitalisation" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Loan Activity Maturity Min: </label>
                                <input type="text" name="LoanActivityMaturityMin" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Loan Activity Maturity Max: </label>
                                <input type="text" name="LoanActivityMaturityMax" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Loan Activity Constant Annuity: </label>
                                <input type="text" name="LoanActivityConstantAnnuity" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Loan Activity Grace Period Min: </label>
                                <input type="text" name="LoanActivityGracePeriodMin" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">LoanActivity Grace Period Max: </label>
                                <input type="text" name="LoanActivityGracePeriodMax" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">SoftLoanActivityInterest: </label>
                                <input type="text" name="SoftLoanActivityInterest" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">SoftLoanActivityCapitalisation: </label>
                                <input type="text" name="SoftLoanActivityCapitalisation" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">SoftLoanActivityMaturityMin: </label>
                                <input type="text" name="SoftLoanActivityMaturityMin" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">SoftLoanActivityMaturityMax: </label>
                                <input type="text" name="SoftLoanActivityMaturityMax" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">SoftLoanActivityConstantAnnuity: </label>
                                <input type="text" name="SoftLoanActivityConstantAnnuity" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">SoftLoanActivityGracePeriodMin: </label>
                                <input type="text" name="SoftLoanActivityGracePeriodMin" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">SoftLoanActivityGracePeriodMax: </label>
                                <input type="text" name="SoftLoanActivityGracePeriodMax" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">ProgrammePeriod: </label>
                                <input type="text" name="ProgrammePeriod" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">ProgrammeFundAllocation: </label>
                                <input type="text" name="ProgrammeFundAllocation" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">FundsAllocatedInForeignCurrency: </label>
                                <input type="text" name="FundsAllocatedInForeignCurrency" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">FundsAllocatedInLocalCurrency: </label>
                                <input type="text" name="FundsAllocatedInLocalCurrency" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">ProgrammeFundAllocationStructure: </label>
                                <input type="text" name="ProgrammeFundAllocationStructure" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">FundsAllocatedAsGrantsInLocalCurrency: </label>
                                <input type="text" name="FundsAllocatedAsGrantsInLocalCurrency"
                                    class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">ProgrammeFundUtilizationStructure: </label>
                                <input type="text" name="ProgrammeFundUtilizationStructure" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">TdfLoansForConstructionActivities: </label>
                                <input type="text" name="TdfLoansForConstructionActivities" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">TdfSoftLoansForConstructionActivities: </label>
                                <input type="text" name="TdfSoftLoansForConstructionActivities"
                                    class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">TdfGrantsForConstructionActivities: </label>
                                <input type="text" name="TdfGrantsForConstructionActivities" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">LossProvisionForTdfLoans: </label>
                                <input type="text" name="LossProvisionForTdfLoans" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Loaninstallments: </label>
                                <input type="text" name="Loaninstallments" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Softloaninstallments: </label>
                                <input type="text" name="Softloaninstallments" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Currency: </label>
                                <input type="text" name="Currency" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">TemplateID: </label>
                                <input type="text" name="TemplateID" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">grantfund: </label>
                                <input type="text" name="grantfund" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">studygrantfund: </label>
                                <input type="text" name="studygrantfund" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">supervisiongrantfund: </label>
                                <input type="text" name="supervisiongrantfund" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">constructiongrantfund: </label>
                                <input type="text" name="constructiongrantfund" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">loanfund: </label>
                                <input type="text" name="loanfund" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">softloanfund: </label>
                                <input type="text" name="softloanfund" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">CreatedDate: </label>
                                <input type="text" name="CreatedDate" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">UpdatedDate: </label>
                                <input type="text" name="UpdatedDate" class="form-control" />
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Program</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    {{-- create new project modal --}}
    <div class="modal fade" id="createNewProjectModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1052;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('projects.store') }}">
                        @csrf
                        <input type="hidden" id="new_project_programid_modal-f" name="programID" required>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Fiscal Year: <span class="text-danger">*</span></label>
                                <input type="text" name="fiscal_year" class="form-control " readonly
                                    value="79/80" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Project Name: <span class="text-danger">*</span></label>
                                <input type="text" name="Name"
                                    placeholder="eg:JanaJukta Secondary School, Barun Campus Extension,Public Toilet at Hat Bazar"
                                    class="form-control" required />
                            </div>

                            <div class="form-group col-md-12">
                                <label for="usr">Town Name: <span class="text-danger">*</span></label>
                                <select class="form-control select2" name="townID" required style="z-index: 1052;">
                                    <option value="" disabled>--SELECT TOWN--</option>
                                    @foreach ($townlists as $townlist)
                                        <option value="{{ $townlist->ID }}">
                                            {{ $townlist->TownName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="usr">Specification: </label>
                                <input type="text" name="Specification" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Initial Talks Held With Client About Project Ideas: </label>
                                <input type="text" name="InitialTalksHeldWithClientAboutProjectIdeas"
                                    class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Client Consulted In Project Identification Selection: </label>
                                <input type="text" name="ClientConsultedInProjectIdentificationSelection"
                                    class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Client Provided With Standard Set Of Documents: </label>
                                <input type="text" name="ClientProvidedWithStandardSetOfDocuments"
                                    class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Request For Financing Incl Study Received Or Assessed: </label>
                                <input type="text" name="RequestForFinancingInclStudyReceivedOrAssessed"
                                    class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Budget Estimate For Study Cost: </label>
                                <input type="text" name="BudgetEstimateForStudyCost" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Date Of Application Received: </label>
                                <input type="text" name="DateOfApplicationReceived" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">First StField Visit Implemented If Required: </label>
                                <input type="text" name="FirstStFieldVisitImplementedIfRequired"
                                    class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Pre Appraisal Report Initiated: </label>
                                <input type="text" name="PreAppraisalReportInitiated" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Client Debt Bearing Capacity Assessed: </label>
                                <input type="text" name="ClientDebtBearingCapacityAssessed" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Client On Conditions Of Financing Of Study Adviced: </label>
                                <input type="text" name="ClientOnConditionsOfFinancingOfStudyAdviced"
                                    class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Pre Appraisal Completed: </label>
                                <input type="text" name="PreAppraisalCompleted" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Date Of Application Confirmed: </label>
                                <input type="text" name="DateOfApplicationConfirmed" class="form-control" />
                            </div>
                            <div class="form-group col-md-12">
                                <label for="usr">Date Of Project Stop: </label>
                                <input type="text" name="DateOfProjectStop" class="form-control" />
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
@endpush
