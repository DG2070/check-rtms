<div>

    {{-- controls --}}
    <div class="pi_controls-container">

        <form id="pi_controls_form" action="">
            @csrf
            <input type="hidden" name="tab_selected" value="#progress_input">
            <input type="hidden" name="fiscal_year" value="{{ request('fiscal_year') ?? '' }}">
            <input type="hidden" name="programID" value="{{ request('programID') ?? '' }}">
            <input type="hidden" name="projectID" value="{{ request('projectID') ?? '' }}">
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
        <div class="mt-4">
            {{-- <h4><strong>Timeline</strong></h4> --}}
            <form method="POST" action="{{ route('programs.progress-input-milestone-progress.store') }}">
                <input type="hidden" name="projectID" value="{{ request('projectID') ?? '' }}">
                @csrf
                <table class="table table-bordered progress_input_table">
                    <thead class="thead-blue">
                        <tr>
                            <th rowspan="2" class="align-middle text-center">Milestones</th>
                            <th colspan="3" class="align-middle text-center">1st Quarter</th>
                            <th colspan="3" class="align-middle text-center">2nd Quarter</th>
                            <th colspan="3" class="align-middle text-center">3rd Quarter</th>
                            <th colspan="3" class="align-middle text-center">4th Quarter</th>
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
                        {{-- {{ dd($program->project[0]->projectActivity) }} --}}
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
                                    @foreach ($act->milestone ?? [] as $key2 => $mile)
                                        {{-- show timeline data --}}

                                        @php
                                            $timeline = $mile->timeline()->pluck('timeline', 'milestone_id') ?? [];
                                            $timeline_id_list = $mile->timeline()->pluck('id');
                                            $progress_input_data = $mile->timeline()->pluck('progress_input_data', 'milestone_id');
                                        @endphp

                                        @if (count($timeline) > 0)
                                            <tr @if ($key2 % 2 == 0) style="background: aliceblue;" @endif>
                                                <input type="hidden" value="{{ $mile->id }}"
                                                    name="milestone_id[{{ $mile->id }}]">
                                                <td rowspan="2" style="max-width: 300px;min-width: 300px">{{ $mile->milestone }}</td>
                                                <td
                                                    class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][1]) && $timeline[$mile->id][1] == 1 ? 'background-green' : '') }}">
                                                    <div class="text-center">
                                                        {{ $mile->is_text == 'yes' ? $timeline[$mile->id][1] ?? '' : '' }}
                                                    </div>
                                                </td>
                                                <td
                                                    class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][2]) && $timeline[$mile->id][2] == 1 ? 'background-green' : '') }}">
                                                    <div class="text-center">
                                                        {{ $mile->is_text == 'yes' ? $timeline[$mile->id][2] ?? '' : '' }}
                                                    </div>
                                                </td>
                                                <td
                                                    class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][3]) && $timeline[$mile->id][3] == 1 ? 'background-green' : '') }}">
                                                    <div class="text-center">
                                                        {{ $mile->is_text == 'yes' ? $timeline[$mile->id][3] ?? '' : '' }}
                                                    </div>
                                                </td>
                                                <td
                                                    class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][4]) && $timeline[$mile->id][4] == 1 ? 'background-green' : '') }}">
                                                    <div class="text-center">
                                                        {{ $mile->is_text == 'yes' ? $timeline[$mile->id][4] ?? '' : '' }}
                                                    </div>
                                                </td>
                                                <td
                                                    class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][5]) && $timeline[$mile->id][5] == 1 ? 'background-green' : '') }}">
                                                    <div class="text-center">
                                                        {{ $mile->is_text == 'yes' ? $timeline[$mile->id][5] ?? '' : '' }}
                                                    </div>
                                                </td>
                                                <td
                                                    class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][6]) && $timeline[$mile->id][6] == 1 ? 'background-green' : '') }}">
                                                    <div class="text-center">
                                                        {{ $mile->is_text == 'yes' ? $timeline[$mile->id][6] ?? '' : '' }}
                                                    </div>
                                                </td>
                                                <td
                                                    class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][7]) && $timeline[$mile->id][7] == 1 ? 'background-green' : '') }}">
                                                    <div class="text-center">
                                                        {{ $mile->is_text == 'yes' ? $timeline[$mile->id][7] ?? '' : '' }}
                                                    </div>
                                                </td>
                                                <td
                                                    class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][8]) && $timeline[$mile->id][8] == 1 ? 'background-green' : '') }}">
                                                    <div class="text-center">
                                                        {{ $mile->is_text == 'yes' ? $timeline[$mile->id][8] ?? '' : '' }}
                                                    </div>
                                                </td>
                                                <td
                                                    class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][9]) && $timeline[$mile->id][9] == 1 ? 'background-green' : '') }}">
                                                    <div class="text-center">
                                                        {{ $mile->is_text == 'yes' ? $timeline[$mile->id][9] ?? '' : '' }}
                                                    </div>
                                                </td>
                                                <td
                                                    class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][10]) && $timeline[$mile->id][10] == 1 ? 'background-green' : '') }}">
                                                    <div class="text-center">
                                                        {{ $mile->is_text == 'yes' ? $timeline[$mile->id][10] ?? '' : '' }}
                                                    </div>
                                                </td>
                                                <td
                                                    class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][11]) && $timeline[$mile->id][11] == 1 ? 'background-green' : '') }}">
                                                    <div class="text-center">
                                                        {{ $mile->is_text == 'yes' ? $timeline[$mile->id][11] ?? '' : '' }}
                                                    </div>
                                                </td>
                                                <td
                                                    class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][12]) && $timeline[$mile->id][12] == 1 ? 'background-green' : '') }}">
                                                    <div class="text-center">
                                                        {{ $mile->is_text == 'yes' ? $timeline[$mile->id][12] ?? '' : '' }}
                                                    </div>
                                                </td>

                                            </tr>
                                            {{-- Milestone progress --}}
                                            <tr @if ($key2 % 2 == 0) style="background: aliceblue;" @endif>
                                                <input type="hidden" value="{{ $timeline_id_list[0] }}"
                                                    name="timeline_id[{{ $mile->id }}]">


                                                @for ($timelinecntr = 1; $timelinecntr < 13; $timelinecntr++)
                                                    <td class="px-1">
                                                        @if ($timeline[$mile->id][$timelinecntr] != '')
                                                            <input
                                                                class="form-control p-0 {{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }}"
                                                                type="{{ $mile->is_text == 'yes' ? 'text' : 'checkbox' }}"
                                                                name="progressinput[{{ $mile->id }}][{{ $timelinecntr }}]"
                                                                value="{{ $mile->is_text == 'yes' ? $progress_input_data[$mile->id][$timelinecntr] ?? '' : 1 }}"
                                                                {{ $mile->is_text == 'yes' ? '' : (isset($progress_input_data[$mile->id][$timelinecntr]) && $progress_input_data[$mile->id][$timelinecntr] == 1 ? 'checked' : '') }}>
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
                    <button type="submit" class="btn btn-primary btn-tdf-primary">Save Progress Input Data</button>
                </div>
            </form>
        </div>
    </div>
    {{-- !ENDS content --}}

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

</div>
