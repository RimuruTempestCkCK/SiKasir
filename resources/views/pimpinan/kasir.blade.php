@extends('layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Manage Cashiers</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/pimpinan') }}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Cashiers</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title text-dark">Cashier List</h4>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-primary btn-rounded shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#addCashierModal">
                                <i class="fas fa-plus"></i> Add New Cashier
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Joined At</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cashiers as $cashier)
                                <tr>
                                    <td>
                                        <div class="d-flex no-block align-items-center">
                                            <div class="me-3">
                                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white font-weight-bold shadow-sm" 
                                                     style="width: 40px; height: 40px; background-color: #5f76e8; font-size: 14px;">
                                                    {{ strtoupper(substr($cashier->name, 0, 2)) }}
                                                </div>
                                            </div>
                                            <div class="">
                                                <h5 class="text-dark mb-0 font-16 font-weight-medium">{{ $cashier->name }}</h5>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $cashier->email }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-primary border-primary border rounded-pill px-3">{{ ucfirst($cashier->role) }}</span>
                                    </td>
                                    <td class="text-center text-muted">{{ $cashier->created_at->format('d M Y') }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info btn-circle shadow-sm" data-bs-toggle="modal"
                                            data-bs-target="#editCashierModal{{ $cashier->id }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('pimpinan.kasir.delete', $cashier->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-circle shadow-sm" onclick="return confirm('Are you sure?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                        <!-- Edit Cashier Modal -->
                                        <div id="editCashierModal{{ $cashier->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editCashierModalLabel{{ $cashier->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content text-start border-0 shadow-lg">
                                                    <div class="modal-header modal-colored-header bg-info">
                                                        <h4 class="modal-title" id="editCashierModalLabel{{ $cashier->id }}">Edit Cashier</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                    </div>
                                                    <form action="{{ route('pimpinan.kasir.update', $cashier->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body p-4">
                                                            <div class="form-group mb-3">
                                                                <label class="form-label font-weight-medium">Full Name</label>
                                                                <input type="text" name="name" class="form-control" value="{{ $cashier->name }}" required>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="form-label font-weight-medium">Email</label>
                                                                <input type="email" name="email" class="form-control" value="{{ $cashier->email }}" required>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="form-label font-weight-medium">New Password (Empty if no change)</label>
                                                                <input type="password" name="password" class="form-control" placeholder="Enter new password">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer bg-light">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-info">Update Cashier</button>
                                                        </div>
                                                    </form>
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

    <!-- Add Cashier Modal -->
    <div id="addCashierModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addCashierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="addCashierModalLabel">Add New Cashier</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form action="{{ route('pimpinan.kasir.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="form-group mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter cashier name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Cashier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
