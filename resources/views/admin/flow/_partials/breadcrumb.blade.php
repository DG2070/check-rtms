<div class="row">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ Request::url() }}">
                        {{ $page_title ?? '' }}
                    </a>
                </li>
                @if ($program_name != '')
                    <li class="breadcrumb-item">
                        <a href="{{ route('projects.index', ['program' => $projectId]) }}">
                            {{ $program_name }}
                        </a>
                    </li>
                @endif
                @if ($project_name != '')
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $project_name }}
                    </li>
                @endif
            </ol>
        </nav>
    </div>
</div>
