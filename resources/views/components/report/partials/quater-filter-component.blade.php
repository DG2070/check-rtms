<div class="quality-filter-component">
    <div>
        <div class="row">
            <div class="col-12 col-md-4">
                <form action="">

                    @if (!empty(request('tab_selected')) && request('tab_selected') != '')
                        <input type="hidden" name="tab_selected" class="quater_tab_selected"
                            value="{{ request('tab_selected') }}">
                    @else
                        <input type="hidden" name="tab_selected" class="quater_tab_selected"
                            value="#activities_milestones">
                    @endif

                    @if (!empty(request('program')) && request('program') != '')
                        <input type="hidden" name="program" value="{{ request('program') }}">
                    @endif
                    @if (!empty(request('project')) && request('project') != '')
                        <input type="hidden" name="project" value="{{ request('project') }}">
                    @endif

                    @if (!empty(request('fiscal_year')) && request('fiscal_year') != '')
                        <input type="hidden" name="fiscal_year" value="{{ request('fiscal_year') }}">
                    @endif
                    @if (!empty(request('programID')) && request('programID') != '')
                        <input type="hidden" name="programID" value="{{ request('programID') }}">
                    @endif
                    @if (!empty(request('projectID')) && request('projectID') != '')
                        <input type="hidden" name="projectID" value="{{ request('projectID') }}">
                    @endif

                    <div class="form-group col-md-12 ">
                        <div class="d-flex align-items-center">
                            <div>
                                <label>Month Filter:</label>
                                <div style="min-width: 700px">
                                    <select   class="form-control report-month-filter" id="report-month-filter"
                                        name="selected_months[]" multiple="multiple">
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
                            <div class="ml-3 mt-2">
                                <label></label>
                                <button type="submit" class="btn btn-primary btn-tdf-primary tdf-border-small">
                                    Filter
                                </button>

                            </div>
                            <div class="ml-2 mt-2">
                                <label></label>
                                <div class="btn btn-primary btn-dark reset_quater_filters tdf-border-small" id="reset_quater_filters">
                                    Reset
                                </div>
                            </div>
                        </div>
                    </div>


                </form>

            </div>
        </div>

    </div>
</div>


@push('script')
    <script></script>
@endpush
