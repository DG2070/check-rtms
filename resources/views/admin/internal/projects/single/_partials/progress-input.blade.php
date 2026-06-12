<div>

    {{-- content --}}
    <div>
        <div class="mt-4 ">
            <form method="POST" action="{{ route('internal.project.single.progress-input.timeline-progress') }}">
                {{-- <input type="hidden" name="projectID" value="{{ $projectId }}"> --}}
                @csrf
                <table class="table table-bordered progress_input_table tdf-table-primary">
                    <thead class="thead-blue">
                        <tr>
                            <th rowspan="2" colspan="2" class="align-middle text-center">Milestones</th>
                            <th colspan="3" class="align-middle text-center">1st Quarter</th>
                            <th colspan="3" class="align-middle text-center">2nd Quarter</th>
                            <th colspan="3" class="align-middle text-center">3rd Quarter</th>
                            <th colspan="3" class="align-middle text-center">4th Quarter</th>
                            <th rowspan="2" class="align-middle text-center">Disbursement Progress</th>
                            <th rowspan="2" class="align-middle text-center">Remark</th>
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
                        @if (!empty($project_datas))
                            @foreach ($project_datas as $item)
                                <tr>
                                    <td rowspan="3" style="min-width: 120px">
                                        {{ $item->activity_milestone }}
                                    </td>
                                    <td>T</td>

                                    @for ($i = 1; $i < 13; $i++)
                                        <td style="padding: 3px" class="{{ $item->is_text == 'yes' ? 'px-1' : '' }}">

                                            {{-- @php
                                                dd($i);
                                            @endphp --}}

                                            @if (isset($item->timeline_target[$i]) && $item->timeline_target[$i] != '')
                                                @if ($item->is_text == 'no' && $item->timeline_target[$i] == '1')
                                                    <div class="tdf-progress-input-target-box">

                                                    </div>
                                                @endif
                                            @endif

                                            <div class="text-center">
                                                {{ $item->is_text == 'yes' ? $item->timeline_target[$i] ?? '' : '' }}
                                            </div>
                                        </td>
                                    @endfor

                                    <td rowspan="2" class="text-center" style="padding: 0px !important">
                                        <textarea name="timeline_disbursement_progress[{{ $item->id }}]">{{ $item->timeline_disbursement_progress ?? '' }}</textarea>
                                    </td>
                                    <td rowspan="2" class="text-center" style="padding: 0px !important">
                                        <textarea name="remarks[{{ $item->id }}]">{{ $item->remark ?? '' }}</textarea>
                                    </td>

                                </tr>
                                <tr>
                                    <td> P</td>

                                    <input type="hidden" value="{{ $item->id }}"
                                        name="internal_project_data_id[{{ $item->id }}]">

                                    @for ($i = 1; $i < 13; $i++)
                                        <td class="px-1">
                                            @if (isset($item->timeline_target[$i]) && $item->timeline_target[$i] != '')
                                                <input
                                                    class="form-control p-0 {{ $item->is_text == 'yes' ? 'px-1' : 'clickable-box' }}"
                                                    type="{{ $item->is_text == 'yes' ? 'text' : 'checkbox' }}"
                                                    @if ($item->is_text == 'yes') min="0"
                                                                        step="0.01" @endif
                                                    name="progressinput[{{ $item->id }}][{{ $i }}]"
                                                    value="{{ $item->is_text == 'yes' ? $item->timeline_progress[$i] ?? '' : 1 }}"
                                                    {{ $item->is_text == 'yes' ? '' : (isset($item->timeline_progress[$i]) && $item->timeline_progress[$i] == 1 ? 'checked' : '') }}>
                                            @endif
                                        </td>
                                    @endfor

                                </tr>
                                <tr>
                                    <td> R</td>

                                    @for ($i = 1; $i < 13; $i++)
                                        <td class="px-1 text-center">
                                            @if (isset($item->timeline_target[$i]) && $item->timeline_target[$i] != '')
                                                <div class="text-canter" data-toggle="tooltip" data-placement="top"
                                                    title="{{ $item->timeline_remarks[$i] ?? '' }}">
                                                    <button type="button" class="btn btn-primary tdf-border-small"
                                                        data-toggle="modal"
                                                        data-target="#remarks-modal-{{ $item->id }}-{{ $i }}">
                                                        <i class="nav-icon fas fa-plus"></i>
                                                    </button>
                                                </div>


                                                {{-- remarks modal --}}
                                                <div class="modal fade"
                                                    id="remarks-modal-{{ $item->id }}-{{ $i }}"
                                                    tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">
                                                                    Remark</h5>
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
                                                                    action="{{ route('internal.project.single.progress-input.timeline-progress.remarks') }}">
                                                                    @csrf

                                                                    <input type="hidden" value="{{ $item->id }}"
                                                                        name="timeline_id">
                                                                    <input type="hidden" value="{{ $i }}"
                                                                        name="timeline_mnth">

                                                                    <div class="row">
                                                                        <div class="form-group col-md-12">
                                                                            <textarea name="remark" class="form-control" rows="15">{{ $item->timeline_remarks[$i] ?? '' }}</textarea>
                                                                        </div>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
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
                            @endforeach
                        @endif

                    </tbody>
                </table>
                {{-- actions --}}
                <div class="text-right">
                    <button type="submit" class="btn btn-primary btn-tdf-primary">Update Progress</button>
                </div>
            </form>
        </div>
    </div>
    {{-- !ENDS content --}}

</div>



@push('script')
    <style>
        .progress_input_table td {
            height: 50px;
            width: 50px;
        }
    </style>




    <style>
        $("body").on("click", ".delete-activity", function(e) {
                e.preventDefault();
                var target=this;

                if (confirm("Do you really want to delete this activity?")) {
                    $(target).closest('form').submit();

                }
            }

        );
    </style>
@endpush
