@extends('layouts.admin')

@section('title', 'My Profile')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">My Profile</h3>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="profile-image-container mb-3">
                                @if($user->profile_image)
                                    <img src="{{ asset('storage/' . $user->profile_image) }}" 
                                         alt="Profile Image" 
                                         class="img-fluid rounded-circle" 
                                         style="width: 200px; height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 200px; height: 200px; margin: 0 auto;">
                                        <i class="fas fa-user fa-5x text-white"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="profile-info">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Name:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $user->name }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Email:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $user->email }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Role:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        <span class="badge badge-{{ $user->role === 'super_admin' ? 'danger' : ($user->role === 'admin' ? 'warning' : 'info') }}">
                                            {{ $user->getRoleDisplayAttribute() }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Status:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        <span class="badge badge-{{ $user->is_active ? 'success' : 'secondary' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>
                                @if($user->last_login_at)
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <strong>Last Login:</strong>
                                    </div>
                                    <div class="col-sm-9">
                                        {{ $user->last_login_at->format('M d, Y h:i A') }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection