<div>

    {{-- controls --}}
    <div class="pi_controls-container">

        <form id="pi_controls_form" action="">
            @csrf
            <input type="hidden" name="tab_selected" value="#progress_input">
            <input type="hidden" name="fiscal_year" value="{{ request('fiscal_year') ?? '' }}">
            <input type="hidden" name="programID" value="{{ $programId }}">
            <input type="hidden" name="projectID" value="{{ $projectId }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Activity</label>
                        <select class="form-control select2" id="pi_activity_select" name="pi_activity_id" required>
                            <option value="" selected disabled>--SELECT ACTIVITY--</option>
                            @foreach ($program->project[0]->projectActivity ?? [] as $pro)
                                @if ($pro->id == $activityId)
                                    <option value="{{ $pro->id }}" selected>{{ $pro->activity }}</option>
                                @else
                                    @if ($loop->index == 0)
                                        <option value="{{ $pro->id }}" selected>{{ $pro->activity }}</option>
                                    @else
                                        <option value="{{ $pro->id }}">{{ $pro->activity }}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="col-md-3 d-none">
                    <div class="form-group">
                        <label>Milestone</label>
                        <select class="form-control select2" id="pi_milestone_select" name="pi_milestone_id">
                            <option value="" selected disabled>--SELECT MILESTONE--</option>

                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="d-block">&nbsp;</label>
                        <button type="submit" id="progressinput_show_button"
                            class="btn btn-primary rounded-0">Show</button>
                        {{-- <a href="{{ route('programs.new') }}" class="btn btn-danger rounded-0 ml-2">Clear</a> --}}
                    </div>
                </div>
            </div>
        </form>

    </div>
    {{-- !ENDS controls --}}

    {{-- content --}}
    <div>
        <div class="mt-4 ">
            <form method="POST" action="{{ route('programs.progress-input-milestone-progress.store') }}">
                <input type="hidden" name="projectID" value="{{ $projectId }}">
                <input type="hidden" name="fiscal_year" value="{{ request('fiscal_year') }}">
                @csrf
                <table class="table table-bordered progress_input_table tdf-table-primary">
                    <thead class="thead-blue">
                        <tr>
                            <th rowspan="2" colspan="2" class="align-middle text-center">Milestones</th>
                            <th colspan="3" class="align-middle text-center">1st Quarter</th>
                            <th colspan="3" class="align-middle text-center">2nd Quarter</th>
                            <th colspan="3" class="align-middle text-center">3rd Quarter</th>
                            <th colspan="3" class="align-middle text-center">4th Quarter</th>
                            <th rowspan="2" class="align-middle text-center">Remark</th>
                            <th rowspan="2" class="align-middle text-center">Upload</th>
                        </tr>
                        <tr>
                            <th class="align-middle text-center">1</th>
                            <th class="align-middle text-center">2</th>
                            <th class="align-middle text-center">3</th>
                            <th class="align-middle text-center">1</th>
                            <th class="align-middle text-center">2</th>
                            <th class="align-middle text-center">3</th>
                            <th class="align-middle text-center">1</th>
                            <th class="align-middle text-center">2</th>
                            <th class="align-middle text-center">3</th>
                            <th class="align-middle text-center">1</th>
                            <th class="align-middle text-center">2</th>
                            <th class="align-middle text-center">3</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($program->project[0]->projectActivity) && count($program->project[0]->projectActivity) > 0)
                            @foreach ($program->project[0]->projectActivity ?? [] as $key => $act)
                                {{-- show by milestone list by activity id || show 1st activity if no activity selected --}}
                                @php

                                    $show_milestones = false;
                                    if ($activityId == '' && $loop->index == 0) {
                                        $show_milestones = true;
                                    } else {
                                        if ($act->id == $activityId) {
                                            $show_milestones = true;
                                        }
                                    }

                                @endphp
                                @if ($show_milestones)
                                    <input type="hidden" name="activityId" value="{{ $act->id }}">
                                    @foreach ($act->milestone ?? [] as $key2 => $mile)
                                        {{-- show timeline data --}}

                                        @php
                                            $timeline = $mile->timeline()->pluck('timeline', 'milestone_id') ?? [];
                                            $timeline_id_list = $mile->timeline()->pluck('id');
                                            $progress_input_data = $mile->timeline()->pluck('progress_input_data', 'milestone_id');
                                            $remarks_data = $mile->timeline()->pluck('remarks', 'milestone_id');

                                            //financial target and physical target not editable
                                            $is_financial_target = false;
                                            $is_physical_target = false;
                                            if ($mile->is_text == 'yes') {
                                                if (in_array(strtolower(trim($mile->milestone)), \App\Helper\FinancialMilestone::milestoneNames())) {
                                                    $is_financial_target = true;
                                                }
                                                if (in_array(strtolower(trim($mile->milestone)), \App\Helper\PhysicalMilestone::milestoneNames())) {
                                                    $is_physical_target = true;
                                                }
                                            }

                                        @endphp

                                        @if (count($timeline) > 0)
                                            <tr @if ($key2 % 2 == 0) style="background: aliceblue;" @endif>
                                                <input type="hidden" value="{{ $mile->id }}"
                                                    name="milestone_id[{{ $mile->id }}]">
                                                <td rowspan="3" style="min-width: 120px">
                                                    {{ $mile->milestone }}
                                                </td>
                                                <td>T</td>

                                                @for ($i = 1; $i < 13; $i++)
                                                    <td style="padding: 3px"
                                                        class="{{ $mile->is_text == 'yes' ? 'px-1' : '' }}">

                                                        @if ($mile->is_text == 'no' && $timeline[$mile->id][$i])
                                                            <div class="tdf-progress-input-target-box">
                                                            </div>
                                                        @endif
                                                        <div class="text-center">
                                                            {{ $mile->is_text == 'yes' ? $timeline[$mile->id][$i] ?? '' : '' }}
                                                        </div>
                                                    </td>
                                                @endfor

                                                <td rowspan="3" class="text-center" style="padding: 0px !important">
                                                    <textarea name="milestone_remark[{{ $mile->id }}]">{{ $mile->remark ?? '' }}</textarea>
                                                </td>

                                                <td rowspan="3" style="">
                                                    <div class="text-center d-flex justify-content-center">
                                                        @if (!empty($mile->attachment) && $mile->attachment != '')
                                                            <a href="/uploads/attachments/{{ $mile->attachment }}"
                                                                target="_blank"
                                                                class="btn btn-success mr-2 tdf-border-small">
                                                                <i class="nav-icon fas fa-eye"></i>
                                                            </a>
                                                        @endif
                                                        <button type="button"
                                                            class="btn btn-primary btn-tdf-primary tdf-border-small"
                                                            data-toggle="modal"
                                                            data-target="#upload-attachment-modal-{{ $mile->id }}">
                                                            <i class="nav-icon fas fa-upload"></i>
                                                        </button>

                                                        {{-- attachment modal --}}
                                                        <div class="modal fade"
                                                            id="upload-attachment-modal-{{ $mile->id }}"
                                                            tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">
                                                                            Upload Attachment</h5>
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

                                                                        <form method="POST"
                                                                            action="{{ route('progress-input.upload-attachment') }}"
                                                                            enctype="multipart/form-data">
                                                                            @csrf

                                                                            <input type="hidden"
                                                                                value="{{ $mile->id }}"
                                                                                name="milestone_id">

                                                                            <div class="row">
                                                                                <div class="form-group col-md-12">
                                                                                    <input type="file"
                                                                                        name="attachment">
                                                                                </div>
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Close</button>


                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Upload
                                                                                    Attachment</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- !ENDS attachment modal --}}

                                                    </div>
                                                </td>
                                            </tr>
                                            {{-- Milestone progress --}}
                                            <tr @if ($key2 % 2 == 0) style="background: aliceblue;" @endif>
                                                <input type="hidden" value="{{ $timeline_id_list[0] }}"
                                                    name="timeline_id[{{ $mile->id }}]">
                                                <td>P</td>

                                                @if ($is_financial_target)
                                                    @php
                                                        //fetch disbursement data by month
                                                        $disbursement_data_by_month = \App\Helper\DisbursementFilter::disbursementsForProjectByFiscialYear( "20".request('fiscal_year') ??'2078/2079', $programId, $projectId);
                                                        // dd($disbursement_data_by_month);
                                                    @endphp

                                                    @foreach ([4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3] as $month)
                                                        <td class="px-0 text-left">
                                                            @if (!empty($disbursement_data_by_month[$month]) && $disbursement_data_by_month[$month] != 0)
                                                                <input type="hidden"
                                                                    name="progressinput[{{ $mile->id }}][{{ $loop->index + 1 }}]"
                                                                    value="{{ $disbursement_data_by_month[$month] }}">
                                                                <input class="form-control p-0" disabled
                                                                    type="text"
                                                                    value="{{ $disbursement_data_by_month[$month] }}"
                                                                    title="{{ $disbursement_data_by_month[$month] }}">
                                                                    @php 
                                                                   // dd($disbursement_data_by_month);
                                                                    @endphp
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                @else
                                                    @for ($timelinecntr = 1; $timelinecntr < 13; $timelinecntr++)
                                                        <td class="px-1">
                                                            @if ($timeline[$mile->id][$timelinecntr] != '')
                                                                <input {{-- @if ($is_financial_target || $is_physical_target) disabled @endif --}}
                                                                    class="form-control p-0 {{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }}"
                                                                    type="{{ $mile->is_text == 'yes' ? 'number' : 'checkbox' }}"
                                                                    @if ($mile->is_text == 'yes') min="0"
                                                                        step="0.01" @endif
                                                                    name="progressinput[{{ $mile->id }}][{{ $timelinecntr }}]"
                                                                    value="{{ $mile->is_text == 'yes' ? $progress_input_data[$mile->id][$timelinecntr] ?? '' : 1 }}"
                                                                    {{ $mile->is_text == 'yes' ? '' : (isset($progress_input_data[$mile->id][$timelinecntr]) && $progress_input_data[$mile->id][$timelinecntr] == 1 ? 'checked' : '') }}>
                                                            @endif
                                                        </td>
                                                    @endfor
                                                @endif
                                            </tr>
                                            {{-- Milestone Remarks --}}
                                            <tr
                                                @if ($key2 % 2 == 0) style="background: aliceblue;" @endif>
                                                <input type="hidden" value="{{ $timeline_id_list[0] }}"
                                                    name="timeline_id[{{ $mile->id }}]">
                                                <td>R</td>

                                                @for ($timelinecntr = 1; $timelinecntr < 13; $timelinecntr++)
                                                    <td class="px-1 text-center">
                                                        @if (isset($timeline[$mile->id]) && $timeline[$mile->id][$timelinecntr] != '')
                                                            <input type="hidden"
                                                                value="{{ $remarks_data[$mile->id][$timelinecntr] ?? '' }}"
                                                                name="timeline_progress_remark[{{ $mile->id }}][{{ $timelinecntr }}] ">
                                                            <div class="text-canter" data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="{{ $remarks_data[$mile->id][$timelinecntr] ?? '' }}">
                                                                <button type="button"
                                                                    class="btn btn-primary tdf-border-small"
                                                                    data-toggle="modal"
                                                                    data-target="#remarks-modal-{{ $timeline_id_list[0] }}{{ $timelinecntr }}">
                                                                    <i class="nav-icon fas fa-plus"></i>
                                                                </button>
                                                            </div>
                                                            {{-- remarks modal --}}
                                                            <div class="modal fade"
                                                                id="remarks-modal-{{ $timeline_id_list[0] }}{{ $timelinecntr }}"
                                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">
                                                                                Remark</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="">
                                                                                <input type="hidden"
                                                                                    value="dont_remove_for_form_to_work">
                                                                            </form>

                                                                            <form method="POST"
                                                                                action="{{ route('programs.progress-input.milestone-progress.remark.store') }}">
                                                                                @csrf

                                                                                <input type="hidden"
                                                                                    value="{{ $mile->id }}"
                                                                                    name="milestone_id">
                                                                                <input type="hidden"
                                                                                    value="{{ $timelinecntr }}"
                                                                                    name="timeline_mnth">
                                                                                <input type="hidden"
                                                                                    value="{{ $timeline_id_list[0] }}"
                                                                                    name="timeline_id">

                                                                                <div class="row">
                                                                                    <div class="form-group col-md-12">
                                                                                        <textarea name="remark" class="form-control" rows="15">{{ $remarks_data[$mile->id][$timelinecntr] ?? '' }}</textarea>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-secondary"
                                                                                        data-dismiss="modal">Close</button>


                                                                                    <button type="submit"
                                                                                        class="btn btn-primary">Save
                                                                                        Remark</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- !ENDS remarks modal --}}
                                                        @endif
                                                    </td>
                                                @endfor
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{-- actions --}}
                <div class="text-right">
                    <button type="submit" class="btn btn-primary btn-tdf-primary tdf-border-small">Update
                        Progress</button>
                </div>
            </form>
        </div>
    </div>
    {{-- !ENDS content --}}

