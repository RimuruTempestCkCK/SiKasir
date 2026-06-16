@extends('layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Manage Products</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/pimpinan') }}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Products</li>
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

            <!-- Filter Card -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3"><i class="fas fa-filter me-2"></i>Filter Products</h4>
                    <form action="{{ route('pimpinan.product') }}" method="GET">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label class="form-label font-weight-medium">Start Date</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label class="form-label font-weight-medium">End Date</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label class="form-label font-weight-medium">Search</label>
                                    <input type="text" name="search" class="form-control" placeholder="Search product or category..." value="{{ $search }}">
                                </div>
                            </div>
                            <div class="col-md-2 mt-3 mt-md-0">
                                <button type="submit" class="btn btn-primary btn-rounded w-100 shadow-sm">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title text-dark">Product List</h4>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-primary btn-rounded shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#addProductModal">
                                <i class="fas fa-plus"></i> Add New Product
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th class="text-end">Modal</th>
                                    <th class="text-end">Jual</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td class="text-center">
                                        @if($product->photo)
                                            <img src="{{ asset('storage/' . $product->photo) }}" alt="product" width="45" height="45" class="rounded-circle shadow-sm">
                                        @else
                                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white font-weight-bold shadow-sm" 
                                                 style="width: 45px; height: 45px; background-color: {{ $product->placeholder_color }}; font-size: 14px;">
                                                {{ $product->initials }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="font-weight-medium text-dark">{{ $product->name }}</td>
                                    <td>{{ $product->category->name ?? '-' }}</td>
                                    <td class="text-end">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $product->stock <= 5 ? 'bg-danger' : 'bg-success' }} rounded-pill font-12 font-weight-medium text-white px-3">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info btn-circle shadow-sm" data-bs-toggle="modal"
                                            data-bs-target="#editProductModal{{ $product->id }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('pimpinan.product.delete', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-circle shadow-sm" onclick="return confirm('Are you sure?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                        <!-- Edit Product Modal -->
                                        <div id="editProductModal{{ $product->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel{{ $product->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content text-start">
                                                    <div class="modal-header modal-colored-header bg-info">
                                                        <h4 class="modal-title">Edit Product</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                    </div>
                                                    <form action="{{ route('pimpinan.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group mb-3">
                                                                <label class="form-label">Product Name</label>
                                                                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="form-label">Category</label>
                                                                <select name="category_id" class="form-control" required>
                                                                    @foreach($categories as $category)
                                                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="form-label">Harga Modal</label>
                                                                <input type="number" name="purchase_price" class="form-control" value="{{ $product->purchase_price }}" required>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="form-label">Harga Jual</label>
                                                                <input type="number" name="selling_price" class="form-control" value="{{ $product->selling_price }}" required>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="form-label">Product Photo</label>
                                                                <input type="file" name="photo" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-info">Update Product</button>
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

<!-- Add Product Modal -->
<div id="addProductModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-primary">
                <h4 class="modal-title" id="addProductModalLabel">Add New Product</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form action="{{ route('pimpinan.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Harga Modal</label>
                        <input type="number" name="purchase_price" class="form-control" placeholder="Enter purchase price" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Harga Jual</label>
                        <input type="number" name="selling_price" class="form-control" placeholder="Enter selling price" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Initial Stock</label>
                        <input type="number" name="stock" class="form-control" placeholder="Enter initial stock" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Product Photo</label>
                        <input type="file" name="photo" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
