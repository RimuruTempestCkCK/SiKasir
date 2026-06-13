@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
@endpush

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Transaction Report</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/pimpinan') }}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Transaction Report</li>
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
                    <h4 class="card-title mb-3"><i class="fas fa-filter me-2"></i>Filter Report</h4>
                    <form action="{{ route('pimpinan.report.transaction') }}" method="GET">
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
                                <a href="{{ route('pimpinan.report.transaction') }}" class="btn btn-light btn-rounded px-4 ms-2">
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
        <div class="col-md-3">
            <div class="card border-end">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Revenue</h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="dollar-sign"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-end">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-primary mb-1 font-weight-medium">Rp {{ number_format($totalProfit, 0, ',', '.') }}</h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Profit</h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-primary"><i data-feather="trending-up"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-end">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 font-weight-medium">{{ $totalTransactionsCount }}</h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Transactions</h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="shopping-cart"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 font-weight-medium">{{ $transactions->unique('user_id')->count() }}</h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Active Cashiers</h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="users"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title">Transaction Details</h4>
                        <div class="ms-auto">
                            <button class="btn btn-outline-primary btn-sm btn-rounded" onclick="window.print()">
                                <i class="fas fa-print me-2"></i>Print Report
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="report_table" class="table table-striped table-bordered no-wrap">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Invoice</th>
                                    <th>Cashier</th>
                                    <th>Total Revenue</th>
                                    <th>Profit</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td>
                                        <span class="font-weight-medium text-dark">{{ $transaction->created_at->format('d M Y') }}</span>
                                        <br><small class="text-muted">{{ $transaction->created_at->format('H:i') }}</small>
                                    </td>
                                    <td><span class="badge bg-light text-primary border-primary border">{{ $transaction->invoice_number }}</span></td>
                                    <td>{{ $transaction->cashier->name }}</td>
                                    <td class="font-weight-medium text-dark">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                    <td class="font-weight-medium text-primary">
                                        @php
                                            $trxProfit = $transaction->details->sum(function($detail) {
                                                return ($detail->selling_price - $detail->purchase_price) * $detail->quantity;
                                            });
                                        @endphp
                                        Rp {{ number_format($trxProfit, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-circle btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $transaction->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($transactions as $transaction)
<!-- Detail Modal -->
<div id="detailModal{{ $transaction->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title"><i class="fas fa-receipt me-2"></i>Invoice {{ $transaction->invoice_number }}</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Date:</span>
                    <span class="text-dark font-weight-medium">{{ $transaction->created_at->format('d F Y, H:i') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Cashier:</span>
                    <span class="text-dark font-weight-medium">{{ $transaction->cashier->name }}</span>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-sm table-borderless">
                        <thead>
                            <tr class="text-muted font-12 text-uppercase">
                                <th>Item</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction->details as $detail)
                            <tr>
                                <td class="font-weight-medium text-dark">{{ $detail->product->name }}</td>
                                <td class="text-center">{{ $detail->quantity }}</td>
                                <td class="text-end">{{ number_format($detail->selling_price * $detail->quantity, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 pt-3 border-top">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted font-16">Total</span>
                        <span class="text-dark font-weight-bold font-18">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Paid</span>
                        <span class="text-dark">Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Change</span>
                        <span class="text-success font-weight-bold">Rp {{ number_format($transaction->change, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary px-4 btn-rounded" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('scripts')
    <script src="{{ asset('assets/extra-libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>
    <script>
        $(function () {
            $('#report_table').DataTable({
                "paging": false,      // Matikan paging DataTable karena pakai Pagination Laravel
                "info": false,        // Matikan info bar
                "searching": false,   // Matikan pencarian client-side (agar tidak lag)
                "ordering": false     // Matikan sorting client-side (agar tidak lag)
            });
        });
    </script>
@endpush
