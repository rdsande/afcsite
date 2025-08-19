@extends('layouts.app')

@section('content')
<div class="uk-section uk-section-small">
    <div class="uk-container uk-container-medium">
        <!-- Breadcrumb -->
        <nav aria-label="Breadcrumb">
            <ul class="uk-breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('fixtures') }}">Fixtures</a></li>
                <li><span>{{ $fixture->homeTeam->name ?? 'Home Team' }} vs {{ $fixture->awayTeam->name ?? 'Away Team' }}</span></li>
            </ul>
        </nav>

        <!-- Match Header -->
        <div class="uk-card uk-card-default uk-card-body uk-margin-medium">
            <div class="uk-grid-match" uk-grid>
                <!-- Home Team -->
                <div class="uk-width-1-3@m uk-text-center">
                    @if($fixture->homeTeam && $fixture->homeTeam->logo)
                        <img src="{{ asset('storage/' . $fixture->homeTeam->logo) }}" alt="{{ $fixture->homeTeam->name }}" class="team-logo uk-margin-small-bottom" style="width: 80px; height: 80px; object-fit: contain;">
                    @else
                        <img src="{{ asset('img/logo.png') }}" alt="Home Team" class="team-logo uk-margin-small-bottom" style="width: 80px; height: 80px; object-fit: contain;">
                    @endif
                    <h3 class="uk-margin-remove">{{ $fixture->homeTeam->name ?? 'Home Team' }}</h3>
                </div>

                <!-- Match Info -->
                <div class="uk-width-1-3@m uk-text-center">
                    @if($fixture->status === 'completed' && $fixture->home_score !== null && $fixture->away_score !== null)
                        <div class="uk-text-large uk-text-bold uk-margin-small-bottom">
                            {{ $fixture->home_score }} - {{ $fixture->away_score }}
                        </div>
                        <span class="uk-badge uk-badge-success">Final</span>
                    @else
                        <div class="uk-text-large uk-text-bold uk-margin-small-bottom">
                            {{ $fixture->match_date->format('H:i') }}
                        </div>
                        <span class="uk-badge uk-badge-{{ $fixture->status === 'live' ? 'danger' : 'primary' }}">
                            {{ ucfirst($fixture->status) }}
                        </span>
                    @endif
                    
                    <div class="uk-margin-small-top">
                        <div class="uk-text-small uk-text-muted">
                            {{ $fixture->match_date->format('M d, Y') }}
                        </div>
                        <div class="uk-text-small uk-text-muted">
                            {{ $fixture->stadium }}
                        </div>
                        @if($fixture->tournament)
                            <div class="uk-text-small uk-text-muted">
                                {{ $fixture->tournament->name }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Away Team -->
                <div class="uk-width-1-3@m uk-text-center">
                    @if($fixture->awayTeam && $fixture->awayTeam->logo)
                        <img src="{{ asset('storage/' . $fixture->awayTeam->logo) }}" alt="{{ $fixture->awayTeam->name }}" class="team-logo uk-margin-small-bottom" style="width: 80px; height: 80px; object-fit: contain;">
                    @else
                        <img src="{{ asset('img/logo.png') }}" alt="Away Team" class="team-logo uk-margin-small-bottom" style="width: 80px; height: 80px; object-fit: contain;">
                    @endif
                    <h3 class="uk-margin-remove">{{ $fixture->awayTeam->name ?? 'Away Team' }}</h3>
                </div>
            </div>
        </div>

        <!-- Match Details -->
        <div class="uk-grid-match" uk-grid>
            <!-- Match Preview/Report -->
            @if($fixture->match_preview || $fixture->match_report)
                <div class="uk-width-2-3@m">
                    <div class="uk-card uk-card-default uk-card-body">
                        @if($fixture->status === 'completed' && $fixture->match_report)
                            <h4>Match Report</h4>
                            <div class="uk-text-justify">
                                {!! nl2br(e($fixture->match_report)) !!}
                            </div>
                        @elseif($fixture->match_preview)
                            <h4>Match Preview</h4>
                            <div class="uk-text-justify">
                                {!! nl2br(e($fixture->match_preview)) !!}
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Match Info Sidebar -->
            <div class="uk-width-1-3@m">
                <div class="uk-card uk-card-default uk-card-body">
                    <h4>Match Information</h4>
                    <dl class="uk-description-list">
                        <dt>Competition</dt>
                        <dd>{{ $fixture->tournament->name ?? $fixture->competition_type }}</dd>
                        
                        <dt>Match Type</dt>
                        <dd>{{ ucfirst($fixture->match_type) }}</dd>
                        
                        <dt>Category</dt>
                        <dd>{{ ucfirst($fixture->team_category) }}</dd>
                        
                        <dt>Stadium</dt>
                        <dd>{{ $fixture->stadium }}</dd>
                        
                        @if($fixture->referee)
                            <dt>Referee</dt>
                            <dd>{{ $fixture->referee }}</dd>
                        @endif
                        
                        @if($fixture->attendance)
                            <dt>Attendance</dt>
                            <dd>{{ number_format($fixture->attendance) }}</dd>
                        @endif
                        
                        @if($fixture->broadcast_link)
                            <dt>Watch Live</dt>
                            <dd><a href="{{ $fixture->broadcast_link }}" target="_blank" class="uk-button uk-button-primary uk-button-small">Watch Now</a></dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <!-- Match Events -->
        @if($fixture->matchEvents && $fixture->matchEvents->count() > 0)
            <div class="uk-card uk-card-default uk-card-body uk-margin-medium">
                <h4>Match Events</h4>
                <div class="uk-overflow-auto">
                    <table class="uk-table uk-table-divider">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Event</th>
                                <th>Team</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fixture->matchEvents as $event)
                                <tr>
                                    <td>{{ $event->minute }}'</td>
                                    <td>
                                        @switch($event->event_type)
                                            @case('goal')
                                                <span class="uk-label uk-label-success">⚽ Goal</span>
                                                @break
                                            @case('yellow_card')
                                                <span class="uk-label uk-label-warning">🟨 Yellow Card</span>
                                                @break
                                            @case('red_card')
                                                <span class="uk-label uk-label-danger">🟥 Red Card</span>
                                                @break
                                            @case('substitution')
                                                <span class="uk-label">🔄 Substitution</span>
                                                @break
                                            @default
                                                <span class="uk-label">{{ ucfirst(str_replace('_', ' ', $event->event_type)) }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ ucfirst($event->team) }}</td>
                                    <td>{{ $event->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Back to Fixtures -->
        <div class="uk-text-center uk-margin-medium">
            <a href="{{ route('fixtures') }}" class="uk-button uk-button-default">
                <span uk-icon="arrow-left"></span> Back to Fixtures
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.team-logo {
    border-radius: 50%;
    border: 2px solid #e5e5e5;
}

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