@extends('layouts.app')

@section('title', 'Progress Report Performance Review')

@include('layouts.includes.data-table.style')

@section('content')
<style>
    th,
    td {
        vertical-align: middle !important;
    }
</style>
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h4 class="text-center">
                        <strong>Progress Report Performance for {{ $project->Name }}</strong>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

@include("layouts.includes.errors")

@php $count = 0; @endphp
@foreach($project->projectActivity as $pro_act)
@php $count += count($pro_act->milestone); @endphp
@endforeach
<div style="background: #EDEFF2; padding-bottom: 30px; padding: 30px;">

    <form method="POST" action="{{ route('project.milestone.review.store', $project->projectID) }}">
        @csrf
        <table border="1" class="table table-responsive table-nowrap" style="text-align: center;">
            <thead>
                <tr style=" border-color: #fff; background-color: #225e95; color: #fff;">
                    <th rowspan="3">S.N</th>
                    <th rowspan="3">Project Name</th>
                    <th colspan="2">Project status as of the end of FY 2079/80</th>
                    <th rowspan="3">Approved Budget FY 2079/80</th>
                    <th rowspan="3">Main Activities (Total: target of this year)</th>
                    <th rowspan="3">Performance Indicators</th>
                    <th rowspan="3">Progress</th>
                    <th colspan="2">PME review (Target)</th>
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

                @foreach($project->projectActivity as $key => $pro_act)
                @foreach($pro_act->milestone as $key2 => $mile)
                <tr>
                    @if ($key == 0 && $key2 == 0)
                    <td rowspan="{{ $count }}">{{ $loop->iteration }}</td>
                    <td rowspan="{{ $count }}" class="text-nowrap">{{ $project->Name }}</td>
                    <td rowspan="{{ $count }}">{{ $project->progress[$loop->index]->physical_progress??0 }}%</td>
                    <td rowspan="{{ $count }}">87%</td>
                    <td rowspan="{{ $count }}">290000000</td>
                    @endif

                    @if ($key2 == 0)
                    <td rowspan="{{ count($pro_act->milestone) }}" class="text-nowrap">{{ $pro_act->activity }}</td>
                    @endif

                    <td class="text-nowrap">{{ $pro_act->milestone[0]->performance_indicator??'' }}</td>
                    <td class="text-nowrap">{{ $reviews->progress[$mile->id]??'' }}</td>
                    <td class="text-nowrap">{{ isset($reviews->target[$mile->id]) && $reviews->target[$mile->id] == 'achived' ? 'Achived' : '' }}</td>
                    <td class="text-nowrap">{{ isset($reviews->target[$mile->id]) && $reviews->target[$mile->id] == 'not_achived' ? 'Not Achived' : '' }}</td>

                    @if ($key2 == 0)
                    <td rowspan="{{ count($pro_act->milestone) }}" class="text-nowrap">{{ $pro_act->main_responsibility }}</td>
                    <td rowspan="{{ count($pro_act->milestone) }}" class="text-nowrap">{{ $pro_act->supportive_responsibility }}</td>
                    @endif
                    <td class="text-nowrap">{{ $reviews->remarks[$mile->id]??'' }}</td>
                </tr>

                @endforeach
                @endforeach

            </tbody>
        </table>
        <div style="display:flex; gap: 10px; align-items: flex-end; justify-content: flex-end; width: 95%; margin:auto">
            {{-- <button style="background-color: #225e95;  text-align: center; color: #fff;"
                class="btn btn-lg  col-md-1" type="button">Download</button>

            <button style="background-color: #225e95;  text-align: center; color: #fff;" class="btn btn-lg  col-md-1"
                type="button">Export</button> --}}
            <a href="{{ route('project.milestone.review', $project->projectID) }}" class="btn btn-primary" type="button">Edit</a>
        </div>
    </form>


</div>

@endsection
