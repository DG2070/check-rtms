{{-- Activities & Milestones --}}
@can('Set Target')
    <div class="tab-pane fade p-3" id="activities_milestones" role="tabpanel" aria-labelledby="activities_milestones-tab">
        <div>
            <x-flow.set-target-component :projectId="request('projectID')" />
        </div>
    </div>
@endcan

{{-- Target Report --}}
@can('Target Report')
    <div class="tab-pane fade p-3" id="target_report" role="tabpanel" aria-labelledby="target_report-tab">
        <div>
            <x-flow.target-report-component :programId="request('programID')" :projectId="request('projectID')" />
        </div>
    </div>
@endcan


{{-- Progress Input --}}
@can('Progress Input')
    <div class="tab-pane fade p-3" id="progress_input" role="tabpanel" aria-labelledby="progress_input-tab">
        <div>
            <x-flow.progress-input-component :programId="request('programID')" :projectId="request('projectID')" :activityId="$selectedActivityId" :milestoneId="$selectedMilestoneId" />
        </div>
    </div>
@endcan


{{-- Physical Progress --}}
@can('Physical Progress')
    <div class="tab-pane fade p-3" id="physical_progress" role="tabpanel" aria-labelledby="physical_progress-tab">
        <div>
            <x-project.physical-progress-component :projectId="request('projectID')" />
        </div>
    </div>
@endcan


{{-- Progress Report --}}
@can('Progress Report')
    <div class="tab-pane fade p-3" id="progress_report" role="tabpanel" aria-labelledby="progress_report-tab">
        <div>
            <x-flow.progress-report-component :programId="request('programID')" :projectId="request('projectID')" />
        </div>
    </div>
@endcan


{{-- PME Review --}}
@can('PME Review')
    <div class="tab-pane fade p-3" id="pme_report_input" role="tabpanel" aria-labelledby="pme_report_input-tab">
        <div>
            <x-flow.pme-review-component :programId="request('programID')" :projectId="request('projectID')" />
        </div>
    </div>
@endcan


{{-- PME Final Report --}}
@can('PME Final Report')
    <div class="tab-pane fade p-3" id="pme_final_report" role="tabpanel" aria-labelledby="pme_final_report-tab">
        <div>
            <x-flow.pme-final-report-component :programId="request('programID')" :projectId="request('projectID')" />
        </div>
    </div>
@endcan
