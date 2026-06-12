{{-- Activities & Milestones --}}
@can('Set Target')
    <li class="nav-item">
        <a class="tdf_tab btn btn-primary btn-tdf-primary_tabs" id="activities_milestones-tab" data-toggle="tab"
            href="#activities_milestones" role="tab" aria-controls="activities_milestones" aria-selected="false">Set
            Target</a>
    </li>
@endcan


{{-- Target Report --}}
@can('Target Report')
    <li class="nav-item">
        <a class="tdf_tab btn btn-primary btn-tdf-primary_tabs" id="target_report-tab" data-toggle="tab"
            href="#target_report" role="tab" aria-controls="target_report" aria-selected="false">Target
            Report</a>
    </li>
@endcan

{{-- Progress Input --}}
@can('Progress Input')
    <li class="nav-item">
        <a class="tdf_tab btn btn-primary btn-tdf-primary_tabs" id="progress_input-tab" data-toggle="tab"
            href="#progress_input" role="tab" aria-controls="progress_input" aria-selected="false">Progress
            Input</a>
    </li>
@endcan

{{-- Physical Progress --}}
@can('Physical Progress')
    <li class="nav-item">
        <a class="tdf_tab btn btn-primary btn-tdf-primary_tabs " id="physical_progress-tab" data-toggle="tab"
            href="#physical_progress" role="tab" aria-controls="physical_progress" aria-selected="false">Physical
            Progress</a>
    </li>
@endcan

{{-- Progress Report --}}
@can('Progress Report')
    <li class="nav-item">
        <a class="tdf_tab btn btn-primary btn-tdf-primary_tabs " id="progress_report-tab" data-toggle="tab"
            href="#progress_report" role="tab" aria-controls="progress_report" aria-selected="false">Progress
            Report</a>
    </li>
@endcan

{{-- PME Review --}}
@can('PME Review')
    <li class="nav-item">
        <a class="tdf_tab btn btn-primary btn-tdf-primary_tabs" id="pme_report_input-tab" data-toggle="tab"
            href="#pme_report_input" role="tab" aria-controls="pme_report_input" aria-selected="false">PME
            Review</a>
    </li>
@endcan

{{-- PME Final Report --}}
@can('PME Final Report')
    <li class="nav-item">
        <a class="tdf_tab btn btn-primary btn-tdf-primary_tabs" id="pme_final_report-tab" data-toggle="tab"
            href="#pme_final_report" role="tab" aria-controls="pme_final_report" aria-selected="false">PME
            Final Report</a>
    </li>
@endcan
{{-- TODO: redirect or create new component --}}
{{-- <li class="nav-item">
    <a class="tdf_tab btn btn-primary btn-tdf-primary_tabs " target="_blank"
        href="/progress/report?program={{ $selectedProgramId }}&project={{ $selectedProjectId }}">PME Final
        Report</a>
</li> --}}
