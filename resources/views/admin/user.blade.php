@extends('layouts.app')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">User Management</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}" class="text-muted">Home</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Users</li>
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
                        <h4 class="card-title">User List</h4>
                        <div class="ms-auto">
                            <button type="button" class="btn btn-primary btn-rounded" data-bs-toggle="modal"
                                data-bs-target="#addUserModal">
                                <i class="fas fa-plus"></i> Add User
                            </button>
                        </div>
                    </div>
                    <h6 class="card-subtitle">Manage your system users here.</h6>
                    <div class="table-responsive">
                        <table id="zero_config" class="table border table-striped table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Store</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><span class="badge {{ $user->role == 'admin' ? 'bg-danger' : ($user->role == 'pimpinan' ? 'bg-success' : 'bg-info') }}">{{ ucfirst($user->role) }}</span></td>
                                    <td>{{ $user->store->name ?? '-' }}</td>
                                    <td>{{ $user->created_at->format('d M Y') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info btn-rounded" data-bs-toggle="modal"
                                            data-bs-target="#editUserModal{{ $user->id }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-rounded" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit User Modal -->
                                <div id="editUserModal{{ $user->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header modal-colored-header bg-info">
                                                <h4 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit User</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                            </div>
                                            <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Full Name</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Email Address</label>
                                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Role</label>
                                                        <select name="role" class="form-control" required>
                                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                            <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                                                            <option value="pimpinan" {{ $user->role == 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Store (Optional)</label>
                                                        <select name="store_id" class="form-control">
                                                            <option value="">None</option>
                                                            @foreach($stores as $store)
                                                                <option value="{{ $store->id }}" {{ $user->store_id == $store->id ? 'selected' : '' }}>{{ $store->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Password (Leave blank if not changing)</label>
                                                        <input type="password" name="password" class="form-control" placeholder="Enter new password">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-info">Update User</button>
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

    <!-- Add User Modal -->
    <div id="addUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-colored-header bg-primary">
                    <h4 class="modal-title" id="addUserModalLabel">Add New User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form action="{{ route('admin.user.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-control" required>
                                <option value="admin">Admin</option>
                                <option value="kasir">Kasir</option>
                                <option value="pimpinan">Pimpinan</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Store (Optional)</label>
                            <select name="store_id" class="form-control">
                                <option value="">None</option>
                                @foreach($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
