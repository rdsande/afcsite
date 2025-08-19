@extends('layouts.admin')

@section('title', 'Edit Tournament')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Tournament</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.tournaments.index') }}">Tournaments</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Tournament Information</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.tournaments.update', $tournament) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">Tournament Name *</label>
                                            <input type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name', $tournament->name) }}" 
                                                   placeholder="e.g., Premier League" 
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="short_name" class="form-label">Short Name</label>
                                            <input type="text" 
                                                   class="form-control @error('short_name') is-invalid @enderror" 
                                                   id="short_name" 
                                                   name="short_name" 
                                                   value="{{ old('short_name', $tournament->short_name) }}" 
                                                   placeholder="e.g., PL">
                                            @error('short_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="type" class="form-label">Tournament Type *</label>
                                            <select class="form-control @error('type') is-invalid @enderror" 
                                                    id="type" 
                                                    name="type" 
                                                    required>
                                                <option value="">Select Type</option>
                                                <option value="league" {{ old('type', $tournament->type) == 'league' ? 'selected' : '' }}>League</option>
                                                <option value="cup" {{ old('type', $tournament->type) == 'cup' ? 'selected' : '' }}>Cup</option>
                                                <option value="friendly" {{ old('type', $tournament->type) == 'friendly' ? 'selected' : '' }}>Friendly</option>
                                            </select>
                                            @error('type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="format" class="form-label">Format *</label>
                                            <select class="form-control @error('format') is-invalid @enderror" 
                                                    id="format" 
                                                    name="format" 
                                                    required>
                                                <option value="">Select Format</option>
                                                <option value="round_robin" {{ old('format', $tournament->format) == 'round_robin' ? 'selected' : '' }}>Round Robin</option>
                                                <option value="knockout" {{ old('format', $tournament->format) == 'knockout' ? 'selected' : '' }}>Knockout</option>
                                                <option value="group_stage" {{ old('format', $tournament->format) == 'group_stage' ? 'selected' : '' }}>Group Stage</option>
                                            </select>
                                            @error('format')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="season" class="form-label">Season</label>
                                            <input type="text" 
                                                   class="form-control @error('season') is-invalid @enderror" 
                                                   id="season" 
                                                   name="season" 
                                                   value="{{ old('season', $tournament->season) }}" 
                                                   placeholder="e.g., 2024/2025">
                                            @error('season')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="start_date" class="form-label">Start Date</label>
                                            <input type="date" 
                                                   class="form-control @error('start_date') is-invalid @enderror" 
                                                   id="start_date" 
                                                   name="start_date" 
                                                   value="{{ old('start_date', $tournament->start_date ? $tournament->start_date->format('Y-m-d') : '') }}">
                                            @error('start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="end_date" class="form-label">End Date</label>
                                            <input type="date" 
                                                   class="form-control @error('end_date') is-invalid @enderror" 
                                                   id="end_date" 
                                                   name="end_date" 
                                                   value="{{ old('end_date', $tournament->end_date ? $tournament->end_date->format('Y-m-d') : '') }}">
                                            @error('end_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="4" 
                                              placeholder="Tournament description and details...">{{ old('description', $tournament->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Tournament Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($tournament->logo)
                                            <div class="mb-3">
                                                <label class="form-label">Current Logo</label>
                                                <div class="text-center">
                                                    <img src="{{ Storage::url($tournament->logo) }}" 
                                                         alt="Tournament Logo" 
                                                         class="img-thumbnail" 
                                                         style="max-width: 100px; max-height: 100px;">
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <div class="form-group mb-3">
                                            <label for="logo" class="form-label">{{ $tournament->logo ? 'Change Logo' : 'Tournament Logo' }}</label>
                                            <input type="file" 
                                                   class="form-control @error('logo') is-invalid @enderror" 
                                                   id="logo" 
                                                   name="logo" 
                                                   accept="image/*">
                                            <small class="text-muted">Max size: 2MB. Formats: JPG, PNG, GIF</small>
                                            @error('logo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-check mb-3">
                                            <input type="checkbox" 
                                                   class="form-check-input" 
                                                   id="is_active" 
                                                   name="is_active" 
                                                   value="1" 
                                                   {{ old('is_active', $tournament->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                Active Tournament
                                            </label>
                                        </div>
                                        
                                        <div class="alert alert-info">
                                            <small>
                                                <i class="fas fa-info-circle me-1"></i>
                                                Active tournaments will be available for fixture creation and will appear in public listings.
                                            </small>
                                        </div>
                                        
                                        @if($tournament->fixtures_count > 0)
                                            <div class="alert alert-warning">
                                                <small>
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    This tournament has {{ $tournament->fixtures_count }} fixture(s). Changes may affect existing fixtures.
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.tournaments.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Back to Tournaments
                                    </a>
                                    <div>
                                        <a href="{{ route('admin.tournaments.show', $tournament) }}" class="btn btn-info me-2">
                                            <i class="fas fa-eye me-1"></i> View Tournament
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Update Tournament
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Validate end date is after start date
    document.getElementById('start_date').addEventListener('change', function() {
        const endDate = document.getElementById('end_date');
        if (this.value) {
            endDate.min = this.value;
        }
    });
    
    // Initialize end date validation on page load
    document.addEventListener('DOMContentLoaded', function() {
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        
        if (startDate.value) {
            endDate.min = startDate.value;
        }
    });
</script>
@endpush