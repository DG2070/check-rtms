<div class="home-counter-container">
    <div class="row justify-content-center">

        <div class="col-12 col-md-3 mt-2">
            <div class="card card-body home-counter-single">
                <div class="row justify-content-between">
                    <div class="col-6">
                        <p class="home-counter-single--title">
                            <span title="Active Programs">
                                Programs (A)
                            </span>
                        </p>
                        <h4 class="home-counter-single--count">
                            {{ $active_program_count ?? '' }}
                        </h4>
                    </div>
                    <div class="col-3">
                        <div class="avatar-md rounded">
                            <i class="fa-solid fa-boxes-stacked avatar-title text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3 mt-2">
            <div class="card card-body home-counter-single">
                <div class="row justify-content-between">
                    <div class="col-6">
                        <p class="home-counter-single--title">
                            <span title="Active Projects/Internal Projects">
                                Projects (A/I)
                            </span>
                        </p>
                        <h4 class="home-counter-single--count">
                            <span data-toggle="tooltip" title="Active projects">
                                {{ $active_project_count ?? '' }}
                            </span>
                            /
                            <span data-toggle="tooltip" title="Active projects">
                                {{ $all_internal_project_count ?? '' }}
                            </span>
                        </h4>
                    </div>
                    <div class="col-3">
                        <div class="avatar-md rounded">
                            <i class="fa-solid fa-folder-open avatar-title text-white"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-12 col-md-3 mt-2">
            <div class="card card-body home-counter-single">
                <div class="row justify-content-between">
                    <div class="col-6">
                        <p class="home-counter-single--title">
                            Users
                        </p>
                        <h4 class="home-counter-single--count">
                            {{ $user_count ?? '' }}
                        </h4>
                    </div>
                    <div class="col-3">
                        <div class="avatar-md rounded">
                            <i class="fa-solid fa-users avatar-title text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3 mt-2">
            <div class="card card-body home-counter-single">
                <div class="row justify-content-between">
                    <div class="col-6">
                        <p class="home-counter-single--title">
                            Departments
                        </p>
                        <h4 class="home-counter-single--count">
                            {{ $department_count ?? '' }}
                        </h4>
                    </div>
                    <div class="col-3">
                        <div class="avatar-md rounded">
                            <i class="fa-solid fa-building-user avatar-title text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
