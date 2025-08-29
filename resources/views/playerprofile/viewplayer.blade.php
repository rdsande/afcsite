@extends('layouts.app')
<!-- Chart Js -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')


<!-- Header Container Players -->
<div class="uk-section head-inner">
    <div class="uk-grid-collapse uk-child-width-expand@s uk-text-center uk-grid-match players-section-container" uk-grid>
        <div>
            <div class="uk-bg-highlight bg-h-light uk-padding">
                <div class="plyr-container" uk-scrollspy="cls: uk-animation-fade; target: .uk-card; delay: 100; repeat: true">
                    @if($player->profile_image)
                        <img src="{{ asset('storage/' . $player->profile_image) }}" class="playerprfl" loading="lazy" alt="{{ $player->name }}" />
                    @else
                        <img src="{{asset('img/players/profiles/default.png')}}" class="playerprfl" loading="lazy" alt="{{ $player->name }}" />
                    @endif
                </div>
                <div class="player-no">
                    <h1>{{ $player->jersey_number ?? 'N/A' }}</h1>
                </div>
                <div class="player-pos">
                    <h1>{{ $player->jersey_number ?? 'N/A' }}</h1>
                    <a href="/"><span class="uk-label">{{ strtoupper($player->team_category ?? 'TEAM') }}</span></a>
                </div>
            </div>
        </div>
        <div>
            <div class="uk-background-primary uk-padding uk-light">
                <div class="player-details-info" uk-scrollspy="cls: uk-animation-fade; target: .uk-card; delay: 100; repeat: true">
                    <h3>{{ strtoupper($player->name) }}</h3>
                    <h2 class="uk-heading-line uk-text-right uk-text-warning posspan">
                        <span>{{ strtoupper($player->position ?? 'PLAYER') }}</span>
                    </h2>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Player Summary top -->
