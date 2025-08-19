@extends('layouts.admin')

@section('title', 'Edit Team')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Team: {{ $team->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.teams.index') }}">Teams</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Team Information</h3>
                    </div>
                    <form action="{{ route('admin.teams.update', $team) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Team Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $team->name) }}" required>
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="short_name">Short Name</label>
                                        <input type="text" class="form-control @error('short_name') is-invalid @enderror" id="short_name" name="short_name" value="{{ old('short_name', $team->short_name) }}" maxlength="10">
                                        @error('short_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="logo">Team Logo</label>
                                        @if($team->logo)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }} Logo" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                                <p class="text-muted small mt-1">Current logo</p>
                                            </div>
                                        @endif
                                        <input type="file" class="form-control-file @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*">
                                        <small class="form-text text-muted">Leave empty to keep current logo. Accepted formats: JPEG, PNG, JPG, GIF, SVG. Max size: 2MB</small>
                                        @error('logo')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="home_stadium">Home Stadium</label>
                                        <input type="text" class="form-control @error('home_stadium') is-invalid @enderror" id="home_stadium" name="home_stadium" value="{{ old('home_stadium', $team->home_stadium) }}">
                                        @error('home_stadium')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="founded_year">Founded Year</label>
                                        <input type="number" class="form-control @error('founded_year') is-invalid @enderror" id="founded_year" name="founded_year" value="{{ old('founded_year', $team->founded_year) }}" min="1800" max="{{ date('Y') }}">
                                        @error('founded_year')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="website">Website</label>
                                        <input type="url" class="form-control @error('website') is-invalid @enderror" id="website" name="website" value="{{ old('website', $team->website) }}">
                                        @error('website')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="primary_color">Primary Color</label>
                                        <input type="color" class="form-control @error('primary_color') is-invalid @enderror" id="primary_color" name="primary_color" value="{{ old('primary_color', $team->primary_color ?? '#000000') }}">
                                        @error('primary_color')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="secondary_color">Secondary Color</label>
                                        <input type="color" class="form-control @error('secondary_color') is-invalid @enderror" id="secondary_color" name="secondary_color" value="{{ old('secondary_color', $team->secondary_color ?? '#ffffff') }}">
                                        @error('secondary_color')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $team->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $team->is_active) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Active Team</label>
                                </div>
                                <small class="form-text text-muted">Inactive teams are considered relegated or disbanded</small>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Team
                            </button>
                            <a href="{{ route('admin.teams.show', $team) }}" class="btn btn-info">
                                <i class="fas fa-eye"></i> View Team
                            </a>
                            <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection