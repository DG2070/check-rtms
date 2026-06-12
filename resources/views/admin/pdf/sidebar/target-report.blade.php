<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $pdfTitle }}</title>


    <style>
        * {
            margin: 0;
            padding: 0;
            /* box-sizing: border-box; */
        }

        p {
            font-size: 40px;
            /* font-weight: 500; */
            letter-spacing: 1px;
            display: inline-block;
            text-align: left;
        }

        td {
            padding: 5px;
        }

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

        .tdf-progress-input-target-box--small {
            background-color: #529f52 !important;
            height: 35px;
            margin: auto;
            width: 35px;
        }



        input {
            display: none
        }

        input:checked {
            display: block;
            height: 44px !important;
            width: 44px !important;
            font-size: 44px;
            color: blue;
            text-align: center;
            /* padding: 0px */
            outline: none;

        }

        .flex {
            display: flex;
            /* justify-content: space-between; */
            width: 100vw;
        }

        .flex div {

            width: 50%;
        }
    </style>

    <style>
        th {
            padding: 20px 10px
        }

        td {

            padding-top: 10px;
            padding-bottom: 10px;
            padding-left: 20px
        }

        body {
            font-size: 40px;
            padding-top: 80px;
        }
    </style>

</head>

<body>
    @php
        $quaterfilter = new App\Helper\QuaterFilter();
    @endphp
    <div class=""
        style="padding-top:130px;display:flex;;items-center;width:100vw;text-align:center;letter-spacing:1px;margin-bottom:20px;margin: 0 auto;">
        Town Development Fund <br>
        Target of Performance Monitoring Framework (TPMF) <br>
        {{ $programName }} <br>
        FY 20{{ $fiscalYear }} <br>
    </div>

    <table border="1" class="table table-responsive custom-table fullscreen_table tdf-table-primary"
        style="width: 100%;margin-top:30px;margin-bottom: 20px;padding:0px 30px">
        <thead>
            <tr>
                <th rowspan="2">Project Name</th>
                <th colspan="2">
                    Project status as of the <br> end of FY
                    20{{ App\Helper\FiscalYear::previousFYFromGivenFY($fiscalYear) }}
                </th>
                <th rowspan="2">Main Activities <br> (Total: target of this year)</th>
                <th rowspan="2">Approved Budget <br> 20{{ $fiscalYear }}</th>
                <th rowspan="2">Main <br> Responsibility</th>
                <th rowspan="2">Supportive <br> Responsibility</th>
            </tr>
            <tr>
                <th>Physical</th>
                <th>Financial</th>
            </tr>
        </thead>
        <tbody class="main_tbody">
            <tr>
                <td style="text-align:left;"> {{ $project->Name }} [ {{ $project->TownName }} ]</td>

                <td>
                    {{ isset($project->projectDataSQ[0]->physical_progress) ? $project->projectDataSQ[0]->physical_progress . '%' : 'NA' }}
                </td>
                <td>
                    {{ \App\Helper\DisbursementFilter::totalDisbursementForProjectAsOfYear('20' . App\Helper\FiscalYear::previousFYFromGivenFY($fiscalYear), $programId, $projectId) }}
                </td>
                <td style="text-align:left;">
                    @foreach ($project->projectActivity as $key => $pro_act)
                        {{ $pro_act->activity }}
                    @endforeach
                </td>
                <td> {{ isset($project->projectDataSQ[0]->approved_budget) ? $project->projectDataSQ[0]->approved_budget : 'NA' }}
                </td>

                <td style="text-align:left;">
                    @foreach ($project->projectActivity as $key => $pro_act)
                        @foreach ($pro_act->milestone as $key2 => $mile)
                            @if ($key2 == 0)
                                @foreach (\App\Models\User::whereIn('id', $pro_act->main_responsibility ?? [])->get() as $user)
                                    <span>
                                        {{ $user->name }}@if (!$loop->last)
                                            ,
                                        @endif
                                    </span>
                                @endforeach
                            @endif
                        @endforeach
                    @endforeach
                </td>
                <td style="text-align:left;">
                    @foreach ($project->projectActivity as $key => $pro_act)
                        @foreach ($pro_act->milestone as $key2 => $mile)
                            @if ($key2 == 0)
                                @foreach (\App\Models\User::whereIn('id', $pro_act->supportive_responsibility ?? [])->get() as $user)
                                    <span>
                                        {{ $user->name }}
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    </span>
                                @endforeach
                            @endif
                        @endforeach
                    @endforeach
                </td>
            </tr>
        </tbody>

    </table>


    <table border="1" class="table table-responsive custom-table tdf-table-primary"
        style="width: 100%;margin-top:30px;margin-bottom: 20px;padding:0px 30px">
        <thead>
            <tr>
                <th>Total Financial Target</th>
                <th>Total Physical Target</th>
            </tr>
        </thead>
        @foreach ($project->projectActivity ?? [] as $key => $pro_act)
            @foreach ($pro_act->milestone as $key2 => $mile)
                <tbody @if ($key2 / 2 == 0) style="page-break-before: always" @endif>
                    <tr>
                        @if ($key == 0 && $key2 == 0)
                            @php
                                $ft_fp_pt_pp = \App\Helper\FlowProjectMilestone::calculateTargetAndProgressFromMilestone($pro_act->milestone, $quaterfilter->showMonths());
                            @endphp

                            {{-- FT --}}
                            <td>
                                {{ $ft_fp_pt_pp['financial_target'] == 0 ? 'NA' : $ft_fp_pt_pp['financial_target'] }}
                            </td>
                            {{-- PT --}}
                            <td>
                                {{ $ft_fp_pt_pp['physical_target'] == 0 ? 'NA' : $ft_fp_pt_pp['physical_target'] . ' %' }}
                            </td>
                        @endif
                    </tr>
                </tbody>
            @endforeach
        @endforeach
    </table>

    <table border="1" class="table table-responsive custom-table tdf-table-primary"
        style="width: 100%;margin-top:30px;margin-bottom: 20px;padding:0px 30px">
        <thead>

            <tr>
                <th rowspan="3">Milestones</th>
                <th colspan="{{ $quaterfilter->allQuaterCount() }}">
                    Timeline
                </th>
                <th rowspan="3">Performance Indicators</th>
            </tr>

            <tr>
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
            </tr>
        </thead>

        <tbody class="main_tbody">
            @php $count = 0; @endphp
            @foreach ($project->projectActivity as $pro_act)
                @php $count += count($pro_act->milestone); @endphp
            @endforeach
            @foreach ($project->projectActivity as $key => $pro_act)
                @foreach ($pro_act->milestone as $key2 => $mile)
                    <tr @if ($key == 0 && $key2 == 0) style="border-top:1.5px solid #2969a2 !important" @endif>
                        <td
                            style="text-align:left;max-width:450px;@if ($key2 % 2 == 0) background: aliceblue; @endif">
                            {{ $mile->milestone }}
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


                        {{-- performance_indicator --}}
                        <td style="text-align:left;max-width:450px;">
                            {{ $mile->performance_indicator }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>



</body>

</html>
