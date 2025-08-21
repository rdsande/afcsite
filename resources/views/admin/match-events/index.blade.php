@extends('layouts.admin')

@section('title', 'Match Events - ' . $fixture->homeTeam->name . ' vs ' . $fixture->awayTeam->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Match Events</h4>
                    <div>
                        <span class="badge bg-info">{{ $fixture->homeTeam->name ?? 'TBD' }} vs {{ $fixture->awayTeam->name ?? 'TBD' }}</span>
                        <span class="badge bg-secondary">{{ $fixture->match_date->format('M d, Y H:i') }}</span>
                        <span class="badge bg-{{ $fixture->status === 'live' ? 'success' : ($fixture->status === 'completed' ? 'primary' : 'warning') }}">
                            {{ ucfirst($fixture->status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Add Event Form -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Add New Event</h6>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.fixtures.events.store', $fixture) }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label for="event_type" class="form-label">Event Type</label>
                                                <select class="form-select @error('event_type') is-invalid @enderror" id="event_type" name="event_type" required>
                                                    <option value="">Select Event</option>
                                                    <option value="goal" {{ old('event_type') === 'goal' ? 'selected' : '' }}>Goal ⚽</option>
                                                    <option value="yellow_card" {{ old('event_type') === 'yellow_card' ? 'selected' : '' }}>Yellow Card 🟨</option>
                                                    <option value="red_card" {{ old('event_type') === 'red_card' ? 'selected' : '' }}>Red Card 🟥</option>
                                                    <option value="substitution" {{ old('event_type') === 'substitution' ? 'selected' : '' }}>Substitution 🔄</option>
                                                    <option value="live_update" {{ old('event_type') === 'live_update' ? 'selected' : '' }}>Live Update 📝</option>
                                                    <option value="kick_off" {{ old('event_type') === 'kick_off' ? 'selected' : '' }}>Kick Off</option>
                                                    <option value="half_time" {{ old('event_type') === 'half_time' ? 'selected' : '' }}>Half Time</option>
                                                    <option value="full_time" {{ old('event_type') === 'full_time' ? 'selected' : '' }}>Full Time</option>
                                                </select>
                                                @error('event_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-1">
                                                <label for="minute" class="form-label">Minute</label>
                                                <input type="number" class="form-control @error('minute') is-invalid @enderror" id="minute" name="minute" min="0" max="120" value="{{ old('minute') }}" required>
                                                @error('minute')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <label for="team" class="form-label">Team</label>
                                                <select class="form-select @error('team') is-invalid @enderror" id="team" name="team" required>
                                                    <option value="">Select Team</option>
                                                    <option value="home" {{ old('team') === 'home' ? 'selected' : '' }}>{{ $fixture->homeTeam->name ?? 'Home Team' }}</option>
                                                    <option value="away" {{ old('team') === 'away' ? 'selected' : '' }}>{{ $fixture->awayTeam->name ?? 'Away Team' }}</option>
                                                </select>
                                                @error('team')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <label for="player_id" class="form-label">Player</label>
                                                <select class="form-select @error('player_id') is-invalid @enderror" id="player_id" name="player_id">
                                                    <option value="">Select Player</option>
                                                    @foreach($players as $player)
                                                        <option value="{{ $player->id }}" {{ old('player_id') == $player->id ? 'selected' : '' }}>
                                                            {{ $player->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('player_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <label for="description" class="form-label">Description</label>
                                                <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ old('description') }}" placeholder="Event description">
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="submit" class="btn btn-primary">Add Event</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Events List -->
                    <div class="row">
                        <div class="col-md-12">
                            @if($events->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Time</th>
                                                <th>Event</th>
                                                <th>Team</th>
                                                <th>Player</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($events as $event)
                                                <tr>
                                                    <td>
                                                        <span class="badge bg-primary">{{ $event->minute }}'</span>
                                                    </td>
                                                    <td>
                                                        <span class="me-2">{{ $event->event_icon }}</span>
                                                        {{ $event->event_display_name }}
                                                        @if($event->is_live_update)
                                                            <span class="badge bg-success ms-1">Live</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{ $event->team === 'home' ? 'info' : 'warning' }}">
                                                            {{ $event->team === 'home' ? ($fixture->homeTeam->name ?? 'Home') : ($fixture->awayTeam->name ?? 'Away') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ $event->player->name ?? '-' }}
                                                    </td>
                                                    <td>
                                                        {{ $event->description ?? '-' }}
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-sm btn-outline-warning" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#editEventModal{{ $event->id }}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline" 
                                                                  onsubmit="return confirm('Are you sure you want to delete this event?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Edit Event Modal -->
                                                <div class="modal fade" id="editEventModal{{ $event->id }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Event</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <form action="{{ route('admin.events.update', $event) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label for="edit_event_type_{{ $event->id }}" class="form-label">Event Type</label>
                                                                            <select class="form-select" id="edit_event_type_{{ $event->id }}" name="event_type" required>
                                                                                <option value="goal" {{ $event->event_type === 'goal' ? 'selected' : '' }}>Goal ⚽</option>
                                                                                <option value="yellow_card" {{ $event->event_type === 'yellow_card' ? 'selected' : '' }}>Yellow Card 🟨</option>
                                                                                <option value="red_card" {{ $event->event_type === 'red_card' ? 'selected' : '' }}>Red Card 🟥</option>
                                                                                <option value="substitution" {{ $event->event_type === 'substitution' ? 'selected' : '' }}>Substitution 🔄</option>
                                                                                <option value="live_update" {{ $event->event_type === 'live_update' ? 'selected' : '' }}>Live Update 📝</option>
                                                                                <option value="kick_off" {{ $event->event_type === 'kick_off' ? 'selected' : '' }}>Kick Off</option>
                                                                                <option value="half_time" {{ $event->event_type === 'half_time' ? 'selected' : '' }}>Half Time</option>
                                                                                <option value="full_time" {{ $event->event_type === 'full_time' ? 'selected' : '' }}>Full Time</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="edit_minute_{{ $event->id }}" class="form-label">Minute</label>
                                                                            <input type="number" class="form-control" id="edit_minute_{{ $event->id }}" name="minute" min="0" max="120" value="{{ $event->minute }}" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mt-3">
                                                                        <div class="col-md-6">
                                                                            <label for="edit_team_{{ $event->id }}" class="form-label">Team</label>
                                                                            <select class="form-select" id="edit_team_{{ $event->id }}" name="team" required>
                                                                                <option value="home" {{ $event->team === 'home' ? 'selected' : '' }}>{{ $fixture->homeTeam->name ?? 'Home Team' }}</option>
                                                                                <option value="away" {{ $event->team === 'away' ? 'selected' : '' }}>{{ $fixture->awayTeam->name ?? 'Away Team' }}</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="edit_player_id_{{ $event->id }}" class="form-label">Player</label>
                                                                            <select class="form-select" id="edit_player_id_{{ $event->id }}" name="player_id">
                                                                                <option value="">Select Player</option>
                                                                                @foreach($players as $player)
                                                                                    <option value="{{ $player->id }}" {{ $event->player_id == $player->id ? 'selected' : '' }}>
                                                                                        {{ $player->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mt-3">
                                                                        <div class="col-md-12">
                                                                            <label for="edit_description_{{ $event->id }}" class="form-label">Description</label>
                                                                            <input type="text" class="form-control" id="edit_description_{{ $event->id }}" name="description" value="{{ $event->description }}" placeholder="Event description">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-primary">Update Event</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Events Recorded</h5>
                                    <p class="text-muted">No match events have been recorded for this fixture yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <a href="{{ route('admin.fixtures.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Fixtures
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-hide success alerts after 5 seconds
    setTimeout(function() {
        $('.alert-success').fadeOut('slow');
    }, 5000);
</script>
@endpush