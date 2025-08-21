<div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>

    <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-4@m uk-grid fxtures-home">
        @if($allFixtures && $allFixtures->count() > 0)
            @foreach($allFixtures as $fixture)
                <li>
                    <div class="uk-panel">
                        <div class="inner-fixtures">
                            <h3>
                                @if($fixture->tournament && $fixture->tournament->logo)
                                    <img src="{{ asset('storage/' . $fixture->tournament->logo) }}" class="compt-logo">
                                @else
                                    <img src="{{ asset('img/league/nbc.png') }}" class="compt-logo">
                                @endif
                                {{ strtoupper($fixture->tournament->name ?? 'FRIENDLY') }}
                            </h3>
                            <p>{{ $fixture->match_date->format('d/m/Y') }}</p>
                            <p>{{ strtoupper($fixture->stadium ?? 'TBD') }}</p>
                            <div class="teams-inner-container">
                                @php
                                    $isAzamHome = $fixture->homeTeam && stripos($fixture->homeTeam->name, 'AZAM') !== false;
                                @endphp
                                @if($isAzamHome)
                                    <!-- AZAM FC is home team -->
                                    <div class="team-disp-1">
                                        <img src="{{ asset('img/logo.png') }}" class="logo-card-item" alt="AZAM FC Logo" />
                                    </div>
                                    <div class="team-disp-1 results-section">
                                        <div class="scr-card">
                                            <span class="hm-team-score">{{ $fixture->match_date->format('H:i') }}</span>
                                        </div>
                                    </div>
                                    <div class="team-disp-1">
                                        <img src="{{ $fixture->awayTeam && $fixture->awayTeam->logo ? asset('storage/' . $fixture->awayTeam->logo) : asset('img/teamlogos/default.png') }}" 
                                             class="logo-card-item" alt="{{ $fixture->awayTeam->name ?? 'Away Team' }} Logo" />
                                    </div>
                                @else
                                    <!-- AZAM FC is away team -->
                                    <div class="team-disp-1">
                                        <img src="{{ $fixture->homeTeam && $fixture->homeTeam->logo ? asset('storage/' . $fixture->homeTeam->logo) : asset('img/teamlogos/default.png') }}" 
                                             class="logo-card-item" alt="{{ $fixture->homeTeam->name ?? 'Home Team' }} Logo" />
                                    </div>
                                    <div class="team-disp-1 results-section">
                                        <div class="scr-card">
                                            <span class="hm-team-score">{{ $fixture->match_date->format('H:i') }}</span>
                                        </div>
                                    </div>
                                    <div class="team-disp-1">
                                        <img src="{{ asset('img/logo.png') }}" class="logo-card-item" alt="AZAM FC Logo" />
                                    </div>
                                @endif
                            </div>
                            <div class="fxture">
                                @if($isAzamHome)
                                    <span class="homteam">AZAM FC</span>
                                    <span class="faintcol"> VS </span>
                                    <span class="homteam">{{ strtoupper($fixture->awayTeam->name ?? 'AWAY TEAM') }}</span>
                                @else
                                    <span class="homteam">{{ strtoupper($fixture->homeTeam->name ?? 'HOME TEAM') }}</span>
                                    <span class="faintcol"> VS </span>
                                    <span class="homteam">AZAM FC</span>
                                @endif
                            </div>
                            @if($fixture->id)
                                <a href="{{ route('fixture.show', $fixture->id) }}" class="match-btn">
                                    <button class="uk-button uk-button-primary">Match Details</button>
                                </a>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        @else
            <li>
                <div class="uk-panel">
                    <div class="inner-fixtures">
                        <h3>No Upcoming Fixtures</h3>
                        <p>Check back soon for upcoming matches</p>
                    </div>
                </div>
            </li>
        @endif
    </ul>

    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>

    <!-- <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul> -->

</div>