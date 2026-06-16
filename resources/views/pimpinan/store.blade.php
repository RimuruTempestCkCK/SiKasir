@extends('layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Store Profile</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/pimpinan') }}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Store</li>
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
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                        <h4 class="card-title text-dark mb-0">My Store Information</h4>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-info btn-rounded shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#editStoreModal">
                                <i class="fas fa-edit"></i> Edit Store Info
                            </button>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            @if($store->logo)
                                <img src="{{ asset('storage/' . $store->logo) }}" alt="Store Logo" class="img-fluid rounded shadow-sm border" style="max-height: 250px;">
                            @else
                                <div class="rounded shadow-sm border d-flex align-items-center justify-content-center bg-light" style="height: 250px;">
                                    <i class="fas fa-store fa-5x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-borderless v-middle">
                                    <tr>
                                        <th width="200" class="text-muted font-weight-medium">Store Name</th>
                                        <td class="text-dark font-weight-bold font-18">: {{ $store->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted font-weight-medium">Owner Name</th>
                                        <td class="text-dark">: {{ $store->owner->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted font-weight-medium">Address</th>
                                        <td class="text-dark">: {{ $store->address ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted font-weight-medium">Phone Number</th>
                                        <td class="text-dark">: {{ $store->phone ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted font-weight-medium">Description</th>
                                        <td class="text-dark">: {{ $store->description ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- Modals -->
    <!-- ============================================================== -->
    
    <!-- Edit Store Modal -->
    <div id="editStoreModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editStoreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-start shadow-lg border-0">
                <div class="modal-header modal-colored-header bg-info">
                    <h4 class="modal-title" id="editStoreModalLabel">Edit Store Information</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form action="{{ route('pimpinan.store.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label font-weight-medium">Store Name</label>
                                    <input type="text" name="name" class="form-control custom-radius" value="{{ $store->name }}" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label font-weight-medium">Phone Number</label>
                                    <input type="text" name="phone" class="form-control custom-radius" value="{{ $store->phone }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label font-weight-medium">Store Logo / Photo</label>
                                    <input type="file" name="logo" class="form-control custom-radius">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label font-weight-medium">Address</label>
                                    <textarea name="address" class="form-control custom-radius" rows="3">{{ $store->address }}</textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label font-weight-medium">Description</label>
                                    <textarea name="description" class="form-control custom-radius" rows="3">{{ $store->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-light shadow-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info shadow-sm">Save Changes</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</div>
@endsection
