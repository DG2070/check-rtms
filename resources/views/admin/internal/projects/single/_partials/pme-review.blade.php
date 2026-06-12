<div>
    @php
        $quaterfilter = new App\Helper\QuaterFilter();
    @endphp

    {{-- quater filter --}}
    <x-report.partials.quater-filter-component />
    {{-- !ENDS quater filter --}}

    <form method="POST" action="{{ route('internal.project.single.pme-review.update') }}">
        @csrf
        <table border="1" class="table table-responsive custom-table fullscreen_table tdf-table-primary  "
            style="text-align: left;">
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
                @foreach ($project_datas ?? [] as $item)
                    <tr>
                        <td rowspan="3">{{ $loop->index + 1 }}</td>
                        <td rowspan="3" style="text-align: left">{{ $item->activity_milestone }}</td>
                        <td>T</td>
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
                        <td rowspan="3" style="text-align: left">{{ $item->performance_indicator }}</td>
                        <td rowspan="3" style="text-align: left">{{ $item->remark }}</td>

                        @php
                            $achived = false;
                            $not_achived = false;
                            if (isset($item->pme_target_review)) {
                                if ($item->pme_target_review == 'achived') {
                                    $achived = true;
                                }
                                if ($item->pme_target_review == 'not_achived') {
                                    $not_achived = true;
                                }
                            }
                            
                        @endphp


                        <td rowspan="3">
                            <input type="radio" name="pme_target_review[{{ $item->id }}]" value="achived"
                                class="pme_radio_input" id="achived_pme_radio_input_{{ $item->id }}"
                                data-milestone-id="{{ $item->id }}"
                                data-is-checked="{{ $achived ? 'true' : 'false' }}" {{ $achived ? 'checked' : '' }}>
                        </td>
                        <td rowspan="3">
                            <input type="radio" name="pme_target_review[{{ $item->id }}]" value="not_achived"
                                class="pme_radio_input" id="not_achived_pme_radio_input_{{ $item->id }}"
                                data-milestone-id="{{ $item->id }}"
                                data-is-checked="{{ $not_achived ? 'true' : 'false' }}"
                                {{ $not_achived ? 'checked' : '' }}>
                        </td>

                        <td rowspan="3">
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
                        <td rowspan="3">
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
                        <td rowspan="3">
                            <textarea name="pme_target_remarks[{{ $item->id }}]">{{ $item->pme_target_remarks ?? '' }}</textarea>
                        </td>


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
                                            <input style="min-width: 25px;height: 25px;padding: 0px !important"
                                                class="form-control p-0 {{ isset($item->timeline_progress[$loop->index + 1]) && $item->timeline_progress[$loop->index + 1] == 1 ? '' : 'd-none' }}"
                                                type="checkbox" readonly onclick="return false;"
                                                {{ isset($item->timeline_progress[$loop->index + 1]) && $item->timeline_progress[$loop->index + 1] == 1 ? 'checked' : '' }}>
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
                    <tr>
                        <td>R</td>
                        {{-- timeline  for remarks --}}
                        @if ($item->timeline_target)
                            @foreach ($item->timeline_progress ?? [] as $timeline_month => $time)
                                @if (in_array($timeline_month, $quaterfilter->showMonths()))
                                    <td>
                                        @php
                                            $remarks_data = '';
                                            if (isset($item->timeline_remarks[$loop->index + 1])) {
                                                $remarks_data = $item->timeline_remarks[$loop->index + 1];
                                            }
                                            
                                        @endphp

                                        @if ($remarks_data != '')
                                            <div class="text-center" data-toggle="tooltip" data-placement="top"
                                                title="{{ $remarks_data }}">
                                                <button type="button" class="btn btn-primary tdf-border-small"
                                                    data-toggle="modal"
                                                    data-target="#view-remarks-modal-{{ $item->id }}-{{ $loop->index + 1 }}">
                                                    <i class="nav-icon fas fa-book"></i>
                                                </button>
                                            </div>
                                            {{-- remarks modal --}}
                                            <div class="modal fade"
                                                id="view-remarks-modal-{{ $item->id }}-{{ $loop->index + 1 }}"
                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                Remark</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
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
                                    <td>
                                    </td>
                                @endif
                            @endfor
                        @endif
                        {{-- !ENDS timeline for remarks --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="display:flex; gap: 10px; align-items: flex-end; justify-content: flex-end; width: 95%; margin:auto">

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
            /* /* padding: 15px; */
            ;
            */
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

</div>
