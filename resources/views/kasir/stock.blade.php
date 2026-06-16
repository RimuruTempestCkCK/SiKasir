@extends('layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Stock Monitor</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/kasir') }}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Stock Monitor</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title text-dark mb-4">Available Stock</h4>
                    <div class="table-responsive">
                        <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-center">Current Stock</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name ?? '-' }}</td>
                                    <td class="text-end font-weight-medium">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                    <td class="text-center text-dark font-weight-medium">{{ $product->stock }}</td>
                                    <td class="text-center">
                                        @if($product->stock <= 5)
                                            <span class="badge bg-danger rounded-pill font-12 font-weight-medium text-white px-3">Low Stock</span>
                                        @elseif($product->stock <= 20)
                                            <span class="badge bg-warning rounded-pill font-12 font-weight-medium text-dark px-3">Medium Stock</span>
                                        @else
                                            <span class="badge bg-success rounded-pill font-12 font-weight-medium text-white px-3">In Stock</span>
                                        @endif
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
