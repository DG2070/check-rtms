<div class="contents activity-milestone-container">
    <div class="pt-4">
        <h4><strong>Main Activities: </strong></h4>

        <div class="my-2">
            <button type="button" class="btn btn-primary btn-tdf-primary" data-toggle="modal"
                data-target="#createNewActivityModal">Add New Activity</button>

        </div>

        <table class="table table-bordered">
            <thead class="thead-blue">
                <tr>
                    <th>Activities</th>
                    <th>Main Responsibilities</th>
                    <th>Supportive Responsibilities</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($project->projectActivity as $pro_act)
                    <tr>
                        <td>
                            <input type="text" name="activity" class="form-control" value="{{ $pro_act->activity }}"
                                placeholder="Activities">
                        </td>
                        <td>

                            @php

                                // $main_responsibility = $pro_act->main_responsibility ?? [];
                                // $main_responsibility = is_array($pro_act->main_responsibility) ? $pro_act->main_responsibility : (is_array(json_decode($pro_act->main_responsibility ?? '')) ? json_decode($pro_act->main_responsibility) : []);
                                $main_responsibility_users = \App\Models\User::whereIn('id', $pro_act->main_responsibility ?? [])->get();
                            @endphp
                            <div class="form- control d-flex flex-wrap"
                                style="border: 1px solid #ccc;font-size: 14px;line-height: 1.42857143;color: #555;border: 1px solid #ccc;border-radius: 4px;min-height: 30px">
                                @foreach ($main_responsibility_users as $item)
                                    <div class="badge badge-pill badge-primary py-2 px-2 m-1"
                                        style="font-size: 13px;font-weight:normal;cursor: pointer;">
                                        {{ $item->name }}
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            @php

                                // $supportive_responsibility = is_array($pro_act->supportive_responsibility) ? $pro_act->supportive_responsibility : (is_array(json_decode($pro_act->supportive_responsibility ?? '')) ? json_decode($pro_act->supportive_responsibility) : []);
                                // $supportive_responsibility_users = \App\Models\User::whereIn('id', $supportive_responsibility)->get();

                                $supportive_responsibility_users = \App\Models\User::whereIn('id', $pro_act->supportive_responsibility ?? [])->get();

                            @endphp
                            <div class="form- control d-flex flex-wrap"
                                style="border: 1px solid #ccc;font-size: 14px;line-height: 1.42857143;color: #555;border: 1px solid #ccc;border-radius: 4px;min-height: 30px">
                                @foreach ($supportive_responsibility_users as $item)
                                    <div class="badge badge-pill badge-primary py-2 px-2 m-1"
                                        style="font-size: 12px;font-weight:normal;cursor: pointer;">
                                        {{ $item->name }}
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <div class="text-center">
                                <button class="btn btn-dark" type="button" data-toggle="modal"
                                    data-target="#editActivityModal-{{ $pro_act->id }}">
                                    <i class="fa fa-pen"></i>
                                </button>
                                <button type="button" class="btn bg-danger">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>


    </div>

    <div class="mt-4">
        <h4><strong>Add Milestones: </strong></h4>
        <table class="table table-bordered">
            <thead class="thead-blue">
                <tr>
                    <th>Activities</th>
                    <th>Milestones</th>
                    <th>Performance Indicator</th>
                    <th>Is Text(Timeline)</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
                <form method="POST" action="{{ route('project.milestone.store', $project->projectID) }}">
                    @csrf
                    <tr>
                        <td>
                            <select name="activity" class="form-control">
                                <option value="" selected disabled>-- Select Activity --</option>
                                @foreach ($project->projectActivity as $pro_act)
                                    <option value="{{ $pro_act->id }}">{{ $pro_act->activity }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input list="mielstone_datalist" type="text" name="milestone" class="form-control"
                                placeholder="Milestones">
                            <datalist id="mielstone_datalist">
                                <option value="Finalization of DPR">Finalization of DPR</option>
                                <option value="Appraisal Complete">Appraisal Complete</option>
                                <option value="Advance Mobilization">Advance Mobilization</option>
                                <option value="Project Monitoring & Supervision">Project Monitoring & Supervision
                                </option>
                                <option value="Board approval and Loan Agreement">Board approval and Loan Agreement
                                </option>
                                <option value="Support to Procurement process and NoL">Support to Procurement process
                                    and
                                    NoL</option>
                                <option value="Financial Target">Financial Target</option>
                                <option value="Physical Target">Physical Target</option>
                                <option value="Disbursement Target">Disbursement Target</option>
                                <option value="Monthly Progress Report form (As per Loan Agreement)">Monthly Progress
                                    Report form (As per Loan Agreement)</option>

                            </datalist>
                        </td>
                        <td>
                            <input type="text" name="performance_indicator" class="form-control"
                                placeholder="Performance Indicator">
                        </td>
                        <td>
                            <input type="checkbox" name="is_text" class="form-control"
                                placeholder="Performance Indicator" value="yes">
                        </td>
                        <td>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </td>
                    </tr>
                </form>


                @foreach ($project->projectActivity ?? [] as $act)
                    @foreach ($act->milestone ?? [] as $mile)
                        <form method="POST"
                            action="{{ route('project.milestone.update', [$project->projectID, $mile->id]) }}">
                            @csrf
                            <tr>
                                <td>
                                    <select name="activity" class="form-control">
                                        <option value="" selected disabled>-- Select Activity --</option>
                                        @foreach ($project->projectActivity as $pro_act)
                                            <option value="{{ $pro_act->id }}"
                                                {{ $mile->project_activity_id == $pro_act->id ? 'selected' : '' }}>
                                                {{ $pro_act->activity }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input name="milestone" value="{{ $mile->milestone }}" class="form-control">
                                </td>
                                <td><input name="performance_indicator" value="{{ $mile->performance_indicator }}"
                                        class="form-control"></td>
                                <td><input type="checkbox" name="is_text" class="form-control"
                                        {{ $mile->is_text == 'yes' ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-floppy-disk"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary bg-danger">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </form>
                    @endforeach
                @endforeach


            </tbody>
        </table>
    </div>
    @php $count = 0; @endphp
    @foreach ($project->projectActivity as $pro_act)
        @php $count += count($pro_act->milestone); @endphp
    @endforeach
    <form method="POST" action="{{ route('project.timeline.store', $project->projectID) }}">
        @csrf
        <div class="mt-4">
            <h4><strong>Timeline</strong></h4>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-blue">
                        <tr>
                            <th rowspan="2" class="align-middle text-center">Milestones</th>
                            <th colspan="3" class="align-middle text-center">1st Quarter</th>
                            <th colspan="3" class="align-middle text-center">2nd Quarter</th>
                            <th colspan="3" class="align-middle text-center">3rd Quarter</th>
                            <th colspan="3" class="align-middle text-center">4th Quarter</th>
                            <th rowspan="2" class="align-middle text-center">FT</th>
                            <th rowspan="2" class="align-middle text-center">PT</th>
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
                        @php
                            $ft = 0;
                            $pt = 0;
                        @endphp
                        @foreach ($project->projectActivity ?? [] as $key => $act)
                            @foreach ($act->milestone ?? [] as $key2 => $mile)
                                @php
                                    $timeline = $mile->timeline()->pluck('timeline', 'milestone_id') ?? [];

                                @endphp
                                <tr>
                                    <input type="hidden" value="{{ $mile->id }}"
                                        name="milestone_id[{{ $mile->id }}]">
                                    <td style="max-width: 300px;min-width: 300px">{{ $mile->milestone }}</td>
                                    <td
                                        class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][1]) && $timeline[$mile->id][1] == 1 ? 'background-blue' : '') }}">
                                        <input type="{{ $mile->is_text == 'yes' ? 'text' : 'checkbox' }}"
                                            name="timeline[{{ $mile->id }}][1]"
                                            value="{{ $mile->is_text == 'yes' ? $timeline[$mile->id][1] ?? '' : 1 }}"
                                            class="form-control p-0 {{ $mile->is_text == 'yes' ? '' : 'd-none' }}"
                                            {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][1]) && $timeline[$mile->id][1] == 1 ? 'checked' : '') }}>
                                    </td>
                                    <td
                                        class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][2]) && $timeline[$mile->id][2] == 1 ? 'background-blue' : '') }}">
                                        <input type="{{ $mile->is_text == 'yes' ? 'text' : 'checkbox' }}"
                                            name="timeline[{{ $mile->id }}][2]"
                                            value="{{ $mile->is_text == 'yes' ? $timeline[$mile->id][2] ?? '' : 1 }}"
                                            class="form-control p-0 {{ $mile->is_text == 'yes' ? '' : 'd-none' }}"
                                            {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][2]) && $timeline[$mile->id][2] == 1 ? 'checked' : '') }}>
                                    </td>
                                    <td
                                        class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][3]) && $timeline[$mile->id][3] == 1 ? 'background-blue' : '') }}">
                                        <input type="{{ $mile->is_text == 'yes' ? 'text' : 'checkbox' }}"
                                            name="timeline[{{ $mile->id }}][3]"
                                            value="{{ $mile->is_text == 'yes' ? $timeline[$mile->id][3] ?? '' : 1 }}"
                                            class="form-control p-0 {{ $mile->is_text == 'yes' ? '' : 'd-none' }}"
                                            {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][3]) && $timeline[$mile->id][3] == 1 ? 'checked' : '') }}>
                                    </td>
                                    <td
                                        class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][4]) && $timeline[$mile->id][4] == 1 ? 'background-blue' : '') }}">
                                        <input type="{{ $mile->is_text == 'yes' ? 'text' : 'checkbox' }}"
                                            name="timeline[{{ $mile->id }}][4]"
                                            value="{{ $mile->is_text == 'yes' ? $timeline[$mile->id][4] ?? '' : 1 }}"
                                            class="form-control p-0 {{ $mile->is_text == 'yes' ? '' : 'd-none' }}"
                                            {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][4]) && $timeline[$mile->id][4] == 1 ? 'checked' : '') }}>
                                    </td>
                                    <td
                                        class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][5]) && $timeline[$mile->id][5] == 1 ? 'background-blue' : '') }}">
                                        <input type="{{ $mile->is_text == 'yes' ? 'text' : 'checkbox' }}"
                                            name="timeline[{{ $mile->id }}][5]"
                                            value="{{ $mile->is_text == 'yes' ? $timeline[$mile->id][5] ?? '' : 1 }}"
                                            class="form-control p-0 {{ $mile->is_text == 'yes' ? '' : 'd-none' }}"
                                            {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][5]) && $timeline[$mile->id][5] == 1 ? 'checked' : '') }}>
                                    </td>
                                    <td
                                        class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][6]) && $timeline[$mile->id][6] == 1 ? 'background-blue' : '') }}">
                                        <input type="{{ $mile->is_text == 'yes' ? 'text' : 'checkbox' }}"
                                            name="timeline[{{ $mile->id }}][6]"
                                            value="{{ $mile->is_text == 'yes' ? $timeline[$mile->id][6] ?? '' : 1 }}"
                                            class="form-control p-0 {{ $mile->is_text == 'yes' ? '' : 'd-none' }}"
                                            {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][6]) && $timeline[$mile->id][6] == 1 ? 'checked' : '') }}>
                                    </td>
                                    <td
                                        class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][7]) && $timeline[$mile->id][7] == 1 ? 'background-blue' : '') }}">
                                        <input type="{{ $mile->is_text == 'yes' ? 'text' : 'checkbox' }}"
                                            name="timeline[{{ $mile->id }}][7]"
                                            value="{{ $mile->is_text == 'yes' ? $timeline[$mile->id][7] ?? '' : 1 }}"
                                            class="form-control p-0 {{ $mile->is_text == 'yes' ? '' : 'd-none' }}"
                                            {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][7]) && $timeline[$mile->id][7] == 1 ? 'checked' : '') }}>
                                    </td>
                                    <td
                                        class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][8]) && $timeline[$mile->id][8] == 1 ? 'background-blue' : '') }}">
                                        <input type="{{ $mile->is_text == 'yes' ? 'text' : 'checkbox' }}"
                                            name="timeline[{{ $mile->id }}][8]"
                                            value="{{ $mile->is_text == 'yes' ? $timeline[$mile->id][8] ?? '' : 1 }}"
                                            class="form-control p-0 {{ $mile->is_text == 'yes' ? '' : 'd-none' }}"
                                            {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][8]) && $timeline[$mile->id][8] == 1 ? 'checked' : '') }}>
                                    </td>
                                    <td
                                        class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][9]) && $timeline[$mile->id][9] == 1 ? 'background-blue' : '') }}">
                                        <input type="{{ $mile->is_text == 'yes' ? 'text' : 'checkbox' }}"
                                            name="timeline[{{ $mile->id }}][9]"
                                            value="{{ $mile->is_text == 'yes' ? $timeline[$mile->id][9] ?? '' : 1 }}"
                                            class="form-control p-0 {{ $mile->is_text == 'yes' ? '' : 'd-none' }}"
                                            {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][9]) && $timeline[$mile->id][9] == 1 ? 'checked' : '') }}>
                                    </td>
                                    <td
                                        class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][10]) && $timeline[$mile->id][10] == 1 ? 'background-blue' : '') }}">
                                        <input type="{{ $mile->is_text == 'yes' ? 'text' : 'checkbox' }}"
                                            name="timeline[{{ $mile->id }}][10]"
                                            value="{{ $mile->is_text == 'yes' ? $timeline[$mile->id][10] ?? '' : 1 }}"
                                            class="form-control p-0 {{ $mile->is_text == 'yes' ? '' : 'd-none' }}"
                                            {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][10]) && $timeline[$mile->id][10] == 1 ? 'checked' : '') }}>
                                    </td>
                                    <td
                                        class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][11]) && $timeline[$mile->id][11] == 1 ? 'background-blue' : '') }}">
                                        <input type="{{ $mile->is_text == 'yes' ? 'text' : 'checkbox' }}"
                                            name="timeline[{{ $mile->id }}][11]"
                                            value="{{ $mile->is_text == 'yes' ? $timeline[$mile->id][11] ?? '' : 1 }}"
                                            class="form-control p-0 {{ $mile->is_text == 'yes' ? '' : 'd-none' }}"
                                            {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][11]) && $timeline[$mile->id][11] == 1 ? 'checked' : '') }}>
                                    </td>
                                    <td
                                        class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][12]) && $timeline[$mile->id][12] == 1 ? 'background-blue' : '') }}">
                                        <input type="{{ $mile->is_text == 'yes' ? 'text' : 'checkbox' }}"
                                            name="timeline[{{ $mile->id }}][12]"
                                            value="{{ $mile->is_text == 'yes' ? $timeline[$mile->id][12] ?? '' : 1 }}"
                                            class="form-control p-0 {{ $mile->is_text == 'yes' ? '' : 'd-none' }}"
                                            {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][12]) && $timeline[$mile->id][12] == 1 ? 'checked' : '') }}>
                                    </td>
                                    @php

                                        // for physical and financial target
                                        if ($mile->is_text == 'yes') {
                                            if (in_array(strtolower(trim($mile->milestone)), \App\Helper\FinancialMilestone::milestoneNames())) {
                                                for ($i = 0; $i < 12; $i++) {
                                                    if (isset($timeline[$mile->id][$i + 1])) {
                                                        $ft = $ft + (int) $timeline[$mile->id][$i + 1];
                                                    }
                                                }
                                            }
                                            if (in_array(strtolower(trim($mile->milestone)), \App\Helper\PhysicalMilestone::milestoneNames())) {
                                                for ($i = 0; $i < 12; $i++) {
                                                    if (isset($timeline[$mile->id][$i + 1])) {
                                                        $pt = $pt + (int) $timeline[$mile->id][$i + 1];
                                                    }
                                                }
                                            }
                                        }
                                    @endphp
                                    @if ($key == 0 && $key2 == 0)
                                        <td rowspan="{{ $count }}" class="px-1 align-middle">
                                            <input id="ft_div" type="text" name="FT" readonly
                                                class="form-control p-0" />
                                        </td>
                                        <td rowspan="{{ $count }}" class="px-1 align-middle">
                                            <input id="pt_div" type="text" name="FP" readonly
                                                class="form-control p-0" />
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>



        <div class="d-flex justify-content-end" style="gap: 5px;">
            <a href="{{ route('projects.index', ['program' => $project->programID]) }}"
                class="btn btn-lg btn-secondary">Back</a>
            <button type="submit" class="btn btn-lg btn-primary">Save</button>
        </div>
    </form>

