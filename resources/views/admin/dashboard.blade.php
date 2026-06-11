@extends('layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Good Morning, {{ Auth::user()->name }}!</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">System Administrator Dashboard</a>
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
                                <h2 class="text-dark mb-1 font-weight-medium">{{ $totalUsers }}</h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Users</h6>
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
                            <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium">{{ $totalStores }}</h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Active Stores</h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="shopping-cart"></i></span>
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
                                <h2 class="text-dark mb-1 font-weight-medium">{{ $totalTransactions }}</h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Transactions</h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="file-text"></i></span>
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
                            <h2 class="text-dark mb-1 font-weight-medium">{{ $newUsersToday }}</h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">New Users Today</h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- *************************************************************** -->
    <!-- Start Sales Charts Section -->
    <!-- *************************************************************** -->
    <div class="row">
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Stores by Type</h4>
                    <div id="admin-donut-chart" class="mt-2" style="height:283px; width:100%;"></div>
                    <ul class="list-style-none mb-0">
                        @foreach($storesByCategory->take(5) as $index => $cat)
                        <li class="{{ $index > 0 ? 'mt-3' : '' }}">
                            <i class="fas fa-circle font-10 me-2" style="color: {{ ['#5f76e8', '#ff4f70', '#01caf1', '#22ca80', '#ffad46'][$index % 5] }}"></i>
                            <span class="text-muted">{{ $cat->category }}</span>
                            <span class="text-dark float-end font-weight-medium">{{ $cat->total }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">System Revenue</h4>
                    <div class="net-income mt-4 position-relative" style="height:294px;"></div>
                    <ul class="list-inline text-center mt-5 mb-2">
                        <li class="list-inline-item text-muted fst-italic">Total revenue last 6 months</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Top Stores Share</h4>
                    @php $allSalesSum = $topStores->sum('transactions_sum_total_price') ?: 1; @endphp
                    @foreach($topStores->take(4) as $index => $store)
                    <div class="row mb-3 align-items-center {{ $index == 0 ? 'mt-5' : '' }}">
                        <div class="col-4 text-end">
                            <span class="text-muted font-14">{{ Str::limit($store->name, 10) }}</span>
                        </div>
                        <div class="col-5">
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar" role="progressbar" style="width: 100%; background-color: {{ ['#5f76e8', '#ff4f70', '#01caf1', '#22ca80'][$index % 4] }}"
                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-3 text-end">
                            <span class="mb-0 font-14 text-dark font-weight-medium">{{ round(($store->transactions_sum_total_price / $allSalesSum) * 100) }}%</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- *************************************************************** -->
    <!-- Start Location and Earnings Charts Section -->
    <!-- *************************************************************** -->
    <div class="row">
        <div class="col-md-6 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-0">Daily System Performance</h4>
                    <div class="pl-4 mb-5">
                        <div class="stats ct-charts position-relative" style="height: 315px;"></div>
                    </div>
                    <ul class="list-inline text-center mt-4 mb-0">
                        <li class="list-inline-item text-muted fst-italic">Daily transactions volume (7 days)</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Recent Stores</h4>
                    <div class="mt-4 activity">
                        @foreach($recentStores as $index => $store)
                        <div class="d-flex align-items-start border-left-line {{ $loop->last ? '' : 'pb-3' }}">
                            <div>
                                <a href="javascript:void(0)" class="btn {{ ['btn-info', 'btn-danger', 'btn-cyan'][$index % 3] }} btn-circle mb-2 btn-item">
                                    <i data-feather="shopping-bag"></i>
                                </a>
                            </div>
                            <div class="ms-3 mt-2">
                                <h5 class="text-dark font-weight-medium mb-2">{{ $store->name }}</h5>
                                <p class="font-14 mb-2 text-muted">Owned by <strong>{{ $store->owner->name ?? 'Unknown' }}</strong></p>
                                <span class="font-weight-light font-14 text-muted">{{ $store->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- *************************************************************** -->
    <!-- Start Top Leader Table -->
    <!-- *************************************************************** -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title">Top Performing Stores</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table no-wrap v-middle mb-0">
                            <thead>
                                <tr class="border-0">
                                    <th class="border-0 font-14 font-weight-medium text-muted">Store Name</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted px-2">Owner</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted text-center">Transactions</th>
                                    <th class="border-0 font-14 font-weight-medium text-muted">Total Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topStores as $store)
                                <tr>
                                    <td class="border-top-0 px-2 py-4">
                                        <div class="d-flex no-block align-items-center">
                                            <div class="me-3"><img src="{{ asset('assets/images/big/icon.png') }}" alt="user" class="rounded-circle" width="45" height="45" /></div>
                                            <div class="">
                                                <h5 class="text-dark mb-0 font-16 font-weight-medium">{{ $store->name }}</h5>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border-top-0 text-muted px-2 py-4 font-14">{{ $store->owner->name ?? 'Unknown' }}</td>
                                    <td class="border-top-0 text-center font-weight-medium text-muted px-2 py-4">
                                        {{ $store->transactions_count }}
                                    </td>
                                    <td class="font-weight-medium text-dark border-top-0 px-2 py-4">
                                        Rp{{ number_format($store->transactions_sum_total_price, 0, ',', '.') }}
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

<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script>
$(function () {
    // 1. Donut Chart
    var donutChart = c3.generate({
        bindto: '#admin-donut-chart',
        data: {
            columns: [
                @foreach($storesByCategory as $cat)
                ['{{ $cat->category }}', {{ $cat->total }}],
                @endforeach
            ],
            type: 'donut'
        },
        donut: {
            label: { show: false },
            title: "Stores",
            width: 18
        },
        legend: { hide: true },
        color: {
            pattern: ['#5f76e8', '#ff4f70', '#01caf1', '#22ca80', '#ffad46']
        }
    });

    // 2. Bar Chart
    new Chartist.Bar('.net-income', {
        labels: [@foreach($monthlyRevenue as $mr) '{{ $mr->month }}', @endforeach],
        series: [[@foreach($monthlyRevenue as $mr) {{ $mr->total }}, @endforeach]]
    }, {
        low: 0,
        showArea: true,
        plugins: [Chartist.plugins.tooltip()]
    });

    // 3. Area Chart
    new Chartist.Line('.stats', {
        labels: [@foreach($dailyStats as $ds) '{{ \Carbon\Carbon::parse($ds->date)->format('d M') }}', @endforeach],
        series: [[@foreach($dailyStats as $ds) {{ $ds->total }}, @endforeach]]
    }, {
        low: 0,
        showArea: true,
        fullWidth: true,
        plugins: [Chartist.plugins.tooltip()]
    });
});
</script>
@endsection
