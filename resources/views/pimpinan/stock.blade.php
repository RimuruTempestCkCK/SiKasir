@extends('layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Stock Management</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/pimpinan') }}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Stock</li>
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
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title">Stock Status</h4>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-success btn-rounded" data-bs-toggle="modal"
                                data-bs-target="#addStockModal">
                                <i class="fas fa-plus"></i> Add Stock
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Current Stock</th>
                                    <th>Status</th>
                                    <th>Last Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        @if($product->stock <= 5)
                                            <span class="badge bg-danger">Low Stock</span>
                                        @elseif($product->stock <= 20)
                                            <span class="badge bg-warning text-dark">Medium Stock</span>
                                        @else
                                            <span class="badge bg-success">Good Stock</span>
                                        @endif
                                    </td>
                                    <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-success btn-rounded" data-bs-toggle="modal"
                                            data-bs-target="#addStockModal" onclick="document.getElementById('product_select').value = '{{ $product->id }}'">
                                            <i class="fas fa-plus"></i> Restock
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

    <!-- Add Stock Modal -->
    <div id="addStockModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addStockModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-success">
                    <h4 class="modal-title" id="addStockModalLabel">Add Stock</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form action="{{ route('pimpinan.stock.add') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label">Product</label>
                            <select name="product_id" id="product_select" class="form-control" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Quantity to Add</label>
                            <input type="number" name="quantity" class="form-control" placeholder="Enter quantity" required min="1">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="note" class="form-control" placeholder="Optional notes"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Stock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