</div>

@push('modal')
@endpush

@push('script')
    <style>
        .background-green {
            background-color: green !important;
        }

        .progress_input_table td {
            height: 50px;
            width: 50px;
        }
    </style>


    <script>
        $('#pi_activity_select').select2({
            closeOnSelect: true,
        });
        $('#pi_milestone_select').select2({
            closeOnSelect: true,
        });

        /*
         * Get milestone from selected activity
         */
        function getMilestones() {

            var selected_activity = $("#pi_activity_select").val();
            let projectactivities = <?php echo collect($program->project[0]->projectActivity); ?>;
            let request_milestone_id = <?php if ($milestoneId) {
                echo $milestoneId;
            } else {
                echo 0;
            } ?>;
            // console.log(request_milestone_id)

            let html = `<option value="" selected>--SELECT MILESTONE--</option>`;

            projectactivities.forEach(activity => {
                if (activity.id == selected_activity) {
                    activity.milestone.forEach(milestone => {
                        if (milestone.id == request_milestone_id) {
                            html +=
                                `<option value="${milestone.id}"selected>${milestone.milestone}</option>`
                        } else {
                            html += `<option value="${milestone.id}">${milestone.milestone}</option>`
                        }
                    });
                }
            });

            $("select#pi_milestone_select").html(html);
        }
        getMilestones();

        //on new activity selected / changed to another activity
        $('#pi_activity_select').on('select2:select', function(e) {
            //show milestone that belong to activity
            getMilestones();
        });
    </script>
    <style>
        .pi_controls-container .select2-container {
            width: 100% !important;
        }
    </style>

    <style>
        $("body").on("click", ".delete-activity", function(e) {
                e.preventDefault();
                var target=this;

                if (confirm("Do you really want to delete this activity?")) {
                    $(target).closest('form').submit();

                }
            });
    </style>
@endpush
