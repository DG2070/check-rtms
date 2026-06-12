@extends('layouts.app')

@section('title', 'Program Report Performance')

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
          <h4 class="text-center"><strong>Program Report Performance of {{ $project->Name }}</strong></h4>
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

<div style="background: #EDEFF2; padding: 30px;">
  <br />
  <br />
  <!-- ----------- TOP BAR FILTER'S --------------  -->
  <div class="topbar">

    {{-- <select class="form-control"
      style="background-color: z#225e95; border-radius: 8px;  text-align: left; color: #fff; width:auto;">
      <option selected>Fiscal Year</option>
      <option>79/80</option>
      <option>2079/80</option>
      <option>2076/77</option>
    </select> --}}

  </div>

  <br /><br />

  <table border="1" class="table table-responsive" style="text-align: center;">

    <tr style=" border-color: #fff; background-color: #225e95; color: #fff;">
      <th width="2%" rowspan="3">S.N</th>
      <th rowspan="3">Project Name</th>
      <th colspan="2">Project status as of the end of FY 2079/80</th>
      <th rowspan="3">Approved Budget FY 2079/80</th>
      <th rowspan="3">Main Activities (Total: target of this year)</th>
      <th rowspan="3">Milestones</th>
      <th colspan="14">Timeline</th>
      <th rowspan="3">Performance Indicators</th>
      <th colspan="2">Responsibility</th>
      <th rowspan="3">Remarks</th>
    </tr>

    <tr style=" border-color: #fff; background-color: #225e95; color: #fff;">
      <th rowspan="2">Physical</th>
      <th rowspan="2">Financial</th>
      <th colspan="3">1st Quarter</th>
      <th colspan="3">2nd Quarter</th>
      <th colspan="3">3rd Quarter</th>
      <th colspan="3">4th Quarter</th>
      <th colspan="2">Total </th>
      <th rowspan="2">Main Responsibility</th>
      <th rowspan="2">Supportive Responsibility</th>
    </tr>

    <tr style="border-color: #fff; background-color: #225e95; color: #fff;">
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

    <tbody style="border-color: #225e95;">
      @foreach($project->projectActivity as $key => $pro_act)
      @foreach($pro_act->milestone as $key2 => $mile)
      <tr>

        @if ($key == 0 && $key2 == 0)
        <td rowspan="{{ $count }}">{{ $loop->iteration }}</td>
        <td rowspan="{{ $count }}" class="text-nowrap">{{ $project->Name }}</td>
        <td rowspan="{{ $count }}">
          {{ $physical_progress->physical_progress??0 }}%
          @if ($physical_progress)
          <div>
            <a href="{{ route('project.physicalProgress.edit', ['id' => $project->projectID, 'progress' => $physical_progress->id] ) }}">
              link
            </a>
          </div>
          @endif
        </td>
        <td rowspan="{{ $count }}">87%</td>
        <td rowspan="{{ $count }}">290000000</td>
        @endif

        @if ($key2 == 0)
        <td rowspan="{{ count($pro_act->milestone) }}" class="text-nowrap">{{ $pro_act->activity }}</td>
        @endif

        <td class="text-nowrap text-left">{{ $mile->milestone }}</td>

        @if ($mile->timeline)
        @foreach($mile->timeline->timeline ?? [] as $time)
        @if ($mile->is_text == 'yes')
        <td>{{ $time }}</td>
        @else
        <td class="@if($time) bg-success @endif"></td>
        @endif
        @endforeach
        @else
        @for ($i = 0; $i < 12; $i++)
          <td></td>
          @endfor
          @endif

          @if ($key == 0 && $key2 == 0)
          <td rowspan="{{ $count }}"></td>
          <td rowspan="{{ $count }}"></td>
          @endif

          <td class="text-left">{{ $mile->performance_indicator }}</td>

          @if($key2 == 0)
          <td rowspan="{{ count($pro_act->milestone) }}" class="text-nowrap">{{ $pro_act->main_responsibility }}</td>
          <td rowspan="{{ count($pro_act->milestone) }}" class="text-nowrap">{{ $pro_act->supportive_responsibility }}</td>
          <td rowspan="{{ count($pro_act->milestone) }}" class="text-nowrap">{{ $pro_act->remark }}</td>
          @endif

      </tr>
      @endforeach
      @endforeach

    </tbody>
  </table>

  <div style="display:flex; gap: 10px; align-items: flex-end; justify-content: flex-end; width: 95%; margin:auto">
    <!-- <button style="background-color: #225e95;  text-align: center; color: #fff;" class="btn btn-lg  col-md-1"
      type=" button">Download
    </button>

    <button style="background-color: #225e95;  text-align: center; color: #fff;" class="btn btn-lg  col-md-1"
      type=" button">Export
    </button> -->

    <a href="{{ route('project.milestone.review', $project->projectID) }}"
      class="btn btn-primary text-nowrap"type="button">
      PME Review
    </a>

  </div>
</div>

@endsection
