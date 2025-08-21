<!-- Featured Match -->
@if(isset($featuredFixtures) && $featuredFixtures->count() > 0)
<div class="uk-inline latest-featured-game">
    @php $featuredMatch = $featuredFixtures->first(); @endphp
    <a href="{{ route('fixture.show', $featuredMatch->id) }}" class="uk-link-reset">
    <img src="{{ asset('img/breadcrumbs/image3.png')}}" uk-img="loading: eager" class="uk-animation-kenburns" width="1800" height="600" alt="">
    <div class="uk-overlay-primary uk-position-cover"></div>
    <div class="uk-overlay uk-position-center uk-light">
        <div class="highlight-score-section" uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 100">
            <!-- Label -->
            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                <div class="uk-width-auto@m uk-align-center">
                    <span class="uk-label outline">{{ $featuredMatch->tournament->name ?? 'Next Match' }}</span>
                </div>
            </div>
            <!-- Teams -->
            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                <!-- Home team -->
                <div class="uk-width-auto@m">
                    <div class="uk-card uk-card-default uk-card-body">
                        <div class="uk-column-1-2">
                            <p>
                                @if($featuredMatch->homeTeam && $featuredMatch->homeTeam->logo)
                                    <img src="{{ asset('storage/' . $featuredMatch->homeTeam->logo) }}" alt="{{ $featuredMatch->homeTeam->name }}" style="max-height: 80px;" />
                                @else
                                    <img src="{{ asset('img/logo.png') }}" alt="{{ $featuredMatch->homeTeam->name ?? 'Home Team' }}" style="max-height: 80px;" />
                                @endif
                            </p>
                            <p>{{ $featuredMatch->homeTeam->name ?? 'Home Team' }}</p>
                        </div>
                    </div>
                </div>
                <div class="uk-width-auto@m vsv">
                    <div class="uk-card uk-card-default uk-card-body">
                        <span>VS</span>
                    </div>
                </div>
                <!-- Away team -->
                <div class="uk-width-auto@m">
                    <div class="uk-card uk-card-default uk-card-body">
                        <div class="uk-column-1-2">
                            <p>{{ $featuredMatch->awayTeam->name ?? 'Away Team' }}</p>
                            <p>
                                @if($featuredMatch->awayTeam && $featuredMatch->awayTeam->logo)
                                    <img src="{{ asset('storage/' . $featuredMatch->awayTeam->logo) }}" alt="{{ $featuredMatch->awayTeam->name }}" style="max-height: 80px;" />
                                @else
                                    <img src="{{ asset('img/teamlogos/default.png') }}" alt="{{ $featuredMatch->awayTeam->name ?? 'Away Team' }}" style="max-height: 80px;" />
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Date Info -->
            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                <div class="uk-width-auto@m uk-align-center">
                    <p class="stadium-details"> - <span class="boldfont">{{ $featuredMatch->match_date->format('M d, Y') }} | {{ $featuredMatch->stadium }}</span> </p>
                </div>
            </div>
        </div>
    </div>
    </a>
</div>
@endif

