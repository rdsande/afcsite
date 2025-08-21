@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Vendors Management</h3>
                    <a href="{{ route('admin.vendors.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Vendor
                    </a>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('admin.vendors.index') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Search by name or phone..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="region" class="form-control">
                                    <option value="">All Regions</option>
                                    <option value="Dar es Salaam" {{ request('region') == 'Dar es Salaam' ? 'selected' : '' }}>Dar es Salaam</option>
                                    <option value="Mwanza" {{ request('region') == 'Mwanza' ? 'selected' : '' }}>Mwanza</option>
                                    <option value="Arusha" {{ request('region') == 'Arusha' ? 'selected' : '' }}>Arusha</option>
                                    <option value="Dodoma" {{ request('region') == 'Dodoma' ? 'selected' : '' }}>Dodoma</option>
                                    <option value="Mbeya" {{ request('region') == 'Mbeya' ? 'selected' : '' }}>Mbeya</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-secondary">Filter</button>
                                <a href="{{ route('admin.vendors.index') }}" class="btn btn-outline-secondary">Clear</a>
                            </div>
                        </div>
                    </form>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Region</th>
                                    <th>District</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vendors as $vendor)
                                    <tr>
                                        <td>{{ $vendor->id }}</td>
                                        <td>{{ $vendor->name }}</td>
                                        <td>{{ $vendor->phone_number }}</td>
                                        <td>{{ $vendor->region }}</td>
                                        <td>{{ $vendor->district }}</td>
                                        <td>{{ $vendor->fullAddress }}</td>
                                        <td>
                                            @if($vendor->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.vendors.show', $vendor) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.vendors.edit', $vendor) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.vendors.destroy', $vendor) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this vendor?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No vendors found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $vendors->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection