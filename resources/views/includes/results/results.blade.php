<div class="uk-section">
    <div class="uk-container uk-container-medium games-fixtures">
        @if(isset($recentResults) && $recentResults->count() > 0)
            @php
                $resultsByMonth = $recentResults->groupBy(function($result) {
                    return $result->match_date->format('F Y');
                });
            @endphp
            
            @foreach($resultsByMonth as $monthYear => $results)
                <!-- Monthly Header -->
                <div class="widget-header-wrapper">
                    <div class="widget-header-wrapper__header">
                        <header class="widget-header">
                            <h2 class="widget-header__title">{{ strtoupper($monthYear) }}</h2>
                        </header>
                    </div>
                </div>
                
                <!-- Results -->
                <div>
                    <ul class="uk-grid-small uk-grid uk-child-width-1-3@s uk-text-center fxtures-list-divs">
                        @foreach($results as $result)
                            <li>
                                <div class="uk-card uk-card-default uk-card-body result-card">
                                    <div class="result-header">
                                        <span class="tournament-badge">{{ $result->tournament->short_name ?? $result->competition_type }}</span>
                                        <span class="match-status completed">{{ ucfirst($result->status) }}</span>
                                    </div>
                                    
                                    <div class="teams-section">
                                        <div class="team home-team">
                                            @if($result->homeTeam && $result->homeTeam->logo)
                                                <img src="{{ asset('storage/' . $result->homeTeam->logo) }}" alt="{{ $result->homeTeam->name }}" class="team-logo">
                                            @else
                                                <img src="{{ asset('img/logo.png') }}" alt="{{ $result->homeTeam->name ?? 'Home Team' }}" class="team-logo">
                                            @endif
                                            <span class="team-name">{{ $result->homeTeam->name ?? 'Home Team' }}</span>
                                        </div>
                                        
                                        <div class="score-section">
                                            <div class="final-score">
                                                <span class="home-score">{{ $result->home_score ?? 0 }}</span>
                                                <span class="score-separator">-</span>
                                                <span class="away-score">{{ $result->away_score ?? 0 }}</span>
                                            </div>
                                            <div class="match-result">
                                                @if($result->home_score > $result->away_score)
                                                    @if($result->is_home)
                                                        <span class="result-badge win">W</span>
                                                    @else
                                                        <span class="result-badge loss">L</span>
                                                    @endif
                                                @elseif($result->home_score < $result->away_score)
                                                    @if($result->is_home)
                                                        <span class="result-badge loss">L</span>
                                                    @else
                                                        <span class="result-badge win">W</span>
                                                    @endif
                                                @else
                                                    <span class="result-badge draw">D</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="team away-team">
                                            <span class="team-name">{{ $result->awayTeam->name ?? 'Away Team' }}</span>
                                            @if($result->awayTeam && $result->awayTeam->logo)
                                                <img src="{{ asset('storage/' . $result->awayTeam->logo) }}" alt="{{ $result->awayTeam->name }}" class="team-logo">
                                            @else
                                                <img src="{{ asset('img/teamlogos/default.png') }}" alt="{{ $result->awayTeam->name ?? 'Away Team' }}" class="team-logo">
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="match-details">
                                        <div class="match-date">
                                            <i class="fas fa-calendar"></i>
                                            {{ $result->match_date->format('M d, Y') }}
                                        </div>
                                        <div class="match-venue">
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{ $result->stadium }}
                                        </div>
                                        @if($result->attendance)
                                            <div class="attendance-info">
                                                <i class="fas fa-users"></i>
                                                {{ number_format($result->attendance) }} fans
                                            </div>
                                        @endif
                                        @if($result->referee)
                                            <div class="referee-info">
                                                <i class="fas fa-whistle"></i>
                                                {{ $result->referee }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    @if($result->match_report)
                                        <div class="match-report">
                                            <p>{{ Str::limit($result->match_report, 100) }}</p>
                                            <a href="#" class="read-more">Read Full Report</a>
                                        </div>
                                    @endif
                                    
                                    @if($result->matchEvents->count() > 0)
                                        <div class="match-events">
                                            <h6>Key Events:</h6>
                                            <div class="events-list">
                                                @foreach($result->matchEvents->take(3) as $event)
                                                    <div class="event-item">
                                                        <span class="event-time">{{ $event->minute }}'</span>
                                                        <span class="event-type">{{ ucfirst($event->event_type) }}</span>
                                                        @if($event->player)
                                                            <span class="event-player">{{ $event->player->name }}</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        @else
            <div class="uk-text-center uk-margin-large">
                <p class="uk-text-muted">No recent match results available.</p>
            </div>
        @endif
            </div>
        </div>
        <!-- Fixtures -->
        <div>
            <ul class="uk-grid-small uk-grid uk-child-width-1-3@s uk-text-center fxtures-list-divs">
                @include('includes/fixtures/2023/nov.fixtures')
            </ul>
        </div>
        <!-- Monthly -->
        <div class="widget-header-wrapper">
            <div class="widget-header-wrapper__header">
                <header class="widget-header  ">
                    <h2 class="widget-header__title">DECEMBER 2023</h2>
                </header>
            </div>
        </div>
        <!-- Fixtures -->
        <div>
            <ul class="uk-grid-small uk-grid uk-child-width-1-3@s uk-text-center fxtures-list-divs">
                @include('includes/fixtures/2023/dec.fixtures')
            </ul>
        </div>
        <!-- Monthly -->
        <div class="widget-header-wrapper">
            <div class="widget-header-wrapper__header">
                <header class="widget-header  ">
                    <h2 class="widget-header__title">FEBRUARY 2024</h2>
                </header>
            </div>
        </div>
        <!-- Fixtures -->
        <div>
            <ul class="uk-grid-small uk-grid uk-child-width-1-3@s uk-text-center fxtures-list-divs">
                @include('includes/fixtures/2024/feb.fixtures')
            </ul>
        </div>
        <!-- Monthly -->
        <div class="widget-header-wrapper">
            <div class="widget-header-wrapper__header">
                <header class="widget-header  ">
                    <h2 class="widget-header__title">MARCH 2024</h2>
                </header>
            </div>
        </div>
        <!-- Fixtures -->
        <div>
            <ul class="uk-grid-small uk-grid uk-child-width-1-3@s uk-text-center fxtures-list-divs">
                @include('includes/fixtures/2024/mar.fixtures')
            </ul>
        </div>
        <!-- Monthly -->
        <div class="widget-header-wrapper">
            <div class="widget-header-wrapper__header">
                <header class="widget-header  ">
                    <h2 class="widget-header__title">APRIL 2024</h2>
                </header>
            </div>
        </div>
        <!-- Fixtures -->
        <div>
            <ul class="uk-grid-small uk-grid uk-child-width-1-3@s uk-text-center fxtures-list-divs">
                @include('includes/fixtures/2024/apr.fixtures')
            </ul>
        </div>
        <!-- Monthly -->
        <div class="widget-header-wrapper">
            <div class="widget-header-wrapper__header">
                <header class="widget-header  ">
                    <h2 class="widget-header__title">MAY 2024</h2>
                </header>
            </div>
        </div>
        <!-- Fixtures -->
        <div>
            <ul class="uk-grid-small uk-grid uk-child-width-1-3@s uk-text-center fxtures-list-divs">
                @include('includes/fixtures/2024/may.fixtures')
            </ul>
        </div>
    </div>
</div>