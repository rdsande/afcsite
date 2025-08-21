@extends('layouts.admin')

@section('title', 'Create Notice')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Notice</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.notices.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Notices
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.notices.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="content">Content <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('content') is-invalid @enderror" 
                                              id="content" name="content" rows="6" required>{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="type">Type <span class="text-danger">*</span></label>
                                    <select class="form-control @error('type') is-invalid @enderror" 
                                            id="type" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="info" {{ old('type') == 'info' ? 'selected' : '' }}>Info</option>
                                        <option value="success" {{ old('type') == 'success' ? 'selected' : '' }}>Success</option>
                                        <option value="warning" {{ old('type') == 'warning' ? 'selected' : '' }}>Warning</option>
                                        <option value="danger" {{ old('type') == 'danger' ? 'selected' : '' }}>Danger</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="priority">Priority <span class="text-danger">*</span></label>
                                    <select class="form-control @error('priority') is-invalid @enderror" 
                                            id="priority" name="priority" required>
                                        <option value="">Select Priority</option>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" 
                                               id="is_active" name="is_active" value="1" 
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">Active</label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" 
                                               id="is_dismissible" name="is_dismissible" value="1" 
                                               {{ old('is_dismissible', true) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_dismissible">Dismissible</label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" 
                                               id="show_on_dashboard" name="show_on_dashboard" value="1" 
                                               {{ old('show_on_dashboard') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="show_on_dashboard">Show on Dashboard</label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="expires_at">Expires At</label>
                                    <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror" 
                                           id="expires_at" name="expires_at" value="{{ old('expires_at') }}">
                                    @error('expires_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Leave empty for no expiration</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Notice
                            </button>
                            <a href="{{ route('admin.notices.index') }}" class="btn btn-secondary">
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

@push('styles')
<style>
.custom-control-label::before {
    border-radius: 0.25rem;
}
.custom-control-label::after {
    border-radius: 0.25rem;
}
</style>
@endpush