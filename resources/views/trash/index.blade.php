@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')


    <div id="vue-for-milestone-draggable">
        <flow-set-target-milestone :project_id="{{ json_encode($project->projectID) }}"
            :milestones_data="{{ json_encode($milestones_data) }}" :activities_data="{{ json_encode($activities_data) }}"
            :old_milestones_name="{{ json_encode($old_milestones_name) }}"
            :old_performance_indicator_name="{{ json_encode($old_performance_indicator_name) }}"
            :is_locked="{{ json_encode($target_locked) }}" />
    </div>

@endsection
