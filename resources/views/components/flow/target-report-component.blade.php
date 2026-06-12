<div>
    @if ($program && $program->project && count($program->project) > 0)

        @php
            $quaterfilter = new App\Helper\QuaterFilter();
        @endphp

        {{-- quater filter --}}
        <x-report.partials.quater-filter-component />
        {{-- !ENDS quater filter --}}

        <table border="1" class="table table-responsive custom-table fullscreen_table tdf-table-primary"
            style="text-align: left;" id="report_table">
            <thead>
                <tr>
                    <th colspan="{{ 7 + 12 + 4 + 4 }}" class="text-center">
                        Town Development Fund <br>
                        Target of Performance Monitoring Framework (TPMF) <br>
                        {{ $program->NameLong }} <br>
                        FY 20{{ $fiscalYear }}<br>
                    </th>
                </tr>
                <tr>
                    <th rowspan="3">Project</th>
                    <th colspan="2">Project status as of the end of FY
                        20{{ App\Helper\FiscalYear::previousFYFromGivenFY($fiscalYear) }}</th>
                    <th rowspan="3">Approved Budget FY 20{{ $fiscalYear }}</th>
                    <th rowspan="3">Main Activities (Total: target of this year)</th>
                    <th rowspan="3">Milestones</th>
                    <th colspan="{{ 2 + $quaterfilter->allQuaterCount() }}" style="text-align: center">
                        Timeline
                    </th>
                    <th rowspan="3">Performance Indicators</th>
                    <th colspan="2">Responsibility</th>
                    {{-- <th rowspan="3">Remarks</th> --}}
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
                    <th colspan="2">Total </th>
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
                    {{-- <th>FP</th> --}}
                    <th>PT</th>
                    {{-- <th>PP</th> --}}
                </tr>
            </thead>

            <tbody>
                @foreach ($program->project as $pro_key => $project)
                    @php $count = 0; @endphp
                    @foreach ($project->projectActivity as $pro_act)
                        @php $count += count($pro_act->milestone); @endphp
                    @endforeach
                    @foreach ($project->projectActivity as $key => $pro_act)
                        @foreach ($pro_act->milestone as $key2 => $mile)
                            <tr>
                                @if ($key == 0 && $key2 == 0)
                                    <td rowspan="{{ $count }}" class="">{{ $project->Name }} [
                                        {{ $project->TownName }} ]</td>
                                    <td rowspan="{{ $count }}" class="text-center">
                                        {{-- {{ $project->lastProgress->physical_progress ?? 0 }}% --}}
                                        {{ isset($project->projectDataSQ[0]->physical_progress) ? $project->projectDataSQ[0]->physical_progress . '%' : 'NA' }}
                                    </td>
                                    <td rowspan="{{ $count }}"class="text-center">
                                        {{ \App\Helper\DisbursementFilter::totalDisbursementForProjectAsOfYear('20' . App\Helper\FiscalYear::previousFYFromGivenFY($fiscalYear), $project->programID, $project->projectID) }}
                                    </td>
                                    {{-- Approved Budget FY --}}
                                    <td rowspan="{{ $count }}" class="text-center">
                                        {{ isset($project->projectDataSQ[0]->approved_budget) ? $project->projectDataSQ[0]->approved_budget : 'NA' }}
                                    </td>
                                @endif

                                @if ($key2 == 0)
                                    <td rowspan="{{ count($pro_act->milestone) }}" class="">
                                        {{ $pro_act->activity }}</td>
                                @endif

                                <td class=" text-left" style="min-width: 150px;max-width: 150px">
                                    {{ $mile->milestone }}
                                </td>

                                {{-- timeline_target --}}

                                @if ($mile->timeline)
                                    @foreach ($mile->timeline->timeline ?? [] as $timeline_month => $time)
                                        @if (in_array($timeline_month, $quaterfilter->showMonths()))
                                            @if ($mile->is_text == 'yes')
                                                <td>{{ $time }}</td>
                                            @else
                                                <td>
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
                                            <td>
                                            </td>
                                        @endif
                                    @endfor
                                @endif
                                {{-- !ENDS timeline_target --}}

                                @if ($key == 0 && $key2 == 0)
                                    @php
                                        $ft_fp_pt_pp = \App\Helper\FlowProjectMilestone::calculateTargetAndProgressFromMilestone($pro_act->milestone, $quaterfilter->showMonths());
                                    @endphp
                                    {{-- FT --}}
                                    <td rowspan="{{ $count }}">
                                        {{ $ft_fp_pt_pp['financial_target'] == 0 ? 'NA' : $ft_fp_pt_pp['financial_target'] }}
                                    </td>
                                    {{-- PT --}}
                                    <td rowspan="{{ $count }}">
                                        {{ $ft_fp_pt_pp['physical_target'] == 0 ? 'NA' : $ft_fp_pt_pp['physical_target'] }}
                                    </td>
                                @endif

                                {{-- performance_indicator --}}

                                <td class=" text-left" style="min-width: 200px;max-width: 200px">
                                    {{ $mile->performance_indicator }}</td>

                                @if ($key2 == 0)
                                    <td rowspan="{{ count($pro_act->milestone) }}" class="">
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
                                    <td rowspan="{{ count($pro_act->milestone) }}" class="">
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
                                {{-- <td style="min-width: 250px;">
                                    {{ $mile->remark }}
                                </td> --}}

                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>


        <div class="text-right">
            {{-- <button class="btn btn-primary export_pdf_btn" data-pdf-orientation="portrait">
                PDF Export Portrait
            </button>
            <button class="btn btn-primary export_pdf_btn" data-pdf-orientation="landscape">
                PDF Export Landscape
            </button> --}}

            <form action="{{ route('flow.target-report-download') }}" method="POST" class="mx-2">
                @csrf
                <input type="hidden" name="fiscal_year" value="{{ $fiscal_year }}">

                <input type="hidden" name="programId" value="{{ $programId }}">
                <input type="hidden" name="projectId" value="{{ $projectId }}">
                <button class="btn btn-primary " data-pdf-orientation="landscape">
                    Export PDF
                </button>
            </form>
            {{-- <a href="{{ route('export.progress.report', ['is_target_report' => 'yes', 'program' => "$selectedProgram", 'project' => "$selectedProject", 'selected_months' => $quaterfilter->showMonths()]) }}"
                class="btn btn-primary">Export</a> --}}
        </div>

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
