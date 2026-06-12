<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Target Report</title>
    <style>
        /* @font-face {
            font-family: Kalimati;
            font-style: normal;
            font-weight: 400;
            src: url('{{ storage_path('fonts/Kalimati Regular.otf') }}') format('truetype');
            unicode-range: U+0900-097F;
        }

        */

        /* @font-face {
            font-family: NotoSans;
            font-style: normal;
            font-weight: 400;
            src: url('{{ storage_path('fonts/NotoSans-Regular.ttf') }}') format('truetype');
            unicode-range: U+0020-007E;
            /* Basic Latin characters */
        }

        */
        /* @font-face {
            font-family: 'Poppins-Regular';
            font-style: normal;
            font-weight: 400;
            src: url('{{ storage_path('fonts/Poppins-Regular.ttf') }}') format('truetype');
        } */
    </style>
    <style>
        @font-face {
            font-family: Nirmala;
            font-style: normal;
            font-weight: 400;
            src: url('{{ storage_path('fonts/Nirmala.ttf') }}') format('truetype');
        }

        body {
            font-family: Nirmala;
            font-size: 14px;
        }
    </style>

</head>

<body style='font-family: Nirmala;'>
    {{-- <body style='font-family: "Preeti";'> --}}
    <div>
        @php
            $quaterfilter = new App\Helper\QuaterFilter();
        @endphp

        {{-- quater filter --}}
        {{-- !ENDS quater filter --}}

        <table border="1" class="table table-responsive custom-table fullscreen_table tdf-table-primary"
            style="text-align: left;width:100%" id="report_table-internal-target-report">
            <thead>
                <tr>
                    <th colspan="{{ 7 + 12 + 4 + 4 + 3 + 1 }}" class="text-center">
                        Town Development Fund <br>
                        Target of Performance Monitoring Framework (PPMF) <br>
                        {{ $project->name }} <br>
                        FY 20{{ $project->fiscal_year }}<br>
                    </th>
                </tr>

                <tr>
                    <th rowspan="3">S.N</th>
                    <th rowspan="3">Approved Budget FY 20{{ $project->fiscal_year }}</th>
                    <th rowspan="3"> Activities/Milestones</th>
                    <th colspan="{{ $quaterfilter->allQuaterCount() }}" style="text-align: center">
                        Timeline
                    </th>
                    <th rowspan="3">Performance Indicators</th>
                    <th rowspan="3">Main Responsibility</th>
                    <th rowspan="3">Supportive Responsibility</th>
                    <th rowspan="3">Remarks</th>
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

            <tbody>
                @if (!empty($project_datas))
                    @foreach ($project_datas as $item)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $item->approved_budget }}</td>
                            <td style="text-align: left">{{ $item->activity_milestone }}</td>
                            {{-- timeline_target --}}
                            @if (!empty($item->timeline_target))
                                @foreach ($item->timeline_target ?? [] as $timeline_month => $time)
                                    @if (in_array($timeline_month, $quaterfilter->showMonths()))
                                        @if ($item->is_text == 'yes')
                                            <td>{{ $time }}</td>
                                        @else
                                            <td style="padding: 5px !important">
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
                            <td style="text-align: left">{{ $item->performance_indicator }}</td>
                            <td style="text-align: left">
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
                            <td style="text-align: left">
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
                            <td style="text-align: left">{{ $item->remark }}</td>

                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
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
                width: 100%;
                font-size: 40px;
                padding: 5px 10px;
            }

            .custom-table tbody>tr>td {

                border: 1px solid #fff !important;

                font-size: 44px;
                padding: 15px 7px;

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

            .tdf-progress-input-target-box--small {
                background-color: #529f52 !important;
                height: 35px;
                margin: auto;
                width: 35px;
            }
        </style>
    </div>
</body>

</html>
