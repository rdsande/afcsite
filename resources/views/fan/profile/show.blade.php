@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="fas fa-user"></i> My Profile</h3>
                    <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="profile-image-container mb-4">
                                @if($fan->profile_image)
                                    <img src="{{ asset('storage/' . $fan->profile_image) }}" 
                                         alt="Profile Image" 
                                         class="img-fluid rounded-circle border border-primary" 
                                         style="width: 200px; height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center border" 
                                         style="width: 200px; height: 200px; margin: 0 auto;">
                                        <i class="fas fa-user fa-5x text-white"></i>
                                    </div>
                                @endif
                            </div>
                            <h4 class="text-primary">{{ $fan->first_name }} {{ $fan->last_name }}</h4>
                            <p class="text-muted">Fan Member</p>
                        </div>
                        <div class="col-md-8">
                            <div class="profile-info">
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong><i class="fas fa-user text-primary"></i> First Name:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $fan->first_name }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong><i class="fas fa-user text-primary"></i> Last Name:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $fan->last_name }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong><i class="fas fa-envelope text-primary"></i> Email:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $fan->email }}
                                    </div>
                                </div>
                                @if($fan->phone)
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong><i class="fas fa-phone text-primary"></i> Phone:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $fan->phone }}
                                    </div>
                                </div>
                                @endif
                                @if($fan->date_of_birth)
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong><i class="fas fa-birthday-cake text-primary"></i> Date of Birth:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $fan->date_of_birth->format('M d, Y') }} ({{ $fan->getAge() }} years old)
                                    </div>
                                </div>
                                @endif
                                @if($fan->region)
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong><i class="fas fa-map-marker-alt text-primary"></i> Region:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $fan->region }}
                                    </div>
                                </div>
                                @endif
                                @if($fan->district)
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong><i class="fas fa-map-marker text-primary"></i> District:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $fan->district }}
                                    </div>
                                </div>
                                @endif
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong><i class="fas fa-star text-warning"></i> Points:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <span class="badge badge-warning badge-lg">{{ number_format($fan->points) }} points</span>
                                    </div>
                                </div>
                                @if($fan->jersey_number && $fan->jersey_name)
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong><i class="fas fa-tshirt text-primary"></i> Jersey:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        #{{ $fan->jersey_number }} - {{ $fan->jersey_name }}
                                    </div>
                                </div>
                                @endif
                                @if($fan->last_login)
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong><i class="fas fa-clock text-primary"></i> Last Login:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $fan->last_login->format('M d, Y h:i A') }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="text-center">
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection