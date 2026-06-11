@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extra-libs/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
@endpush

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Store Management</h4>
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
    <!-- Summary Cards -->
    <div class="row">
        <div class="col-md-4">
            <div class="card border-end">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{ $stores->count() }}</h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Registered Stores</h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="home" class="text-primary"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-end">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 font-weight-medium">{{ $stores->whereNotNull('user_id')->count() }}</h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Store Owners (Pimpinan)</h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="user-check" class="text-success"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 font-weight-medium">{{ $stores->sum(function($s){ return $s->cashiers->count(); }) }}</h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Active Cashiers</h6>
                        </div>
                        <div class="ms-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="users" class="text-info"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Store Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title">List of All Stores</h4>
                    </div>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered no-wrap">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Store Info</th>
                                    <th>Owner</th>
                                    <th>Type</th>
                                    <th>Staff Count</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stores as $store)
                                <tr>
                                    <td>
                                        <h5 class="text-dark mb-0 font-16 font-weight-medium">{{ $store->name }}</h5>
                                        <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i> {{ $store->address ?? 'No address' }}</small>
                                    </td>
                                    <td>
                                        <div class="d-flex no-block align-items-center">
                                            <div class="me-2"><img src="{{ asset('assets/images/users/profile-pic.jpg') }}" alt="user" class="rounded-circle" width="30" /></div>
                                            <div>
                                                <h5 class="text-dark mb-0 font-14 font-weight-medium">{{ $store->owner->name ?? 'Unassigned' }}</h5>
                                                <small class="text-muted">{{ $store->owner->email ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-primary border-primary border px-3">{{ $store->type }}</span>
                                    </td>
                                    <td>
                                        <span class="text-dark font-weight-medium">{{ $store->cashiers->count() }} Kasir</span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-info btn-circle btn-sm" data-bs-toggle="modal" data-bs-target="#storeDetailModal{{ $store->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
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

@foreach($stores as $store)
<!-- Store Detail Modal -->
<div id="storeDetailModal{{ $store->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title"><i class="fas fa-store me-2"></i>Store Details: {{ $store->name }}</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row mb-4">
                    <div class="col-md-6 border-end">
                        <h6 class="text-primary text-uppercase font-weight-bold mb-3">General Information</h6>
                        <div class="mb-2">
                            <small class="text-muted d-block">Store Name</small>
                            <span class="text-dark font-weight-medium font-16">{{ $store->name }}</span>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted d-block">Store Type</small>
                            <span class="badge bg-light text-primary border-primary border">{{ $store->type }}</span>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted d-block">Phone Number</small>
                            <span class="text-dark font-weight-medium">{{ $store->phone ?? '-' }}</span>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted d-block">Full Address</small>
                            <span class="text-dark font-weight-medium">{{ $store->address ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 ps-md-4">
                        <h6 class="text-primary text-uppercase font-weight-bold mb-3">Owner (Pimpinan)</h6>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3"><img src="{{ asset('assets/images/users/profile-pic.jpg') }}" alt="user" class="rounded-circle" width="50" /></div>
                            <div>
                                <h5 class="text-dark mb-0 font-weight-bold">{{ $store->owner->name ?? 'Not Assigned' }}</h5>
                                <p class="text-muted mb-0">{{ $store->owner->email ?? 'No email' }}</p>
                            </div>
                        </div>
                        <div class="alert alert-info py-2 font-12">
                            <i class="fas fa-info-circle me-1"></i> This owner is responsible for managing products and staff for this store.
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <h6 class="text-primary text-uppercase font-weight-bold mb-3">Registered Cashiers ({{ $store->cashiers->count() }})</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover border">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0">Cashier Name</th>
                                        <th class="border-0">Email Address</th>
                                        <th class="border-0 text-end">Registered At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($store->cashiers as $cashier)
                                    <tr>
                                        <td class="font-weight-medium text-dark">{{ $cashier->name }}</td>
                                        <td>{{ $cashier->email }}</td>
                                        <td class="text-end text-muted">{{ $cashier->created_at->format('d M Y') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-3 text-muted italic">No cashiers currently assigned to this store.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
            $('#zero_config').DataTable({
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[ 0, "asc" ]]
            });
        });
    </script>
@endpush
