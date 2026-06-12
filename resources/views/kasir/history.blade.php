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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">My Recent Transactions</h4>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered no-wrap">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Date</th>
                                    <th>Invoice</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Change</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                    <td><span class="font-weight-medium">{{ $transaction->invoice_number }}</span></td>
                                    <td>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($transaction->change, 0, ',', '.') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info btn-rounded" data-bs-toggle="modal" data-bs-target="#modal-{{ $transaction->id }}">
                                            <i class="fas fa-eye"></i> View
                                        </button>

                                        <!-- Detail Modal -->
                                        <div id="modal-{{ $transaction->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header modal-colored-header bg-info">
                                                        <h4 class="modal-title">Invoice: {{ $transaction->invoice_number }}</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <strong>Date:</strong> {{ $transaction->created_at->format('d M Y H:i') }}<br>
                                                            <strong>Cashier:</strong> {{ $transaction->cashier->name }}
                                                        </div>
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>Product</th>
                                                                    <th>Qty</th>
                                                                    <th class="text-end">Price</th>
                                                                    <th class="text-end">Subtotal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($transaction->details as $detail)
                                                                <tr>
                                                                    <td>{{ $detail->product->name }}</td>
                                                                    <td>{{ $detail->quantity }}</td>
                                                                    <td class="text-end">{{ number_format($detail->price, 0, ',', '.') }}</td>
                                                                    <td class="text-end">{{ number_format($detail->quantity * $detail->price, 0, ',', '.') }}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th colspan="3" class="text-end">Total</th>
                                                                    <th class="text-end">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No transactions found.</td>
                                </tr>
                                @endforelse
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
@endsection