<div class="uk-section">
    <div class="uk-container uk-container-medium games-fixtures">
        @if(isset($upcomingFixtures) && $upcomingFixtures->count() > 0)
            @php
                $fixturesByMonth = $upcomingFixtures->groupBy(function($fixture) {
                    return $fixture->match_date->format('F Y');
                });
            @endphp
            
            @foreach($fixturesByMonth as $monthYear => $fixtures)
                <!-- Monthly Header -->
                <div class="widget-header-wrapper">
                    <div class="widget-header-wrapper__header">
                        <header class="widget-header">
                            <h2 class="widget-header__title">{{ strtoupper($monthYear) }}</h2>
                        </header>
                    </div>
                </div>
                
                <!-- Fixtures -->
                <div>
                    <ul class="uk-grid-small uk-grid uk-child-width-1-3@s uk-text-center fxtures-list-divs">
                        @foreach($fixtures as $fixture)
                            <li>
                                <a href="{{ route('fixture.show', $fixture->id) }}" class="uk-link-reset">
                                <div class="uk-card uk-card-default uk-card-body fixture-card">
                                    <div class="fixture-header">
                                        <span class="tournament-badge">{{ $fixture->tournament->short_name ?? $fixture->competition_type }}</span>
                                        <span class="match-type">{{ ucfirst($fixture->match_type) }}</span>
                                    </div>
                                    
                                    @php
                                        // Determine if AZAM FC is home or away team
                                        $isAzamHome = $fixture->homeTeam && stripos($fixture->homeTeam->name, 'AZAM') !== false;
                                        $isAzamAway = $fixture->awayTeam && stripos($fixture->awayTeam->name, 'AZAM') !== false;
                                        
                                        if ($isAzamHome) {
                                            $opponentTeam = $fixture->awayTeam;
                                            $matchTitle = 'AZAM FC vs ' . ($opponentTeam ? $opponentTeam->name : 'TBD');
                                        } elseif ($isAzamAway) {
                                            $opponentTeam = $fixture->homeTeam;
                                            $matchTitle = ($opponentTeam ? $opponentTeam->name : 'TBD') . ' vs AZAM FC';
                                        } else {
                                            // Fallback for non-AZAM matches
                                            $opponentTeam = $fixture->awayTeam;
                                            $matchTitle = ($fixture->homeTeam ? $fixture->homeTeam->name : 'TBD') . ' vs ' . ($fixture->awayTeam ? $fixture->awayTeam->name : 'TBD');
                                        }
                                    @endphp
                                    
                                    <div class="teams-section">
                                        <div class="team home-team">
                                            @if($fixture->homeTeam && $fixture->homeTeam->logo)
                                                <img src="{{ asset('storage/' . $fixture->homeTeam->logo) }}" alt="{{ $fixture->homeTeam->name }}" class="team-logo">
                                            @else
                                                <img src="{{ asset('img/logo.png') }}" alt="{{ $fixture->homeTeam->name ?? 'Home Team' }}" class="team-logo">
                                            @endif
                                            <span class="team-name">{{ $fixture->homeTeam->name ?? 'Home Team' }}</span>
                                        </div>
                                        
                                        <div class="vs-section">
                                            <span class="vs-text">VS</span>
                                            <div class="match-time">
                                                {{ $fixture->match_date->format('H:i') }}
                                            </div>
                                        </div>
                                        
                                        <div class="team away-team">
                                            <span class="team-name">{{ $fixture->awayTeam->name ?? 'Away Team' }}</span>
                                            @if($fixture->awayTeam && $fixture->awayTeam->logo)
                                                <img src="{{ asset('storage/' . $fixture->awayTeam->logo) }}" alt="{{ $fixture->awayTeam->name }}" class="team-logo">
                                            @else
                                                <img src="{{ asset('img/teamlogos/default.png') }}" alt="{{ $fixture->awayTeam->name ?? 'Away Team' }}" class="team-logo">
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="match-details">
                                        <div class="match-date">
                                            <i class="fas fa-calendar"></i>
                                            {{ $fixture->match_date->format('M d, Y') }}
                                        </div>
                                        <div class="match-venue">
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{ $fixture->stadium }}
                                        </div>
                                        @if($fixture->broadcast_link)
                                            <div class="broadcast-info">
                                                <a href="{{ $fixture->broadcast_link }}" target="_blank" class="broadcast-link">
                                                    <i class="fas fa-tv"></i> Watch Live
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    @if($fixture->match_preview)
                                        <div class="match-preview">
                                            <p>{{ Str::limit($fixture->match_preview, 100) }}</p>
                                        </div>
                                    @endif
                                </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
            
            <!-- Pagination -->
            <div class="uk-margin-large-top uk-text-center">
                {{ $upcomingFixtures->links() }}
            </div>
        @else
            <div class="uk-text-center uk-margin-large">
                <p class="uk-text-muted">No upcoming fixtures scheduled.</p>
            </div>
        @endif
    </div>
</div>