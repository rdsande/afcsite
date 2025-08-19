<img src="{{ asset('img/breadcrumbs/image3.png')}}" uk-img="loading: eager" class="uk-animation-kenburns" width="1800"
    height="600" alt="">
<div class="uk-overlay-primary uk-position-cover"></div>
<div class="uk-overlay uk-position-center uk-light">
    <div class="highlight-score-section" uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 100">
        @if(isset($featuredFixtures) && $featuredFixtures && $featuredFixtures->count() > 0)
            @php $featured = $featuredFixtures->first(); @endphp
            <!-- Label -->
            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                <div class="uk-width-auto@m uk-align-center">
                    <span class="uk-label outline">Next Match</span>
                </div>
            </div>
            <!-- Teams -->
            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                <!-- Home team -->
                <div class="uk-width-auto@m">
                    <div class="uk-card uk-card-default uk-card-body">
                        <div class="uk-column-1-2">
                            <!-- Home team logo -->
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
                            <p>{{ strtoupper($featured->awayTeam->name ?? 'Away Team') }}</p>
                            <!-- Away team logo -->
                            <p>
                                <img src="{{ $featured->awayTeam && $featured->awayTeam->logo ? asset('storage/' . $featured->awayTeam->logo) : asset('img/teamlogos/default.png') }}" 
                                     alt="{{ $featured->awayTeam->name ?? 'Away Team' }}" />
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Date Info -->
            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                <div class="uk-width-auto@m uk-align-center">
                    <p class="stadium-details"> - 
                        <span class="boldfont">
                            {{ $featured->match_date->format('F j, Y') }} | {{ strtoupper($featured->stadium ?? 'TBD') }}
                            @if($featured->tournament)
                                <br><small>{{ strtoupper($featured->tournament->name) }}</small>
                            @endif
                        </span> 
                    </p>
                </div>
            </div>
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