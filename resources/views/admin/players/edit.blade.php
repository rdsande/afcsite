@extends('layouts.admin')

@section('title', 'Edit Player')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-edit"></i>
                        Edit Player: {{ $player->name }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.players.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Players
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h5><i class="icon fas fa-ban"></i> Please fix the following errors:</h5>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.players.update', $player) }}" 
                          method="POST" 
                          enctype="multipart/form-data" 
                          id="playerForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Basic Information</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="name" class="form-label">Full Name *</label>
                                                    <input type="text" 
                                                           class="form-control @error('name') is-invalid @enderror" 
                                                           id="name" 
                                                           name="name" 
                                                           value="{{ old('name', $player->name) }}" 
                                                           required>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="slug" class="form-label">URL Slug *</label>
                                                    <input type="text" 
                                                           class="form-control @error('slug') is-invalid @enderror" 
                                                           id="slug" 
                                                           name="slug" 
                                                           value="{{ old('slug', $player->slug) }}" 
                                                           required>
                                                    <small class="form-text text-muted">Auto-generated from name, but you can customize it</small>
                                                    @error('slug')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="jersey_number" class="form-label">Jersey Number</label>
                                                    <input type="number" 
                                                           class="form-control @error('jersey_number') is-invalid @enderror" 
                                                           id="jersey_number" 
                                                           name="jersey_number" 
                                                           value="{{ old('jersey_number', $player->jersey_number) }}" 
                                                           min="1" 
                                                           max="99">
                                                    @error('jersey_number')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="position" class="form-label">Position *</label>
                                                    <select class="form-control @error('position') is-invalid @enderror" 
                                                            id="position" 
                                                            name="position" 
                                                            required>
                                                        <option value="">Select Position</option>
                                                        <option value="Goalkeeper" {{ old('position', $player->position) == 'Goalkeeper' ? 'selected' : '' }}>Goalkeeper</option>
                                                        <option value="Defender" {{ old('position', $player->position) == 'Defender' ? 'selected' : '' }}>Defender</option>
                                                        <option value="Midfielder" {{ old('position', $player->position) == 'Midfielder' ? 'selected' : '' }}>Midfielder</option>
                                                        <option value="Forward" {{ old('position', $player->position) == 'Forward' ? 'selected' : '' }}>Forward</option>
                                                    </select>
                                                    @error('position')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="team" class="form-label">Team *</label>
                                                    <select class="form-control @error('team') is-invalid @enderror" 
                                                            id="team" 
                                                            name="team" 
                                                            required>
                                                        <option value="senior" {{ old('team', $player->team_category) == 'senior' ? 'selected' : '' }}>Senior Team</option>
                                                        <option value="u20" {{ old('team', $player->team_category) == 'u20' ? 'selected' : '' }}>Under 20 Academy</option>
                                                        <option value="u17" {{ old('team', $player->team_category) == 'u17' ? 'selected' : '' }}>Under 17 Academy</option>
                                                        <option value="u15" {{ old('team', $player->team_category) == 'u15' ? 'selected' : '' }}>Under 15 Academy</option>
                                                        <option value="u13" {{ old('team', $player->team_category) == 'u13' ? 'selected' : '' }}>Under 13 Academy</option>
                                                    </select>
                                                    @error('team')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                                                    <input type="date" 
                                                           class="form-control @error('date_of_birth') is-invalid @enderror" 
                                                           id="date_of_birth" 
                                                           name="date_of_birth" 
                                                           value="{{ old('date_of_birth', $player->date_of_birth ? $player->date_of_birth->format('Y-m-d') : '') }}">
                                                    @error('date_of_birth')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="nationality" class="form-label">Nationality</label>
                                                    <input type="text" 
                                                           class="form-control @error('nationality') is-invalid @enderror" 
                                                           id="nationality" 
                                                           name="nationality" 
                                                           value="{{ old('nationality', $player->nationality) }}">
                                                    @error('nationality')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="height" class="form-label">Height (m)</label>
                                                    <input type="number" 
                                                           class="form-control @error('height') is-invalid @enderror" 
                                                           id="height" 
                                                           name="height" 
                                                           value="{{ old('height', $player->height) }}"
                                                           step="0.01"
                                                           min="1.5"
                                                           max="2.5"
                                                           placeholder="e.g. 1.75">
                                                    @error('height')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                            <label for="biography" class="form-label">Biography</label>
                            <textarea class="form-control @error('biography') is-invalid @enderror" 
                                      id="biography" 
                                      name="biography" 
                                      rows="4" 
                                      placeholder="Brief biography about the player...">{{ old('biography', $player->biography) }}</textarea>
                            @error('biography')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                                    </div>
                                </div>
                            </div>

                            <!-- Photo and Status -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Photo & Status</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label for="photo" class="form-label">Player Photo</label>
                                            <input type="file" 
                                                   class="form-control @error('photo') is-invalid @enderror" 
                                                   id="photo" 
                                                   name="photo" 
                                                   accept="image/*">
                                            <small class="form-text text-muted">Recommended: 400x400px, max 2MB. Leave empty to keep current photo.</small>
                                            @error('photo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        @if($player->profile_image)
                                            <div class="mb-3">
                                                <label class="form-label">Current Photo</label>
                                                <div class="text-center">
                                                    <img src="{{ asset('storage/' . $player->profile_image) }}" 
                                                         alt="{{ $player->name }}" 
                                                         class="img-thumbnail" 
                                                         style="max-width: 200px; max-height: 200px;">
                                                </div>
                                                <div class="form-check mt-2">
                                                    <input type="checkbox" 
                                                           class="form-check-input" 
                                                           id="remove_photo" 
                                                           name="remove_photo" 
                                                           value="1">
                                                    <label class="form-check-label" for="remove_photo">
                                                        Remove current photo
                                                    </label>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group mb-3">
                                            <label for="status" class="form-label">Status *</label>
                                            <select class="form-control @error('status') is-invalid @enderror" 
                                                    id="status" 
                                                    name="status" 
                                                    required>
                                                <option value="active" {{ old('status', $player->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $player->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                <option value="injured" {{ old('status', $player->status) == 'injured' ? 'selected' : '' }}>Injured</option>
                                                <option value="suspended" {{ old('status', $player->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" 
                                                       class="form-check-input" 
                                                       id="is_featured" 
                                                       name="is_featured" 
                                                       value="1" 
                                                       {{ old('is_featured', $player->is_featured) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_featured">
                                                    Featured Player
                                                </label>
                                                <small class="form-text text-muted d-block">Show on homepage and highlights</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Player Statistics -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Player Statistics</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <!-- Goals Section -->
                                            <div class="col-md-4">
                                                <h5 class="mb-3">Goals</h5>
                                                <div class="form-group mb-3">
                                                    <label for="goals_inside_box" class="form-label">Goals Inside the Box</label>
                                                    <input type="number" 
                                                           class="form-control @error('goals_inside_box') is-invalid @enderror" 
                                                           id="goals_inside_box" 
                                                           name="goals_inside_box" 
                                                           value="{{ old('goals_inside_box', $player->goals_inside_box ?? 0) }}"
                                                           min="0">
                                                    @error('goals_inside_box')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="goals_outside_box" class="form-label">Goals Outside the Box</label>
                                                    <input type="number" 
                                                           class="form-control @error('goals_outside_box') is-invalid @enderror" 
                                                           id="goals_outside_box" 
                                                           name="goals_outside_box" 
                                                           value="{{ old('goals_outside_box', $player->goals_outside_box ?? 0) }}"
                                                           min="0">
                                                    @error('goals_outside_box')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Attacking Section -->
                                            <div class="col-md-4">
                                                <h5 class="mb-3">Attacking</h5>
                                                <div class="form-group mb-3">
                                                    <label for="passes_completed" class="form-label">Completed Passes</label>
                                                    <input type="number" 
                                                           class="form-control @error('passes_completed') is-invalid @enderror" 
                                                           id="passes_completed" 
                                                           name="passes_completed" 
                                                           value="{{ old('passes_completed', $player->passes_completed ?? 0) }}"
                                                           min="0">
                                                    @error('passes_completed')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="passes_lost" class="form-label">Lost Passes</label>
                                                    <input type="number" 
                                                           class="form-control @error('passes_lost') is-invalid @enderror" 
                                                           id="passes_lost" 
                                                           name="passes_lost" 
                                                           value="{{ old('passes_lost', $player->passes_lost ?? 0) }}"
                                                           min="0">
                                                    @error('passes_lost')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="assists" class="form-label">Assists</label>
                                                    <input type="number" 
                                                           class="form-control @error('assists') is-invalid @enderror" 
                                                           id="assists" 
                                                           name="assists" 
                                                           value="{{ old('assists', $player->assists ?? 0) }}"
                                                           min="0">
                                                    @error('assists')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Defending Section -->
                                            <div class="col-md-4">
                                                <h5 class="mb-3">Defending</h5>
                                                <div class="form-group mb-3">
                                                    <label for="tackles_won" class="form-label">Tackles Won</label>
                                                    <input type="number" 
                                                           class="form-control @error('tackles_won') is-invalid @enderror" 
                                                           id="tackles_won" 
                                                           name="tackles_won" 
                                                           value="{{ old('tackles_won', $player->tackles_won ?? 0) }}"
                                                           min="0">
                                                    @error('tackles_won')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="tackles_lost" class="form-label">Tackles Lost</label>
                                                    <input type="number" 
                                                           class="form-control @error('tackles_lost') is-invalid @enderror" 
                                                           id="tackles_lost" 
                                                           name="tackles_lost" 
                                                           value="{{ old('tackles_lost', $player->tackles_lost ?? 0) }}"
                                                           min="0">
                                                    @error('tackles_lost')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="interceptions" class="form-label">Interceptions</label>
                                                    <input type="number" 
                                                           class="form-control @error('interceptions') is-invalid @enderror" 
                                                           id="interceptions" 
                                                           name="interceptions" 
                                                           value="{{ old('interceptions', $player->interceptions ?? 0) }}"
                                                           min="0">
                                                    @error('interceptions')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="clearances" class="form-label">Clearances</label>
                                                    <input type="number" 
                                                           class="form-control @error('clearances') is-invalid @enderror" 
                                                           id="clearances" 
                                                           name="clearances" 
                                                           value="{{ old('clearances', $player->clearances ?? 0) }}"
                                                           min="0">
                                                    @error('clearances')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="blocks" class="form-label">Blocks</label>
                                                    <input type="number" 
                                                           class="form-control @error('blocks') is-invalid @enderror" 
                                                           id="blocks" 
                                                           name="blocks" 
                                                           value="{{ old('blocks', $player->blocks ?? 0) }}"
                                                           min="0">
                                                    @error('blocks')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Video Reel Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Video Reel</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label for="video_reel_link" class="form-label">YouTube Video ID</label>
                                            <input type="text" 
                                                   class="form-control @error('video_reel_link') is-invalid @enderror" 
                                                   id="video_reel_link" 
                                                   name="video_reel_link" 
                                                   value="{{ old('video_reel_link', $player->video_reel_link) }}"
                                                   placeholder="dQw4w9WgXcQ">
                                            <small class="form-text text-muted">Enter only the YouTube video ID (e.g., from https://www.youtube.com/watch?v=dQw4w9WgXcQ, enter: dQw4w9WgXcQ)</small>
                                            @error('video_reel_link')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.players.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Player
                                    </button>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-generate slug from name
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        
        nameInput.addEventListener('input', function() {
            if (!slugInput.dataset.manual) {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim('-');
                slugInput.value = slug;
            }
        });
        
        // Mark slug as manually edited if user types in it
        slugInput.addEventListener('input', function() {
            this.dataset.manual = 'true';
        });
        
        // Photo preview
        const photoInput = document.getElementById('photo');
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Remove existing preview if any
                    const existingPreview = document.getElementById('photo-preview');
                    if (existingPreview) {
                        existingPreview.remove();
                    }
                    
                    // Create new preview
                    const preview = document.createElement('div');
                    preview.id = 'photo-preview';
                    preview.className = 'mt-2 text-center';
                    preview.innerHTML = `
                        <label class="form-label">New Photo Preview</label>
                        <div>
                            <img src="${e.target.result}" 
                                 alt="Preview" 
                                 class="img-thumbnail" 
                                 style="max-width: 200px; max-height: 200px;">
                        </div>
                    `;
                    photoInput.parentNode.appendChild(preview);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush