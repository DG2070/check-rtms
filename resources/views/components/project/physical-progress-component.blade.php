<div>
    <div class="d-flex justify-content-end mb-2">
        <a href="{{ route('project.createPhysicalProgress', $project->projectID) }}" target="_blank"
             class="btn btn-primary">Add
            Physical
            Progress
        </a>
    </div>
    <div class="card shadow-lg border-0">
        <div class="card-body table-card-body">
            <table id="physical_progress_datatable" class="table table-hover">
                <thead>
                    <tr>
                        <th width="10%">S.N</th>
                        <th>Visitor Name</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Physical Progress</th>
                        <th style="text-align: right">Activities</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($progress as $progress)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ implode(', ', $progress->visitor_details['name']) }}</td>

                            <td>{{ $progress->from_date }}</td>

                            <td>{{ $progress->to_date }}</td>

                            <td>{{ $progress->physical_progress ?? 0 }}%</td>

                            <td style="text-align: right">
                                <div class="d-flex justify-content-between">
                                    <a class="btn btn-custom-secondary" target="_blank"
                                        href="{{ route('project.physicalProgress.edit', ['id' => $progress['project_id'], 'progress' => $progress->id]) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
