<div class="home-assigned-project-component">
    <div class="card card-body">
        <div class="main-title">
            Assigned Projects FY {{ App\Helper\FiscalYear::curentFullFiscalYear() }}
        </div>

        <div class="table-container table-responsive">
            <table class="table table-bordered dashboardTable">
                <thead class="thead-blue ">
                    <tr>
                        <th scope="col">Project Name</th>
                        <th scope="col">Program Name</th>
                        <th scope="col">Progress</th>
                        <th scope="col">Started At</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if (!empty($projects))
                        @foreach ($projects as $project)
                            <tr>
                                <td>{{ $project->Name }}
                                    <span class="badge badge-info">
                                        {{ $project->TownName ?? '' }}
                                    </span>

                                </td>
                                <td>
                                    {{ $project->program->NameLong }}
                                    <span class="badge badge-info">
                                        {{ $project->program->Code ?? '' }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $has_pme_reviewed = false;
                                        $milestone_count_for_project = 0;
                                        $achived_no_of_milestones = 0;
                                        $target = 0;

                                        foreach ($project->projectActivity as $projectActivity) {
                                            $milestone_count_for_project = $milestone_count_for_project + count($projectActivity->milestone);
                                        }

                                        if (!empty($project->projectReview->target)) {
                                            //check if pme has atleast reviewed one
                                            foreach ($project->projectReview->target as $key => $value) {
                                                if ($value == 'achived') {
                                                    $achived_no_of_milestones++;
                                                }

                                                if ($value == 'not_achived') {
                                                    $has_pme_reviewed = true;
                                                }
                                            }
                                        }

                                        if ($milestone_count_for_project != 0) {
                                            $target = ($achived_no_of_milestones / $milestone_count_for_project) * 100;
                                            $targer = round($target, 0);
                                        }

                                        $progress_color = 'yellow';
                                        if ($target > 70) {
                                            $progress_color = 'green';
                                        }
                                        if ($target < 60) {
                                            $progress_color = 'red';
                                        }
                                    @endphp

                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-1 text-muted fs-13">{{ round($target, 0) }}%</div>
                                        <div class="progress progress-sm  flex-grow-1"
                                            style="width: {{ round($target, 0) ?? 0 }}%;">
                                            <div class="progress-bar bg-success rounded" role="progressbar"
                                                style="width: {{ round($target, 0) ?? 0 }}%"
                                                aria-valuenow="{{ round($target, 0) ?? 0 }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-muted">

                                    {{ isset($project->curentFiscialYearProjectDataSQ) ? $project->curentFiscialYearProjectDataSQ->created_at->toDateString() : '' }}
                                </td>
                                <td>
                                    <div class="text-center">
                                        <a href="/programs/new?programID={{ $project['programID'] }}&projectID={{ $project['projectID'] }}"
                                            target="_blank" class="btn btn-primary btn-tdf-primary" type="button">
                                            <i class="fa fa-eye"></i>
                                        </a>
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
