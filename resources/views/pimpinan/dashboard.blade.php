@extends('layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Good Morning, {{ Auth::user()->name }}!</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/pimpinan') }}">Dashboard {{ $store->name }}</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- *************************************************************** -->
    <!-- Start First Cards -->
    <!-- *************************************************************** -->
    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="card border-end">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{ $totalCashiers }}</h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Cashiers</h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="users"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-end ">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium"><sup class="set-doller">Rp</sup>{{ number_format($totalSales, 0, ',', '.') }}</h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Sales</h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="dollar-sign"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card border-end ">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{ $totalProducts }}</h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Products</h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="box"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card ">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 font-weight-medium">{{ number_format($totalStock) }}</h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Items In Stock</h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="grid"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- *************************************************************** -->
    <!-- End First Cards -->
    <!-- *************************************************************** -->

    <!-- *************************************************************** -->
    <!-- Start Sales Charts Section -->
    <!-- *************************************************************** -->
    <div class="row">
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Sales by Category</h4>
                    <div id="campaign-v2" class="mt-2" style="height:283px; width:100%;"></div>
                    <ul class="list-style-none mb-0">
                        @foreach($salesByCategory as $index => $sale)
                        <li class="{{ $index > 0 ? 'mt-3' : '' }}">
                            <i class="fas fa-circle font-10 me-2" style="color: {{ ['#5f76e8', '#ff4f70', '#01caf1', '#22ca80', '#ffad46'][$index % 5] }}"></i>
                            <span class="text-muted">{{ $sale->category }}</span>
                            <span class="text-dark float-end font-weight-medium">Rp{{ number_format($sale->total, 0, ',', '.') }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Monthly Revenue</h4>
                    <div class="net-income mt-4 position-relative" style="height:294px;"></div>
                    <ul class="list-inline text-center mt-5 mb-2">
                        <li class="list-inline-item text-muted fst-italic">Revenue for the last 6 months</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Top 4 Categories (Progress)</h4>
                    @foreach($salesByCategory->take(4) as $index => $sale)
                    <div class="row mb-3 align-items-center {{ $index == 0 ? 'mt-5' : '' }}">
                        <div class="col-4 text-end">
                            <span class="text-muted font-14">{{ $sale->category }}</span>
                        </div>
                        <div class="col-5">
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar" role="progressbar" style="width: 100%; background-color: {{ ['#5f76e8', '#ff4f70', '#01caf1', '#22ca80'][$index % 4] }}"
                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-3 text-end">
                            <span class="mb-0 font-14 text-dark font-weight-medium">{{ round(($sale->total / ($totalSales ?: 1)) * 100) }}%</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- *************************************************************** -->
    <!-- End Sales Charts Section -->
    <!-- *************************************************************** -->

    <!-- *************************************************************** -->
    <!-- Start Location and Earnings Charts Section -->
    <!-- *************************************************************** -->
    <div class="row">
        <div class="col-md-6 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <h4 class="card-title mb-0">Earning Statistics (Daily)</h4>
                    </div>
                    <div class="pl-4 mb-5">
                        <div class="stats ct-charts position-relative" style="height: 315px;"></div>
                    </div>
                    <ul class="list-inline text-center mt-4 mb-0">
                        <li class="list-inline-item text-muted fst-italic">Earnings for the last 7 days</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Transactions</h4>
                    <div class="mt-4 activity">
                        @foreach($recentTransactions as $index => $trx)
                        <div class="d-flex align-items-start border-left-line {{ $loop->last ? '' : 'pb-3' }}">
                            <div>
                                <a href="javascript:void(0)" class="btn {{ ['btn-info', 'btn-danger', 'btn-cyan'][$index % 3] }} btn-circle mb-2 btn-item">
                                    <i data-feather="shopping-cart"></i>
                                </a>
                            </div>
                            <div class="ms-3 mt-2">
                                <h5 class="text-dark font-weight-medium mb-2">{{ $trx->invoice_number }}</h5>
                                <p class="font-14 mb-2 text-muted">Sold by <strong>{{ $trx->cashier->name }}</strong><br>
                                   Total: Rp{{ number_format($trx->total_price, 0, ',', '.') }}
                                </p>
                                <span class="font-weight-light font-14 text-muted">{{ $trx->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- *************************************************************** -->
    <!-- End Location and Earnings Charts Section -->
    <!-- *************************************************************** -->

    <!-- *************************************************************** -->
    <!-- Start Top Leader Table -->
    <!-- *************************************************************** -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title">Top Sold Products</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-14 font-weight-medium text-muted">Product</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">Price</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted">Sold Qty</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted">Total Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProducts as $product)
                                <tr>
                                    <td class="border-top-0 px-2 py-4">
                                        <div class="d-flex no-block align-items-center">
                                            <div class="me-3"><img src="{{ asset('assets/images/big/icon.png') }}" alt="user" class="rounded-circle" width="45" height="45" /></div>
                                            <div class="">
                                                <h5 class="text-dark mb-0 font-16 font-weight-medium">{{ $product->name }}</h5>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border-top-0 text-muted px-2 py-4 font-14">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td class="border-top-0 px-2 py-4 text-center font-weight-medium text-muted">
                                        {{ $product->total_qty }}
                                    </td>
                                    <td class="font-weight-medium text-dark border-top-0 px-2 py-4">
                                        Rp{{ number_format($product->revenue, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(function () {
    // 1. Category Donut Chart
    var donutChart = c3.generate({
        bindto: '#campaign-v2',
        data: {
            columns: [
                @foreach($salesByCategory as $index => $sale)
                ['{{ $sale->category }}', {{ $sale->total }}],
                @endforeach
            ],
            type: 'donut',
            tooltip: { show: true }
        },
        donut: {
            label: { show: false },
            title: "Categories",
            width: 18
        },
        legend: { hide: true },
        color: {
            pattern: ['#5f76e8', '#ff4f70', '#01caf1', '#22ca80', '#ffad46']
        }
    });
    d3.select('#campaign-v2 .c3-chart-arcs-title').style('font-family', 'Rubik');

    // 2. Monthly Revenue Bar Chart
    var barChart = new Chartist.Bar('.net-income', {
        labels: [@foreach($monthlySales as $ms) '{{ $ms->month }}', @endforeach],
        series: [[@foreach($monthlySales as $ms) {{ $ms->total }}, @endforeach]]
    }, {
        low: 0,
        showArea: true,
        plugins: [Chartist.plugins.tooltip()],
        axisX: { showGrid: false }
    });

    // 3. Daily Stats Area Chart
    var areaChart = new Chartist.Line('.stats', {
        labels: [@foreach($salesDaily as $sd) '{{ \Carbon\Carbon::parse($sd->date)->format('d M') }}', @endforeach],
        series: [[@foreach($salesDaily as $sd) {{ $sd->total }}, @endforeach]]
    }, {
        low: 0,
        showArea: true,
        fullWidth: true,
        plugins: [Chartist.plugins.tooltip()],
        axisY: {
            onlyInteger: true,
            offset: 30,
            labelInterpolationFnc: function (value) {
                return (value >= 1000) ? (value / 1000) + 'k' : value;
            }
        }
    });

    areaChart.on('draw', function (ctx) {
        if (ctx.type === 'area') {
            ctx.element.attr({
                x1: ctx.x1 + 0.001
            });
        }
    });

    areaChart.on('created', function (ctx) {
        var defs = ctx.svg.elem('defs');
        defs.elem('linearGradient', {
            id: 'gradient',
            x1: 0,
            y1: 1,
            x2: 0,
            y2: 0
        }).elem('stop', {
            offset: 0,
            'stop-color': 'rgba(255, 255, 255, 1)'
        }).parent().elem('stop', {
            offset: 1,
            'stop-color': 'rgba(80, 153, 255, 1)'
        });
    });

    $(window).on('resize', function () {
        areaChart.update();
    });
});
</script>
@endpush
@endsection