<div class="uk-section bg-white-type-two sec-relative brd-down contain-short-stats">
    <div class="uk-container uk-container-medium">
        <div class="uk-grid-small uk-child-width-expand@s uk-text-center shadow-two" uk-grid uk-height-match uk-scrollspy="cls: uk-animation-fade; target: .uk-card; delay: 100; repeat: false">
            <div>
                <div class="uk-card uk-card-default uk-card-body inner-info-plyr">
                    <div uk-grid>
                        <div class="uk-width-auto@m">
                            <img src="{{ asset('img/icons/formation.svg')}}" class="icon-item" />
                        </div>
                        <div class="uk-width-expand@m">
                            <span class="title-sm-main">POSITION<br /></span>
                            <span class="title-sm-tp">{{ strtoupper($player->position ?? 'N/A') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-body inner-info-plyr">
                    <div uk-grid>
                        <div class="uk-width-auto@m">
                            <img src="{{ asset('img/icons/flag.svg')}}" class="icon-item" />
                        </div>
                        <div class="uk-width-expand@m">
                            <span class="title-sm-main">NATIONALITY <br /></span>
                            <span class="title-sm-tp">{{ strtoupper($player->nationality ?? 'N/A') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-body inner-info-plyr">
                    <div uk-grid>
                        <div class="uk-width-auto@m">
                            <img src="{{ asset('img/icons/time.svg')}}" class="icon-item" />
                        </div>
                        <div class="uk-width-expand@m plyr-birthdate">
                            <span class="title-sm-main">BIRTHDATE<br /></span>
                            <span class="title-sm-tp">{{ $player->date_of_birth ? \Carbon\Carbon::parse($player->date_of_birth)->format('d/m/Y') : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-body inner-info-plyr">
                    <div uk-grid>
                        <div class="uk-width-auto@m">
                            <img src="{{ asset('img/icons/pitch.svg')}}" class="icon-item" />
                        </div>
                        <div class="uk-width-expand@m">
                            <span class="title-sm-main">HEIGHT <br /></span>
                            <span class="title-sm-tp">{{ $player->height ? $player->height . 'm' : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="uk-card uk-card-default uk-card-body inner-info-plyr">
                    <div uk-grid>
                        <div class="uk-width-auto@m">
                            <img src="{{ asset('img/icons/gametime.svg')}}" class="icon-item" />
                        </div>
                        <div class="uk-width-expand@m">
                            <span class="title-sm-main">AGE <br /></span>
                            <span class="title-sm-tp">{{ $player->date_of_birth ? \Carbon\Carbon::parse($player->date_of_birth)->age . ' years' : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Player Details -->
<div class="uk-section whiteptn ptn4">
    <div class="uk-container uk-container-medium">
        <div class="uk-position-relative uk-margin-medium js-example playr-profile-info">

            <ul uk-tab="swiping: false" role="tablist" class="uk-tab">
                <li class="uk-active" role="presentation"><a href="#" aria-selected="true" role="tab" id="uk-tab-5-tab-0" aria-controls="uk-tab-5-tabpanel-0">Profile</a></li>
                <li role="presentation" class=""><a href="#" aria-selected="false" role="tab" id="uk-tab-5-tab-1" aria-controls="uk-tab-5-tabpanel-1" tabindex="-1">Stats</a></li>
            </ul>

            <ul class="uk-switcher" role="presentation">
                <li class="uk-active" id="uk-tab-5-tabpanel-0" role="tabpanel" aria-labelledby="uk-tab-5-tab-0">
                    <!-- Player Bio -->
                    <div class="uk-grid-small uk-child-width-expand@s uk-text-center" uk-grid>
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <div>
                                    {{ $player->biography ?? 'No biography available for this player yet.' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    

                </li>
                <li id="uk-tab-5-tabpanel-1" role="tabpanel" aria-labelledby="uk-tab-5-tab-1" class="">
                    <!-- Player stats -->
                    <div class="uk-grid-small uk-child-width-expand@s uk-text-center" uk-grid>
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                            <div class="grid">
                                <p> <strong>*</strong> Note: This is illustrative data, real data will be updated soon. Thanks </p>
                            </div>
                                <div class="uk-child-width-expand@s uk-text-center stats-inner" uk-grid>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-body">
                                            <div class="widget-header-wrapper ">
                                                <div class="widget-header-wrapper__header">
                                                    <header class="widget-header  ">
                                                        <h3 class="widget-header__title"> GOALS </h3>
                                                    </header>
                                                </div>
                                            </div>
                                            <div class="stat-cont">
                                                <span class="statmainitem"> Total Goals: <span class="statvalue"> {{ ($player->goals_inside_box ?? 0) + ($player->goals_outside_box ?? 0) }}
                                                    </span> | Assists: <span class="statvalue"> {{ $player->assists ?? 0 }} </span></span>
                                                <img src="{{asset('img/icons/goal.png')}}" class="goalstat">

                                                <!-- Goal Stats -->
                                                <div class="goals-box" uk-tooltip="title: Goals inside the box">{{ $player->goals_inside_box ?? 0 }}</div>
                                                <div class="goals-not-box" uk-tooltip="title: Goals outside of the box">
                                                    {{ $player->goals_outside_box ?? 0 }}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-body">
                                            <div class="widget-header-wrapper ">
                                                <div class="widget-header-wrapper__header">
                                                    <header class="widget-header  ">
                                                        <h3 class="widget-header__title"> ATTACKING </h3>
                                                    </header>
                                                </div>
                                            </div>
                                            <div class="stat-cont">
                                                <canvas id="attackingStats" width="400" height="400" 
                                                    data-goals-inside="{{ $player->goals_inside_box ?? 0 }}" 
                                                    data-goals-outside="{{ $player->goals_outside_box ?? 0 }}" 
                                                    data-assists="{{ $player->assists ?? 0 }}" 
                                                    data-passes-completed="{{ $player->passes_completed ?? 0 }}"></canvas>
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        var ctx = document.getElementById('attackingStats');
                                                        if (ctx) {
                                                            ctx = ctx.getContext('2d');
                                                            
                                                            var goalsInside = parseInt(ctx.canvas.getAttribute('data-goals-inside')) || 0;
                                                            var goalsOutside = parseInt(ctx.canvas.getAttribute('data-goals-outside')) || 0;
                                                            var assists = parseInt(ctx.canvas.getAttribute('data-assists')) || 0;
                                                            var passesCompleted = parseInt(ctx.canvas.getAttribute('data-passes-completed')) || 0;
                                                            
                                                            var attackingData = {
                                                                labels: ['Goals (Inside Box)', 'Goals (Outside Box)', 'Assists', 'Passes Completed'],
                                                                datasets: [{
                                                                    data: [goalsInside, goalsOutside, assists, passesCompleted],
                                                                    backgroundColor: ['#28a745', '#17a2b8', '#ffc107', '#6f42c1']
                                                                }]
                                                            };

                                                            var attackingChart = new Chart(ctx, {
                                                                type: 'pie',
                                                                data: attackingData,
                                                                options: {
                                                                    responsive: true,
                                                                    plugins: {
                                                                        legend: {
                                                                            display: true,
                                                                            position: 'bottom'
                                                                        },
                                                                        tooltip: {
                                                                            callbacks: {
                                                                                label: function(context) {
                                                                                    return context.label + ': ' + context.parsed;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            });
                                                        }
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-body">
                                            <div class="widget-header-wrapper ">
                                                <div class="widget-header-wrapper__header">
                                                    <header class="widget-header  ">
                                                        <h3 class="widget-header__title"> DEFENDING </h3>
                                                    </header>
                                                </div>
                                            </div>
                                            <div class="stat-cont">
                                                <ul class="uk-list uk-list-divider">
                                                    <li>
                                                        <div class="uk-grid-small defending-stat" uk-grid>
                                                            <div class="uk-width-expand" uk-leader>Tackles Won</div>
                                                            <div><span class="num-first">{{ $player->tackles_won ?? 0 }}</span><span class="num-compare">/{{ ($player->tackles_won ?? 0) + ($player->tackles_lost ?? 0) }}</span></div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="uk-grid-small defending-stat" uk-grid>
                                                            <div class="uk-width-expand" uk-leader>Interceptions</div>
                                                            <div><span class="num-first">{{ $player->interceptions ?? 0 }}</span></div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="uk-grid-small defending-stat" uk-grid>
                                                            <div class="uk-width-expand" uk-leader>Clearances</div>
                                                            <div><span class="num-first">{{ $player->clearances ?? 0 }}</span></div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="uk-grid-small defending-stat" uk-grid>
                                                            <div class="uk-width-expand" uk-leader>Blocks</div>
                                                            <div><span class="num-first">{{ $player->blocks ?? 0 }}</span></div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- Video reel -->
    <div class="uk-container uk-container-medium uk-margin">
        <div class="uk-grid-small uk-child-width-expand@s uk-text-center" uk-grid>
            <div>
                <div class="uk-card uk-card-default uk-card-body">
                    <div>
                        <h3> <i class="ri-clapperboard-line"></i> VIDEO SHOWREEL</h3>
                        <div class="uk-margin uk-text-center">
                            @if($player->video_reel_link)
                                <div class="player-video-showreel">
                                    {!! $player->video_reel_link !!}
                                </div>
                            @else
                                <button class="uk-button uk-button-default uk-button-large" disabled>
                                    <i class="ri-play-circle-line"></i> Video Reel Coming Soon
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     
</div>

<!-- Players Related -->
<div class="uk-section bg-gradient-one players-section">
    <div class="uk-container uk-container-medium">
        <div class="floating-results-one shadow-one">
            <!-- Post Header -->
            <div class="widget-header-wrapper light">
                <div class="widget-header-wrapper__header">
                    <header class="widget-header  ">
                        <h2 class="widget-header__title">OTHER PLAYERS</h2>
                    </header>
                </div>

                <div class="widget-header-wrapper__content ">
                    <div class="uk-inline">
                    </div>
                </div>
            </div>
            <!-- Related Players -->
            <div class="results-fixtures-carousel ">
                <div class="uk-section">
                    <div class="uk-container uk-container-medium">
                        <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>

                            <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@m uk-grid">
                                @forelse($relatedPlayers as $relatedPlayer)
                                <li>
                                    <a href="{{ route('player.show', $relatedPlayer->id) }}">
                                        <div>
                                            <div class="uk-card uk-card-default uk-card-body uk-animation-toggle" tabindex="0">
                                                <div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                                                    <span class="bgtop"></span>
                                                    <img loading="lazy" class="uk-transition-scale-up uk-transition-opaque" 
                                                         src="{{ $relatedPlayer->profile_image ? asset('storage/' . $relatedPlayer->profile_image) : asset('/img/players/profiles/default.png') }}" 
                                                         width="1800" height="1200" alt="{{ $relatedPlayer->name }}">
                                                </div>
                                                <div class="player-card-details uk-animation-slide-bottom-medium">
                                                    <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                                                        <div>
                                                            <span class="uk-heading-divider">{{ strtoupper($relatedPlayer->name) }}</span>
                                                            <span class="pos-player">{{ $relatedPlayer->position }}</span>
                                                        </div>
                                                        <div>
                                                            <span class="plyr-number">
                                                                {{ $relatedPlayer->jersey_number ?? 'N/A' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                @empty
                                <li>
                                    <div class="uk-card uk-card-default uk-card-body">
                                        <div class="uk-text-center">
                                            <p>No related players found.</p>
                                        </div>
                                    </div>
                                </li>
                                @endforelse
                            </ul>
                            <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                            <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="spacer-3r"></div>
</div>


@endsection

@push('styles')
<style>
.player-video-content {
    line-height: 1.6;
}

.player-video-content iframe {
    max-width: 100%;
    height: auto;
    min-height: 315px;
    border-radius: 8px;
}

.player-video-content p {
    margin-bottom: 1rem;
}

.player-video-content a {
    color: #1e87f0;
    text-decoration: none;
}

.player-video-content a:hover {
    text-decoration: underline;
}

/* Responsive video embeds */
.player-video-content .ql-video {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    height: 0;
    overflow: hidden;
}

.player-video-content .ql-video iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

/* Video Showreel Styling */
.player-video-showreel {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}

.player-video-showreel iframe {
    width: 100%;
    height: 450px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.player-video-showreel .ql-video {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    height: 0;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.player-video-showreel .ql-video iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 8px;
}

.player-video-showreel p {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 15px;
}

.player-video-showreel a {
    color: #1e87f0;
    text-decoration: none;
    font-weight: 500;
}

.player-video-showreel a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .player-video-showreel {
        max-width: 100%;
        padding: 0 15px;
    }
    
    .player-video-showreel iframe {
        height: 250px;
    }
}
</style>
@endpush