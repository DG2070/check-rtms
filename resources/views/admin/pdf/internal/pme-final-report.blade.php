<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PME Final Report</title>
    <style>
        @font-face {
            font-family: NotoSans-Regular;
            font-style: normal;
            font-weight: 400;
            src: url('{{ storage_path('fonts/NotoSans-Regular.ttf') }}') format('truetype');
        }

        body {
            font-family: NotoSans-Regular;
            font-size: 14px;
        }
    </style>
</head>

<body style='font-family: NotoSans-Regular;'>
    <div>
        @php
            $quaterfilter = new App\Helper\QuaterFilter();
        @endphp


        <table border="1" class="table table-responsive custom-table fullscreen_table  tdf-table-primary"
            style="text-align: left;height:100%;margin-top:-80px;" id="report_table-internal-pme-final-report">
            <thead>
                <tr>
                    <th colspan="{{ 7 + 12 + 4 + 4 + 3 }}" class="text-center">
                        Town Development Fund <br>
                        Progress of Performance Monitoring Framework (PPMF) <br>
                        {{ $project->name }} <br>
                        FY 20{{ $project->fiscal_year }} <br>
                    </th>
                </tr>

                <tr>
                    <th rowspan="3">S.N</th>
                    <th rowspan="3">Approved Budget FY 20{{ $project->fiscal_year }}</th>
                    <th rowspan="3" colspan="2"> Activities/Milestones</th>
                    <th colspan="{{ $quaterfilter->allQuaterCount() }}" style="text-align: center">
                        Timeline
                    </th>
                    <th rowspan="3">Performance Indicators</th>
                    <th rowspan="3">Progress</th>
                    <th colspan="2">PME Review</th>
                    <th rowspan="3">Main Responsibility</th>
                    <th rowspan="3">Supportive Responsibility</th>
                    <th rowspan="3">PME Remarks</th>
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
                    <th rowspan="2">Achived</th>
                    <th rowspan="2">Not Achived</th>
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

            <tbody>
                @if (!empty($project_datas))
                    @foreach ($project_datas as $item)
                        <tr>
                            <td rowspan="2">{{ $loop->index + 1 }}</td>
                            <td rowspan="2">{{ $item->approved_budget }}</td>
                            <td rowspan="2" style="min-width: 200px;max-width: 200px; ">
                                {{ $item->activity_milestone }}
                            </td>
                            <td style="text-align: right">T</td>
                            {{-- timeline_target --}}
                            @if (!empty($item->timeline_target))
                                @foreach ($item->timeline_target ?? [] as $timeline_month => $time)
                                    @if (in_array($timeline_month, $quaterfilter->showMonths()))
                                        @if ($item->is_text == 'yes')
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
                                @for ($i = 1; $i < 13; $i++)
                                    @if (in_array($i, $quaterfilter->showMonths()))
                                        <td>

                                        </td>
                                    @endif
                                @endfor
                            @endif
                            {{-- !ENDS timeline_target --}}
                            <td rowspan="2"> {{ $item->performance_indicator }}</td>
                            <td rowspan="2"> {{ $item->remark }}</td>

                            <td rowspan="2">
                                <input
                                    class="form-control p-0 {{ isset($item->pme_target_review) && $item->pme_target_review == 'achived' ? '' : 'd-none' }}"
                                    readonly onclick="return false;" type="checkbox"
                                    {{ isset($item->pme_target_review) && $item->pme_target_review == 'achived' ? 'checked' : '' }}>

                            </td>
                            <td rowspan="2">
                                <input
                                    class="form-control p-0 {{ isset($item->pme_target_review) && $item->pme_target_review == 'not_achived' ? '' : 'd-none' }}"
                                    readonly onclick="return false;" type="checkbox"
                                    {{ isset($item->pme_target_review) && $item->pme_target_review == 'not_achived' ? 'checked' : '' }}>

                            </td>

                            <td rowspan="2">
                                <div class="d-flex flex-wrap">
                                    @foreach (\App\Models\User::whereIn('id', $item->main_responsibility ?? [])->get() as $user)
                                        <div>
                                            {{ $user->name }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td rowspan="2">
                                <div class="d-flex flex-wrap">
                                    @foreach (\App\Models\User::whereIn('id', $item->supportive_responsibility ?? [])->get() as $user)
                                        <div>
                                            {{ $user->name }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td rowspan="2">
                                {{ $item->pme_target_remarks ?? '' }}
                            </td>


                        </tr>
                        <tr>
                            <td style="text-align: right">P</td>

                            {{-- timeline  for progress --}}
                            @if ($item->timeline_progress)
                                @foreach ($item->timeline_progress ?? [] as $timeline_month => $time)
                                    @if (in_array($timeline_month, $quaterfilter->showMonths()))
                                        @if ($item->is_text == 'yes')
                                            <td>
                                                {{ $item->timeline_progress[$loop->index + 1] ?? '' }}
                                            </td>
                                        @else
                                            <td>
                                                <input style="min-width: 25px;height: 25px;padding: 0px !important"
                                                    class="form-control p-0 {{ isset($item->timeline_progress[$loop->index + 1]) && $item->timeline_progress[$loop->index + 1] == 1 ? '' : 'd-none' }}"
                                                    type="checkbox" readonly onclick="return false;"
                                                    {{ isset($item->timeline_progress[$loop->index + 1]) && $item->timeline_progress[$loop->index + 1] == 1 ? 'checked' : '' }}>
                                            </td>
                                        @endif
                                    @endif
                                @endforeach
                            @else
                                @for ($i = 1; $i < 13; $i++)
                                    @if (in_array($i, $quaterfilter->showMonths()))
                                        <td>
                                        </td>
                                    @endif
                                @endfor
                            @endif
                            {{-- !ENDS timeline for progress --}}
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>


        <style>
            td {
                width: 100%;
                max-height: 100%;
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
                width: 100%;
                font-size: 40px;
                padding: 5px 10px;
            }

            .custom-table tbody>tr {
                height: 100%;
            }

            .custom-table tbody>tr>td {
                width: 100%;
                border: 1px solid #fff !important;
                letter-spacing: 2px;
                font-size: 44px;
                /* font-weight: 500; */
                padding: 20px 10px;


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
        </style>



</body>

</html>
