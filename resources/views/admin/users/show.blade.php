@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">{{ $user->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">User Information</h3>
                            <div class="card-tools">
                                @if(auth()->user()->role === 'super_admin' || auth()->user()->id === $user->id)
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit User
                                </a>
                                @endif
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <p class="form-control-static">{{ $user->name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <p class="form-control-static">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Role</label>
                                        <p class="form-control-static">
                                            <span class="badge badge-{{ $user->role == 'super_admin' ? 'danger' : ($user->role == 'admin' ? 'warning' : 'info') }} badge-lg">
                                                <i class="fas fa-{{ $user->role == 'super_admin' ? 'crown' : ($user->role == 'admin' ? 'user-shield' : 'edit') }}"></i>
                                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <p class="form-control-static">
                                            <span class="badge badge-{{ $user->status == 'active' ? 'success' : 'secondary' }} badge-lg">
                                                <i class="fas fa-{{ $user->status == 'active' ? 'check-circle' : 'times-circle' }}"></i>
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Created Date</label>
                                        <p class="form-control-static">
                                            {{ $user->created_at->format('F d, Y \a\t H:i') }}
                                            <small class="text-muted">({{ $user->created_at->diffForHumans() }})</small>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Updated</label>
                                        <p class="form-control-static">
                                            {{ $user->updated_at->format('F d, Y \a\t H:i') }}
                                            <small class="text-muted">({{ $user->updated_at->diffForHumans() }})</small>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Last Login</label>
                                        <p class="form-control-static">
                                            @if($user->last_login_at)
                                                {{ $user->last_login_at->format('F d, Y \a\t H:i') }}
                                                <small class="text-muted">({{ $user->last_login_at->diffForHumans() }})</small>
                                            @else
                                                <span class="text-muted">Never logged in</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>User ID</label>
                                        <p class="form-control-static">#{{ $user->id }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Users
                            </a>
                            @if(auth()->user()->role === 'super_admin' || auth()->user()->id === $user->id)
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit User
                            </a>
                            @endif
                            @if(auth()->user()->role === 'super_admin' && auth()->user()->id !== $user->id)
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Delete User
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Role Permissions</h3>
                        </div>
                        <div class="card-body">
                            @if($user->role === 'super_admin')
                            <div class="alert alert-danger">
                                <h5><i class="fas fa-crown"></i> Super Administrator</h5>
                                <ul class="mb-0">
                                    <li>Full system access</li>
                                    <li>Manage all users</li>
                                    <li>Manage all content</li>
                                    <li>System configuration</li>
                                </ul>
                            </div>
                            @elseif($user->role === 'admin')
                            <div class="alert alert-warning">
                                <h5><i class="fas fa-user-shield"></i> Administrator</h5>
                                <ul class="mb-0">
                                    <li>Manage editors</li>
                                    <li>Manage all content</li>
                                    <li>View user reports</li>
                                    <li>Content moderation</li>
                                </ul>
                            </div>
                            @else
                            <div class="alert alert-info">
                                <h5><i class="fas fa-edit"></i> Editor</h5>
                                <ul class="mb-0">
                                    <li>Create and edit news</li>
                                    <li>Manage players</li>
                                    <li>Manage fixtures</li>
                                    <li>Upload media files</li>
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Account Statistics</h3>
                        </div>
                        <div class="card-body">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-info"><i class="fas fa-calendar-plus"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Account Age</span>
                                    <span class="info-box-number">{{ $user->created_at->diffInDays() }} days</span>
                                </div>
                            </div>

                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-{{ $user->status == 'active' ? 'success' : 'secondary' }}">
                                    <i class="fas fa-{{ $user->status == 'active' ? 'check-circle' : 'times-circle' }}"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Account Status</span>
                                    <span class="info-box-number">{{ ucfirst($user->status) }}</span>
                                </div>
                            </div>

                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Last Activity</span>
                                    <span class="info-box-number">
                                        @if($user->last_login_at)
                                            {{ $user->last_login_at->diffForHumans() }}
                                        @else
                                            Never
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
.badge-lg {
    font-size: 0.9em;
    padding: 0.5em 0.75em;
}
.form-control-static {
    padding-top: 7px;
    padding-bottom: 7px;
    margin-bottom: 0;
    min-height: 34px;
}
</style>
@endsection