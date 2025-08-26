@extends('layouts.app')

@section('content')
<div class="uk-container uk-container-large uk-margin-large-top">
    <div class="uk-grid-large" uk-grid>
        <div class="uk-width-2-3@l">
            <!-- Breadcrumb -->
            <nav aria-label="Breadcrumb">
                <ul class="uk-breadcrumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('fixtures') }}">Fixtures</a></li>
                    <li><span>{{ $fixture->homeTeam->name ?? 'Home' }} vs {{ $fixture->awayTeam->name ?? 'Away' }}</span></li>
                </ul>
            </nav>

            <!-- Match Header with Football Background -->
            <div class="uk-card uk-card-default uk-card-body uk-margin-medium football-background-card">
                <div class="uk-grid-match" uk-grid>
                    <!-- Home Team -->
                    <div class="uk-width-1-3@m uk-text-center">
                        @if($fixture->homeTeam && $fixture->homeTeam->logo)
                            <img src="{{ asset('storage/' . $fixture->homeTeam->logo) }}" alt="{{ $fixture->homeTeam->name }}" class="team-logo uk-margin-small-bottom" style="width: 100px; height: 100px; object-fit: contain;">
                        @else
                            <img src="{{ asset('img/logo.png') }}" alt="Home Team" class="team-logo uk-margin-small-bottom" style="width: 100px; height: 100px; object-fit: contain;">
                        @endif
                        <h3 class="uk-margin-remove team-name">{{ $fixture->homeTeam->name ?? 'Home Team' }}</h3>
                        @if($fixture->status === 'completed' || $fixture->status === 'live')
                            <div class="score-display uk-margin-small-top">
                                <span class="score-number">{{ $fixture->home_score ?? 0 }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Match Info -->
                    <div class="uk-width-1-3@m uk-text-center match-center">
                        @if($fixture->status === 'completed' && $fixture->home_score !== null && $fixture->away_score !== null)
                            <div class="vs-text uk-margin-small-bottom">VS</div>
                            <span class="uk-badge uk-badge-success match-status">Final</span>
                        @elseif($fixture->status === 'live')
                            <div class="vs-text uk-margin-small-bottom">VS</div>
                            <span class="uk-badge uk-badge-danger match-status live-pulse">🔴 LIVE</span>
                        @else
                            <div class="match-time uk-text-large uk-text-bold uk-margin-small-bottom">
                                {{ $fixture->match_date->format('H:i') }}
                            </div>
                            <span class="uk-badge uk-badge-primary match-status">
                                {{ ucfirst($fixture->status) }}
                            </span>
                        @endif
                        
                        <div class="uk-margin-small-top match-details">
                            <div class="uk-text-small">
                                {{ $fixture->match_date->format('M d, Y') }}
                            </div>
                            <div class="uk-text-small">
                                📍 {{ $fixture->stadium }}
                            </div>
                            @if($fixture->tournament)
                                <div class="uk-text-small">
                                    🏆 {{ $fixture->tournament->name }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Away Team -->
                    <div class="uk-width-1-3@m uk-text-center">
                        @if($fixture->awayTeam && $fixture->awayTeam->logo)
                            <img src="{{ asset('storage/' . $fixture->awayTeam->logo) }}" alt="{{ $fixture->awayTeam->name }}" class="team-logo uk-margin-small-bottom" style="width: 100px; height: 100px; object-fit: contain;">
                        @else
                            <img src="{{ asset('img/logo.png') }}" alt="Away Team" class="team-logo uk-margin-small-bottom" style="width: 100px; height: 100px; object-fit: contain;">
                        @endif
                        <h3 class="uk-margin-remove team-name">{{ $fixture->awayTeam->name ?? 'Away Team' }}</h3>
                        @if($fixture->status === 'completed' || $fixture->status === 'live')
                            <div class="score-display uk-margin-small-top">
                                <span class="score-number">{{ $fixture->away_score ?? 0 }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Match Preview/Report -->
            @if($fixture->preview || $fixture->report)
                <div class="uk-card uk-card-default uk-card-body uk-margin-medium">
                    @if($fixture->status === 'upcoming' && $fixture->preview)
                        <h4>Match Preview</h4>
                        <div class="uk-text-justify">
                            {!! nl2br(e($fixture->preview)) !!}
                        </div>
                    @elseif($fixture->status === 'completed' && $fixture->report)
                        <h4>Match Report</h4>
                        <div class="uk-text-justify">
                            {!! nl2br(e($fixture->report)) !!}
                        </div>
                    @endif
                </div>
            @endif

            <!-- Live Match Events Card -->
            @if($fixture->status === 'live' || ($fixture->matchEvents && $fixture->matchEvents->count() > 0))
                <div class="uk-card uk-card-default uk-card-body uk-margin-medium live-events-card">
                    <div class="uk-flex uk-flex-between uk-flex-middle uk-margin-small-bottom">
                        <h4 class="uk-margin-remove">
                            @if($fixture->status === 'live')
                                🔴 Live Match Updates
                            @else
                                📋 Match Events
                            @endif
                        </h4>
                        @if($fixture->status === 'live')
                            <span class="uk-badge uk-badge-danger live-pulse">LIVE</span>
                        @endif
                    </div>
                    
                    @if($fixture->matchEvents && $fixture->matchEvents->count() > 0)
                        <div class="events-timeline">
                            @foreach($fixture->matchEvents->sortByDesc('minute') as $event)
                                <div class="event-item uk-margin-small-bottom">
                                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                                        <div class="uk-width-auto">
                                            <span class="event-minute">{{ $event->minute }}'</span>
                                        </div>
                                        <div class="uk-width-auto">
                                            @switch($event->event_type)
                                                @case('goal')
                                                    <span class="event-icon goal">⚽</span>
                                                    @break
                                                @case('yellow_card')
                                                    <span class="event-icon yellow-card">🟨</span>
                                                    @break
                                                @case('red_card')
                                                    <span class="event-icon red-card">🟥</span>
                                                    @break
                                                @case('substitution')
                                                    <span class="event-icon substitution">🔄</span>
                                                    @break
                                                @case('live_update')
                                                    <span class="event-icon live-update">📝</span>
                                                    @break
                                                @default
                                                    <span class="event-icon">📋</span>
                                            @endswitch
                                        </div>
                                        <div class="uk-width-expand">
                                            <div class="event-details">
                                                <strong>{{ ucfirst(str_replace('_', ' ', $event->event_type)) }}</strong>
                                                <span class="team-badge {{ $event->team }}">{{ ucfirst($event->team) }}</span>
                                                @if($event->player && $event->player->name)
                                                    <div class="player-name">{{ $event->player->name }}</div>
                                                @endif
                                                @if($event->description)
                                                    <div class="event-description">{{ $event->description }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="uk-text-center uk-text-muted uk-padding">
                            @if($fixture->status === 'live')
                                <p>🔄 Waiting for live updates...</p>
                                <small>Match events will appear here as they happen</small>
                            @else
                                <p>No match events recorded yet</p>
                            @endif
                        </div>
                    @endif
                    
                    @if($fixture->status === 'live')
                        <div class="uk-text-center uk-margin-small-top">
                            <button class="uk-button uk-button-primary uk-button-small" onclick="refreshEvents()">
                                <span uk-icon="refresh"></span> Refresh Updates
                            </button>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="uk-width-1-3@l">
            <div class="uk-card uk-card-default uk-card-body">
                <h4>Match Information</h4>
                <dl class="uk-description-list uk-description-list-divider">
                    <dt>Date & Time</dt>
                    <dd>{{ $fixture->match_date->format('M d, Y - H:i') }}</dd>
                    
                    <dt>Stadium</dt>
                    <dd>{{ $fixture->stadium }}</dd>
                    
                    @if($fixture->tournament)
                        <dt>Tournament</dt>
                        <dd>{{ $fixture->tournament->name }}</dd>
                    @endif
                    
                    <dt>Status</dt>
                    <dd>
                        <span class="uk-badge uk-badge-{{ $fixture->status === 'live' ? 'danger' : ($fixture->status === 'completed' ? 'success' : 'primary') }}">
                            {{ ucfirst($fixture->status) }}
                        </span>
                    </dd>
                    
                    @if($fixture->status === 'completed' && $fixture->home_score !== null && $fixture->away_score !== null)
                        <dt>Final Score</dt>
                        <dd class="uk-text-large uk-text-bold">
                            {{ $fixture->home_score }} - {{ $fixture->away_score }}
                        </dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Football Background Card */
.football-background-card {
    background-image: url('{{ asset('assets/football.jpg') }}');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    position: relative;
    color: white;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
}

.football-background-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    border-radius: inherit;
}

.football-background-card > * {
    position: relative;
    z-index: 1;
}

/* Team Logos */
.team-logo {
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    background: white;
    padding: 5px;
}

/* Team Names */
.team-name {
    color: white;
    font-weight: bold;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
}

/* Score Display */
.score-display {
    background: rgba(255,255,255,0.9);
    border-radius: 50px;
    padding: 10px 20px;
    display: inline-block;
    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.score-number {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
}

/* Match Center */
.match-center .vs-text {
    font-size: 1.5rem;
    font-weight: bold;
    color: white;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
}

.match-time {
    color: white;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
}

.match-status {
    font-size: 0.9rem;
    padding: 8px 16px;
    border-radius: 20px;
}

.match-details {
    color: rgba(255,255,255,0.9);
    text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
}

/* Live Pulse Animation */
.live-pulse {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

/* Live Events Card */
.live-events-card {
    border-left: 4px solid #e74c3c;
}

.events-timeline {
    max-height: 400px;
    overflow-y: auto;
}

.event-item {
    padding: 12px;
    border-left: 3px solid #ddd;
    margin-left: 20px;
    background: #f8f9fa;
    border-radius: 0 8px 8px 0;
    transition: all 0.3s ease;
}

.event-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.event-minute {
    background: #007bff;
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-weight: bold;
    font-size: 0.8rem;
    min-width: 35px;
    text-align: center;
    display: inline-block;
}

.event-icon {
    font-size: 1.2rem;
    margin-right: 8px;
}

.event-details strong {
    color: #333;
    margin-right: 8px;
}

.team-badge {
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 0.7rem;
    font-weight: bold;
    text-transform: uppercase;
}

.team-badge.home {
    background: #28a745;
    color: white;
}

.team-badge.away {
    background: #dc3545;
    color: white;
}

.player-name {
    font-size: 0.9rem;
    color: #666;
    font-style: italic;
}

.event-description {
    font-size: 0.85rem;
    color: #555;
    margin-top: 4px;
}

/* General Styles */
.uk-description-list dt {
    font-weight: bold;
    color: #333;
}

.uk-description-list dd {
    margin-bottom: 10px;
}

.fixture-card {
    transition: transform 0.2s ease;
}

.fixture-card:hover {
    transform: translateY(-2px);
}
</style>
@endpush

@push('scripts')
<script>
function refreshEvents() {
    location.reload();
}

// Auto-refresh for live matches
if ({{ $fixture->status === 'live' ? 'true' : 'false' }}) {
    setInterval(function() {
        refreshEvents();
    }, 30000);
}
</script>
@endpush