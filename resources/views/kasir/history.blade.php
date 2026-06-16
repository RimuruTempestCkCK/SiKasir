@extends('layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Transaction History</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/kasir') }}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">History</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <!-- Filter Card -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('kasir.history') }}" method="GET">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label class="form-label font-weight-medium">Start Date</label>
                            <input type="date" name="start_date" class="form-control custom-radius custom-shadow border-0 bg-white" value="{{ $startDate }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label class="form-label font-weight-medium">End Date</label>
                            <input type="date" name="end_date" class="form-control custom-radius custom-shadow border-0 bg-white" value="{{ $endDate }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <label class="form-label font-weight-medium">Invoice Number</label>
                            <div class="customize-input">
                                <input type="text" name="search" class="form-control custom-radius custom-shadow border-0 bg-white" placeholder="Search invoice..." value="{{ $search }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-rounded w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-dark mb-4">My Recent Transactions</h4>
                    <div class="table-responsive">
                        <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Invoice</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-end">Paid</th>
                                    <th class="text-end">Change</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <span class="badge bg-light text-primary border-primary border rounded-pill px-3">{{ $transaction->invoice_number }}</span>
                                    </td>
                                    <td class="text-end">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                    <td class="text-end text-muted">Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}</td>
                                    <td class="text-end text-success font-weight-medium">Rp {{ number_format($transaction->change, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info btn-circle shadow-sm" data-bs-toggle="modal" data-bs-target="#modal-{{ $transaction->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <!-- Detail Modal -->
                                        <div id="modal-{{ $transaction->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content text-start border-0 shadow-lg">
                                                    <div class="modal-header modal-colored-header bg-info">
                                                        <h4 class="modal-title"><i class="fas fa-receipt me-2"></i>Invoice: {{ $transaction->invoice_number }}</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <div class="d-flex justify-content-between mb-3">
                                                            <span class="text-muted font-weight-medium">Date:</span>
                                                            <span class="text-dark">{{ $transaction->created_at->format('d F Y, H:i') }}</span>
                                                        </div>
                                                        <hr>
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
                                                                    <td class="text-end">{{ number_format($detail->quantity * $detail->selling_price, 0, ',', '.') }}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr class="border-top">
                                                                    <th colspan="2" class="pt-3 text-muted">Total</th>
                                                                    <th class="pt-3 text-dark font-weight-bold text-end font-18">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer bg-light">
                                                        <button type="button" class="btn btn-light shadow-sm btn-rounded" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
@endsection
