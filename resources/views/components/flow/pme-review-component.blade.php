<div>
    @if (!empty($program) && $program->project && count($program->project) > 0)

        @php
            $quaterfilter = new App\Helper\QuaterFilter();
        @endphp
        {{-- quater filter --}}
        <x-report.partials.quater-filter-component />
        {{-- !ENDS quater filter --}}

        <form method="POST" action="{{ route('project.milestone.review.store', $projectId) }}">
            @csrf
            <input type="hidden" name="fiscal_year" value="{{ $fiscalYear }}">
            <table border="1" class="table table-responsive custom-table tdf-table-primary" style="text-align: left; ">
                <thead>
                    <tr>
                        <th colspan="{{ 7 + 12 + 4 + 4 + 3 }}" class="text-center">
                            Town Development Fund <br>
                            Progress of Performance Monitoring Framework (PPMF) <br>
                            {{ $program->NameLong }} <br>
                            FY 20{{ $fiscalYear }} <br>
                        </th>
                    </tr>
                    <tr>
                        <th rowspan="3">Project Name</th>
                        <th colspan="2">Project status as of the end of FY
                            20{{ App\Helper\FiscalYear::previousFYFromGivenFY($fiscalYear) }}</th>
                        <th rowspan="3">Approved Budget FY 20{{ $fiscalYear }}</th>
                        <th rowspan="3">Main Activities (Total: target of this year)</th>
                        <th rowspan="3" colspan="2">Milestones</th>
                        <th colspan="{{ 4 + $quaterfilter->allQuaterCount() }}" style="text-align: center">
                            Timeline
                        </th>
                        <th rowspan="3">Performance Indicators</th>
                        <th rowspan="3">Progress</th>
                        <th colspan="2">PME Review</th>
                        <th colspan="2">Responsibility</th>
                        <th rowspan="3">PME Remarks</th>
                        {{-- <th rowspan="3" class="align-middle text-center">Attachment</th> --}}
                    </tr>

                    <tr>
                        <th rowspan="2">Physical</th>
                        <th rowspan="2">Financial</th>
                        @if ($quaterfilter->firstQuaterCount() > 0)
                            <th colspan="{{ $quaterfilter->firstQuaterCount() }}">1st Quarter </th>
                        @endif
                        @if ($quaterfilter->secondQuaterCount() > 0)
                            <th colspan="{{ $quaterfilter->secondQuaterCount() }}">2nd Quarter </th>
                        @endif
                        @if ($quaterfilter->thirdQuaterCount() > 0)
                            <th colspan="{{ $quaterfilter->thirdQuaterCount() }}">3rd Quarter </th>
                        @endif
                        @if ($quaterfilter->fourthQuaterCount() > 0)
                            <th colspan="{{ $quaterfilter->fourthQuaterCount() }}">4th Quarter </th>
                        @endif
                        <th colspan="4">Total </th>
                        <th rowspan="2">Achived</th>
                        <th rowspan="2">Not Achived</th>
                        <th rowspan="2">Main Responsibility</th>
                        <th rowspan="2">Supportive Responsibility</th>
                    </tr>

                    <tr>
                        @if (in_array(1, $quaterfilter->showMonths()))
                            <th>1</th>
                        @endif
                        @if (in_array(2, $quaterfilter->showMonths()))
                            <th>2</th>
                        @endif
                        @if (in_array(3, $quaterfilter->showMonths()))
                            <th>3</th>
                        @endif
                        @if (in_array(4, $quaterfilter->showMonths()))
                            <th>1</th>
                        @endif
                        @if (in_array(5, $quaterfilter->showMonths()))
                            <th>2</th>
                        @endif
                        @if (in_array(6, $quaterfilter->showMonths()))
                            <th>3</th>
                        @endif
                        @if (in_array(7, $quaterfilter->showMonths()))
                            <th>1</th>
                        @endif
                        @if (in_array(8, $quaterfilter->showMonths()))
                            <th>2</th>
                        @endif
                        @if (in_array(9, $quaterfilter->showMonths()))
                            <th>3</th>
                        @endif
                        @if (in_array(10, $quaterfilter->showMonths()))
                            <th>1</th>
                        @endif
                        @if (in_array(11, $quaterfilter->showMonths()))
                            <th>2</th>
                        @endif
                        @if (in_array(12, $quaterfilter->showMonths()))
                            <th>3</th>
                        @endif
                        <th>FT</th>
                        <th>FP</th>
                        <th>PT</th>
                        <th>PP</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $counter = 1;
                    @endphp
                     @foreach ($program->project as $pro_key => $project)
                        @php
                            $totalRows = 0;
                            foreach ($project->projectActivity as $pa) {
                                foreach ($pa->milestone as $m) {
                                    if (strtolower(trim($m->milestone)) == 'disbursement target') {
                                        $totalRows += 4;
                                    } else {
                                        $totalRows += 3;
                                    }
                                }
                            }
                        @endphp
                        @foreach ($project->projectActivity as $key => $pro_act)
                            @php
                                $actRows = 0;
                                foreach ($pro_act->milestone as $m) {
                                    if (strtolower(trim($m->milestone)) == 'disbursement target') {
                                        $actRows += 4;
                                    } else {
                                        $actRows += 3;
                                    }
                                }
                            @endphp
                            @foreach ($pro_act->milestone as $key2 => $mile)
                                @php
                                    $mileRows = strtolower(trim($mile->milestone)) == 'disbursement target' ? 4 : 3;
                                    $isDisbTarget = strtolower(trim($mile->milestone)) == 'disbursement target';
                                @endphp
                                <tr
                                    style=" background:  @if ($counter % 2 == 0) #efefef  @else #fff @endif ">
                                    @if ($key == 0 && $key2 == 0)
                                        <td rowspan="{{ $totalRows }}">{{ $project->Name }} [
                                            {{ $project->TownName }} ]</td>
                                        <td rowspan="{{ $totalRows }}" class="text-center">
                                            {{ isset($project->projectDataSQ[0]->physical_progress) ? $project->projectDataSQ[0]->physical_progress . '%' : 'NA' }}
                                        </td>
                                        <td rowspan="{{ $totalRows }}" class="text-center">
                                            {{ \App\Helper\DisbursementFilter::totalDisbursementForProjectAsOfYear('20' . App\Helper\FiscalYear::previousFYFromGivenFY($fiscalYear), $project->programID, $project->projectID) }}
                                        </td>
                                        {{-- Approved Budget FY --}}
                                        <td rowspan="{{ $totalRows }}" class="text-center">
                                            {{ isset($project->projectDataSQ[0]->approved_budget) ? $project->projectDataSQ[0]->approved_budget : 'NA' }}
                                        </td>
                                    @endif

                                    @if ($key2 == 0)
                                        <td rowspan="{{ $actRows }}" class="">
                                            {{ $pro_act->activity }}</td>
                                    @endif

                                    <td rowspan="{{ $mileRows }}" class=" text-left"
                                        style="min-width: 200px;max-width: 200px;padding: 0px !important; padding-left:10px!important;@if ($key2 % 2 == 0) background: aliceblue; @endif">
                                        {{ $mile->milestone }}
                                    </td>

                                    <td @if ($key2 % 2 == 0) style="background: aliceblue;" @endif>
                                        T
                                    </td>

                                    {{-- timeline for target --}}
                                    @if ($mile->timeline)
                                        @foreach ($mile->timeline->timeline ?? [] as $timeline_month => $time)
                                            @if (in_array($timeline_month, $quaterfilter->showMonths()))
                                                @if ($mile->is_text == 'yes')
                                                    <td style="{{ $key2 % 2 == 0 ? 'background: aliceblue;' : '' }}">
                                                        {{ $time }}
                                                    </td>
                                                @else
                                                    <td style="{{ $key2 % 2 == 0 ? 'background: aliceblue;' : '' }}">
                                                        @if ($time)
                                                            <div class="tdf-progress-input-target-box--small">
                                                            </div>
                                                        @endif
                                                    </td>
                                                @endif
                                            @endif
                                        @endforeach
                                    @else
                                        @for ($i = 0; $i < 12; $i++)
                                            @if (in_array($i, $quaterfilter->showMonths()))
                                                <td style="{{ $key2 % 2 == 0 ? 'background: aliceblue;' : '' }}">
                                                </td>
                                            @endif
                                        @endfor
                                    @endif
                                    {{-- !ENDS timeline for target --}}

                                    @if ($key == 0 && $key2 == 0)
                                        @php
                                            $ft_fp_pt_pp = \App\Helper\FlowProjectMilestone::calculateTargetAndProgressFromMilestone($pro_act->milestone, $quaterfilter->showMonths());
                                        @endphp

                                        {{-- FT --}}
                                        <td rowspan="{{ $totalRows }}">
                                            {{ $ft_fp_pt_pp['financial_target'] == 0 ? 'NA' : $ft_fp_pt_pp['financial_target'] }}
                                        </td>
                                        {{-- FP --}}
                                        <td rowspan="{{ $totalRows }}">
                                            {{ $ft_fp_pt_pp['financial_progress'] == 0 ? 'NA' : $ft_fp_pt_pp['financial_progress'] }}
                                        </td>
                                        {{-- PT --}}
                                        <td rowspan="{{ $totalRows }}">
                                            {{ $ft_fp_pt_pp['physical_target'] == 0 ? 'NA' : $ft_fp_pt_pp['physical_target'] }}
                                        </td>
                                        {{-- PP --}}
                                        <td rowspan="{{ $totalRows }}">
                                            {{ $ft_fp_pt_pp['physical_progress'] == 0 ? 'NA' : $ft_fp_pt_pp['physical_progress'] }}
                                        </td>
                                    @endif

                                    {{-- performance_indicator --}}

                                    <td rowspan="{{ $mileRows }}" class=" text-left" style="min-width: 100px;max-width: 100px">
                                        {{ $mile->performance_indicator }}</td>
                                    <td rowspan="{{ $mileRows }}" class=" text-left" style="min-width: 100px;max-width: 100px">
                                        {{ $mile->remark }}</td>

                                    @php
                                        $achived = false;
                                        $not_achived = false;
                                        if (isset($project->projectReview->target[$mile->id])) {
                                            if ($project->projectReview->target[$mile->id] == 'achived') {
                                                $achived = true;
                                            }
                                            if ($project->projectReview->target[$mile->id] == 'not_achived') {
                                                $not_achived = true;
                                            }
                                        }
                                        
                                    @endphp

                                    <td rowspan="{{ $mileRows }}">
                                        <input class="pme_radio_input" id="achived_pme_radio_input_{{ $mile->id }}"
                                            data-milestone-id="{{ $mile->id }}" type="radio"
                                            name="target[{{ $mile->id }}]" value="achived"
                                            data-is-checked="{{ $achived ? 'true' : 'false' }}"
                                            {{ $achived ? 'checked' : '' }}>
                                    </td>
                                    <td rowspan="{{ $mileRows }}">
                                        <input class="pme_radio_input"
                                            id="not_achived_pme_radio_input_{{ $mile->id }}"
                                            data-milestone-id="{{ $mile->id }}" type="radio"
                                            name="target[{{ $mile->id }}]" value="not_achived"
                                            data-is-checked="{{ $not_achived ? 'true' : 'false' }}"
                                            {{ $not_achived ? 'checked' : '' }}>
                                    </td>

                                    @if ($key2 == 0)
                                        <td rowspan="{{ $actRows }}" class="">
                                            <div class="d-flex flex-wrap">
                                                @foreach (\App\Models\User::whereIn('id', $pro_act->main_responsibility ?? [])->get() as $user)
                                                    <div>
                                                        {{ $user->name }}
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td rowspan="{{ $actRows }}" class="">
                                            <div class="d-flex flex-wrap">
                                                @foreach (\App\Models\User::whereIn('id', $pro_act->supportive_responsibility ?? [])->get() as $user)
                                                    <div>
                                                        {{ $user->name }}
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    @endif
                                    <td rowspan="{{ $mileRows }}">
                                        <textarea name="remarks[{{ $mile->id }}]">{{ $project->projectReview->remarks[$mile->id] ?? '' }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td @if ($key2 % 2 == 0) style="background: aliceblue;" @endif>
                                        {{ $isDisbTarget ? 'P (Loan)' : 'P' }}
                                    </td>
                                    {{-- timeline  for progress --}}
                                    @if ($mile->timeline)
                                        @foreach ($mile->timeline->timeline ?? [] as $timeline_month => $time)
                                            @if (in_array($timeline_month, $quaterfilter->showMonths()))
                                                @if ($mile->is_text == 'yes')
                                                    <td style="{{ $key2 % 2 == 0 ? 'background: aliceblue;' : '' }}">
                                                        {{ $mile->timeline->progress_input_data[$loop->index + 1] ?? '' }}
                                                    </td>
                                                @else
                                                    <td style="{{ $key2 % 2 == 0 ? 'background: aliceblue;' : '' }}">
                                                        <input
                                                            style="min-width: 25px;height: 25px;padding: 0px !important"
                                                            class="form-control p-0 {{ isset($mile->timeline->progress_input_data[$loop->index + 1]) && $mile->timeline->progress_input_data[$loop->index + 1] == 1 ? '' : 'd-none' }}"
                                                            type="checkbox" readonly onclick="return false;"
                                                            {{ isset($mile->timeline->progress_input_data[$loop->index + 1]) && $mile->timeline->progress_input_data[$loop->index + 1] == 1 ? 'checked' : '' }}
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="{{ isset($mile->timeline->remarks[$loop->index + 1]) ? $mile->timeline->remarks[$loop->index + 1] : '' }}">
                                                    </td>
                                                @endif
                                            @endif
                                        @endforeach
                                    @else
                                        @for ($i = 0; $i < 12; $i++)
                                            @if (in_array($i, $quaterfilter->showMonths()))
                                                <td style="{{ $key2 % 2 == 0 ? 'background: aliceblue;' : '' }}">
                                                </td>
                                            @endif
                                        @endfor
                                    @endif
                                    {{-- !ENDS timeline for progress --}}
                                </tr>

                                @if($isDisbTarget)
                                @php
                                    $disbursement_data_by_month_g = \App\Helper\DisbursementFilter::disbursementsForProjectByFiscialYearG( "20".$fiscalYear, $project->programID, $project->projectID);
                                @endphp
                                <tr>
                                    <td @if ($key2 % 2 == 0) style="background: aliceblue;" @endif>
                                        P (Grant)
                                    </td>
                                    @for ($i = 0; $i < 12; $i++)
                                        @if (in_array(array_keys($disbursement_data_by_month_g)[$i], $quaterfilter->showMonths()))
                                            <td style="{{ $key2 % 2 == 0 ? 'background: aliceblue;' : '' }}">
                                                {{ $disbursement_data_by_month_g[array_keys($disbursement_data_by_month_g)[$i]] ?: '' }}
                                            </td>
                                        @endif
                                    @endfor
                                </tr>
                                @endif

                                <tr>
                                    <td @if ($key2 % 2 == 0) style="background: aliceblue;" @endif>
                                        R
                                    </td>
                                    {{-- timeline  for remarks --}}
                                    @if ($mile->timeline)
                                        @foreach ($mile->timeline->timeline ?? [] as $timeline_month => $time)
                                            @if (in_array($timeline_month, $quaterfilter->showMonths()))
                                                <td style="{{ $key2 % 2 == 0 ? 'background: aliceblue;' : '' }}">
                                                    @php
                                                        $remarks_data = '';
                                                        if (isset($mile->timeline->remarks[$loop->index + 1])) {
                                                            $remarks_data = $mile->timeline->remarks[$loop->index + 1];
                                                        }
                                                        
                                                    @endphp
                                                    @if ($remarks_data != '')
                                                        <div class="text-canter" data-toggle="tooltip"
                                                            data-placement="top" title="{{ $remarks_data }}">
                                                            <button type="button"
                                                                class="btn btn-primary tdf-border-small"
                                                                data-toggle="modal"
                                                                data-target="#remarks-modal-{{ $mile->id }}-{{ $loop->index + 1 }}">
                                                                <i class="nav-icon fas fa-book"></i>
                                                            </button>
                                                        </div>
                                                        {{-- remarks modal --}}
                                                        <div class="modal fade"
                                                            id="remarks-modal-{{ $mile->id }}-{{ $loop->index + 1 }}"
                                                            tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">
                                                                            Remark</h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="">
                                                                            <input type="hidden"
                                                                                value="dont_remove_for_form_to_work">
                                                                        </form>
                                                                        <div class="row">
                                                                            <div class="form-group col-md-12">
                                                                                <textarea disabled name="remark" class="form-control" rows="15">{{ $remarks_data }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- !ENDS remarks modal --}}
                                                    @endif
                                                </td>
                                            @endif
                                        @endforeach
                                    @else
                                        @for ($i = 0; $i < 12; $i++)
                                            @if (in_array($i, $quaterfilter->showMonths()))
                                                <td style="{{ $key2 % 2 == 0 ? 'background: aliceblue;' : '' }}">
                                                </td>
                                            @endif
                                        @endfor
                                    @endif
                                    {{-- !ENDS timeline for remarks --}}
                                </tr>
                            @endforeach
                        @endforeach
                        @php
                            $counter++;
                        @endphp
                    @endforeach
                </tbody>
            </table>

            <div
                style="display:flex; gap: 10px; align-items: flex-end; justify-content: flex-end; width: 95%; margin:auto">
                <button class="btn btn-lg btn-primary" type="submit">Update PME Review</button>
            </div>
        </form>
        <style>
            .custom-table {
                border: none;
                text-align: center;
                border-spacing: 0 !important;
            }

            .custom-table thead {
                background-color: #2767a0;
            }

            .custom-table thead>tr>th {
                color: #fff;
                border: 1px solid #fff !important;
                /* padding: 15px; */
                ;
            }

            .custom-table thead>tr>th span {
                padding: .9375rem;
                display: block;
            }

            .custom-table thead>tr>th>table {
                width: 100%;
            }

            .custom-table tbody>tr>td {
                border: 1px solid #e1e1e1 !important;
                /* padding: 15px; */
                ;
            }

            .custom-table tbody>tr>td.bg-select {
                background-color: green;
                color: #fff;
            }

            .custom-table tbody>tr>td.bg-success {
                background-color: green !important;
                color: #fff;
            }
        </style>
    @endif
</div>
