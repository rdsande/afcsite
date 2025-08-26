@extends('layouts.admin')

@section('title', 'Manage Fixtures')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Fixtures & Results</h3>
                    <div>
                        <a href="{{ route('admin.fixtures.create') }}" class="btn btn-primary me-2">
                            <i class="fas fa-plus"></i> Add New Fixture
                        </a>
                        <a href="{{ route('admin.tournaments.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-trophy"></i> Manage Tournaments
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select class="form-select" id="tournamentFilter">
                                <option value="">All Tournaments</option>
                                @foreach($tournaments as $tournament)
                                    <option value="{{ $tournament->id }}">{{ $tournament->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="categoryFilter">
                                <option value="">All Categories</option>
                                <option value="senior">Senior</option>
                                <option value="u20">U20</option>
                                <option value="u17">U17</option>
                                <option value="u15">U15</option>
                                <option value="u13">U13</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="scheduled">Scheduled</option>
                                <option value="live">Live</option>
                                <option value="completed">Completed</option>
                                <option value="postponed">Postponed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-primary" id="refreshBtn">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Filter Tabs -->
                    <ul class="nav nav-tabs mb-3" id="fixtureTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
                                All Fixtures ({{ $fixtures->total() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" type="button" role="tab">
                                Upcoming
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab">
                                Completed
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="fixtureTabContent">
                        <div class="tab-pane fade show active" id="all" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date & Time</th>
                                            <th>Match</th>
                                            <th>Tournament</th>
                                            <th>Category</th>
                                            <th>Venue</th>
                                            <th>Status</th>
                                            <th>Result</th>
                                            <th>Events</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($fixtures as $fixture)
                                            <tr class="{{ $fixture->match_date->isPast() ? 'table-light' : '' }}" 
                                                data-tournament="{{ $fixture->tournament_id }}" 
                                                data-category="{{ $fixture->team_category }}" 
                                                data-status="{{ $fixture->status }}">
                                                <td>
                                                    <div>
                                                        <strong>{{ $fixture->match_date->format('M d, Y') }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $fixture->match_date->format('H:i') }}</small>
                                                        @if($fixture->is_featured)
                                                            <br><span class="badge badge-sm bg-warning">Featured</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="text-center">
                                                            <div class="fw-bold">{{ $fixture->homeTeam->name ?? 'Unknown Team' }}</div>
                                                            <small class="text-muted">vs</small>
                                                            <div class="fw-bold">{{ $fixture->awayTeam->name ?? 'Unknown Team' }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($fixture->tournament)
                                                        <span class="badge bg-info">{{ $fixture->tournament->name }}</span>
                                                        <br><small class="text-muted">{{ $fixture->competition_type }}</small>
                                                    @else
                                                        <span class="badge bg-secondary">No Tournament</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $fixture->team_category === 'senior' ? 'primary' : 'secondary' }}">
                                                        {{ strtoupper($fixture->team_category) }}
                                                    </span>
                                                    <br><small class="text-muted">{{ ucfirst($fixture->match_type) }}</small>
                                                </td>
                                                <td>
                                                    <div>
                                                        <i class="fas fa-map-marker-alt text-muted"></i>
                                                        {{ $fixture->stadium ?? 'TBA' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    @switch($fixture->status)
                                                        @case('scheduled')
                                                            <span class="badge bg-primary">Scheduled</span>
                                                            @break
                                                        @case('live')
                                                            <span class="badge bg-danger blink">LIVE</span>
                                                            @break
                                                        @case('completed')
                                                            <span class="badge bg-success">Completed</span>
                                                            @break
                                                        @case('postponed')
                                                            <span class="badge bg-warning">Postponed</span>
                                                            @break
                                                        @case('cancelled')
                                                            <span class="badge bg-dark">Cancelled</span>
                                                            @break
                                                        @default
                                                            <span class="badge bg-secondary">{{ ucfirst($fixture->status) }}</span>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    @if($fixture->home_score !== null && $fixture->away_score !== null)
                                                        <div class="text-center">
                                                            <span class="badge bg-dark fs-6">
                                                                {{ $fixture->home_score }} - {{ $fixture->away_score }}
                                                            </span>
                                                            @if($fixture->attendance)
                                                                <br><small class="text-muted">{{ number_format($fixture->attendance) }} fans</small>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @php
                                                            $goals = $fixture->matchEvents()->where('event_type', 'goal')->count();
                                                            $cards = $fixture->matchEvents()->whereIn('event_type', ['yellow_card', 'red_card'])->count();
                                                            $liveUpdates = $fixture->matchEvents()->where('event_type', 'live_update')->count();
                                                        @endphp
                                                        @if($goals > 0)
                                                            <span class="badge bg-success" title="Goals">⚽ {{ $goals }}</span>
                                                        @endif
                                                        @if($cards > 0)
                                                            <span class="badge bg-warning" title="Cards">🟨 {{ $cards }}</span>
                                                        @endif
                                                        @if($liveUpdates > 0)
                                                            <span class="badge bg-info" title="Live Updates">📝 {{ $liveUpdates }}</span>
                                                        @endif
                                                        @if($goals === 0 && $cards === 0 && $liveUpdates === 0)
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('fixture.show', $fixture->id) }}" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           target="_blank" 
                                                           title="View Fixture">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.fixtures.edit', $fixture) }}" 
                                                           class="btn btn-sm btn-outline-warning" 
                                                           title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @if($fixture->status === 'live')
                                             <a href="{{ route('admin.fixtures.events.manage', $fixture->id) }}" 
                                                class="btn btn-sm btn-success" 
                                                title="Manage Live Events">
                                                 <i class="fas fa-broadcast-tower"></i>
                                             </a>
                                         @endif
                                                        @if($fixture->status !== 'completed')
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-outline-success" 
                                                                    title="Update Result" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#resultModal" 
                                                                    data-fixture-id="{{ $fixture->id }}" 
                                                                    data-home-team="{{ $fixture->homeTeam->name ?? 'TBD' }}"
                                        data-away-team="{{ $fixture->awayTeam->name ?? 'TBD' }}" 
                                                                    data-home-score="{{ $fixture->home_score }}" 
                                                                    data-away-score="{{ $fixture->away_score }}">
                                                                <i class="fas fa-trophy"></i>
                                                            </button>
                                                        @endif
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle" data-bs-toggle="dropdown" title="Status">
                                                                <i class="fas fa-cog"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                @foreach(['scheduled', 'live', 'completed', 'postponed', 'cancelled'] as $status)
                                                                    @if($fixture->status !== $status)
                                                                        <li>
                                                                            <form action="{{ route('admin.fixtures.updateStatus', $fixture) }}" method="POST" class="d-inline">
                                                                                @csrf
                                                                                @method('PATCH')
                                                                                <input type="hidden" name="status" value="{{ $status }}">
                                                                                <button type="submit" class="dropdown-item">
                                                                                    Mark as {{ ucfirst($status) }}
                                                                                </button>
                                                                            </form>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <form action="{{ route('admin.fixtures.destroy', $fixture) }}" 
                                                              method="POST" 
                                                              class="d-inline" 
                                                              onsubmit="return confirm('Are you sure you want to delete this fixture?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-danger" 
                                                                    title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-calendar-alt fa-3x mb-3"></i>
                                                        <p>No fixtures found.</p>
                                                        <a href="{{ route('admin.fixtures.create') }}" class="btn btn-primary">
                                                            Add your first fixture
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if($fixtures->hasPages())
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $fixtures->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Result Modal -->
<div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultModalLabel">Add Match Result</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="resultForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 text-center">
                            <h6 id="homeTeamName"></h6>
                            <input type="number" class="form-control text-center" id="homeScore" name="home_score" min="0" required>
                        </div>
                        <div class="col-md-2 text-center d-flex align-items-center justify-content-center">
                            <span class="fw-bold">VS</span>
                        </div>
                        <div class="col-md-5 text-center">
                            <h6 id="awayTeamName"></h6>
                            <input type="number" class="form-control text-center" id="awayScore" name="away_score" min="0" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="matchNotes" class="form-label">Match Notes (Optional)</label>
                        <textarea class="form-control" id="matchNotes" name="notes" rows="3" placeholder="Any additional notes about the match..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Result</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Live Events Modal -->
<div class="modal fade" id="liveEventsModal" tabindex="-1" aria-labelledby="liveEventsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="liveEventsModalLabel">Manage Live Events</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h6 id="liveMatchTitle"></h6>
                    </div>
                </div>
                
                <!-- Add Event Form -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="mb-0">Add New Event</h6>
                    </div>
                    <div class="card-body">
                        <form id="addEventForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="event_type" class="form-label">Event Type</label>
                                    <select class="form-select" id="event_type" name="event_type" required>
                                        <option value="">Select Event</option>
                                        <option value="goal">Goal ⚽</option>
                                        <option value="yellow_card">Yellow Card 🟨</option>
                                        <option value="red_card">Red Card 🟥</option>
                                        <option value="substitution">Substitution 🔄</option>
                                        <option value="live_update">Live Update 📝</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="minute" class="form-label">Minute</label>
                                    <input type="number" class="form-control" id="minute" name="minute" min="1" max="120" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="player_name" class="form-label">Player</label>
                                    <input type="text" class="form-control" id="player_name" name="player_name" placeholder="Player name">
                                </div>
                                <div class="col-md-4">
                                    <label for="description" class="form-label">Description</label>
                                    <input type="text" class="form-control" id="description" name="description" placeholder="Event description">
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary btn-sm">Add Event</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Events List -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Match Events</h6>
                    </div>
                    <div class="card-body">
                        <div id="eventsList">
                            <div class="text-center text-muted">
                                <i class="fas fa-spinner fa-spin"></i> Loading events...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

    // Filter functionality
    function applyFilters() {
        const tournamentFilter = document.getElementById('tournamentFilter').value;
        const categoryFilter = document.getElementById('categoryFilter').value;
        const statusFilter = document.getElementById('statusFilter').value;
        const searchTerm = document.getElementById('searchInput') ? document.getElementById('searchInput').value.toLowerCase() : '';
        
        const rows = document.querySelectorAll('tbody tr[data-tournament]');
        
        rows.forEach(row => {
            let showRow = true;
            
            // Tournament filter
            if (tournamentFilter && row.getAttribute('data-tournament') !== tournamentFilter) {
                showRow = false;
            }
            
            // Category filter
            if (categoryFilter && row.getAttribute('data-category') !== categoryFilter) {
                showRow = false;
            }
            
            // Status filter
            if (statusFilter && row.getAttribute('data-status') !== statusFilter) {
                showRow = false;
            }
            
            // Search filter
            if (searchTerm) {
                const rowText = row.textContent.toLowerCase();
                if (!rowText.includes(searchTerm)) {
                    showRow = false;
                }
            }
            
            row.style.display = showRow ? '' : 'none';
        });
        
        // Update results count
        const visibleRows = document.querySelectorAll('tbody tr[data-tournament]:not([style*="display: none"])');
        const totalRows = document.querySelectorAll('tbody tr[data-tournament]');
        
        // Show/hide no results message
        const noResultsRow = document.querySelector('.no-fixtures-row');
        if (visibleRows.length === 0 && totalRows.length > 0) {
            if (!noResultsRow) {
                const tbody = document.querySelector('tbody');
                const newRow = document.createElement('tr');
                newRow.className = 'no-fixtures-row';
                newRow.innerHTML = '<td colspan="9" class="text-center text-muted py-4">No fixtures match the current filters.</td>';
                tbody.appendChild(newRow);
            }
        } else if (noResultsRow) {
            noResultsRow.remove();
        }
    }
    
    // Attach filter event listeners
    document.getElementById('tournamentFilter').addEventListener('change', applyFilters);
    document.getElementById('categoryFilter').addEventListener('change', applyFilters);
    document.getElementById('statusFilter').addEventListener('change', applyFilters);
    
    // Refresh button functionality
    document.getElementById('refreshBtn').addEventListener('click', function() {
        location.reload();
    });
    
    // Search functionality (if search input exists)
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }

    // Handle result modal
    document.addEventListener('DOMContentLoaded', function() {
        const resultModal = document.getElementById('resultModal');
        const resultForm = document.getElementById('resultForm');
        const homeTeamName = document.getElementById('homeTeamName');
        const awayTeamName = document.getElementById('awayTeamName');
        const homeScoreInput = document.getElementById('home_score');
         const awayScoreInput = document.getElementById('away_score');
        
        resultModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const fixtureId = button.getAttribute('data-fixture-id');
            const homeTeam = button.getAttribute('data-home-team');
            const awayTeam = button.getAttribute('data-away-team');
            const homeScore = button.getAttribute('data-home-score');
            const awayScore = button.getAttribute('data-away-score');
            
            homeTeamName.textContent = homeTeam;
            awayTeamName.textContent = awayTeam;
            resultForm.action = `/admin/fixtures/${fixtureId}/result`;
            
            // Set existing scores if available
            homeScoreInput.value = homeScore && homeScore !== 'null' ? homeScore : '';
            awayScoreInput.value = awayScore && awayScore !== 'null' ? awayScore : '';
        });
        
        // Filter fixtures by status
        const tabs = document.querySelectorAll('[data-bs-toggle="tab"]');
        const tableRows = document.querySelectorAll('tbody tr');
        
        tabs.forEach(tab => {
            tab.addEventListener('shown.bs.tab', function(e) {
                const target = e.target.id;
                
                tableRows.forEach(row => {
                    if (target === 'all-tab') {
                        row.style.display = '';
                    } else if (target === 'upcoming-tab') {
                        const statusBadge = row.querySelector('.badge');
                        if (statusBadge && statusBadge.textContent.trim() === 'Upcoming') {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    } else if (target === 'completed-tab') {
                        const statusBadge = row.querySelector('.badge');
                        if (statusBadge && statusBadge.textContent.trim() === 'Completed') {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
            });
        });
    });

    // Live Events Modal functionality
    let currentFixtureId = null;
    const liveEventsModal = new bootstrap.Modal(document.getElementById('liveEventsModal'));
    
    function openLiveEventsModal(button) {
        currentFixtureId = button.getAttribute('data-fixture-id');
        const homeTeam = button.getAttribute('data-home-team');
        const awayTeam = button.getAttribute('data-away-team');
        
        document.getElementById('liveMatchTitle').textContent = `${homeTeam} vs ${awayTeam}`;
        
        liveEventsModal.show();
        loadMatchEvents();
    }
    
    function loadMatchEvents() {
        const eventsList = document.getElementById('eventsList');
        eventsList.innerHTML = '<div class="text-center text-muted"><i class="fas fa-spinner fa-spin"></i> Loading events...</div>';
        
        fetch(`/admin/fixtures/${currentFixtureId}/events/live`)
            .then(response => response.json())
            .then(data => {
                if (data.events && data.events.length > 0) {
                    let eventsHtml = '';
                    data.events.forEach(event => {
                        const eventIcon = getEventIcon(event.event_type);
                        eventsHtml += `
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <div>
                                    <span class="badge bg-primary">${event.minute}'</span>
                                    <span class="ms-2">${eventIcon} ${event.event_type.replace('_', ' ').toUpperCase()}</span>
                                    ${event.player_name ? `<br><small class="text-muted ms-4">Player: ${event.player_name}</small>` : ''}
                                    ${event.description ? `<br><small class="text-muted ms-4">${event.description}</small>` : ''}
                                </div>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteEvent(${event.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        `;
                    });
                    eventsList.innerHTML = eventsHtml;
                } else {
                    eventsList.innerHTML = '<div class="text-center text-muted">No events recorded yet.</div>';
                }
            })
            .catch(error => {
                console.error('Error loading events:', error);
                eventsList.innerHTML = '<div class="text-center text-danger">Error loading events.</div>';
            });
    }
    
    function getEventIcon(eventType) {
        const icons = {
            'goal': '⚽',
            'yellow_card': '🟨',
            'red_card': '🟥',
            'substitution': '🔄',
            'live_update': '📝'
        };
        return icons[eventType] || '📝';
    }
    
    // Handle add event form
    document.getElementById('addEventForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('fixture_id', currentFixtureId);
        
        fetch(`/admin/fixtures/${currentFixtureId}/events`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.reset();
                loadMatchEvents();
                // Show success message
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show';
                alert.innerHTML = `
                    Event added successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.querySelector('.modal-body').insertBefore(alert, document.querySelector('.card'));
                setTimeout(() => alert.remove(), 3000);
            } else {
                alert('Error adding event: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error adding event:', error);
            alert('Error adding event. Please try again.');
        });
    });
    
    function deleteEvent(eventId) {
        if (confirm('Are you sure you want to delete this event?')) {
            fetch(`/admin/events/${eventId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadMatchEvents();
                } else {
                    alert('Error deleting event: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error deleting event:', error);
                alert('Error deleting event. Please try again.');
            });
        }
    }
</script>
@endpush