@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Edit Profile</h3>
                    <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Profile
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

                    @if($errors->any())
                        <div class="alert alert-danger">
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
                                    <label>Profile Image</label>
                                    <div class="profile-image-container mb-3">
                                        @if($user->profile_image)
                                            <img src="{{ asset('storage/' . $user->profile_image) }}" 
                                                 alt="Profile Image" 
                                                 class="img-fluid rounded-circle" 
                                                 style="width: 200px; height: 200px; object-fit: cover;"
                                                 id="profile-preview">
                                        @else
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                                 style="width: 200px; height: 200px; margin: 0 auto;"
                                                 id="profile-placeholder">
                                                <i class="fas fa-user fa-5x text-white"></i>
                                            </div>
                                            <img src="" alt="Profile Image" class="img-fluid rounded-circle d-none" 
                                                 style="width: 200px; height: 200px; object-fit: cover;"
                                                 id="profile-preview">
                                        @endif
                                    </div>
                                    
                                    <div class="custom-file mb-2">
                                        <input type="file" class="custom-file-input" id="profile_image" name="profile_image" accept="image/*">
                                        <label class="custom-file-label" for="profile_image">Choose file</label>
                                    </div>
                                    
                                    @if($user->profile_image)
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
                                <div class="form-group">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr>
                                <h5>Change Password</h5>
                                <p class="text-muted">Leave password fields empty if you don't want to change your password.</p>

                                <div class="form-group">
                                    <label for="current_password">Current Password</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" name="current_password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Confirm New Password</label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                            <a href="{{ route('profile.show') }}" class="btn btn-secondary ml-2">
                                Cancel
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