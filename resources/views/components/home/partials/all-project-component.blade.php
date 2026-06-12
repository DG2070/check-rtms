<div class="home-assigned-project-component-type-2">
    <div class="card card-body">
        <div class="main-title">
            All Projects FY {{ App\Helper\FiscalYear::curentFullFiscalYear() }}
        </div>

        <div class="table-container table-responsive">
            <table class="table table-bordered dashboardTable">
                <thead class="thead-blue ">
                    <tr>
                        <th scope="col">Project</th>
                        <th scope="col">Program</th>
                        <th scope="col">Province</th>
                        <th scope="col">Main/Supportive</th>
                        <th scope="col">PME Achived %</th>
                        <th scope="col">Started At</th>
                        {{-- <th scope="col">Action</th> --}}
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
                                        {{ $project->program->Name ?? '' }}
                                    </span>
                                </td>
                                <td>
                                    @php

                                        $province = [
                                            [
                                                'id' => 01,
                                                'ename' => 'Province 1',
                                                'nname' => 'प्रदेश नं. १',
                                            ],
                                            [
                                                'id' => 02,
                                                'ename' => 'Madhesh Province',
                                                'nname' => 'मधेश प्रदेश',
                                            ],
                                            [
                                                'id' => 03,
                                                'ename' => 'Bagmati Province',
                                                'nname' => 'वाग्मती प्रदेश',
                                            ],
                                            [
                                                'id' => 04,
                                                'ename' => 'Gandaki Province',
                                                'nname' => 'गण्डकी प्रदेश',
                                            ],
                                            [
                                                'id' => 05,
                                                'ename' => 'Lumbini Province',
                                                'nname' => 'लुम्बिनी प्रदेश',
                                            ],
                                            [
                                                'id' => 06,
                                                'ename' => 'Karnali Province',
                                                'nname' => 'कर्णाली प्रदेश',
                                            ],
                                            [
                                                'id' => 07,
                                                'ename' => 'Sudurpashchim Province',
                                                'nname' => 'सुदूरपश्चिम प्रदेश',
                                            ],
                                        ];
                                        $province_no = 0;
                                        //belongs to certain province via townlist
                                        if (!empty($project->town) && !empty($project->town->Province) && intval($project->town->Province) < 8) {
                                            $province_no = intval($project->town->Province);
                                        }

                                    @endphp

                                    @if ($province_no > 0)
                                        {{ $province[$province_no - 1]['ename'] ?? '' }}
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap">
                                        @php
                                            //for unique main/supportive users
                                            $main_supportive_responsibility = [];
                                        @endphp
                                        @foreach ($project->projectActivity ?? [] as $pro_act)
                                            @foreach (\App\Models\User::whereIn('id', $pro_act->main_responsibility ?? [])->orWhereIn('id', $pro_act->supportive_responsibility ?? [])->get() as $user)
                                                @if (!in_array($user->id, $main_supportive_responsibility))
                                                    <div>
                                                        {{ $user->name }}
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    </div>
                                                    @php
                                                        //add in array
                                                        array_push($main_supportive_responsibility, $user->id);
                                                    @endphp
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </div>
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
                                {{-- <td>
                                    <div class="text-center">
                                        <a href="/programs/new?programID={{ $project['programID'] }}&projectID={{ $project['projectID'] }}"
                                            target="_blank" class="btn btn-primary btn-tdf-primary" type="button">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                </td> --}}
                            </tr>
                        @endforeach
                    @endif
                </tbody><!-- end tbody -->

            </table>
        </div>
    </div>
</div>