</div>


@push('modal')
    {{-- create new activity modal --}}
    <div class="modal fade" id="createNewActivityModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1052;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Activity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('project.mainActivity.store', $project->projectID) }}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Activity Name:<span class="text-danger">*</span></label>
                                <input required list="activity_datalist" type="text" name="activity"
                                    class="form-control" placeholder="Activities">
                                <datalist id="activity_datalist">
                                    <option value="Mobilization Advance">Mobilization Advance</option>
                                    <option value="Completion of 10% construction work">Completion of 10% construction work
                                    </option>
                                    <option value="Completion of 60% construction work">Completion of 60% construction work
                                    </option>
                                </datalist>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Main Responsibilities:<span class="text-danger">*</span></label>
                                <div>
                                    <select required class="form-control responsibility_user"
                                        id="main_responsibility_user" style="z-index: 1052;" name="main_responsibility[]"
                                        multiple="multiple">
                                        <option value="" disabled>--SELECT USER--</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Supportive Responsibilities:<span class="text-danger">*</span></label>
                                <div>
                                    <select required class="form-control responsibility_user"
                                        id="supportive_responsibility_user" style="z-index: 1052;"
                                        name="supportive_responsibility[]" multiple="multiple">
                                        <option value="" disabled>--SELECT USER--</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add New Activity</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- edit activity modal --}}
    @foreach ($project->projectActivity as $pro_act)
        <div class="modal fade" id="editActivityModal-{{ $pro_act->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1052;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Activity</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST"
                            action="{{ route('project.mainActivity.update', [$project->projectID, $pro_act->id]) }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Activity Name:<span class="text-danger">*</span></label>
                                    <input required list="activity_datalist" type="text" name="activity"
                                        class="form-control" placeholder="Activities" value="{{ $pro_act->activity }}">
                                    <datalist id="activity_datalist">
                                        <option value="Mobilization Advance">Mobilization Advance</option>
                                        <option value="Completion of 10% construction work">Completion of 10% construction
                                            work
                                        </option>
                                        <option value="Completion of 60% construction work">Completion of 60% construction
                                            work
                                        </option>
                                    </datalist>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Main Responsibilities:<span class="text-danger">*</span></label>
                                    <div>
                                        @php
                                            $main_responsibility = $pro_act->main_responsibility ?? [];
                                        @endphp

                                        <select required class="form-control responsibility_user"
                                            id="main_responsibility_user" style="z-index: 1052;"
                                            name="main_responsibility[]" multiple="multiple">
                                            <option value="" disabled>--SELECT USER--</option>
                                            @foreach ($users as $user)
                                                @if (in_array($user->id, $main_responsibility))
                                                    <option value="{{ $user->id }}" selected>
                                                        {{ $user->name }}</option>
                                                @else
                                                    <option value="{{ $user->id }}">
                                                        {{ $user->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Supportive Responsibilities:<span class="text-danger">*</span></label>
                                    <div>

                                        @php
                                            $supportive_responsibility = $pro_act->supportive_responsibility ?? [];
                                        @endphp
                                        <select required class="form-control responsibility_user"
                                            id="supportive_responsibility_user" style="z-index: 1052;"
                                            name="supportive_responsibility[]" multiple="multiple">
                                            <option value="" disabled>--SELECT USER--</option>
                                            @foreach ($users as $user)
                                                @if (in_array($user->id, $supportive_responsibility))
                                                    <option value="{{ $user->id }}" selected>
                                                        {{ $user->name }}</option>
                                                @else
                                                    <option value="{{ $user->id }}">
                                                        {{ $user->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Edit Activity</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endforeach

@endpush


{{-- Responsibilities scripts --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />



<script>
    $(document).ready(function() {

        $('.responsibility_user').select2({
            closeOnSelect: true,
        });
    });
</script>



<script>
    $('.clickable-box').click(function() {
        $(this).find("input").prop("checked", !$(this).find("input").prop("checked"));
        $(this).toggleClass('background-blue');
    })

    $('#ft_div').val({{ $ft }});
    $('#pt_div').val({{ $pt }});


    function uploadFT() {
        $.ajax({
            url: "/api/project/" + {{ $project->projectID }} + "/update/ft-pt",
            method: "POST",
            data: {
                ft: {{ $ft }},
                pt: {{ $pt }},
            },
            success: function(result) {
                console.log(result);
                window.location.reload();
                //reload page
            }
        })
    }
    @if ($ft != $project->FT || $pt != $project->FP)
        uploadFT();
    @endif
</script>
