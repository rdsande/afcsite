@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                        </div>

                        <form action="{{ route('admin.users.update', $user) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <!-- Name -->
                                <div class="form-group">
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label for="email">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password">
                                    <small class="form-text text-muted">Leave blank to keep current password. Must be at least 8 characters if changing.</small>
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm New Password</label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation">
                                </div>

                                <!-- Role -->
                                @if(auth()->user()->role === 'super_admin' && auth()->user()->id !== $user->id)
                                <div class="form-group">
                                    <label for="role">Role <span class="text-danger">*</span></label>
                                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="editor" {{ old('role', $user->role) == 'editor' ? 'selected' : '' }}>Editor</option>
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <strong>Editor:</strong> Can manage news, players, and fixtures.<br>
                                        <strong>Admin:</strong> Can manage content and users (except super admins).
                                    </small>
                                </div>
                                @else
                                <div class="form-group">
                                    <label>Role</label>
                                    <input type="text" class="form-control" value="{{ ucfirst(str_replace('_', ' ', $user->role)) }}" readonly>
                                    <small class="form-text text-muted">
                                        @if(auth()->user()->id === $user->id)
                                            You cannot change your own role.
                                        @else
                                            Only super admins can modify user roles.
                                        @endif
                                    </small>
                                </div>
                                @endif

                                <!-- Status -->
                                @if(auth()->user()->role === 'super_admin' && auth()->user()->id !== $user->id)
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                @else
                                <div class="form-group">
                                    <label>Status</label>
                                    <input type="text" class="form-control" value="{{ ucfirst($user->status) }}" readonly>
                                    <small class="form-text text-muted">
                                        @if(auth()->user()->id === $user->id)
                                            You cannot change your own status.
                                        @else
                                            Only super admins can modify user status.
                                        @endif
                                    </small>
                                </div>
                                @endif
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update User
                                </button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">User Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-info"><i class="fas fa-user"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">User ID</span>
                                    <span class="info-box-number">#{{ $user->id }}</span>
                                </div>
                            </div>

                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success"><i class="fas fa-calendar"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Created</span>
                                    <span class="info-box-number">{{ $user->created_at->format('M d, Y') }}</span>
                                    <small>{{ $user->created_at->diffForHumans() }}</small>
                                </div>
                            </div>

                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Last Login</span>
                                    <span class="info-box-number">
                                        {{ $user->last_login_at ? $user->last_login_at->format('M d, Y') : 'Never' }}
                                    </span>
                                    @if($user->last_login_at)
                                    <small>{{ $user->last_login_at->diffForHumans() }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="info-box">
                                <span class="info-box-icon bg-{{ $user->role == 'super_admin' ? 'danger' : ($user->role == 'admin' ? 'warning' : 'info') }}">
                                    <i class="fas fa-{{ $user->role == 'super_admin' ? 'crown' : ($user->role == 'admin' ? 'user-shield' : 'edit') }}"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Current Role</span>
                                    <span class="info-box-number">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection