<img src="{{ asset('img/breadcrumbs/image3.png')}}" uk-img="loading: eager" class="uk-animation-kenburns" width="1800"
    height="600" alt="">
<div class="uk-overlay-primary uk-position-cover"></div>
<div class="uk-overlay uk-position-center uk-light">
    <div class="highlight-score-section" uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 100">
        @if($nextFixture)
        <a href="{{ route('fixture.show', $nextFixture->id) }}" class="uk-link-reset">
            <!-- Label -->
            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                <div class="uk-width-auto@m uk-align-center">
                    <span class="uk-label outline">Next Match</span>
                </div>
            </div>
            <!-- Teams -->
            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                @php
                $isAzamHomeHighlight = $nextFixture->homeTeam && stripos($nextFixture->homeTeam->name, 'AZAM') !== false;
                @endphp
                @if($isAzamHomeHighlight)
                <!-- AZAM FC is home team -->
                <div class="uk-width-auto@m">
                    <div class="uk-card uk-card-default uk-card-body">
                        <div class="uk-column-1-2">
                            <!-- AZAM FC logo -->
                            <p>
                                <img src="{{ asset('img/logo.png')}}" alt="AZAM FC" />
                            </p>
                            <p>AZAM FC</p>
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
                            <p>{{ strtoupper($nextFixture->awayTeam->name ?? 'Away Team') }}</p>
                            <!-- Away team logo -->
                            <p>
                                <img src="{{ $nextFixture->awayTeam && $nextFixture->awayTeam->logo ? asset('storage/' . $nextFixture->awayTeam->logo) : asset('img/teamlogos/default.png') }}"
                                    alt="{{ $nextFixture->awayTeam->name ?? 'Away Team' }}" />
                            </p>
                        </div>
                    </div>
                </div>
                @else
                <!-- AZAM FC is away team -->
                <div class="uk-width-auto@m">
                    <div class="uk-card uk-card-default uk-card-body">
                        <div class="uk-column-1-2">
                            <!-- Home team logo -->
                            <p>
                                <img src="{{ $nextFixture->homeTeam && $nextFixture->homeTeam->logo ? asset('storage/' . $nextFixture->homeTeam->logo) : asset('img/teamlogos/default.png') }}"
                                    alt="{{ $nextFixture->homeTeam->name ?? 'Home Team' }}" />
                            </p>
                            <p>{{ strtoupper($nextFixture->homeTeam->name ?? 'Home Team') }}</p>
                        </div>
                    </div>
                </div>
                <div class="uk-width-auto@m vsv">
                    <div class="uk-card uk-card-default uk-card-body">
                        <span>VS</span>
                    </div>
                </div>
                <!-- AZAM FC -->
                <div class="uk-width-auto@m">
                    <div class="uk-card uk-card-default uk-card-body">
                        <div class="uk-column-1-2">
                            <p>AZAM FC</p>
                            <!-- AZAM FC logo -->
                            <p>
                                <img src="{{ asset('img/logo.png')}}" alt="AZAM FC" />
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <!-- Date Info -->
            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                <div class="uk-width-auto@m uk-align-center">
                    <p class="stadium-details">
                        <span class="boldfont">
                            {{ $nextFixture->match_date->format('F j, Y') }} | {{ strtoupper($nextFixture->stadium ?? 'TBD') }}
                            @if($nextFixture->tournament)
                            <br><small>{{ strtoupper($nextFixture->tournament->name) }}</small>
                            @endif
                        </span>
                    </p>
                </div>
            </div>
        </a>
        @else
        <!-- Fallback content when no featured fixtures -->
        <div class="uk-child-width-expand@s uk-text-center" uk-grid>
            <div class="uk-width-auto@m uk-align-center">
                <span class="uk-label outline">No Upcoming Matches</span>
            </div>
        </div>
        @endif
    </div>
</div>