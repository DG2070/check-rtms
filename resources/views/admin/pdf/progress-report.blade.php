<div class="containers">
    @if ($program && $program->project && count($program->project) > 0)
        @include('admin.report.components.progress-report-table')
    @endif
</div>
