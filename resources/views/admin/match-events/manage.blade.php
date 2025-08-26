@extends('layouts.admin')

@section('title', 'Live Events Manager - ' . $fixture->homeTeam->name . ' vs ' . $fixture->awayTeam->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Live Events Manager</h4>
                    <div>
                        <span class="badge bg-info">{{ $fixture->homeTeam->name ?? 'TBD' }} vs {{ $fixture->awayTeam->name ?? 'TBD' }}</span>
                        <span class="badge bg-secondary">{{ $fixture->match_date->format('M d, Y H:i') }}</span>
                        <span class="badge bg-{{ $fixture->status === 'live' ? 'success' : ($fixture->status === 'completed' ? 'primary' : 'warning') }}">
                            {{ ucfirst($fixture->status) }}
                        </span>
                        @if($fixture->status === 'live')
                            <span class="badge bg-danger blink">🔴 LIVE</span>
                        @endif
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

                    <!-- Live Event Form -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">🔴 Add Live Event</h6>
                                </div>
                                <div class="card-body">
                                    <form id="liveEventForm" action="{{ route('admin.fixtures.events.store', $fixture) }}" method="POST">
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
                                                <button type="submit" class="btn btn-success" id="addEventBtn">
                                                    <i class="fas fa-plus"></i> Add Event
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">⚡ Quick Actions</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-outline-success w-100" onclick="quickEvent('kick_off', 0, 'Match started')">
                                                <i class="fas fa-play"></i> Kick Off
                                            </button>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-outline-warning w-100" onclick="quickEvent('half_time', 45, 'First half ended')">
                                                <i class="fas fa-pause"></i> Half Time
                                            </button>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-outline-primary w-100" onclick="quickEvent('full_time', 90, 'Match ended')">
                                                <i class="fas fa-stop"></i> Full Time
                                            </button>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-outline-info w-100" onclick="refreshEvents()">
                                                <i class="fas fa-sync-alt"></i> Refresh Events
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Live Events Timeline -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">📋 Live Events Timeline</h6>
                                    <div>
                                        <span class="badge bg-secondary">{{ $events->count() }} Events</span>
                                        @if($fixture->status === 'live')
                                            <span class="badge bg-success" id="autoRefreshStatus">Auto-refresh ON</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body" id="eventsContainer">
                                    @if($events->count() > 0)
                                        <div class="timeline">
                                            @foreach($events as $event)
                                                <div class="timeline-item" data-event-id="{{ $event->id }}">
                                                    <div class="timeline-marker bg-{{ $event->team === 'home' ? 'info' : 'warning' }}">
                                                        {{ $event->event_icon }}
                                                    </div>
                                                    <div class="timeline-content">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <h6 class="mb-1">
                                                                    <span class="badge bg-primary me-2">{{ $event->minute }}'</span>
                                                                    {{ $event->event_display_name }}
                                                                    @if($event->is_live_update)
                                                                        <span class="badge bg-success ms-1">Live</span>
                                                                    @endif
                                                                </h6>
                                                                <p class="mb-1">
                                                                    <span class="badge bg-{{ $event->team === 'home' ? 'info' : 'warning' }}">
                                                                        {{ $event->team === 'home' ? ($fixture->homeTeam->name ?? 'Home') : ($fixture->awayTeam->name ?? 'Away') }}
                                                                    </span>
                                                                    @if($event->player)
                                                                        <span class="ms-2">{{ $event->player->name }}</span>
                                                                    @endif
                                                                </p>
                                                                @if($event->description)
                                                                    <p class="text-muted mb-0">{{ $event->description }}</p>
                                                                @endif
                                                            </div>
                                                            <div class="btn-group" role="group">
                                                                <button type="button" class="btn btn-sm btn-outline-warning" 
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#editEventModal{{ $event->id }}">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                                        onclick="deleteEvent('{{ $event->id }}')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

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

@push('styles')
<style>
.blink {
    animation: blink-animation 1s steps(5, start) infinite;
}

@keyframes blink-animation {
    to {
        visibility: hidden;
    }
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.timeline-content {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    margin-left: 15px;
}

.timeline-content:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
</style>
@endpush

@push('scripts')
<script>
let autoRefreshInterval;
const isLive = {{ $fixture->status === 'live' ? 'true' : 'false' }} === 'true';

// Auto-hide success alerts after 5 seconds
setTimeout(function() {
    if (typeof $ !== 'undefined') {
        $('.alert-success').fadeOut('slow');
    }
}, 5000);

// Quick event function
function quickEvent(eventType, minute, description) {
    document.getElementById('event_type').value = eventType;
    document.getElementById('minute').value = minute;
    document.getElementById('description').value = description;
    
    // Auto-submit for match control events
    if (['kick_off', 'half_time', 'full_time'].includes(eventType)) {
        document.getElementById('liveEventForm').submit();
    }
}

// Delete event function
function deleteEvent(eventId) {
    if (confirm('Are you sure you want to delete this event?')) {
        fetch('/admin/events/' + eventId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting event');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting event');
        });
    }
}

// Refresh events function
function refreshEvents() {
    location.reload();
}

// Auto-refresh for live matches
if (isLive) {
    autoRefreshInterval = setInterval(function() {
        refreshEvents();
    }, 30000); // Refresh every 30 seconds
}

// Form submission with loading state
document.getElementById('liveEventForm').addEventListener('submit', function() {
    const btn = document.getElementById('addEventBtn');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
    btn.disabled = true;
});
</script>
@endpush