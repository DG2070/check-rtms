<div class="card shadow-lg border-0 mt-2">
    <div class="card-body">
        {{-- filters --}}
        @include('home._partials.filters')
        {{-- !ENDS filters --}}
        <div class="row">

            <div class="col-md-9" style="min-height: 500px;">
                <div id="map" class="map"></div>
            </div>
            <div id="info" class="col-md-3 stat-box-container" value="">
                <div class="province_name " id="provinceName">
                    Overview FY {{ App\Helper\FiscalYear::curentFullFiscalYear() }}
                </div>
                <div class="total_project project-single">
                    <div class="row">
                        <div class="counter_title">
                            <span class="text-white text-capitalize">
                                Total Budget FY {{ App\Helper\FiscalYear::curentFullFiscalYear() }}:
                            </span><br>
                            <span class="text-white" id="total_budget">0</span>
                        </div>
                    </div>
                </div>
                <div class="total_project project-single">
                    <div class="row">
                        <div class="counter_title">
                            <span class="text-white text-capitalize">
                                Financial Target
                            </span>
                            <br>
                            <span class="text-white" id="financial_target">0</span>
                        </div>
                    </div>
                </div>
                <div class="running_project project-single">
                    <div class="row">
                        <div class="counter_title">
                            <span class="text-white text-capitalize">
                                Financial Progress
                            </span>
                            <br>
                            <span class="text-white" id="financial_progress">0</span>
                        </div>
                    </div>
                </div>
                <div class="running_project project-single">
                    <div class="row">
                        <div class="counter_title">
                            <span class="text-white text-capitalize">
                                Physical Target
                                <span class="badge badge-info mb-1" title="(converted to 100%)">
                                    <i class="fa fa-info"></i>
                                </span>
                            </span>
                            <br>
                            <span class="text-white" id="physical_target">0</span>%
                        </div>
                    </div>
                </div>
                <div class="running_project project-single">
                    <div class="row">
                        <div class="counter_title">
                            <span class="text-white text-capitalize">
                                Physical Progress
                            </span>
                            <br>
                            <span class="text-white" id="physical_progress">0</span>%
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
