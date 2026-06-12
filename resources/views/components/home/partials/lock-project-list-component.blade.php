<div class="home-assigned-project-component">
    <div class="card card-body">
        <div class="main-title">
            All Locked Targets
            {{-- FY {{ App\Helper\FiscalYear::curentFullFiscalYear() }} --}}
        </div>
        <div class="table-container table-responsive">
            <table class="table table-bordered dashboardTable">
                <thead class="thead-blue ">
                    <tr>
                        <th scope="col">Project Name</th>
                        <th scope="col">Program Name</th>
                        <th scope="col">Started At</th>
                        <th scope="col">Locked At</th>
                        <th scope="col">Locked By</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if (!empty($project_datas))
                        @foreach ($project_datas as $project_data)
                            <tr>
                                <td>{{ $project_data->project->Name }}
                                    <span class="badge badge-info">
                                        {{ $project_data->project->TownName ?? '' }}
                                    </span>
                                </td>
                                <td>
                                    {{ $project_data->project->program->NameLong }}
                                    <span class="badge badge-info">
                                        {{ $project_data->project->program->Code ?? '' }}
                                    </span>
                                </td>
                                <td class="text-muted">
                                    {{ isset($project_data->project->curentFiscialYearProjectDataSQ) ? $project_data->project->curentFiscialYearProjectDataSQ->created_at->toDateString() : '' }}
                                </td>
                                <td class="text-muted">
                                    {{ \Carbon\Carbon::parse($project_data->locked_at)->toDateString() }}
                                </td>
                                <td>
                                    <div>
                                        {{ $project_data->lockedUser->name }}
                                    </div>
                                    <div>
                                        {{ $project_data->lockedUser->email }}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        {{-- <a href="/programs/new?programID={{ $project_data->project['programID'] }}&projectID={{ $project_data->project['projectID'] }}"
                                            target="_blank" class="btn btn-primary btn-tdf-primary" type="button">
                                            <i class="fa fa-eye"></i>
                                        </a> --}}
                                        <button type="button" class="btn btn-danger tdf-border-small"
                                            data-toggle="modal"
                                            data-target="#unlockTargetModal-{{ $project_data->project['projectID'] }}">Unlock
                                            Target</button>
                                        {{-- unlock target modal --}}
                                        <div class="modal fade"
                                            id="unlockTargetModal-{{ $project_data->project['projectID'] }}"
                                            tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1052;">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Unlock Target ?</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="">
                                                            <input type="hidden">
                                                        </form>
                                                        <form method="POST" action="{{ route('set-target.unlock') }}">
                                                            @csrf
                                                            <input type="hidden" name="fiscal_year"
                                                                value="{{ request('fiscal_year', '79/80') }}">
                                                            <input type="hidden" name="project_id"
                                                                value="{{ $project_data->project['projectID'] }}">
                                                            <button type="button"
                                                                class="btn btn-secondary tdf-border-small"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                class="btn btn-danger tdf-border-small">Unlock</button>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody><!-- end tbody -->

            </table>
        </div>
    </div>
</div>
