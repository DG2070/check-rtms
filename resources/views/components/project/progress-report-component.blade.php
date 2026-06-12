<div>
    @if ($program && $program->project && count($program->project) > 0)
        @include('admin.report.components.program-new-progress-report-table')
        <div class="text-right">
            <a href="{{ route('download.progress.report', ['program' => "$programId", 'project' => "$projectId"]) }}"
                target="_blank" class="btn btn-primary">Export</a>
        </div>
    @endif
</div>
