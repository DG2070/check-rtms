<table border="1" class="table table-responsive custom-table tdf-table-primary" style="text-align: left;">
    <thead>
        <tr>
            <th width="2%" rowspan="3">S.N</th>
            <th rowspan="3">Project Name</th>
            <th colspan="2">Project status as of the end of FY 2079/80</th>
            <th rowspan="3">Approved Budget FY 2079/80</th>
            <th rowspan="3">Main Activities (Total: target of this year)</th>
            <th rowspan="3">Milestones</th>
            <th colspan="14">Timeline {{ $is_pdf ? '(Quarter)' : '' }}</th>
            <th rowspan="3">Performance Indicators</th>
            <th colspan="2">Responsibility</th>
            <th rowspan="3">Remarks</th>
        </tr>

        <tr>
            <th rowspan="2">Physical</th>
            <th rowspan="2">Financial</th>
            <th colspan="3">1st {{ $is_pdf ? '' : 'Quarter' }}</th>
            <th colspan="3">2nd {{ $is_pdf ? '' : 'Quarter' }}</th>
            <th colspan="3">3rd {{ $is_pdf ? '' : 'Quarter' }}</th>
            <th colspan="3">4th {{ $is_pdf ? '' : 'Quarter' }}</th>
            <th colspan="2">Total </th>
            <th rowspan="2">Main Responsibility</th>
            <th rowspan="2">Supportive Responsibility</th>
        </tr>

        <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>FT</th>
            <th>PT</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($program->project as $pro_key => $project)
            @php $count = 0; @endphp
            @foreach ($project->projectActivity as $pro_act)
                @php $count += count($pro_act->milestone); @endphp
            @endforeach
            @foreach ($project->projectActivity as $key => $pro_act)
                @foreach ($pro_act->milestone as $key2 => $mile)
                    <tr>
                        @if ($key == 0 && $key2 == 0)
                            <td rowspan="{{ $count }}">{{ $pro_key + 1 }}</td>
                            <td rowspan="{{ $count }}" class="text-nowrap">{{ $project->Name }}</td>
                            <td rowspan="{{ $count }}">
                                {{ $project->lastProgress->physical_progress ?? 0 }}%
                                {{-- @if ($project->lastProgress && !$is_pdf)
                                    <div>
                                        <a href="{{ route('project.physicalProgress.edit', ['id' => $project->projectID, 'progress' => $project->lastProgress->id]) }}">
                                            link
                                        </a>
                                    </div>
                                @endif --}}
                            </td>
                            <td rowspan="{{ $count }}">NA</td>
                            <td rowspan="{{ $count }}">
                                {{ isset($project->lastDisbursement->Disbursement) ? $project->lastDisbursement->Disbursement : 'NA' }}
                            </td>
                        @endif

                        @if ($key2 == 0)
                            <td rowspan="{{ count($pro_act->milestone) }}" class="text-nowrap">
                                {{ $pro_act->activity }}</td>
                        @endif

                        <td class=" text-left" style="min-width: 400px;max-width: 400px">
                            {{ $mile->milestone }}
                        </td>

                        @if ($mile->timeline)
                            @foreach ($mile->timeline->timeline ?? [] as $time)
                                @if ($mile->is_text == 'yes')
                                    <td>{{ $time }}</td>
                                @else
                                    <td class="@if ($time) bg-success @endif"></td>
                                @endif
                            @endforeach
                        @else
                            @for ($i = 0; $i < 12; $i++)
                                <td>
                                </td>
                            @endfor
                        @endif

                        @if ($key == 0 && $key2 == 0)
                            <td rowspan="{{ $count }}">{{ $project->FT ?? '' }}</td>
                            <td rowspan="{{ $count }}">{!! $project->FP ?? '' !!}</td>
                        @endif

                        <td class="text-nowrap text-left">{{ $mile->performance_indicator }}</td>

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
                            <td rowspan="{{ count($pro_act->milestone) }}" class="text-nowrap">{{ $pro_act->remark }}
                            </td>
                        @endif

                    </tr>
                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>
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
        /* padding: 15px; */;
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
        /* padding: 15px; */;
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
