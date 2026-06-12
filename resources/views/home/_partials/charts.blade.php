<div class="card  border-0">
    <div class="card-body">
        <div class="row">
            {{-- bar chart --}}
            {{-- <div class="card col-md-12 ">
                <div class="d-flex justify-content-center">
                    <div class="card-title py-2">
                        Province Project progress
                    </div>
                </div>
                <div class="card-body" style="min-height: 450px">
                    <canvas id="barChart"></canvas>
                </div>
            </div> --}}
            {{-- donut chart --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="donutChart"></canvas>
                        {{-- <x-home.partials.province-donut-chart-component /> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
