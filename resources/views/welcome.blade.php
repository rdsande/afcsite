@extends('layouts.app')

@section('content')
<!-- Main -->
<main class="afc-main">
    <!-- Hero -->
    <div class="hero-container">
        @include('includes.heroslides')
    </div>
    <!-- Hero End  -->

    <!-- Posts Part One -->
    <div class="uk-section whiteptn ptn4">
        <div class="uk-container uk-container-medium">

            <!-- Fixtures Start -->
            <div class="uk-grid-small uk-child-width-expand@s uk-text-center uk-grid-match uk-margin-medium" uk-grid
                uk-scrollspy="target: > div; cls: uk-animation-scale-up; delay: 200">
                
                @if($featuredFixtures && $featuredFixtures->count() > 0)
                    @php $featured = $featuredFixtures->first(); @endphp
                    <div class="match-home-card bg-primary-two">
                        <div class="uk-card uk-card-default uk-card-body">
                            <div class="widget-header-wrapper">
                                <div class="widget-header-wrapper__header">
                                    <header class="widget-header">
                                        <h2 class="widget-header__title">NEXT MATCH</h2>
                                    </header>
                                </div>
                            </div>
                            <div class="card-tag">
                                <div class="card-inner-teams-results">
                                    <div class="home-team-item">
                                        <img src="{{ asset('img/logo.png')}}" class="logo-card-item" alt="AZAM FC Logo" />
                                        <span class="team-name-card-item">AZAM FC</span>
                                    </div>
                                    <div class="game-score">
                                        <span class="result-item">
                                            <h3>{{ $featured->match_date->format('H:i') }}</h3>
                                        </span>
                                    </div>
                                    <div class="home-team-item">
                                        <img src="{{ $featured->opponent_logo ? asset('storage/' . $featured->opponent_logo) : asset('img/teamlogos/default.png') }}" 
                                             class="logo-card-item" alt="{{ $featured->opponent }} Logo" />
                                        <span class="team-name-card-item">{{ strtoupper($featured->opponent) }}</span>
                                    </div>
                                </div>
                                <div class="card-inner">
                                    <h4 class="comp-label">{{ strtoupper($featured->tournament->name ?? 'FRIENDLY') }}</h4>
                                    <span class="date">
                                        <i class="ri-time-line"></i> 
                                        {{ $featured->match_date->format('M d, Y') }} | {{ strtoupper($featured->stadium ?? 'TBD') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                
                @if($recentMatches && $recentMatches->count() > 0)
                    @foreach($recentMatches->take(2) as $index => $match)
                    <div class="match-home-card">
                        <div class="uk-card uk-card-default uk-card-body">
                            <div class="widget-header-wrapper">
                                <div class="widget-header-wrapper__header">
                                    <header class="widget-header">
                                        <h2 class="widget-header__title">{{ $index == 0 ? 'LAST MATCH' : 'PREVIOUS MATCH' }}</h2>
                                    </header>
                                </div>
                            </div>
                            <div class="card-inner-teams-results">
                                <div class="home-team-item">
                                    <img src="{{ asset('img/logo.png')}}" class="logo-card-item" alt="AZAM FC Logo" />
                                    <span class="team-name-card-item">AZAM FC</span>
                                </div>
                                <div class="game-score">
                                    <span class="result-item">
                                        <h3>{{ $match->home_score ?? '0' }}</h3>
                                    </span>
                                    <span class="result-item">
                                        <h3>{{ $match->away_score ?? '0' }}</h3>
                                    </span>
                                </div>
                                <div class="home-team-item">
                                    <img src="{{ $match->opponent_logo ? asset('storage/' . $match->opponent_logo) : asset('img/teamlogos/default.png') }}" 
                                         class="logo-card-item" alt="{{ $match->opponent }} Logo" />
                                    <span class="team-name-card-item">{{ strtoupper($match->opponent) }}</span>
                                </div>
                            </div>
                            <div class="card-inner">
                                <h4 class="comp-label">{{ strtoupper($match->tournament->name ?? 'FRIENDLY') }}</h4>
                                <span class="date">
                                    <i class="ri-time-line"></i> 
                                    {{ $match->match_date->format('d/m/Y') }} | {{ strtoupper($match->stadium ?? 'TBD') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>

            <!-- Fixtures End -->

            <div class="home-posts shadow-one">
                <!-- Post Header -->
                <div class="widget-header-wrapper ">
                    <div class="widget-header-wrapper__header">
                        <header class="widget-header  ">
                            <h2 class="widget-header__title">LATEST NEWS</h2>
                        </header>
                    </div>

                    <div class="widget-header-wrapper__content ">
                        <a href="{{url('latestnews')}}" class="widget-header__link-to "> View all news <i
                                class="ri-arrow-right-s-line"></i>
                        </a>
                    </div>
                </div>
                <!-- Post Header -->
                <div class="posts-type-one">
                    @include('includes/posts.post_type_one')
                </div>
            </div>
        </div>
    </div>
    <!-- Players Type One -->
    <div class="uk-section bg-gradient-one players-section">
        <div class="uk-container uk-container-medium">
            <div class="floating-results-one shadow-one">
                <!-- Post Header -->
                <div class="widget-header-wrapper light">
                    <div class="widget-header-wrapper__header">
                        <header class="widget-header  ">
                            <h2 class="widget-header__title">OUR SQUAD</h2>
                        </header>
                    </div>

                    <div class="widget-header-wrapper__content ">
                        <div class="uk-inline">
                            <button class="uk-button uk-button-default playershomebtn" type="button">Senior
                                Team</button>
                            <div uk-dropdown>
                                <ul class="uk-nav uk-dropdown-nav">
                                    <li><a href="{{ url('u13team')}}"> U13 - ACADEMY </a></li>
                                    <li><a href="{{ url('u15team')}}"> U15 - ACADEMY </a></li>
                                    <li><a href="{{ url('u17team')}}"> U17 - ACADEMY </a></li>
                                    <li><a href="{{url('u20team')}}"> U20 - ACADEMY </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Post Header -->
                <div class="results-fixtures-carousel ">
                    <div class="uk-section">
                        <div class="uk-container uk-container-medium">
                            @include('includes/players.players')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="spacer-3r"></div>
    </div>
    <!-- Highlight Match -->
    <div class="uk-inline latest-featured-game">
        @include('includes/sections.highlightmatch')
    </div>
    <!-- Kits section -->
    <div class="uk-section bg-white-type-two brd-down">
        <div class="uk-container uk-container-medium">
            <div>
                <!-- Post Header -->
                <div class="widget-header-wrapper light">
                    <div class="widget-header-wrapper__header">
                        <header class="widget-header  ">
                            <h2 class="widget-header__title">AZAMFC SHOP</h2>
                        </header>
                    </div>

                    <div class="widget-header-wrapper__content ">
                        <a href="https://shop.azamfc.co.tz" class="widget-header__link-to" type="button"> View all <i
                                class="ri-arrow-right-s-line"></i>
                        </a>
                    </div>
                </div>
                <!-- Post Header -->
                <div class="results-fixtures-carousel">
                    <div class="uk-section">
                        <div class="uk-container uk-container-medium">
                            @include('includes/sections.shop')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- App section -->
    <div class="uk-section bg-primary">
        <div class="uk-container uk-container-medium">
            <div class="app-section">
                <div class="uk-grid-column-small uk-grid-row-large uk-child-width-1-2@s uk-text-center" uk-grid>
                    <div uk-scrollspy="cls: uk-animation-fade; target: .uk-card; delay: 100; repeat: true">
                        <div class="uk-card uk-card-default uk-card-body">
                            <span class="cta-app-section">
                                <span class="cta-normal">DOWNLOAD <span class="o-text"> THE </span></span>
                            </span>
                            <span class="cta-app-section">
                                <span class="cta-normal"> <span class="o-text"> AZAM FC </span> APP</span>
                            </span>
                            <p uk-margin>
                                <span class="uk-label uk-label-success">COMING SOON</span>
                                <!-- <a class="uk-button uk-button-secondary" href="#"> <i class="ri-apple-fill"></i>
                                    APP STORE</a>
                                <a class="uk-button uk-button-secondary"><i class="ri-google-play-fill"></i>
                                    PLAYSTORE</a> -->
                            </p>
                        </div>
                    </div>
                    <div uk-scrollspy="cls: uk-animation-scale-up; target: .uk-card; delay: 100; repeat: true">
                        <div class="uk-card uk-card-default uk-card-body">
                            <div class="phone-cont">
                                <img loading="lazy" src="{{ asset('img/phone-sm.png')}}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Matches -->
    <div class="uk-section fixtures-two">
        <div class="uk-container">
            <!-- Post Header -->
            <div class="widget-header-wrapper ">
                <div class="widget-header-wrapper__header">
                    <header class="widget-header  ">
                        <h2 class="widget-header__title">Fixtures</h2>
                    </header>
                </div>

                <div class="widget-header-wrapper__content ">
                    <a href="{{ url('latestnews')}}" class="widget-header__link-to "> View all <i
                            class="ri-arrow-right-s-line"></i>
                    </a>
                </div>
            </div>
            <!-- Post Header -->
            @include('includes/sections.fixtures_type_2')
        </div>
    </div>

</main>
@endsection