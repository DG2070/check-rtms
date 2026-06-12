<div>
    <table border="1">
        <thead style="background: #2767a0;color:white;">
            <tr>
                <th colspan="{{ 7 + 4 + $quaterfilter->allQuaterCount() + 4 }}"
                    style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;">
                    <div>
                        Town Development Fund
                    </div>
                    <br style="mso-data-placement:same-cell;" />
                    <div>
                        Progress of project performance monitoring framework (PPMF)
                    </div>
                    <br style="mso-data-placement:same-cell;" />
                    <div>
                        @if ($for_single_project)
                            {{ $program->project[0]->Name }}
                        @else
                            {{ $program->NameLong }}
                        @endif
                    </div>
                    <br style="mso-data-placement:same-cell;" />
                    <div>
                        FY 2079/80
                    </div>
                </th>
            </tr>
            <tr>

                {{-- <th rowspan="3">S.N</th> --}}
                <th rowspan="3"
                    style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;word-wrap:break-word;">
                    Project
                    Name</th>
                <th colspan="2"
                    style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;word-wrap:break-word;">
                    Project
                    status as of the end of FY
                    2078/79</th>
                <th rowspan="3"
                    style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;word-wrap:break-word;">
                    Approved
                    Budget FY 2079/80</th>
                <th rowspan="3"
                    style="text-align: center; vertical-align: center; background-color: #2767a0;color:white; word-wrap:break-word;">
                    Main
                    Activities (Total: target of
                    this year)</th>
                <th rowspan="3" colspan="2"
                    style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;">
                    Milestones</th>
                <th colspan="{{ 4 + $quaterfilter->allQuaterCount() }}"
                    style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;">Timeline
                </th>
                <th rowspan="3"
                    style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;">
                    Performance Indicators</th>
                <th colspan="2"
                    style="text-align: center; vertical-align: center;  background-color: #2767a0;color:white;">
                    Responsibility</th>
                <th rowspan="3"
                    style="text-align: center; vertical-align: center; background-color: #2767a0;color:white;">Remarks
                </th>
            </tr>

            <tr>
                <th rowspan="2"
                    style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">Physical
                </th>
                <th rowspan="2"
                    style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">Financial
                </th>
                @if ($quaterfilter->firstQuaterCount() > 0)
                    <th colspan="{{ $quaterfilter->firstQuaterCount() }}"
                        style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">1st
                        Quarter</th>
                @endif
                @if ($quaterfilter->secondQuaterCount() > 0)
                    <th colspan="{{ $quaterfilter->secondQuaterCount() }}"
                        style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">2nd
                        Quarter</th>
                @endif
                @if ($quaterfilter->thirdQuaterCount() > 0)
                    <th colspan="{{ $quaterfilter->thirdQuaterCount() }}"
                        style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">3rd
                        Quarter</th>
                @endif
                @if ($quaterfilter->fourthQuaterCount() > 0)
                    <th colspan="{{ $quaterfilter->fourthQuaterCount() }}"
                        style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">4th
                        Quarter</th>
                @endif
                <th colspan="4"
                    style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">Total
                </th>
                <th rowspan="2"
                    style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">Main</th>
                <th rowspan="2"
                    style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">Supportive
                </th>
            </tr>

            <tr>
                @if (in_array(1, $quaterfilter->showMonths()))
                    <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">1</th>
                @endif
                @if (in_array(2, $quaterfilter->showMonths()))
                    <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">2</th>
                @endif
                @if (in_array(3, $quaterfilter->showMonths()))
                    <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">3</th>
                @endif
                @if (in_array(4, $quaterfilter->showMonths()))
                    <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">1</th>
                @endif
                @if (in_array(5, $quaterfilter->showMonths()))
                    <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">2</th>
                @endif
                @if (in_array(6, $quaterfilter->showMonths()))
                    <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">3</th>
                @endif
                @if (in_array(7, $quaterfilter->showMonths()))
                    <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">1</th>
                @endif
                @if (in_array(8, $quaterfilter->showMonths()))
                    <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">2</th>
                @endif
                @if (in_array(9, $quaterfilter->showMonths()))
                    <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">3</th>
                @endif
                @if (in_array(10, $quaterfilter->showMonths()))
                    <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">1</th>
                @endif
                @if (in_array(11, $quaterfilter->showMonths()))
                    <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">2</th>
                @endif
                @if (in_array(12, $quaterfilter->showMonths()))
                    <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">3</th>
                @endif
                <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">FT</th>
                <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">FP</th>
                <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">PT</th>
                <th style="text-align: center; vertical-align: center;background-color: #2767a0;color:white;">PP</th>
            </tr>
        </thead>

        <tbody>
            @php
                $counter = 1;
            @endphp
            @foreach ($program->project as $pro_key => $project)
                @php $count = 0; @endphp
                @foreach ($project->projectActivity as $pro_act)
                    @php $count += count($pro_act->milestone); @endphp
                @endforeach
                @foreach ($project->projectActivity as $key => $pro_act)
                    @foreach ($pro_act->milestone as $key2 => $mile)
                        <tr>
                            @if ($key == 0 && $key2 == 0)
                                {{-- <td rowspan="{{ $count * 2 }}">{{ $pro_key + 1 }}</td> --}}
                                <td rowspan="{{ $count * ($is_target_report ? 1 : 2) }}"
                                    style="text-align: left; vertical-align: center;word-wrap:break-word;">
                                    {{ $project->Name }}</td>
                                <td rowspan="{{ $count * ($is_target_report ? 1 : 2) }}"
                                    style="text-align: center; vertical-align: center;">
                                    {{ isset($project->projectDataSQ[0]->physical_progress) ? $project->projectDataSQ[0]->physical_progress . '%' : 'NA' }}
                                </td>
                                <td rowspan="{{ $count * ($is_target_report ? 1 : 2) }}"
                                    style="text-align: center; vertical-align: center;white-space: nowrap;">
                                    {{ \App\Helper\DisbursementFilter::totalDisbursementForProjectAsOfYear('20' . App\Helper\FiscalYear::previousFYFromGivenFY($fiscalYear), $project->programID, $project->projectID) }}
                                </td>
                                <td rowspan="{{ $count * ($is_target_report ? 1 : 2) }}"
                                    style="text-align: center; vertical-align: center;white-space: nowrap;">
                                    {{ isset($project->projectDataSQ[0]->approved_budget) ? $project->projectDataSQ[0]->approved_budget : 'NA' }}
                                </td>
                            @endif

                            @if ($key2 == 0)
                                <td rowspan="{{ count($pro_act->milestone) * ($is_target_report ? 1 : 2) }}"
                                    style="text-align: left; vertical-align: center;word-wrap:break-word;">
                                    {{ $pro_act->activity }}</td>
                            @endif

                            <td
                                rowspan="{{ $is_target_report ? '1' : '2' }}"style="text-align: left; vertical-align: center;word-wrap:break-word;">
                                {{ $mile->milestone }}
                            </td>

                            <td>
                                T
                            </td>

                            {{-- timeline for target --}}
                            @if ($mile->timeline)
                                @foreach ($mile->timeline->timeline ?? [] as $timeline_month => $time)
                                    @if (in_array($timeline_month, $quaterfilter->showMonths()))
                                        @if ($mile->is_text == 'yes')
                                            <td style="text-align: center; vertical-align: center;">
                                                {{ $time }}
                                            </td>
                                        @else
                                            <td @if ($time) style="background: #28a745;" @endif>


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
                            {{-- !ENDS timeline for target --}}

                            @if ($key == 0 && $key2 == 0)
                                <td rowspan="{{ $count * ($is_target_report ? 1 : 2) }}"
                                    style="text-align: center; vertical-align: center;">
                                    {{ isset($project->projectDataSQ[0]->FT) ? $project->projectDataSQ[0]->FT : 'NA' }}
                                </td>
                                <td rowspan="{{ $count * ($is_target_report ? 1 : 2) }}"
                                    style="text-align: center; vertical-align: center;">
                                    {{ isset($project->projectDataSQ[0]->FP) ? $project->projectDataSQ[0]->FP : 'NA' }}
                                </td>
                                <td rowspan="{{ $count * ($is_target_report ? 1 : 2) }}"
                                    style="text-align: center; vertical-align: center;">
                                    {{ isset($project->projectDataSQ[0]->PT) ? $project->projectDataSQ[0]->PT : 'NA' }}
                                </td>
                                <td rowspan="{{ $count * ($is_target_report ? 1 : 2) }}"
                                    style="text-align: center; vertical-align: center;">
                                    {{ isset($project->projectDataSQ[0]->PP) ? $project->projectDataSQ[0]->PP : 'NA' }}
                                </td>
                            @endif

                            <td rowspan="{{ $is_target_report ? '1' : '2' }}"
                                style="text-align: left; vertical-align: center;word-wrap:break-word;">
                                {{ $mile->performance_indicator }}</td>

                            @if ($key2 == 0)
                                <td rowspan="{{ count($pro_act->milestone) * ($is_target_report ? 1 : 2) }}"
                                    style="text-align: center; vertical-align: center;word-wrap:break-word;">
                                    @foreach (\App\Models\User::whereIn('id', $pro_act->main_responsibility ?? [])->get() as $user)
                                        <div>
                                            {{ $user->name }}
                                            @if (!$loop->last)
                                                /
                                            @endif
                                        </div>
                                    @endforeach
                                </td>
                                <td rowspan="{{ count($pro_act->milestone) * ($is_target_report ? 1 : 2) }}"
                                    style="text-align: center; vertical-align: center;word-wrap:break-word;">
                                    @foreach (\App\Models\User::whereIn('id', $pro_act->supportive_responsibility ?? [])->get() as $user)
                                        <div>
                                            {{ $user->name }}
                                            @if (!$loop->last)
                                                /
                                            @endif
                                        </div>
                                    @endforeach
                                </td>
                            @endif
                            <td rowspan="{{ $is_target_report ? '1' : '2' }}"
                                style="text-align: left; vertical-align: center;word-wrap:break-word;">
                                {{ $mile->remark }}
                            </td>
                        </tr>
                        @if (!$is_target_report)
                            <tr>
                                <td>
                                    P
                                </td>
                                {{-- timeline  for progress --}}
                                @if ($mile->timeline)
                                    @foreach ($mile->timeline->timeline ?? [] as $timeline_month => $time)
                                        @if (in_array($timeline_month, $quaterfilter->showMonths()))
                                            @if ($mile->is_text == 'yes')
                                                <td style="text-align: center; vertical-align: center;">
                                                    {{ $mile->timeline->progress_input_data[$loop->index + 1] ?? '' }}
                                                </td>
                                            @else
                                                <td style="text-align: center">
                                                    <div>
                                                        {{ isset($mile->timeline->progress_input_data[$loop->index + 1]) && $mile->timeline->progress_input_data[$loop->index + 1] == 1 ? '✓' : '' }}

                                                    </div>
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
                                {{-- !ENDS timeline for progress --}}
                            </tr>
                        @endif
                    @endforeach
                @endforeach
                @php
                    $counter++;
                @endphp
            @endforeach
        </tbody>
    </table>
</div>
