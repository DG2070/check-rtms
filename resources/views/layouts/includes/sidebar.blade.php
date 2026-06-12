<aside class="main-sidebar elevation-4 color-grad-background">
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset('./images/logo/tdf_small.svg') }}" alt="TDF Logo" class="brand-image" style="opacity: .8;">
        <span class="brand-text font-weight-bold text-white">TDF</span>
    </a>

    <div class="sidebar">
        <nav>
            @php
                function checkRequest($modules)
                {
                    foreach ($modules as $module) {
                        if (request()->is($module) || request()->is($module . '/*')) {
                            return true;
                        }
                    }
                }
            @endphp
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item sidebar-link-color mb-4 ">
                    <a href="{{ route('home') }}"
                        class="nav-link text-white {{ request()->is('home') || request()->is('home/reports') ? 'active-a' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li
                    class="nav-item sidebar-link-color mb-4 {{ checkRequest(['programs']) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link text-white sidebar-link w-100">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>Program<i class="right fas fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview ml-2">
                        {{-- <li class="nav-item sidebar-link">
                            <a href="{{ route('programs.new') }}"
                                class="nav-link text-white {{ checkRequest(['programs/new']) ? 'active-b' : '' }} w-100">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Inputs</p>
                            </a>
                        </li> --}}
                        <li class="nav-item sidebar-link">
                            <a href="{{ route('programs.index') }}"
                                class="nav-link text-white {{ checkRequest(['']) ? 'active-b' : '' }} w-100">
                                <i class="nav-icon fas fa-magnifying-glass"></i>
                                <p>All Programs</p>
                            </a>
                        </li>
                    </ul>
                </li>


                @if (auth()->user()->can('Access Internal Projects') ||
                    auth()->user()->can('Access All Internal Projects'))
                    <li
                        class="nav-item sidebar-link-color mb-4 {{ checkRequest(['internal']) ? 'menu-is-opening menu-open' : '' }}">
                        <a href="javascript:void(0)" class="nav-link text-white sidebar-link w-100">
                            <i class="nav-icon fa-solid fa-network-wired"></i>
                            <p>Internal<i class="right fas fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview ml-2">
                            <li class="nav-item sidebar-link">
                                <a href="{{ route('internal.project.index') }}"
                                    class="nav-link text-white {{ checkRequest(['internal/projects']) ? 'active-b' : '' }} w-100">
                                    <i class="nav-icon fas fa-archive"></i>
                                    <p>Project</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif


                @php

                    $flow_routes = [
                        [
                            'name' => 'Set Target',
                            'route' => route('flow.set-target'),
                            'url_check' => 'flow/set-target',
                            'icon' => 'fas fa-plus',
                            'permission' => 'Set Target',
                        ],
                        [
                            'name' => 'Target Report',
                            'route' => route('flow.target-report'),
                            'url_check' => 'flow/target-report',
                            'icon' => 'fas fa-chart-line',
                            'permission' => 'Target Report',
                        ],
                        [
                            'name' => 'Progress Input',
                            'route' => route('flow.progress-input'),
                            'url_check' => 'flow/progress-input',
                            'icon' => 'fas fa-keyboard',
                            'permission' => 'Progress Input',
                        ],
                        [
                            'name' => 'Progress Report',
                            'route' => route('flow.progress-report'),
                            'url_check' => 'flow/progress-report',
                            'icon' => 'fas fa-chart-line',
                            'permission' => 'Progress Report',
                        ],
                        [
                            'name' => 'PME Review',
                            'route' => route('flow.pme-review'),
                            'url_check' => 'flow/pme-review',
                            'icon' => 'fas fa-id-card',
                            'permission' => 'PME Review',
                        ],
                        [
                            'name' => 'PME Final Report',
                            'route' => route('flow.pme-final-report'),
                            'url_check' => 'flow/pme-final-report',
                            'icon' => 'fas fa-archive',
                            'permission' => 'PME Final Report',
                        ],
                    ];

                    $url_check = array_column($flow_routes, 'url_check');
                @endphp

                @foreach ($flow_routes as $item)
                    @can($item['permission'])
                        <li class="nav-item sidebar-link-color mb-4 ">
                            <a href="{{ $item['route'] }}"
                                class="nav-link text-white {{ checkRequest([$item['url_check']]) ? 'active-a' : '' }}">
                                <i class="nav-icon {{ $item['icon'] }}"></i>
                                <p>{{ $item['name'] }}</p>
                            </a>
                        </li>
                    @endcan
                @endforeach




                {{-- <li
                    class="nav-item sidebar-link-color mb-4 {{ checkRequest($url_check) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="javascript:void(0)" class="nav-link text-white sidebar-link w-100">
                        <i class="nav-icon fa-solid fa-bars-staggered"></i>
                        <p>Flow<i class="right fas fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview ml-2">
                        @foreach ($flow_routes as $item)
                            @can($item['permission'])
                                <li class="nav-item sidebar-link">
                                    <a href="{{ $item['route'] }}"
                                        class="nav-link text-white {{ checkRequest([$item['url_check']]) ? 'active-b' : '' }} w-100">
                                        <i class="nav-icon {{ $item['icon'] }}"></i>
                                        <p>{{ $item['name'] }}</p>
                                    </a>
                                </li>
                            @endcan
                        @endforeach
                    </ul>
                </li> --}}




                {{-- @can('Disbursement-index')
                    <li class="nav-item sidebar-link-color mb-4 ">
                        <a href="{{ route('activities.index') }}"
                            class="nav-link text-white {{ checkRequest(['disbursements']) ? 'active-a' : '' }}">
                            <i class="nav-icon fas fa-money-bill"></i>
                            <p>Disbursement</p>
                        </a>
                    </li>
                @endcan --}}
                {{-- @can('Location-index')
                    <li class="nav-item sidebar-link-color mb-4">
                        <a href="{{ route('locations.index') }}"
                            class="nav-link text-white {{ checkRequest(['locations']) ? 'active-a' : '' }}">
                            <i class="nav-icon fas fa-location-arrow"></i>
                            <p>Town List</p>
                        </a>
                    </li>
                @endcan --}}


                @if (auth()->user()->can('Reports Progress Report') ||
                    auth()->user()->can('Reports PME Review Report'))
                    <li
                        class="nav-item sidebar-link-color mb-4 {{ checkRequest(['progress', 'pme-review']) ? 'menu-is-opening menu-open' : '' }}">
                        <a href="javascript:void(0)" class="nav-link text-white sidebar-link w-100">
                            <i class="nav-icon fas fa-file-pdf"></i>
                            <p>Program Report<i class="right fas fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview ml-2">
                            {{-- @can('Reports Progress Report')
                                <li class="nav-item sidebar-link">
                                    <a href="{{ route('progress.report.filter') }}"
                                        class="nav-link text-white {{ checkRequest(['progress']) ? 'active-b' : '' }} w-100">
                                        <i class="nav-icon fas fa-bars-progress"></i>
                                        <p>Target Review Report</p>
                                    </a>
                                </li>
                            @endcan --}}
                            @can('Reports Progress Report')
                                <li class="nav-item sidebar-link">
                                    <a href="{{ route('progress.report.filter') }}"
                                        class="nav-link text-white {{ checkRequest(['progress']) ? 'active-b' : '' }} w-100">
                                        <i class="nav-icon fas fa-bars-progress"></i>
                                        <p>Progress Review Report</p>
                                    </a>
                                </li>
                            @endcan
                            @can('Reports PME Review Report')
                                <li class="nav-item sidebar-link">
                                    <a href="{{ route('pme.report.filter') }}"
                                        class="nav-link text-white {{ checkRequest(['pme-review']) ? 'active-b' : '' }} w-100">
                                        <i class="nav-icon fas fa-magnifying-glass"></i>
                                        <p>PME Review Report</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                @if (Auth::user()->hasAnyRole(['Sysqube-Super-Admin', 'Super-Admin']))
                    <li
                        class="nav-item sidebar-link-color mb-4 {{ checkRequest(['settings/permission', 'settings/role', 'settings/department', 'settings/user']) ? 'menu-is-opening menu-open' : '' }}">
                        <a href="javascript:void(0)" class="nav-link text-white sidebar-link w-100">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Settings
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        @if (Auth::user()->hasRole(['Sysqube-Super-Admin']))
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item sidebar-link">
                                    <a href="{{ route('settings.permission.index') }}"
                                        class="nav-link text-white {{ checkRequest(['settings/permission']) ? 'active-b' : '' }} w-100">
                                        <i class="nav-icon fas fa-shield"></i>
                                        <p>Permissions</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview ml-2">
                                <li class="nav-item sidebar-link">
                                    <a href="{{ route('settings.role.index') }}"
                                        class="nav-link text-white {{ checkRequest(['settings/role']) ? 'active-b' : '' }} w-100">
                                        <i class="nav-icon fas fa-user-tag"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                            </ul>
                        @endif
                        <ul class="nav nav-treeview ml-2">
                            <li class="nav-item sidebar-link">
                                <a href="{{ route('settings.department.index') }}"
                                    class="nav-link text-white {{ checkRequest(['settings/department']) ? 'active-b' : '' }} w-100">
                                    <i class="nav-icon fas fa-building"></i>
                                    <p>Department</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview ml-2">
                            <li class="nav-item sidebar-link">
                                <a href="{{ route('settings.user.index') }}"
                                    class="nav-link text-white {{ checkRequest(['settings/user']) ? 'active-b' : '' }} w-100">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Users</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview ml-2">
                            <li class="nav-item sidebar-link">
                                <a href="{{ route('settings.api.index') }}"
                                    class="nav-link text-white {{ checkRequest(['settings/api']) ? 'active-b' : '' }} w-100">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>API</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <li class="nav-item sidebar-link-color mb-4 ">
                    <a href="{{ route('about.index') }}"
                        class="nav-link text-white {{ request()->is('about') ? 'active-a' : '' }}">
                        <i class="nav-icon fas fa-info"></i>
                        <p>About</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
