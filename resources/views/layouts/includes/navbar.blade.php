<div class="d-flex flex-column">
    <nav class="grad main-header navbar navbar-expand justify-content-between border-bottom flex-wrap gap-3"
        id="app" style="z-index: 2">
        <ul class="navbar-nav align-items-center">
            <li class="nav-item">
                <a class="nav-link color-bar" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item">
                <div class="container container-custom">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="{{ asset('./images/logo/tdf.svg') }}" alt="TDF Logo" class="brand-image"
                                width="200px">
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        {{-- search box section --}}
        @if (Auth::user()->hasAnyRole(['Sysqube-Super-Admin','Super-Admin', 'Admin']))
            <div class="search-container home-search-container">
                <form action="{{ route('search.index') }}" method="GET">
                    <div class="row no-gutters align-items-center">
                        <div class="col col-md-12">
                            <input required name="search_query" class="form-control border-secondary rounded-pill pr-5"
                                type="Search" placeholder="Search everywhere" id="province_project_search_box"
                                @if (!empty(request('search_query')) && request('search_query') != '') value="{{ request('search_query') }}"@else @endif>
                        </div>
                        <div class="col-auto">
                            <button id="province_project_search_box_button"
                                class="btn btn-outline-light text-dark border-0 rounded-pill ml-n5" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
        {{-- !ENDS search box section --}}

        <ul class="navbar-nav nagarpalika-padding">
            <li class="nav-item dropdown">
                <a class="d-flex justify-content-between align-items-center gap-5" data-toggle="dropdown"
                    href="#">
                    {{-- <img src="{{ asset("/images/default/user_default.svg") }}" --}}

                    {{-- <img src="https://previews.123rf.com/images/aquir/aquir1311/aquir131100315/23569860-sample-grunge-blue-round-stamp.jpg"
                        alt="RBAT Logo" class="brand-image rounded-circle mr-2" width="50px" height="50px" /> --}}
                    <div class="desc text-white">
                        <p class="mb-0">{{ auth()->user()->name }}</p>
                        <p class="mb-0 font-weight-lighter text-xs">{{ auth()->user()->getRoleNames()[0] ?? "NA" }}</p>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                    <a href="{{ route('profile.profile') }}" class="dropdown-item">
                        <i class="fas fa-user"></i> My Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('profile.reset-password') }}" class="dropdown-item">
                        <i class="fa fa-unlock-alt "></i> Change password
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <div class="dropdown-divider"></div>
            </li>
        </ul>

    </nav>

    @if (request()->segment(1) == 'homee')
        <div class="grad main-header pl-md-5 second-header" style="z-index: 1">
            <div class="row custom-top-bottom" style="margin: 30px 0 20px 0;">
                <div class="d-flex">
                    <span class="text-white" id="provinceName"></span>
                </div>
                <div class="row">
                    <span class="bage">
                        <i class="fa fa-building"></i>
                    </span>
                    <div>
                        <span class="text-white" id="total">{{ number_format($total) ?? 0 }}</span><br>
                        <span class="text-white text-capitalize">
                            total project</span>
                    </div>
                </div>
                <div class="row">
                    <span class="bage">
                        <i class="fa-solid fa-trowel-bricks"></i>
                    </span>
                    <div>
                        <span class="text-white" id="running">{{ $running ?? 0 }}</span><br>
                        <span class="text-white text-capitalize">Project in progress</span>
                    </div>
                </div>
                <div class="row">
                    <span class="bage">
                        <i class="fa-solid fa-building-circle-check"></i>
                    </span>
                    <div>
                        <span class="text-white" id="completed">{{ $completed ?? 0 }}</span><br>
                        <span class="text-white text-capitalize">Completed project
                        </span>
                    </div>
                </div>
                <div class="row">
                    <span class="bage">
                        <i class="fa-solid fa-building-circle-xmark"></i>
                    </span>
                    <div>
                        <span class="text-white" id="halt">{{ $stopped ?? 0 }}</span><br>
                        <span class="text-white text-capitalize">Stopped projects</span>
                    </div>
                </div>
                {{-- <div class="col-md-3">
                <select class="form-control fiscal-select">
                    <option>आर्थिक बर्ष | </option>
                </select>
            </div> --}}
                {{-- <div class="ktm-nagar">

                    <span class="float-right pr-xs-3 " style="padding:4px 8px !important">
                        मिती :
                        <span class="current-date">
                        </span>
                    </span>
                </div> --}}
            </div>
        </div>
    @endif

</div>
