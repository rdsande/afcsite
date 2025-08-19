@extends('layouts.app')

@section('content')

<!-- Sort -->

<!-- Breadcrumb -->
<div class="page-brdc">
    <div class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" style="background-image: url(img/breadcrumbs/image1.png);">
        <h1 class="page-title"> SENIOR TEAM </h1>
    </div>
</div>

<!-- Section begin -->
<div class="uk-section pull-top-two whiteptn team-inner pllist">
    <div class="uk-container uk-container-medium">
        <div class="home-posts team-section shadow-one">
            <div class="uk-padding psmall topsort">
                <span class="primarysort">SORT BY SEASON</span>
                <div class="quicknavposts">
                    <nav class="uk-navbar-container">
                        <div class="uk-container">
                            <div uk-navbar>

                                <div class="uk-navbar-left">

                                    <ul class="uk-navbar-nav plyrposition">
                                        <li><a href="#gk" uk-scroll>Goalkeepers</a></li>
                                        <li> <a href="#def" uk-scroll>Defenders</a></li>
                                        <li><a href="#mid" uk-scroll>Midfielders</a></li>
                                        <li><a href="#fw" uk-scroll>Forwards</a></li>
                                    </ul>

                                </div>

                            </div>
                        </div>
                    </nav>
                </div>
                <h4 class="uk-heading-line uk-text-right">
                    <div class="uk-margin">
                        <div class="uk-form-controls">
                            <select class="uk-select" id="form-stacked-select">
                                <option>2023/2024</option>
                                <option>2022/2023</option>
                                <option>2022/2021</option>
                                <option>2021/2020</option>
                                <option>2020/2019</option>
                            </select>
                        </div>
                    </div>
                </h4>
            </div>
            <div class="posts-type-one team-display">
                <!-- Goalkeepers -->
                <!-- Header -->
                <div class="widget-header-wrapper first">
                    <div class="widget-header-wrapper__header">
                        <header class="widget-header  ">
                            <h2 class="widget-header__title">Goalkeepers</h2>
                        </header>
                    </div>
                </div>
                <div id="gk" class="uk-grid-column-small uk-grid-row-large uk-child-width-1-3@s uk-text-center" uk-grid>
                    @if(isset($players['Goalkeeper']) && $players['Goalkeeper']->count() > 0)
                        @foreach($players['Goalkeeper'] as $player)
                            <div>
                                <a href="{{ route('player.show', $player->id) }}">
                                    <div class="uk-card uk-card-default uk-card-body uk-animation-toggle" tabindex="0">
                                        <div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                                            <span class="bgtop"></span>
                                            <img loading="lazy" class="uk-transition-scale-up uk-transition-opaque" 
                                                 src="{{ $player->profile_image ? asset('storage/' . $player->profile_image) : asset('/img/players/profiles/default.png') }}" 
                                                 width="1800" height="1200" alt="{{ $player->name }}">
                                        </div>
                                        <div class="player-card-details uk-animation-slide-bottom-medium">
                                            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                                                <div>
                                                    <span class="uk-heading-divider">{{ strtoupper($player->name) }}</span>
                                                    <span class="pos-player">{{ $player->position }}</span>
                                                </div>
                                                <div>
                                                    <span class="plyr-number">{{ $player->jersey_number ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="uk-text-center">
                            <p>No goalkeepers available.</p>
                        </div>
                    @endif
                </div>

                <!-- Defenders -->
                <!-- Header -->
                <div class="widget-header-wrapper ">
                    <div class="widget-header-wrapper__header">
                        <header class="widget-header  ">
                            <h2 class="widget-header__title">DEFENDERS</h2>
                        </header>
                    </div>
                </div>
                <div id="def" class="uk-grid-column-small uk-grid-row-large uk-child-width-1-4@s uk-text-center" uk-grid>
                    @if(isset($players['Defender']) && $players['Defender']->count() > 0)
                        @foreach($players['Defender'] as $player)
                            <div>
                                <a href="{{ route('player.show', $player->id) }}">
                                    <div class="uk-card uk-card-default uk-card-body uk-animation-toggle" tabindex="0">
                                        <div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                                            <span class="bgtop"></span>
                                            <img loading="lazy" class="uk-transition-scale-up uk-transition-opaque" 
                                                 src="{{ $player->profile_image ? asset('storage/' . $player->profile_image) : asset('/img/players/profiles/default.png') }}" 
                                                 width="1800" height="1200" alt="{{ $player->name }}">
                                        </div>
                                        <div class="player-card-details uk-animation-slide-bottom-medium">
                                            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                                                <div>
                                                    <span class="uk-heading-divider">{{ strtoupper($player->name) }}</span>
                                                    <span class="pos-player">{{ $player->position }}</span>
                                                </div>
                                                <div>
                                                    <span class="plyr-number">{{ $player->jersey_number ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="uk-text-center">
                            <p>No defenders available.</p>
                        </div>
                    @endif
                </div>

                <!-- Midfielders -->
                <!-- Header -->
                <div class="widget-header-wrapper ">
                    <div class="widget-header-wrapper__header">
                        <header class="widget-header  ">
                            <h2 class="widget-header__title">MIDFIELDERS</h2>
                        </header>
                    </div>
                </div>
                <div id="mid" class="uk-grid-column-small uk-grid-row-large uk-child-width-1-4@s uk-text-center" uk-grid>
                    @if(isset($players['Midfielder']) && $players['Midfielder']->count() > 0)
                        @foreach($players['Midfielder'] as $player)
                            <div>
                                <a href="{{ route('player.show', $player->id) }}">
                                    <div class="uk-card uk-card-default uk-card-body uk-animation-toggle" tabindex="0">
                                        <div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                                            <span class="bgtop"></span>
                                            <img loading="lazy" class="uk-transition-scale-up uk-transition-opaque" 
                                                 src="{{ $player->profile_image ? asset('storage/' . $player->profile_image) : asset('/img/players/profiles/default.png') }}" 
                                                 width="1800" height="1200" alt="{{ $player->name }}">
                                        </div>
                                        <div class="player-card-details uk-animation-slide-bottom-medium">
                                            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                                                <div>
                                                    <span class="uk-heading-divider">{{ strtoupper($player->name) }}</span>
                                                    <span class="pos-player">{{ $player->position }}</span>
                                                </div>
                                                <div>
                                                    <span class="plyr-number">{{ $player->jersey_number ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="uk-text-center">
                            <p>No midfielders available.</p>
                        </div>
                    @endif
                </div>

                <!-- Forwards -->
                <!-- Header -->
                <div class="widget-header-wrapper ">
                    <div class="widget-header-wrapper__header">
                        <header class="widget-header  ">
                            <h2 class="widget-header__title">FORWARDS</h2>
                        </header>
                    </div>
                </div>
                <div id="fw" class="uk-grid-column-small uk-grid-row-large uk-child-width-1-4@s uk-text-center" uk-grid>
                    @if(isset($players['Forward']) && $players['Forward']->count() > 0)
                        @foreach($players['Forward'] as $player)
                            <div>
                                <a href="{{ route('player.show', $player->id) }}">
                                    <div class="uk-card uk-card-default uk-card-body uk-animation-toggle" tabindex="0">
                                        <div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                                            <span class="bgtop"></span>
                                            <img loading="lazy" class="uk-transition-scale-up uk-transition-opaque" 
                                                 src="{{ $player->profile_image ? asset('storage/' . $player->profile_image) : asset('/img/players/profiles/default.png') }}" 
                                                 width="1800" height="1200" alt="{{ $player->name }}">
                                        </div>
                                        <div class="player-card-details uk-animation-slide-bottom-medium">
                                            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                                                <div>
                                                    <span class="uk-heading-divider">{{ strtoupper($player->name) }}</span>
                                                    <span class="pos-player">{{ $player->position }}</span>
                                                </div>
                                                <div>
                                                    <span class="plyr-number">{{ $player->jersey_number ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="uk-text-center">
                            <p>No forwards available.</p>
                        </div>
                    @endif
                </div>
                <!-- Forwards -->
                <!-- Header -->
                <div class="widget-header-wrapper ">
                    <div class="widget-header-wrapper__header">
                        <header class="widget-header  ">
                            <h2 class="widget-header__title">MANAGEMENT</h2>
                        </header>
                    </div>
                </div>
                <div id="mgmt" class="uk-grid-column-small uk-grid-row-large uk-child-width-1-4@s uk-text-center" uk-grid>
                    @if(isset($players['Management']) && $players['Management']->count() > 0)
                        @foreach($players['Management'] as $player)
                            <div>
                                <a href="{{ route('player.show', $player->id) }}">
                                    <div class="uk-card uk-card-default uk-card-body uk-animation-toggle" tabindex="0">
                                        <div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                                            <span class="bgtop"></span>
                                            <img loading="lazy" class="uk-transition-scale-up uk-transition-opaque" 
                                                 src="{{ $player->profile_image ? asset('storage/' . $player->profile_image) : asset('/img/players/profiles/default.png') }}" 
                                                 width="1800" height="1200" alt="{{ $player->name }}">
                                        </div>
                                        <div class="player-card-details uk-animation-slide-bottom-medium">
                                            <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                                                <div>
                                                    <span class="uk-heading-divider">{{ strtoupper($player->name) }}</span>
                                                    <span class="pos-player">{{ $player->position }}</span>
                                                </div>
                                                <div>
                                                    <span class="plyr-number">{{ $player->jersey_number ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="uk-text-center">
                            <p>No management staff available.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection