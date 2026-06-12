<div>
    @if (!empty($project_datas))

        @php
            $quaterfilter = new App\Helper\QuaterFilter();
        @endphp

        {{-- quater filter --}}
        <x-report.partials.quater-filter-component />
        {{-- !ENDS quater filter --}}

        @php
            $progressReportProjectsCollection = collect($project_datas);
            $progressReportChunkedProjects = $progressReportProjectsCollection->chunk(5);
        @endphp
        {{-- For PDF only --}}
        <div>
            @php
                $mainSNCounter = 1;
            @endphp
            @foreach ($progressReportChunkedProjects as $projectArray)
                <table border="1"
                    class="table table-responsive pdf-table custom-table fullscreen_table tdf-table-primary  d-none"
                    style="text-align: left;font-size: 13px; !important;font-weight:500;text-align:center;"
                    id="report_table-internal-progress-report-{{ $loop->index + 1 }}">
                    <thead style="font-size: 14px">
                        <tr>
                            <th colspan="{{ 7 + 12 + 4 + 4 + 3 + 1 }}" class="text-center">
                                Town Development Fund <br>
                                Progress of Performance Monitoring Framework (PPMF) <br>
                                {{ $project->name }} <br>
                                FY 20{{ $project->fiscal_year }} <br>
                            </th>
                        </tr>

                        <tr>
                            <th rowspan="3">S.N</th>
                            {{-- <th rowspan="3">Approved Budget FY 20{{ $project->fiscal_year }}}</th> --}}
                            <th rowspan="3" colspan="2"> Activities/Milestones</th>
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
                        @foreach ($projectArray as $item)
                            <tr>
                                <td rowspan="2" style="min-width: 30px;max-width: 30px; ">{{ $mainSNCounter }}</td>
                                {{-- <td rowspan="2">{{ $item->approved_budget }}</td> --}}
                                <td rowspan="2" style="min-width: 150px;max-width: 150px; ">
                                    {{ $item->activity_milestone }}</td>
                                <td>
                                    T
                                </td>
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
                                <td rowspan="2" style="min-width: 120px;max-width: 120px; ">
                                    {{ $item->performance_indicator }}</td>
                                <td rowspan="2" style="min-width: 150px;max-width: 150px; text-align: left">
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
                                <td rowspan="2" style="min-width: 150px;max-width: 150px; text-align: left">
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
                                <td rowspan="2" style="min-width: 150px;max-width: 150px; text-align: left">
                                    {{ $item->remark }}</td>

                            </tr>
                            <tr>
                                <td>P</td>
                                {{-- timeline  for progress --}}
                                @if ($item->timeline_progress)
                                    @foreach ($item->timeline_progress ?? [] as $timeline_month => $time)
                                        @if (in_array($timeline_month, $quaterfilter->showMonths()))
                                            @if ($item->is_text == 'yes')
                                                <td>
                                                    {{ $item->timeline_progress[$loop->index + 1] ?? '' }}
                                                </td>
                                            @else
                                                <td style="text-align: center;">
                                                    @if (isset($item->timeline_progress[$loop->index + 1]) && $item->timeline_progress[$loop->index + 1] == 1)
                                                        <div style="color:black; font-size: 15px;font-weight: 900">
                                                            ✔
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
                                {{-- !ENDS timeline for progress --}}

                            </tr>
                            @php
                                $mainSNCounter = $mainSNCounter + 1;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
        {{-- !ENDS For PDF only --}}

        <table border="1" class="table table-responsive custom-table fullscreen_table tdf-table-primary"
            style="text-align: left; font-size: 13px; !important;font-weight:500;text-align:center;"
            id="report_table-internal-progress-report">
            <thead>
                <tr>
                    <th colspan="{{ 7 + 12 + 4 + 4 + 3 + 1 }}" class="text-center">
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
                @foreach ($project_datas ?? [] as $item)
                    <tr>
                        <td rowspan="2">{{ $loop->index + 1 }}</td>
                        <td rowspan="2">{{ $item->approved_budget }}</td>
                        <td rowspan="2" style="text-align: left">{{ $item->activity_milestone }}</td>
                        <td>
                            T
                        </td>
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
                        <td rowspan="2" style="min-width: 120px;max-width: 120px; ">
                            {{ $item->performance_indicator }}</td>
                        <td rowspan="2" style="min-width: 120px;max-width: 120px; ">
                            <div class="d-flex flex-wrap" style="min-width: 150px;max-width: 150px; ">
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
                        <td rowspan="2" style="text-align: left" style="min-width: 150px;max-width: 150px; ">
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
                        <td rowspan="2" style="text-align: left" style="min-width: 150px;max-width: 150px; ">
                            {{ $item->remark }}</td>

                    </tr>
                    <tr>
                        <td>P</td>
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
                                            @if (isset($item->timeline_progress[$loop->index + 1]) && $item->timeline_progress[$loop->index + 1] == 1)
                                                <div style="color:black; font-size: 30px;font-weight: 900">
                                                    ✔
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
                        {{-- !ENDS timeline for progress --}}

                    </tr>
                @endforeach
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
                background-color: rgb(82, 159, 82) !important;
                color: #fff;
            }

            .custom-table tbody>tr>td.bg-success {
                background-color: rgb(82, 159, 82) !important;
                color: #fff;
            }
        </style>

        <div class="text-right d-flex justify-content-end mt-2">

            <button class="btn btn-primary export_pdf_btn-internal-progress-report" data-pdf-orientation="landscape"
                data-chunk-size="{{ count($progressReportChunkedProjects) }}">
                Export
            </button>
        </div>
        {{-- <form action="{{ route('internal.printProgressReport') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="projectId" value="{{ $project->id }}">
                <input type="hidden" name="orientation" value="portrait">
                <button class="btn btn-primary " type="submit" data-pdf-orientation="landscape">
                    PDF Export
                </button>
            </form> --}}


        {{-- <button class="btn btn-primary export_pdf_btn-internal-target-report" id="export_pdf_btn-internal-target-report">
            PDF Export
        </button> --}}
        {{-- <a href="{{ route('internal.project.single.export.progress-report', ['project_id' => "$project->id", 'selected_months' => $quaterfilter->showMonths()]) }}"
                class="btn btn-primary">Export</a>
        </div> --}}
        {{-- <div class="text-right">
            <button class="btn btn-primary export_pdf_btn-internal-progress-report" data-pdf-orientation="portrait">
                PDF Export Portrait
            </button>
            <button class="btn btn-primary export_pdf_btn-internal-progress-report" data-pdf-orientation="landscape">
                PDF Export Landscape
            </button>

            <a href="{{ route('internal.project.single.export.progress-report', ['project_id' => "$project->id", 'selected_months' => $quaterfilter->showMonths()]) }}"
                class="btn btn-primary">Export</a>
        </div> --}}




    @endif
</div>

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
        integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"
        integrity="sha512-01CJ9/g7e8cUmY0DFTMcUw/ikS799FHiOA0eyHsUWfOetgbx/t6oV4otQ5zXKQyIrQGTHSmRVPIgrgLcZi/WMA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
