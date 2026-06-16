@extends('layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Stock Report</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/pimpinan') }}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Stock Report</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Filter Card -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3 text-dark"><i class="fas fa-filter me-2"></i>Filter Report</h4>
                    <form action="{{ route('pimpinan.report.stock') }}" method="GET">
                        <div class="row align-items-end">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label font-weight-medium">Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label class="form-label font-weight-medium">End Date</label>
                                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary btn-rounded shadow-sm px-4">
                                    <i class="fas fa-search me-2"></i>Filter
                                </button>
                                <a href="{{ route('pimpinan.report.stock') }}" class="btn btn-light btn-rounded px-4 ms-2 shadow-sm border-0">
                                    <i class="fas fa-undo me-2"></i>Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-md-4">
            <div class="card border-end shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{ number_format($totalStockIn, 0, ',', '.') }}</h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Stock In</h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="arrow-down-circle" class="text-success"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-end shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 font-weight-medium">{{ number_format($totalStockOut, 0, ',', '.') }}</h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Stock Out</h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="arrow-up-circle" class="text-danger"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 font-weight-medium text-danger">{{ $lowStockProducts }}</h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Low Stock Alerts</h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="alert-triangle" class="text-warning"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title text-dark">Stock Movement History</h4>
                        <div class="ms-auto">
                            <button class="btn btn-outline-primary btn-sm btn-rounded shadow-sm" onclick="window.print()">
                                <i class="fas fa-print me-2"></i>Print Report
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Product</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Quantity</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stockLogs as $log)
                                <tr>
                                    <td>
                                        <span class="font-weight-medium text-dark">{{ $log->created_at->format('d M Y') }}</span>
                                        <br><small class="text-muted">{{ $log->created_at->format('H:i') }}</small>
                                    </td>
                                    <td class="font-weight-medium text-dark">{{ $log->product->name }}</td>
                                    <td class="text-center">
                                        @if($log->type == 'in')
                                            <span class="badge bg-light text-success border-success border rounded-pill px-3">Stock In</span>
                                        @else
                                            <span class="badge bg-light text-danger border-danger border rounded-pill px-3">Stock Out</span>
                                        @endif
                                    </td>
                                    <td class="text-center font-weight-medium {{ $log->type == 'in' ? 'text-success' : 'text-danger' }}">
                                        {{ $log->type == 'in' ? '+' : '-' }}{{ number_format($log->quantity, 0, ',', '.') }}
                                    </td>
                                    <td class="text-muted">{{ $log->note ?? '-' }}</td>
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
@endsection
