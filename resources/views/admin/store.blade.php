@extends('layouts.app')

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
                        <h4 class="card-title text-dark">Store List</h4>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-primary btn-rounded shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#addStoreModal">
                                <i class="fas fa-plus"></i> Add New Store
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th>Store Name</th>
                                    <th>Owner</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stores as $store)
                                <tr>
                                    <td class="text-center">
                                        @if($store->logo)
                                            <img src="{{ asset('storage/' . $store->logo) }}" alt="logo" width="40" height="40" class="rounded shadow-sm">
                                        @else
                                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center bg-light text-muted shadow-sm" style="width: 40px; height: 40px;">
                                                <i class="fas fa-store"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="font-weight-medium text-dark">{{ $store->name }}</td>
                                    <td>{{ $store->owner->name ?? '-' }}</td>
                                    <td>{{ $store->phone ?? '-' }}</td>
                                    <td>{{ Str::limit($store->address, 30) }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info btn-circle shadow-sm" data-bs-toggle="modal"
                                            data-bs-target="#editStoreModal{{ $store->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.store.delete', $store->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-circle shadow-sm" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                        <!-- Edit Store Modal -->
                                        <div id="editStoreModal{{ $store->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content text-start">
                                                    <div class="modal-header modal-colored-header bg-info">
                                                        <h4 class="modal-title">Edit Store</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                    </div>
                                                    <form action="{{ route('admin.store.update', $store->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group mb-3">
                                                                <label class="form-label">Store Name</label>
                                                                <input type="text" name="name" class="form-control" value="{{ $store->name }}" required>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="form-label">Phone Number</label>
                                                                <input type="text" name="phone" class="form-control" value="{{ $store->phone }}">
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="form-label">Address</label>
                                                                <textarea name="address" class="form-control" rows="2">{{ $store->address }}</textarea>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="form-label">Description</label>
                                                                <textarea name="description" class="form-control" rows="2">{{ $store->description }}</textarea>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="form-label">Store Logo</label>
                                                                <input type="file" name="logo" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-info">Update Store</button>
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
</div>

<!-- Add Store Modal -->
<div id="addStoreModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addStoreModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary">
                <h4 class="modal-title" id="addStoreModalLabel">Add New Store</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="{{ route('admin.store.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label">Store Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter store name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" placeholder="Enter phone number">
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="Enter address"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Enter store description"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Store Logo</label>
                        <input type="file" name="logo" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Store</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
