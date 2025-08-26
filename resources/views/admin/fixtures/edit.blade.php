@extends('layouts.admin')

@section('title', 'Edit Fixture')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-edit"></i>
                        Edit Fixture: {{ $fixture->homeTeam->name ?? 'Unknown' }} vs {{ $fixture->awayTeam->name ?? 'Unknown' }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.fixtures.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Fixtures
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

                    <form action="{{ route('admin.fixtures.update', $fixture) }}" 
                          method="POST" 
                          id="fixtureForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Match Details -->
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Match Details</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="home_team_id" class="form-label">Home Team *</label>
                                                    <select class="form-control @error('home_team_id') is-invalid @enderror" 
                                                            id="home_team_id" 
                                                            name="home_team_id" 
                                                            required>
                                                        <option value="">Select Home Team</option>
                                                        @foreach($teams as $team)
                                                            <option value="{{ $team->id }}" {{ old('home_team_id', $fixture->home_team_id) == $team->id ? 'selected' : '' }}>
                                                                {{ $team->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('home_team_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="away_team_id" class="form-label">Away Team *</label>
                                                    <select class="form-control @error('away_team_id') is-invalid @enderror" 
                                                            id="away_team_id" 
                                                            name="away_team_id" 
                                                            required>
                                                        <option value="">Select Away Team</option>
                                                        @foreach($teams as $team)
                                                            <option value="{{ $team->id }}" {{ old('away_team_id', $fixture->away_team_id) == $team->id ? 'selected' : '' }}>
                                                                {{ $team->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('away_team_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="match_date" class="form-label">Match Date *</label>
                                                    <input type="date" 
                                                           class="form-control @error('match_date') is-invalid @enderror" 
                                                           id="match_date" 
                                                           name="match_date" 
                                                           value="{{ old('match_date', $fixture->match_date->format('Y-m-d')) }}" 
                                                           required>
                                                    @error('match_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="match_time" class="form-label">Match Time *</label>
                                                    <input type="time" 
                                                           class="form-control @error('match_time') is-invalid @enderror" 
                                                           id="match_time" 
                                                           name="match_time" 
                                                           value="{{ old('match_time', $fixture->match_date->format('H:i')) }}" 
                                                           required>
                                                    @error('match_time')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="tournament_id" class="form-label">Tournament</label>
                                                    <select class="form-control @error('tournament_id') is-invalid @enderror" 
                                                            id="tournament_id" 
                                                            name="tournament_id">
                                                        <option value="">Select Tournament</option>
                                                        @foreach($tournaments as $tournament)
                                                            <option value="{{ $tournament->id }}" {{ old('tournament_id', $fixture->tournament_id) == $tournament->id ? 'selected' : '' }}>
                                                                {{ $tournament->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('tournament_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="stadium" class="form-label">Stadium</label>
                                                    <input type="text" 
                                                           class="form-control @error('stadium') is-invalid @enderror" 
                                                           id="stadium" 
                                                           name="stadium" 
                                                           value="{{ old('stadium', $fixture->stadium) }}" 
                                                           placeholder="Stadium name">
                                                    @error('stadium')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="team_category" class="form-label">Team Category</label>
                                                    <select class="form-control @error('team_category') is-invalid @enderror" 
                                                            id="team_category" 
                                                            name="team_category">
                                                        <option value="">Select Category</option>
                                                        <option value="senior" {{ old('team_category', $fixture->team_category) == 'senior' ? 'selected' : '' }}>Senior</option>
                                                        <option value="U20" {{ old('team_category', $fixture->team_category) == 'U20' ? 'selected' : '' }}>U20</option>
                                                        <option value="U17" {{ old('team_category', $fixture->team_category) == 'U17' ? 'selected' : '' }}>U17</option>
                                                        <option value="U15" {{ old('team_category', $fixture->team_category) == 'U15' ? 'selected' : '' }}>U15</option>
                                                        <option value="U13" {{ old('team_category', $fixture->team_category) == 'U13' ? 'selected' : '' }}>U13</option>
                                                    </select>
                                                    @error('team_category')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="match_type" class="form-label">Match Type</label>
                                                    <select class="form-control @error('match_type') is-invalid @enderror" 
                                                            id="match_type" 
                                                            name="match_type">
                                                        <option value="">Select Type</option>
                                                        <option value="league" {{ old('match_type', $fixture->match_type) == 'league' ? 'selected' : '' }}>League</option>
                                                        <option value="cup" {{ old('match_type', $fixture->match_type) == 'cup' ? 'selected' : '' }}>Cup</option>
                                                        <option value="friendly" {{ old('match_type', $fixture->match_type) == 'friendly' ? 'selected' : '' }}>Friendly</option>
                                                        <option value="tournament" {{ old('match_type', $fixture->match_type) == 'tournament' ? 'selected' : '' }}>Tournament</option>
                                                    </select>
                                                    @error('match_type')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="competition_type" class="form-label">Competition Type</label>
                                                    <select class="form-control @error('competition_type') is-invalid @enderror" 
                                                            id="competition_type" 
                                                            name="competition_type">
                                                        <option value="">Select Competition</option>
                                                        <option value="domestic" {{ old('competition_type', $fixture->competition_type) == 'domestic' ? 'selected' : '' }}>Domestic</option>
                                                        <option value="continental" {{ old('competition_type', $fixture->competition_type) == 'continental' ? 'selected' : '' }}>Continental</option>
                                                        <option value="international" {{ old('competition_type', $fixture->competition_type) == 'international' ? 'selected' : '' }}>International</option>
                                                    </select>
                                                    @error('competition_type')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="match_preview" class="form-label">Match Preview</label>
                                                    <textarea class="form-control @error('match_preview') is-invalid @enderror" 
                                                              id="match_preview" 
                                                              name="match_preview" 
                                                              rows="3" 
                                                              placeholder="Match preview and analysis">{{ old('match_preview', $fixture->match_preview) }}</textarea>
                                                    @error('match_preview')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="match_report" class="form-label">Match Report</label>
                                                    <textarea class="form-control @error('match_report') is-invalid @enderror" 
                                                              id="match_report" 
                                                              name="match_report" 
                                                              rows="3" 
                                                              placeholder="Post-match report and summary">{{ old('match_report', $fixture->match_report) }}</textarea>
                                                    @error('match_report')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="broadcast_link" class="form-label">Broadcast Link</label>
                                                    <input type="url" 
                                                           class="form-control @error('broadcast_link') is-invalid @enderror" 
                                                           id="broadcast_link" 
                                                           name="broadcast_link" 
                                                           value="{{ old('broadcast_link', $fixture->broadcast_link) }}" 
                                                           placeholder="https://example.com/live-stream">
                                                    @error('broadcast_link')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="attendance" class="form-label">Attendance</label>
                                                    <input type="number" 
                                                           class="form-control @error('attendance') is-invalid @enderror" 
                                                           id="attendance" 
                                                           name="attendance" 
                                                           value="{{ old('attendance', $fixture->attendance) }}" 
                                                           placeholder="Number of attendees" 
                                                           min="0">
                                                    @error('attendance')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-3">
                                                    <label for="referee" class="form-label">Referee</label>
                                                    <input type="text" 
                                                           class="form-control @error('referee') is-invalid @enderror" 
                                                           id="referee" 
                                                           name="referee" 
                                                           value="{{ old('referee', $fixture->referee) }}" 
                                                           placeholder="Referee name">
                                                    @error('referee')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group mb-3">
                                            <label for="description" class="form-label">Additional Notes</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                      id="description" 
                                                      name="description" 
                                                      rows="2" 
                                                      placeholder="Additional match notes or description">{{ old('description', $fixture->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Match Result -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Match Status & Result</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Match Result</label>
                                            <div class="row">
                                                <div class="col-5">
                                                    <label for="home_score" class="form-label small">{{ $fixture->homeTeam->name ?? 'Home' }}</label>
                                                    <input type="number" 
                                                           class="form-control text-center @error('home_score') is-invalid @enderror" 
                                                           id="home_score" 
                                                           name="home_score" 
                                                           value="{{ old('home_score', $fixture->home_score) }}" 
                                                           min="0">
                                                    @error('home_score')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-2 text-center d-flex align-items-end justify-content-center">
                                                    <span class="fw-bold">-</span>
                                                </div>
                                                <div class="col-5">
                                                    <label for="away_score" class="form-label small">{{ $fixture->awayTeam->name ?? 'Away' }}</label>
                                                    <input type="number" 
                                                           class="form-control text-center @error('away_score') is-invalid @enderror" 
                                                           id="away_score" 
                                                           name="away_score" 
                                                           value="{{ old('away_score', $fixture->away_score) }}" 
                                                           min="0">
                                                    @error('away_score')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">Leave empty if match hasn't been played yet</small>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-control @error('status') is-invalid @enderror" 
                                                    id="status" 
                                                    name="status">
                                                <option value="scheduled" {{ old('status', $fixture->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                                <option value="live" {{ old('status', $fixture->status) == 'live' ? 'selected' : '' }}>Live</option>
                                                <option value="completed" {{ old('status', $fixture->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="postponed" {{ old('status', $fixture->status) == 'postponed' ? 'selected' : '' }}>Postponed</option>
                                                <option value="cancelled" {{ old('status', $fixture->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
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
                                                       {{ old('is_featured', $fixture->is_featured) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_featured">
                                                    Featured Match
                                                </label>
                                                <small class="form-text text-muted d-block">Show prominently on homepage</small>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="notes" class="form-label">Match Notes</label>
                                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                      id="notes" 
                                                      name="notes" 
                                                      rows="3" 
                                                      placeholder="Post-match notes, highlights, etc...">{{ old('notes', $fixture->notes) }}</textarea>
                                            @error('notes')
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
                                    <a href="{{ route('admin.fixtures.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Fixture
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
        // Update away team label in result section when away team changes
        const awayTeamInput = document.getElementById('away_team');
        const awayScoreLabel = document.querySelector('label[for="away_score"]');
        
        if (awayTeamInput && awayScoreLabel) {
            awayTeamInput.addEventListener('input', function() {
                awayScoreLabel.textContent = this.value || 'Away';
            });
        }
        
        // Update home team label in result section when home team changes
        const homeTeamInput = document.getElementById('home_team');
        const homeScoreLabel = document.querySelector('label[for="home_score"]');
        
        if (homeTeamInput && homeScoreLabel) {
            homeTeamInput.addEventListener('input', function() {
                homeScoreLabel.textContent = this.value || 'Home';
            });
        }
        
        // Auto-set status to completed when both scores are entered
        const homeScoreInput = document.getElementById('home_score');
        const awayScoreInput = document.getElementById('away_score');
        const statusSelect = document.getElementById('status');
        
        if (homeScoreInput && awayScoreInput && statusSelect) {
            function checkScores() {
                if (homeScoreInput.value !== '' && awayScoreInput.value !== '') {
                    if (statusSelect.value === 'scheduled') {
                        statusSelect.value = 'completed';
                    }
                }
            }
            
            homeScoreInput.addEventListener('input', checkScores);
            awayScoreInput.addEventListener('input', checkScores);
        }
    });
</script>
@endpush