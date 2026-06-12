{{-- Activities & Milestones --}}
@can('Set Target')
    <div class="tab-pane fade p-3" id="activities_milestones" role="tabpanel" aria-labelledby="activities_milestones-tab">
        <div>
            @include('admin.internal.projects.single._partials.set-target')
        </div>
    </div>
@endcan

{{-- Target Report --}}

@can('Target Report')
    <div class="tab-pane fade p-3" id="target_report" role="tabpanel" aria-labelledby="target_report-tab">
        <div>
            @include('admin.internal.projects.single._partials.target-report')
        </div>
    </div>
@endcan

{{-- Progress Input --}}
@can('Progress Input')
    <div class="tab-pane fade p-3" id="progress_input" role="tabpanel" aria-labelledby="progress_input-tab">
        <div>
            @include('admin.internal.projects.single._partials.progress-input')
        </div>
    </div>
@endcan

{{-- Progress Report --}}
@can('Progress Report')
    <div class="tab-pane fade p-3" id="progress_report" role="tabpanel" aria-labelledby="progress_report-tab">
        <div>
            @include('admin.internal.projects.single._partials.progress-report')
        </div>
    </div>
@endcan

{{-- PME Review --}}
@can('PME Review')
    <div class="tab-pane fade p-3" id="pme_report_input" role="tabpanel" aria-labelledby="pme_report_input-tab">
        <div>
            @include('admin.internal.projects.single._partials.pme-review')
        </div>
    </div>
@endcan

{{-- PME Final Report --}}
@can('PME Final Report')
    <div class="tab-pane fade p-3" id="pme_final_report" role="tabpanel" aria-labelledby="pme_final_report-tab">
        <div>
            @include('admin.internal.projects.single._partials.pme-final-report')
        </div>
    </div>
@endcan
