@extends('layouts.app')

@section('content')

<!-- Sort -->

<!-- Breadcrumb -->
<div class="page-brdc">
    <div class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" style="background-image: url(img/breadcrumbs/image1.png);">
        <h1 class="page-title"> UNDER 15 ACADEMY <a href="https://www.youtube.com/@azamfootballyouthdevelopme5884"><button class="uk-button uk-button-danger">View Channel <i class="ri-youtube-line"></i></button></a> </h1>
    </div>
</div>

<!-- Section begin -->
<div class="uk-section pull-top-two whiteptn team-inner pllist">
    <div class="uk-container uk-container-medium">
        <div class="home-posts team-section shadow-one">

            <!-- Team -->

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
                <div class="uk-grid-column-small uk-grid-row-large uk-child-width-1-3@s uk-text-center" uk-grid>
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
                <div class="uk-grid-column-small uk-grid-row-large uk-child-width-1-4@s uk-text-center" uk-grid>
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
                <div class="uk-grid-column-small uk-grid-row-large uk-child-width-1-4@s uk-text-center" uk-grid>
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
                <div class="uk-grid-column-small uk-grid-row-large uk-child-width-1-4@s uk-text-center" uk-grid>
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
            </div>
        </div>
    </div>
</div>
@endsection