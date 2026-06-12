<div>
    @php $count = 0; @endphp
    @foreach ($project->projectActivity as $pro_act)
        @php $count += count($pro_act->milestone); @endphp
    @endforeach
    <div style="background: #EDEFF2; padding-bottom: 30px; padding: 30px;">
        <form method="POST" action="{{ route('project.milestone.review.store', $project->projectID) }}">
            @csrf
            <table border="1" class="table table-responsive" style="text-align: center;">
                <thead>
                    <tr style="border-color: #fff; background-color: #225e95; color: #fff;">
                        <th rowspan="3">S.N</th>
                        <th rowspan="3">Project Name</th>
                        <th colspan="2">Project status as of the end of FY 2079/80</th>
                        <th rowspan="3">Approved Budget FY 2079/80</th>
                        <th rowspan="3">Main Activities (Total: target of this year)</th>
                        <th rowspan="3">Milestone</th>
                        <th rowspan="3">Performance Indicators</th>
                        <th rowspan="3">Progress</th>
                        <th colspan="2">PME Review (Target)</th>
                        <th colspan="2">Responsibility</th>
                        <th rowspan="2">Remarks</th>
                    </tr>

                    <tr style=" border-color: #fff; background-color: #225e95; color: #fff;">
                        <th>Physical</th>
                        <th>Financial</th>
                        <th>Achived</th>
                        <th>Not Achived</th>
                        <th>Main Responsibility</th>
                        <th>Supportive Responsibility</th>
                    </tr>

                </thead>
                <tbody style="border-color: #225e95;">
                    @foreach ($project->projectActivity as $key => $pro_act)
                        @foreach ($pro_act->milestone as $key2 => $mile)
                            <tr>
                                @if ($key == 0 && $key2 == 0)
                                    <td rowspan="{{ $count }}">{{ $loop->iteration }}</td>
                                    <td rowspan="{{ $count }}" class="text-nowrap">{{ $project->Name }}</td>
                                    <td rowspan="{{ $count }}">
                                        {{ $project->progress[$loop->index]->physical_progress ?? 0 }}%</td>
                                    <td rowspan="{{ $count }}">
                                        {{ isset($project->lastDisbursement) ? number_format($project->lastDisbursement->TDFContractedCost * 1000) : 'NA' }}
                                    </td>
                                    <td rowspan="{{ $count }}">
                                        {{ isset($project->lastDisbursement->Disbursement) ? $project->lastDisbursement->Disbursement : 'NA' }}
                                    </td>
                                @endif

                                @if ($key2 == 0)
                                    <td rowspan="{{ count($pro_act->milestone) }}" class="text-nowrap">
                                        {{ $pro_act->activity }}</td>
                                @endif

                                <td class=" text-left" style="max-width: 300px;min-width: 300px">{{ $mile->milestone ?? '' }}</td>
                                <td class="text-nowrap text-left">{{ $mile->performance_indicator ?? '' }}</td>

                                <td>
                                    <input type="text" name="progress[{{ $mile->id }}]"
                                        value="{{ $reviews->progress[$mile->id] ?? '' }}" placeholder="Progress">
                                </td>
                                <td>
                                    <input type="radio" name="target[{{ $mile->id }}]" value="achived"
                                        {{ isset($reviews->target[$mile->id]) && $reviews->target[$mile->id] == 'achived' ? 'checked' : '' }}>
                                </td>
                                <td>
                                    <input type="radio" name="target[{{ $mile->id }}]" value="not_achived"
                                        {{ isset($reviews->target[$mile->id]) && $reviews->target[$mile->id] == 'not_achived' ? 'checked' : '' }}>
                                </td>

                                @if ($key2 == 0)
                                    <td rowspan="{{ count($pro_act->milestone) }}" class="text-nowrap">
                                        <div class="d-flex flex-wrap">
                                            @foreach (\App\Models\User::whereIn('id', $pro_act->main_responsibility ?? [])->get() as $user)
                                                <div>
                                                    {{ $user->name }}
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td rowspan="{{ count($pro_act->milestone) }}" class="text-nowrap">
                                        <div class="d-flex flex-wrap">
                                            @foreach (\App\Models\User::whereIn('id', $pro_act->supportive_responsibility ?? [])->get() as $user)
                                                <div>
                                                    {{ $user->name }}
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                @endif
                                <td>
                                    <textarea name="remarks[{{ $mile->id }}]">{{ $reviews->remarks[$mile->id] ?? '' }}</textarea>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach

                </tbody>
            </table>
            <div
                style="display:flex; gap: 10px; align-items: flex-end; justify-content: flex-end; width: 95%; margin:auto">
                <a href="{{ route('projects.index', ['program' => $project->programID]) }}"
                    class="btn btn-lg btn-secondary">Back</a>
                <button class="btn btn-lg btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>
