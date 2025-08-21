@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><i class="fas fa-edit"></i> Edit Profile</h3>
                    <a href="{{ route('profile.show') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Profile
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

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h6><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h6>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <div class="col-md-4">
                                <!-- Profile Image Section -->
                                <div class="form-group text-center">
                                    <label class="font-weight-bold"><i class="fas fa-camera"></i> Profile Image</label>
                                    <div class="profile-image-container mb-3">
                                        @if($fan->profile_image)
                                            <img src="{{ asset('storage/' . $fan->profile_image) }}" 
                                                 alt="Profile Image" 
                                                 class="img-fluid rounded-circle border border-primary" 
                                                 style="width: 200px; height: 200px; object-fit: cover;"
                                                 id="profile-preview">
                                        @else
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center border" 
                                                 style="width: 200px; height: 200px; margin: 0 auto;"
                                                 id="profile-placeholder">
                                                <i class="fas fa-user fa-5x text-white"></i>
                                            </div>
                                            <img src="" alt="Profile Image" class="img-fluid rounded-circle border border-primary d-none" 
                                                 style="width: 200px; height: 200px; object-fit: cover;"
                                                 id="profile-preview">
                                        @endif
                                    </div>
                                    
                                    <div class="custom-file mb-2">
                                        <input type="file" class="custom-file-input" id="profile_image" name="profile_image" accept="image/*">
                                        <label class="custom-file-label" for="profile_image">Choose file</label>
                                    </div>
                                    
                                    @if($fan->profile_image)
                                        <form action="{{ route('profile.delete-image') }}" method="POST" class="d-inline" id="delete-image-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDeleteImage()">
                                                <i class="fas fa-trash"></i> Remove Image
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <small class="form-text text-muted">
                                        Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB
                                    </small>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <!-- Basic Information -->
                                <h5 class="text-primary mb-3"><i class="fas fa-user"></i> Personal Information</h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name" class="font-weight-bold">First Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                                   id="first_name" name="first_name" value="{{ old('first_name', $fan->first_name) }}" required>
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name" class="font-weight-bold">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                                   id="last_name" name="last_name" value="{{ old('last_name', $fan->last_name) }}" required>
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="font-weight-bold">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $fan->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="phone" class="font-weight-bold">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $fan->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr>
                                <h5 class="text-primary mb-3"><i class="fas fa-lock"></i> Change Password</h5>
                                <p class="text-muted">Leave password fields empty if you don't want to change your password.</p>

                                <div class="form-group">
                                    <label for="current_password" class="font-weight-bold">Current Password</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" name="current_password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password" class="font-weight-bold">New Password</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation" class="font-weight-bold">Confirm New Password</label>
                                            <input type="password" class="form-control" 
                                                   id="password_confirmation" name="password_confirmation">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4 text-center">
                            <button type="submit" class="btn btn-primary btn-lg mr-3">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                            <a href="{{ route('profile.show') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Preview image before upload
document.getElementById('profile_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('profile-preview');
            const placeholder = document.getElementById('profile-placeholder');
            
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            if (placeholder) {
                placeholder.classList.add('d-none');
            }
        };
        reader.readAsDataURL(file);
    }
});

// Update file input label
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Choose file';
    const label = e.target.nextElementSibling;
    label.textContent = fileName;
});

// Confirm delete image
function confirmDeleteImage() {
    if (confirm('Are you sure you want to remove your profile image?')) {
        document.getElementById('delete-image-form').submit();
    }
}
</script>
@endsection