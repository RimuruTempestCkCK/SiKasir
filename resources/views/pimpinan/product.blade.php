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

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title">Product List</h4>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-primary btn-rounded" data-bs-toggle="modal"
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
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>
                                        @if($product->photo)
                                            <img src="{{ asset('storage/' . $product->photo) }}" alt="product" width="50" class="rounded-circle">
                                        @else
                                            <img src="{{ asset('assets/images/big/icon.png') }}" alt="product" width="50" class="rounded-circle">
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name ?? 'No Category' }}</td>
                                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info btn-rounded" data-bs-toggle="modal"
                                            data-bs-target="#editProductModal{{ $product->id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('pimpinan.product.delete', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-rounded" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Product Modal -->
                                <div id="editProductModal{{ $product->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel{{ $product->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-info">
                                                <h4 class="modal-title" id="editProductModalLabel{{ $product->id }}">Edit Product</h4>
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
                                                        <label class="form-label">Price</label>
                                                        <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

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
                            <label class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" placeholder="Enter price" required>
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

</div>
@endsection
