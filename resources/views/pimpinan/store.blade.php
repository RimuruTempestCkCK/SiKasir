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
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <h4 class="card-title">My Store Information</h4>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-info btn-rounded" data-bs-toggle="modal"
                                data-bs-target="#editStoreModal">
                                <i class="fas fa-edit"></i> Edit Store Info
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <img src="{{ asset('assets/images/big/3.jpg') }}" alt="Store Logo" class="img-fluid rounded shadow" style="max-height: 200px;">
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Store Name</th>
                                    <td>: Toko Berkah SiKasir</td>
                                </tr>
                                <tr>
                                    <th>Owner Name</th>
                                    <td>: Firdinal Juliandre</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>: Jl. Raya Kasir No. 123, Jakarta</td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td>: 0812-3456-7890</td>
                                </tr>
                                <tr>
                                    <th>Store Type</th>
                                    <td>: Retail / Minimarket</td>
                                </tr>
                            </table>
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
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-info">
                    <h4 class="modal-title" id="editStoreModalLabel">Edit Store Information</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form action="#">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Store Name</label>
                                    <input type="text" class="form-control" value="Toko Berkah SiKasir">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" value="0812-3456-7890">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Store Type</label>
                                    <input type="text" class="form-control" value="Retail / Minimarket">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Store Logo / Photo</label>
                                    <input type="file" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" rows="4">Jl. Raya Kasir No. 123, Jakarta</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">Save Changes</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</div>
@endsection
