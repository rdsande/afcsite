@extends('layouts.admin')

@section('title', 'Fan Management')

@section('breadcrumb')
    <li class="breadcrumb-item active">Fans</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($stats['total_fans']) }}</h3>
                    <p>Total Fans</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($stats['new_this_month']) }}</h3>
                    <p>New This Month</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($stats['active_fans']) }}</h3>
                    <p>Active Fans (30 days)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-heart"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ number_format($stats['total_points_distributed']) }}</h3>
                    <p>Total Points Distributed</p>
                </div>
                <div class="icon">
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Search & Filter Fans</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.fans.index') }}" class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="search">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Name, phone, email...">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="region">Region</label>
                        <select class="form-control" id="region" name="region">
                            <option value="">All Regions</option>
                            @foreach($regions as $region)
                                <option value="{{ $region }}" {{ request('region') == $region ? 'selected' : '' }}>
                                    {{ $region }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender">
                            <option value="">All Genders</option>
                            <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ request('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="date_from">From Date</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" 
                               value="{{ request('date_from') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="date_to">To Date</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" 
                               value="{{ request('date_to') }}">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Fans Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Fans List ({{ $fans->total() }} total)</h3>

        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'id', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}">
                                ID
                                @if(request('sort_by') == 'id')
                                    <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'first_name', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}">
                                Name
                                @if(request('sort_by') == 'first_name')
                                    <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Region</th>
                        <th>Gender</th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'points', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}">
                                Points
                                @if(request('sort_by') == 'points')
                                    <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'created_at', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}">
                                Registered
                                @if(request('sort_by') == 'created_at')
                                    <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                @endif
                            </a>
                        </th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fans as $fan)
                        <tr>
                            <td>{{ $fan->id }}</td>
                            <td>
                                <strong>{{ $fan->full_name }}</strong>
                            </td>
                            <td>
                                <a href="tel:{{ $fan->phone }}" class="text-primary">
                                    {{ $fan->phone }}
                                </a>
                            </td>
                            <td>
                                @if($fan->email)
                                    <a href="mailto:{{ $fan->email }}" class="text-primary">
                                        {{ $fan->email }}
                                    </a>
                                @else
                                    <span class="text-muted">No email</span>
                                @endif
                            </td>
                            <td>{{ $fan->region }}</td>
                            <td>
                                <span class="badge badge-{{ $fan->gender == 'male' ? 'primary' : ($fan->gender == 'female' ? 'pink' : 'secondary') }}">
                                    {{ ucfirst($fan->gender) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-success">
                                    <i class="fas fa-star"></i> {{ number_format($fan->points) }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $fan->created_at->format('M d, Y') }}
                                </small>
                            </td>
                            <td>
                                @if($fan->last_login)
                                    <small class="text-muted">
                                        {{ $fan->last_login->diffForHumans() }}
                                    </small>
                                @else
                                    <span class="badge badge-warning">Never</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.fans.show', $fan) }}" class="btn btn-info btn-sm" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.fans.edit', $fan) }}" class="btn btn-warning btn-sm" title="Edit Fan">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <p>No fans found matching your criteria.</p>
                                    @if(request()->hasAny(['search', 'region', 'gender', 'date_from', 'date_to']))
                                        <a href="{{ route('admin.fans.index') }}" class="btn btn-primary">
                                            <i class="fas fa-times"></i> Clear Filters
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($fans->hasPages())
            <div class="card-footer">
                {{ $fans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-submit form on select change
    $('#region, #gender').change(function() {
        $(this).closest('form').submit();
    });
    
    // Clear individual filters
    $('.clear-filter').click(function(e) {
        e.preventDefault();
        var input = $(this).siblings('input, select');
        input.val('');
        $(this).closest('form').submit();
    });
});
</script>
@endpush