<div class="contents activity-milestone-container card card-body">


    {{-- activity container --}}
    <div class="pt-4">
        <h4><strong>Activities For FY 20{{ $fiscal_year }}: </strong></h4>

        @if (!$target_locked)
            <div class="my-2">
                <button type="button" class="btn btn-primary btn-tdf-primary tdf-border-small" data-toggle="modal"
                    data-target="#createNewActivityModal">Add New Activity For FY
                    20{{ $fiscal_year }} </button>
            </div>
        @endif

        <table class="table table-bordered">
            <thead class="thead-blue">
                <tr>
                    <th>Activities</th>
                    <th>Main Responsibilities</th>
                    <th>Supportive Responsibilities</th>
                    @if (!$target_locked)
                        <th>Operations</th>
                    @endif
                </tr>
            </thead>
            <tbody>

                @foreach ($project->projectActivity as $pro_act)
                    <tr>
                        <td>
                            <input readonly type="text" name="activity" class="form-control"
                                value="{{ $pro_act->activity }}" placeholder="Activities">
                        </td>
                        <td>
                            @php
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
                        @if (!$target_locked)
                            <td>
                                <div class="text-center">
                                    <button class="btn btn-dark tdf-border-small" type="button" data-toggle="modal"
                                        data-target="#editActivityModal-{{ $pro_act->id }}">
                                        <i class="fa fa-pen"></i>
                                    </button>

                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['set-target.activity.delete', $pro_act->id],
                                        'style' => 'display:inline',
                                    ]) !!}
                                    <button type="submit" class="btn btn-danger delete-activity tdf-border-small">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    {!! Form::close() !!}
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    {{-- !ENDS activity container --}}

    {{-- milestone container --}}
    <div id="vue-for-milestone-draggable">
        <flow-set-target-milestone :fiscal_year="{{ json_encode($fiscal_year) }}"
            :project_id="{{ json_encode($project->projectID) }}" :milestones_data="{{ json_encode($milestones_data) }}"
            :activities_data="{{ json_encode($activities_data) }}"
            :old_milestones_name="{{ json_encode($old_milestones_name) }}"
            :old_performance_indicator_name="{{ json_encode($old_performance_indicator_name) }}"
            :is_locked="{{ json_encode($target_locked) }}" />
    </div>
    {{-- !ENDS milestone container --}}


    {{-- Timeline Section --}}
    <section class="timeline-section">
        <div>
            @php $count = 0; @endphp
            @foreach ($project->projectActivity as $pro_act)
                @php $count += count($pro_act->milestone); @endphp
            @endforeach

            <form
                @if (!$target_locked) method="POST" action="{{ route('project.timeline.store', $project->projectID) }}" @endif>
                @csrf
                <input type="hidden" name="fiscal_year" value="{{ $fiscal_year }}">
                <div class="mt-4">
                    <h4><strong>Timeline For FY 20{{ $fiscal_year }}:</strong></h4>

                    <div class="table-responsive">
                        <table class="table table-bordered tdf-table-primary" style="text-align: left">
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
                                            
                                            // for physical and financial target
                                            if ($mile->is_text == 'yes') {
                                                if (in_array(strtolower(trim($mile->milestone)), \App\Helper\FinancialMilestone::milestoneNames())) {
                                                    // dd($mile);
                                                    for ($i = 0; $i < 12; $i++) {
                                                        //   dd($i);
                                                        if (isset($timeline[$mile->id][$i + 1])) {
                                                            $ft = $ft + (int) $timeline[$mile->id][$i + 1];
                                                            // dd($ft);
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
                                        <tr>
                                            <input type="hidden" value="{{ $mile->id }}"
                                                name="milestone_id[{{ $mile->id }}]">
                                            <td style="max-width: 300px;min-width: 300px">{{ $mile->milestone }}</td>

                                            @for ($i = 1; $i < 13; $i++)
                                                <td
                                                    class="{{ $mile->is_text == 'yes' ? 'px-1' : 'clickable-box' }} {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][$i]) && $timeline[$mile->id][$i] == 1 ? 'background-blue' : '') }}">
                                                    <input @if ($target_locked) disabled="disabled" @endif
                                                        type="{{ $mile->is_text == 'yes' ? 'number' : 'checkbox' }}"
                                                        min="0"
                                                        @if ($mile->is_text == 'yes') step="0.01" @endif
                                                        name="timeline[{{ $mile->id }}][{{ $i }}]"
                                                        value="{{ $mile->is_text == 'yes' ? $timeline[$mile->id][$i] ?? '' : 1 }}"
                                                        class="form-control p-0 {{ $mile->is_text == 'yes' ? '' : 'd-none' }}"
                                                        {{ $mile->is_text == 'yes' ? '' : (isset($timeline[$mile->id][$i]) && $timeline[$mile->id][$i] == 1 ? 'checked' : '') }}>
                                                </td>
                                            @endfor

                                            @if ($key == 0 && $key2 == 0)
                                                <td rowspan="{{ $count }}" class="px-1 align-middle">
                                                    <input id="ft_div" type="text" name="FT" readonly
                                                        class="form-control p-0" />
                                                </td>
                                                <td rowspan="{{ $count }}" class="px-1 align-middle">
                                                    <input id="pt_div" type="text" name="PT" readonly
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

                @if (!$target_locked)
                    <div class="d-flex justify-content-end" style="gap: 5px;">
                        <button type="submit" class="btn btn-lg btn-primary tdf-border-small">Save Timeline For FY
                            20{{ $fiscal_year }}</button>
                    </div>
                @endif
            </form>
        </div>
    </section>
    {{-- !ENDS Timeline Section --}}

</div>

<div>
    @if (!empty($project->projectActivity) && count($project->projectActivity) > 0)
        {{-- Budget section --}}
        <section class="lock-section mt-4">
            <div class="card card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d flex">
                            <h4 class="h5">
                                <strong>
                                    Approved Budget FY {{ '20' . $fiscal_year }}:
                                </strong>
                                <span class="my-4">
                                    {{ !empty($project->projectDataSQ) ? $project->projectDataSQ->approved_budget : 'NA' }}
                                </span>

                                @if (!$target_locked)
                                    <button type="button" class="btn btn-dark tdf-border-small" data-toggle="modal"
                                        data-target="#addBudgetModal">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                @endif
                            </h4>
                            @if (!$target_locked)
                                <div class="modal fade" id="addBudgetModal" tabindex="-1" role="dialog"
                                    aria-hidden="true" style="z-index: 1052;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Approved Budget FY {{ '20' . $fiscal_year }}
                                                    For
                                                    {{ $project->NameLong }}?</h5>
                                                <button type="button" class="close tdf-border-small"
                                                    data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('set-target.budget.add') }}">
                                                    @csrf
                                                    <input type="hidden" name="fiscal_year"
                                                        value="{{ $fiscal_year }}">
                                                    <input type="hidden" name="project_id"
                                                        value="{{ $project->projectID }}">

                                                    <div class="form-group col-md-12">
                                                        <label>Approved Budget:<span
                                                                class="text-danger">*</span></label>
                                                        <input required type="number" min="0" step="0.01"
                                                            name="approved_budget" class="form-control"
                                                            placeholder="Approved Budget">
                                                    </div>

                                                    <button type="button" class="btn btn-secondary tdf-border-small"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit"
                                                        class="btn btn-primary btn-tdf-primary">Save</button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </section>
        {{-- !ENDS Budget section --}}

        {{-- physcial progress section --}}
        <section class="lock-section mt-4">
            <div class="card card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d flex">
                            <h4 class="h5">
                                <strong>
                                    Physical Progress by the end of FY
                                    20{{ App\Helper\FiscalYear::previousFYFromGivenFY($fiscal_year) }}:
                                </strong>
                                <span class="my-4">
                                    @if (!empty($project->projectDataSQ) && !empty($project->projectDataSQ->physical_progress))
                                        {{ $project->projectDataSQ->physical_progress }}%
                                    @else
                                        NA
                                    @endif
                                </span>

                                @if (!$target_locked)
                                    <button type="button" class="btn btn-dark tdf-border-small" data-toggle="modal"
                                        data-target="#addPhysicalProgressByYearEnd">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                @endif
                            </h4>
                            @if (!$target_locked)
                                <div class="modal fade" id="addPhysicalProgressByYearEnd" tabindex="-1"
                                    role="dialog" aria-hidden="true" style="z-index: 1052;">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Physical Progress by the end of FY
                                                    {{ '20' . $fiscal_year }}</h5>
                                                <button type="button" class="close tdf-border-small"
                                                    data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"
                                                    action="{{ route('set-target.physical-progress.add') }}">
                                                    @csrf
                                                    <input type="hidden" name="fiscal_year"
                                                        value="{{ $fiscal_year }}">
                                                    <input type="hidden" name="project_id"
                                                        value="{{ $project->projectID }}">

                                                    <div class="form-group col-md-12">
                                                        <label>Physical Progress:<span
                                                                class="text-danger">*</span></label>
                                                        <input required type="number" min="0" step="0.01"
                                                            name="physical_progress" class="form-control"
                                                            placeholder="Physical Progress">
                                                    </div>

                                                    <button type="button" class="btn btn-secondary tdf-border-small"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit"
                                                        class="btn btn-primary btn-tdf-primary tdf-border-small">Save</button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </section>
        {{-- !ENDS physcial progress section --}}

        {{-- approved cost section --}}
        <section class="lock-section mt-4">
            <div class="card card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d flex">
                            <h4 class="h5">
                                <strong>
                                    TDF Approved Cost:
                                </strong>
                                <span class="my-4">
                                    {{ !empty($project->projectDataSQ) ? $project->projectDataSQ->approved_cost : 'NA' }}
                                </span>
                            </h4>
                        </div>


                    </div>
                </div>
            </div>
        </section>
        {{-- !ENDS approved cost section --}}

        {{-- contractual_cost section --}}
        <section class="lock-section mt-4">
            <div class="card card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d flex">
                            <h4 class="h5">
                                <strong>
                                    TDF Construction Cost Contracted:
                                </strong>
                                <span class="my-4">
                                    {{ !empty($project->projectDataSQ) ? $project->projectDataSQ->contractual_cost : 'NA' }}
                                </span>
                            </h4>
                        </div>


                    </div>
                </div>
            </div>
        </section>
        {{-- !ENDS contractual_cost section --}}

        {{-- aggrement_date section --}}
        <section class="lock-section mt-4">
            <div class="card card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d flex">
                            <h4 class="h5">
                                <strong>
                                    Agreement Date:
                                </strong>
                                <span class="my-4">
                                    {{ !empty($project->projectDataSQ) ? $project->projectDataSQ->aggrement_date : 'NA' }}
                                </span>
                            </h4>
                        </div>


                    </div>
                </div>
            </div>
        </section>
        {{-- !ENDS aggrement_date section --}}

    @endif
</div>



{{-- lock section --}}
@if (!empty($project->projectActivity) && count($project->projectActivity) > 0)
    <section class="lock-section mt-4">
        <div class="card card-body">
            <div class="row">
                <div class="col-12">
                    <h4 class="h5"><strong>Controls: </strong></h4>
                    <div class="my-2">
                        @if ($target_locked)
                            <div class="alert alert-info">
                                Target Has been Locked on
                                <span>
                                    <u>
                                        {{ $project->projectDataSQ->locked_at }}
                                    </u>
                                </span>
                                by User
                                <span>
                                    <u>
                                        {{ $project->projectDataSQ->user->name ?? '' }}
                                    </u>
                                </span>
                                with Email
                                <span>
                                    <u>
                                        {{ $project->projectDataSQ->user->email ?? '' }}
                                    </u>
                                </span>
                            </div>
                            @if (Auth::user()->hasAnyRole(['Sysqube-Super-Admin', 'ED']))
                                <div>
                                    <button type="button" class="btn btn-danger tdf-border-small"
                                        data-toggle="modal" data-target="#unlockTargetModal">Unlock Target For FY
                                        20{{ $fiscal_year }}</button>
                                </div>
                            @endif
                        @else
                            <button type="button" class="btn btn-danger tdf-border-small" data-toggle="modal"
                                data-target="#lockTargetModal">Lock Target For FY 20{{ $fiscal_year }}</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
{{-- !ENDS lock section --}}


{{-- delete section --}}
{{-- TODO: DO NOT REMOVE MIGHT BE NEEDED IN FUTURE --}}
{{-- @if (Auth::user()->hasAnyRole(['Sysqube-Super-Admin', 'ED']))
    <section class="lock-section mt-4">
        <div class="card card-body">
            <div class="row">
                <div class="col-12">
                    <h4 class="h5"><strong>Dangerous Area: </strong></h4>
                    <div class="my-2">
                        <button type="button" class="btn btn-danger tdf-border-small" data-toggle="modal"
                            data-target="#deleteAllProjectData">Delete All Project Data</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif --}}
{{-- !ENDS delete section --}}



@push('modal')
    {{-- deletet modal --}}
    @if (Auth::user()->hasAnyRole(['Sysqube-Super-Admin', 'ED']))
        <div class="modal fade" id="deleteAllProjectData" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1052;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete All Data?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            <input type="hidden">
                        </form>
                        <form method="POST" action="{{ route('set-target.delete-project-data') }}">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->projectID }}">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete All Data</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endif
    {{-- lock target modal --}}
    <div class="modal fade" id="lockTargetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true" style="z-index: 1052;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lock Target For FY 20{{ $fiscal_year }} On
                        Project {{ $project->NameLong }}?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <input type="hidden">
                    </form>
                    <form method="POST" action="{{ route('set-target.lock') }}">
                        @csrf
                        <input type="hidden" name="fiscal_year" value="{{ $fiscal_year }}">
                        <input type="hidden" name="project_id" value="{{ $project->projectID }}">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Lock</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    {{-- unlock target modal --}}
    <div class="modal fade" id="unlockTargetModal" tabindex="-1" role="dialog" aria-hidden="true"
        style="z-index: 1052;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Unlock Target For FY 20{{ $fiscal_year }} On
                        Project {{ $project->NameLong }}?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <input type="hidden">
                    </form>
                    <form method="POST" action="{{ route('set-target.unlock') }}">
                        @csrf
                        <input type="hidden" name="fiscal_year" value="{{ $fiscal_year }}">
                        <input type="hidden" name="project_id" value="{{ $project->projectID }}">
                        <button type="button" class="btn btn-secondary tdf-border-small"
                            data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger tdf-border-small">Unlock</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
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
                        <input type="hidden" name="fiscal_year" value="{{ $fiscal_year }}" />
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Fiscal Year:<span class="text-danger">*</span></label>
                                <input disabled="disabled" type="text" class="form-control"
                                    value="20{{ $fiscal_year }}">
                            </div>
                            <div class="form-group col-md-12">
                                <label>Activity Name:<span class="text-danger">*</span></label>
                                <input required list="activity_datalist" type="text" name="activity"
                                    class="form-control" placeholder="Activities">
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
                            <input type="hidden" name="fiscal_year" value="{{ $pro_act->fiscal_year }}" />
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Fiscal Year:<span class="text-danger">*</span></label>
                                    <input disabled="disabled" type="text" class="form-control"
                                        value="{{ '20' . $pro_act->fiscal_year }}">
                                </div>
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


@push('script')
    <script>
        $(document).ready(function() {
            $('.responsibility_user').select2({
                closeOnSelect: true,
            });
        });
    </script>
    <script>
        $('.clickable-box').click(function() {
            @if (!$target_locked)
                $(this).find("input").prop("checked", !$(this).find("input").prop("checked"));
                $(this).toggleClass('background-blue');
            @endif
        })

        console.log({{ $ft }});

        if ({{ $ft }} != 0) {
            $('#ft_div').val({{ $ft }});
        }
        if ({{ $pt }} != 0) {
            $('#pt_div').val({{ $pt }});
        }


        @if (!empty($project->projectDataSQ) && ($ft != $project->projectDataSQ->FT || $pt != $project->projectDataSQ->PT))
            function uploadFT() {
                $.ajax({
                    url: "/api/project/" + {{ $project->projectID }} + "/update/ft-pt",
                    method: "POST",
                    data: {
                        ft: {{ $ft }},
                        pt: {{ $pt }},
                        project_data_sq_id: {{ $project->projectDataSQ->id }},
                    },
                    success: function(result) {
                        // console.log(result);
                        window.location.reload();
                        //reload page
                    }
                })
            }
            uploadFT();
        @endif
    </script>
    <script>
        // delete-activity
        $("body").on("click", ".delete-activity", function(e) {
            e.preventDefault();
            var target = this;
            if (confirm("Do you really want to delete this activity?")) {
                $(target).closest('form').submit();

            }
        });
        // $("body").on("click", ".delete-milestone", function(e) {
        //     e.preventDefault();
        //     var target = this;
        //     if (confirm("Do you really want to delete this milestone?")) {
        //         $(target).closest('form').submit();

        //     }
        // });
    </script>
@endpush
