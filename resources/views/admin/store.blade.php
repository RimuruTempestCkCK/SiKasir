@extends('layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Manage Stores</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Stores</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">All Registered Stores</h4>
                    <h6 class="card-subtitle">Overview of all stores, their owners, and cashiers.</h6>
                    <div class="table-responsive">
                        <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    <th>Store Name</th>
                                    <th>Owner (Pimpinan)</th>
                                    <th>Location</th>
                                    <th>Cashiers</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stores as $store)
                                <tr>
                                    <td>{{ $store->name }}</td>
                                    <td>{{ $store->owner->name ?? 'No Owner' }}</td>
                                    <td>{{ $store->address ?? '-' }}</td>
                                    <td><span class="badge bg-primary">{{ $store->cashiers->count() }} Cashiers</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info btn-rounded" data-bs-toggle="modal" data-bs-target="#storeDetailModal{{ $store->id }}">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                    </td>
                                </tr>

                                <!-- Store Detail Modal -->
                                <div id="storeDetailModal{{ $store->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="storeDetailModalLabel{{ $store->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-info">
                                                <h4 class="modal-title" id="storeDetailModalLabel{{ $store->id }}">Store Detailed Information</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-4">
                                                    <div class="col-md-12">
                                                        <h5><i class="fas fa-store"></i> Store & Owner Info</h5>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <p><strong>Store Name:</strong> {{ $store->name }}</p>
                                                                <p><strong>Owner:</strong> {{ $store->owner->name ?? '-' }}</p>
                                                                <p><strong>Email:</strong> {{ $store->owner->email ?? '-' }}</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p><strong>Phone:</strong> {{ $store->phone ?? '-' }}</p>
                                                                <p><strong>Address:</strong> {{ $store->address ?? '-' }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h5><i class="fas fa-users"></i> Assigned Cashiers</h5>
                                                        <hr>
                                                        <div class="table-responsive">
                                                            <table class="table table-sm table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Email</th>
                                                                        <th>Join Date</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @forelse($store->cashiers as $cashier)
                                                                    <tr>
                                                                        <td>{{ $cashier->name }}</td>
                                                                        <td>{{ $cashier->email }}</td>
                                                                        <td>{{ $cashier->created_at->format('d/m/Y') }}</td>
                                                                    </tr>
                                                                    @empty
                                                                    <tr>
                                                                        <td colspan="3" class="text-center">No cashiers assigned.</td>
                                                                    </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
