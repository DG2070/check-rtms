<div class="home-filter-section mt-0 pt-0">

    <form action="">
        <div class="">
            <div class="row justify-content-start">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Fiscal Year</label>
                        <select id="dashboard_filter_year_select"
                            class="form-control tdf-border-small select2 dashboard_filter_select2" disabled>

                            <option value="" disabled>--Select Fiscal Year--</option>


                            @php
                                $currentFiscalYear = App\Helper\FiscalYear::curentFiscalYear();
                            @endphp
                            <option value="{{ $currentFiscalYear }}" selected}>
                                {{ '20' . $currentFiscalYear }}
                            </option>

                            {{-- @php
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
                            @foreach ($fiscalYears ?? [] as $fiscalYear)
                                <option value="{{ $fiscalYear }}"
                                    {{ !empty(request()->fiscal_year) && request()->fiscal_year == $fiscalYear ? 'selected' : '' }}
                                    {{ empty(request()->fiscal_year) && $currentFiscalYear == $fiscalYear ? 'selected' : '' }}>
                                    {{ '20' . $fiscalYear }}
                                </option>
                            @endforeach --}}
                        </select>


                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Province</label>
                        <select id="dashboard_filter_province_select"
                            class="form-control tdf-border-small  select2 dashboard_filter_select2 ">
                            <option value="" selected disabled>Select Province</option>
                            @if (!empty($province))
                                @foreach ($province as $pro)
                                    <option value="{{ $pro['id'] }}">{{ $pro['ename'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-md-2" id="dashboard_filter_district_select--col">
                    <div class="form-group">
                        <label class="d-block">District</label>
                        <select id="dashboard_filter_district_select"
                            class="form-control tdf-border-small select2 dashboard_filter_select2">
                            <option value="" selected disabled>Select District </option>
                            @if (!empty($locations))
                                @foreach ($locations as $location)
                                    <option value="{{ $location['District'] }}">
                                        {{ $location['District'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label class="d-block">&nbsp;</label>
                        <a href="{{ route('home') }}" class="btn btn-danger  ml-2 tdf-border-small">Reset</a>
                    </div>
                </div>

                {{-- <div class="col-md-2">
                <div class="form-group">
                    <label>Town</label>
                    <select id="dashboard_filter_town_select" class="form-control select2 dashboard_filter_select2">
                        <option value="" selected disabled>Select Town</option>
                        @if (!empty($locations))
                            @foreach ($locations as $location)
                                <option value="{{ $location['TownName'] }}">
                                    {{ $location['TownName'] }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div> --}}
                {{-- <div class="col-md-2">
                    <div class="form-group">
                        <label>Agency</label>
                        <select id="dashboard_filter_agency_select"
                            class="form-control select2 dashboard_filter_select2">
                            <option value="" selected disabled>Select Agency</option>
                            @if (!empty($financing_agencies))

                                @foreach ($financing_agencies as $financing_agency)
                                    <option value="{{ $financing_agency['FinancingAgency'] }}">
                                        {{ $financing_agency['FinancingAgency'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div> --}}

                {{-- <div class="col-md-3">
                    <div class="form-group">
                        <label class="d-block">&nbsp;</label>
                        <a href="{{ route('home') }}" class="btn btn-danger rounded-0 ml-2">Clear</a>
                    </div>
                </div> --}}
            </div>
        </div>
    </form>


</div>
