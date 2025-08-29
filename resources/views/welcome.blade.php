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

                <!-- Previous Match / Live Match -->
                @if($previousMatch)
                <div class="match-home-card {{ $previousMatch->status === 'live' ? 'live-match' : '' }}">
                    <a href="{{ route('fixture.show', $previousMatch->id) }}" class="uk-link-reset">
                        <div class="uk-card uk-card-default uk-card-body">
                            <div class="widget-header-wrapper">
                                <div class="widget-header-wrapper__header">
                                    <header class="widget-header">
                                        <h2 class="widget-header__title">
                                            @if($previousMatch->status === 'live')
                                            <span class="live-indicator">🔴 LIVE MATCH</span>
                                            @else
                                            PREVIOUS MATCH
                                            @endif
                                        </h2>
                                    </header>
                                </div>
                            </div>
                            <div class="card-inner-teams-results">
                                @php
                                $isAzamHome = $previousMatch->homeTeam && stripos($previousMatch->homeTeam->name, 'AZAM') !== false;
                                @endphp
                                @if($isAzamHome)
                                <!-- AZAM FC is home team -->
                                <div class="home-team-item">
                                    <img src="{{ asset('img/logo.png')}}" class="logo-card-item" alt="AZAM FC Logo" />
                                    <span class="team-name-card-item">AZAM FC</span>
                                </div>
                                <div class="game-score">
                                    @if($previousMatch->status === 'live')
                                    <span class="result-item live-score">
                                        <h3>{{ $previousMatch->home_score ?? '0' }}</h3>
                                    </span>
                                    <span class="result-item live-score">
                                        <h3>{{ $previousMatch->away_score ?? '0' }}</h3>
                                    </span>
                                    @else
                                    <span class="result-item">
                                        <h3>{{ $previousMatch->home_score ?? '0' }}</h3>
                                    </span>
                                    <span class="result-item">
                                        <h3>{{ $previousMatch->away_score ?? '0' }}</h3>
                                    </span>
                                    @endif
                                </div>
                                <div class="home-team-item">
                                    <img src="{{ $previousMatch->awayTeam && $previousMatch->awayTeam->logo ? asset('storage/' . $previousMatch->awayTeam->logo) : asset('img/teamlogos/default.png') }}"
                                        class="logo-card-item" alt="{{ $previousMatch->awayTeam->name ?? 'Away Team' }} Logo" />
                                    <span class="team-name-card-item">{{ strtoupper($previousMatch->awayTeam->name ?? 'AWAY TEAM') }}</span>
                                </div>
                                @else
                                <!-- AZAM FC is away team -->
                                <div class="home-team-item">
                                    <img src="{{ $previousMatch->homeTeam && $previousMatch->homeTeam->logo ? asset('storage/' . $previousMatch->homeTeam->logo) : asset('img/teamlogos/default.png') }}"
                                        class="logo-card-item" alt="{{ $previousMatch->homeTeam->name ?? 'Home Team' }} Logo" />
                                    <span class="team-name-card-item">{{ strtoupper($previousMatch->homeTeam->name ?? 'HOME TEAM') }}</span>
                                </div>
                                <div class="game-score">
                                    @if($previousMatch->status === 'live')
                                    <span class="result-item live-score">
                                        <h3>{{ $previousMatch->home_score ?? '0' }}</h3>
                                    </span>
                                    <span class="result-item live-score">
                                        <h3>{{ $previousMatch->away_score ?? '0' }}</h3>
                                    </span>
                                    @else
                                    <span class="result-item">
                                        <h3>{{ $previousMatch->home_score ?? '0' }}</h3>
                                    </span>
                                    <span class="result-item">
                                        <h3>{{ $previousMatch->away_score ?? '0' }}</h3>
                                    </span>
                                    @endif
                                </div>
                                <div class="home-team-item">
                                    <img src="{{ asset('img/logo.png')}}" class="logo-card-item" alt="AZAM FC Logo" />
                                    <span class="team-name-card-item">AZAM FC</span>
                                </div>
                                @endif
                            </div>
                            <div class="card-inner">
                                <h4 class="comp-label">{{ strtoupper($previousMatch->tournament->name ?? 'FRIENDLY') }}</h4>
                                <span class="date">
                                    <i class="ri-time-line"></i>
                                    {{ $previousMatch->match_date->format('M d, Y') }} | {{ strtoupper($previousMatch->stadium ?? 'TBD') }}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                @endif

                <!-- Next Fixture -->
                @if($nextFixture)
                <div class="match-home-card bg-primary-two">
                    <a href="{{ route('fixture.show', $nextFixture->id) }}" class="uk-link-reset">
                        <div class="uk-card uk-card-default uk-card-body">
                            <div class="widget-header-wrapper">
                                <div class="widget-header-wrapper__header">
                                    <header class="widget-header">
                                        <h2 class="widget-header__title">NEXT FIXTURE</h2>
                                    </header>
                                </div>
                            </div>
                            <div class="card-tag">
                                <div class="card-inner-teams-results">
                                    @php
                                    $isAzamHomeNext = $nextFixture->homeTeam && stripos($nextFixture->homeTeam->name, 'AZAM') !== false;
                                    @endphp
                                    @if($isAzamHomeNext)
                                    <!-- AZAM FC is home team -->
                                    <div class="home-team-item">
                                        <img src="{{ asset('img/logo.png')}}" class="logo-card-item" alt="AZAM FC Logo" />
                                        <span class="team-name-card-item">AZAM FC</span>
                                    </div>
                                    <div class="game-score">
                                        <span class="result-item">
                                            <h3>{{ $nextFixture->match_date->format('H:i') }}</h3>
                                        </span>
                                    </div>
                                    <div class="home-team-item">
                                        <img src="{{ $nextFixture->awayTeam && $nextFixture->awayTeam->logo ? asset('storage/' . $nextFixture->awayTeam->logo) : asset('img/teamlogos/default.png') }}"
                                            class="logo-card-item" alt="{{ $nextFixture->awayTeam->name ?? 'Away Team' }} Logo" />
                                        <span class="team-name-card-item">{{ strtoupper($nextFixture->awayTeam->name ?? 'AWAY TEAM') }}</span>
                                    </div>
                                    @else
                                    <!-- AZAM FC is away team -->
                                    <div class="home-team-item">
                                        <img src="{{ $nextFixture->homeTeam && $nextFixture->homeTeam->logo ? asset('storage/' . $nextFixture->homeTeam->logo) : asset('img/teamlogos/default.png') }}"
                                            class="logo-card-item" alt="{{ $nextFixture->homeTeam->name ?? 'Home Team' }} Logo" />
                                        <span class="team-name-card-item">{{ strtoupper($nextFixture->homeTeam->name ?? 'HOME TEAM') }}</span>
                                    </div>
                                    <div class="game-score">
                                        <span class="result-item">
                                            <h3>{{ $nextFixture->match_date->format('H:i') }}</h3>
                                        </span>
                                    </div>
                                    <div class="home-team-item">
                                        <img src="{{ asset('img/logo.png')}}" class="logo-card-item" alt="AZAM FC Logo" />
                                        <span class="team-name-card-item">AZAM FC</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="card-inner">
                                    <h4 class="comp-label">{{ strtoupper($nextFixture->tournament->name ?? 'FRIENDLY') }}</h4>
                                    <span class="date">
                                        <i class="ri-time-line"></i>
                                        {{ $nextFixture->match_date->format('M d, Y') }} | {{ strtoupper($nextFixture->stadium ?? 'TBD') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endif

                <!-- Upcoming Fixtures -->
                @if($upcomingFixtures && $upcomingFixtures->count() > 0)
                @foreach($upcomingFixtures as $index => $fixture)
                <div class="match-home-card">
                    <a href="{{ route('fixture.show', $fixture->id) }}" class="uk-link-reset">
                        <div class="uk-card uk-card-default uk-card-body">
                            <div class="widget-header-wrapper">
                                <div class="widget-header-wrapper__header">
                                    <header class="widget-header">
                                        <h2 class="widget-header__title">UPCOMING FIXTURE</h2>
                                    </header>
                                </div>
                            </div>
                            <div class="card-inner-teams-results">
                                @php
                                $isAzamHomeUpcoming = $fixture->homeTeam && stripos($fixture->homeTeam->name, 'AZAM') !== false;
                                @endphp
                                @if($isAzamHomeUpcoming)
                                <!-- AZAM FC is home team -->
                                <div class="home-team-item">
                                    <img src="{{ asset('img/logo.png')}}" class="logo-card-item" alt="AZAM FC Logo" />
                                    <span class="team-name-card-item">AZAM FC</span>
                                </div>
                                <div class="game-score">
                                    <span class="result-item">
                                        <h3>{{ $fixture->match_date->format('H:i') }}</h3>
                                    </span>
                                </div>
                                <div class="home-team-item">
                                    <img src="{{ $fixture->awayTeam && $fixture->awayTeam->logo ? asset('storage/' . $fixture->awayTeam->logo) : asset('img/teamlogos/default.png') }}"
                                        class="logo-card-item" alt="{{ $fixture->awayTeam->name ?? 'Away Team' }} Logo" />
                                    <span class="team-name-card-item">{{ strtoupper($fixture->awayTeam->name ?? 'AWAY TEAM') }}</span>
                                </div>
                                @else
                                <!-- AZAM FC is away team -->
                                <div class="home-team-item">
                                    <img src="{{ $fixture->homeTeam && $fixture->homeTeam->logo ? asset('storage/' . $fixture->homeTeam->logo) : asset('img/teamlogos/default.png') }}"
                                        class="logo-card-item" alt="{{ $fixture->homeTeam->name ?? 'Home Team' }} Logo" />
                                    <span class="team-name-card-item">{{ strtoupper($fixture->homeTeam->name ?? 'HOME TEAM') }}</span>
                                </div>
                                <div class="game-score">
                                    <span class="result-item">
                                        <h3>{{ $fixture->match_date->format('H:i') }}</h3>
                                    </span>
                                </div>
                                <div class="home-team-item">
                                    <img src="{{ asset('img/logo.png')}}" class="logo-card-item" alt="AZAM FC Logo" />
                                    <span class="team-name-card-item">AZAM FC</span>
                                </div>
                                @endif
                            </div>
                            <div class="card-inner">
                                <h4 class="comp-label">{{ strtoupper($fixture->tournament->name ?? 'FRIENDLY') }}</h4>
                                <span class="date">
                                    <i class="ri-time-line"></i>
                                    {{ $fixture->match_date->format('M d, Y') }} | {{ strtoupper($fixture->stadium ?? 'TBD') }}
                                </span>
                            </div>
                        </div>
                    </a>
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

            <!-- Exclusive Stories Section -->
            @if((auth()->check() || auth('fan')->check()) && $exclusiveStories && $exclusiveStories->count() > 0)
            <div class="home-posts shadow-one uk-margin-large-top">
                <!-- Post Header -->
                <div class="widget-header-wrapper ">
                    <div class="widget-header-wrapper__header">
                        <header class="widget-header  ">
                            <h2 class="widget-header__title">EXCLUSIVE FOR YOU</h2>
                        </header>
                    </div>

                    <div class="widget-header-wrapper__content ">
                        <a href="/" class="widget-header__link-to "> View all <i
                                class="ri-arrow-right-s-line"></i>
                        </a>
                    </div>
                </div>
                <!-- Post Header -->
                <div class="exclusive-stories-grid">
                    <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m uk-grid-match" uk-grid uk-scrollspy="target: > div; cls: uk-animation-scale-up; delay: 200">
                        @foreach($exclusiveStories as $story)
                        <div>
                            <div class="uk-card uk-card-default uk-card-hover exclusive-story-card">
                                <div class="uk-card-media-top">
                                    @if($story->type === 'photos' && $story->media_paths && count($story->media_paths) > 0)
                                    <img src="{{ asset('storage/' . $story->media_paths[0]) }}" alt="{{ $story->title }}" class="exclusive-story-image">
                                    <div class="story-type-badge photos-badge">
                                        <i class="ri-image-line"></i> PHOTOS
                                    </div>
                                    @if(count($story->media_paths) > 1)
                                    <div class="media-count-badge">
                                        +{{ count($story->media_paths) - 1 }}
                                    </div>
                                    @endif
                                    @elseif($story->type === 'video')
                                    @if($story->thumbnail)
                                    <img src="{{ asset('storage/' . $story->thumbnail) }}" alt="{{ $story->title }}" class="exclusive-story-image">
                                    @elseif($story->media_paths && count($story->media_paths) > 0)
                                    @php
                                    $firstMediaPath = $story->media_paths[0];
                                    $isVideo = in_array(pathinfo($firstMediaPath, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']);
                                    @endphp
                                    @if($isVideo)
                                    <video class="exclusive-story-video" poster="">
                                        <source src="{{ asset('storage/' . $firstMediaPath) }}" type="video/mp4">
                                    </video>
                                    @else
                                    <img src="{{ asset('storage/' . $firstMediaPath) }}" alt="{{ $story->title }}" class="exclusive-story-image">
                                    @endif
                                    @else
                                    <div class="placeholder-image">
                                        <i class="ri-video-line"></i>
                                    </div>
                                    @endif
                                    <div class="story-type-badge video-badge">
                                        <i class="ri-play-circle-line"></i> VIDEO
                                    </div>
                                    @else
                                    <div class="placeholder-image">
                                        <i class="ri-image-line"></i>
                                    </div>
                                    @endif
                                </div>
                                <div class="uk-card-body">
                                    <h3 class="uk-card-title exclusive-story-title">{{ $story->title }}</h3>
                                    @if($story->description)
                                    <p class="exclusive-story-description">{{ Str::limit($story->description, 100) }}</p>
                                    @endif
                                    <div class="story-meta">
                                        <span class="story-date">
                                            <i class="ri-time-line"></i> {{ $story->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                    <a href="{{ route('exclusive-story.show', $story->id) }}" class="uk-button uk-button-primary uk-button-small uk-margin-small-top">
                                        View {{ $story->type === 'photos' ? 'Gallery' : 'Video' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
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