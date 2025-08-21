@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Vendor Details: {{ $vendor->name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.vendors.edit', $vendor) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.vendors.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Vendors
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-store"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Vendor Name</span>
                                    <span class="info-box-number">{{ $vendor->name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-phone"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Phone Number</span>
                                    <span class="info-box-number">{{ $vendor->phone_number }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-map-marker-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Region</span>
                                    <span class="info-box-number">{{ $vendor->region }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary"><i class="fas fa-city"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">District</span>
                                    <span class="info-box-number">{{ $vendor->district }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-secondary"><i class="fas fa-building"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Ward</span>
                                    <span class="info-box-number">{{ $vendor->ward ?: 'Not specified' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-dark"><i class="fas fa-road"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Street</span>
                                    <span class="info-box-number">{{ $vendor->street ?: 'Not specified' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon {{ $vendor->is_active ? 'bg-success' : 'bg-danger' }}">
                                    <i class="fas {{ $vendor->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Status</span>
                                    <span class="info-box-number">
                                        @if($vendor->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-calendar"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Created</span>
                                    <span class="info-box-number">{{ $vendor->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h4 class="card-title">Complete Address</h4>
                        </div>
                        <div class="card-body">
                            <p class="lead">{{ $vendor->fullAddress }}</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.vendors.edit', $vendor) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Vendor
                            </a>
                            <form action="{{ route('admin.vendors.destroy', $vendor) }}" method="POST" style="display: inline;" 
                                  onsubmit="return confirm('Are you sure you want to delete this vendor? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Delete Vendor
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection