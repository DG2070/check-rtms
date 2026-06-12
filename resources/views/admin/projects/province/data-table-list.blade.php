<div class="province-projects-container">
    <div class="card shadow-lg border-0">
        <div class="card-body table-card-body">

            <div class="project_name   pt-4 pl-4">
                <strong>{{ $province_data['ename'] }}</strong>
                @if ($project_filter_type == 'active_project')
                    Active Project List FY {{ App\Helper\FiscalYear::curentFullFiscalYear() }}
                @elseif($project_filter_type == 'all_project')
                    All Project List
                @else
                    Project List
                @endif
            </div>

            <div class="search-filters-container">
                <div class="row">
                    <div class="col-12 col-md-8">
                        {{-- search box section --}}
                        <div class="search-container">
                            <div class="row no-gutters align-items-center">
                                <div class="col col-md-12">
                                    <input class="form-control border-secondary rounded-pill pr-5" type="Search"
                                        placeholder="search" id="single_province_project_search_box">
                                </div>
                                <div class="col-auto">
                                    <button id="single_province_project_search_box_button"
                                        class="btn btn-outline-light text-dark border-0 rounded-pill ml-n5"
                                        type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{-- !ENDS search box section --}}
                    </div>
                    <div class="col-12 col-md-4">
                        {{-- filter section --}}
                        <div class="filter-container">
                            <div class="dropdown">
                                <div class="filter-container-filter_btns  dropdown-toggle" role="button"
                                    id="project-list-filer__dropdown" data-toggle="dropdown">
                                    <i class="fa fa-filter"></i>
                                    FILTERS
                                </div>
                                <div class="dropdown-menu filter-dropdown-menu"
                                    aria-labelledby="project-list-filer__dropdown">

                                    <div class="filter-menu-container">
                                        <div class="filter-menu--actions">
                                            <div class="filter-menu--province">
                                                <label for="">Province</label>
                                                <div>
                                                    @php
                                                        //TODO: used a lot need a helper which returns $province array
                                                        $province = [
                                                            [
                                                                'id' => 01,
                                                                'ename' => 'Province 1',
                                                                'nname' => 'प्रदेश नं. १',
                                                            ],
                                                            [
                                                                'id' => 02,
                                                                'ename' => 'Madhesh Province',
                                                                'nname' => 'मधेश प्रदेश',
                                                            ],
                                                            [
                                                                'id' => 03,
                                                                'ename' => 'Bagmati Province',
                                                                'nname' => 'वाग्मती प्रदेश',
                                                            ],
                                                            [
                                                                'id' => 04,
                                                                'ename' => 'Gandaki Province',
                                                                'nname' => 'गण्डकी प्रदेश',
                                                            ],
                                                            [
                                                                'id' => 05,
                                                                'ename' => 'Lumbini Province',
                                                                'nname' => 'लुम्बिनी प्रदेश',
                                                            ],
                                                            [
                                                                'id' => 06,
                                                                'ename' => 'Karnali Province',
                                                                'nname' => 'कर्णाली प्रदेश',
                                                            ],
                                                            [
                                                                'id' => 07,
                                                                'ename' => 'Sudurpashchim Province',
                                                                'nname' => 'सुदूरपश्चिम प्रदेश',
                                                            ],
                                                        ];
                                                    @endphp
                                                    <select id="province_select_list" class="form-control">
                                                        @foreach ($province as $province_single)
                                                            @if ($province_data['id'] == $province_single['id'])
                                                                <option value="{{ $province_single['id'] }}" selected>
                                                                    {{ $province_single['ename'] }}</option>
                                                            @else
                                                                <option value="{{ $province_single['id'] }}">
                                                                    {{ $province_single['ename'] }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="filter-by-status mt-2">
                                                <label for="">Project Status</label>
                                                <div>
                                                    <select id="project_status_select_list" class="form-control">
                                                        <option @if ($project_filter_type == 'all_project') selected @endif
                                                            value="all_project">
                                                            All Projects</option>
                                                        <option @if ($project_filter_type == 'active_project') selected @endif
                                                            value="active_project">
                                                            Active Projects FY
                                                            {{ App\Helper\FiscalYear::curentFullFiscalYear() }}</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="fiter-menu--btn mt-3">
                                                <button class="btn btn-dark" id="filter-menu-btn--reset">
                                                    Reset
                                                </button>
                                                <button class="btn btn-primary" id="filter-menu-btn--filer">
                                                    Filter
                                                </button>
                                            </div>


                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>
                        {{-- !ENDS filter section --}}
                    </div>
                </div>

            </div>

            {{-- project list datatable section --}}
            <div class="table-responsive">
                <table id="province_project_list" class="table table-hover">
                    <thead>
                        <tr>
                            <th width="2%">S.N</th>
                            <th width="25%">Name</th>
                            <th width="15%">Town Name</th>
                            <th width="25%">Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($projects))
                            @foreach ($projects as $key => $project)
                                {{-- @if (!empty(request('agency')) && request('agency') != 'all_agency')
                                    @if (request('agency') == $project->program->FinancingAgency)
                                        @include('admin.projects.province.default-list')
                                    @endif
                                @else
                                    @include('admin.projects.province.default-list')
                                @endif --}}
                                @include('admin.projects.province.default-list')
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
            {{-- !ENDS project list datatable section --}}
        </div>
    </div>


</div>

@include('layouts.includes.data-table.script')

@push('script')
    <script>
        /*
         *  Project List Custom Flter
         */

        //stop defaut dropdown propagation
        $('.filter-dropdown-menu').on('click', function(event) {
            event.stopPropagation();
        });

        function filterMenu() {

            //get selected province
            var province_code = $("#province_select_list").val();
            //get selected status
            var status = $("#project_status_select_list").val();

            var url = "/projects/province/" + province_code + "?status=" + status;
            window.location.href = url;
        }

        //on filter button pressed
        $('#filter-menu-btn--filer').on('click', function(event) {
            filterMenu();
        });

        //on reset buttin pressed
        $('#filter-menu-btn--reset').on('click', function(event) {
            var url = '{{ route('project.province.show', $province_data['id']) }}';
            window.location.href = url;

        });
    </script>
@endpush
