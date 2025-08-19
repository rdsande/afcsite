@extends('layouts.app')
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc">
    <div class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle"
        style="background-image: url(img/breadcrumbs/image3.png);">
        <h1 class="page-title"> MATCH </h1>
    </div>
</div>

<!-- Section begin -->
<div class="uk-section pull-top-two whiteptn match-inner">
    <div class="uk-container uk-container-large">
        <div class="home-posts team-section shadow-one">
            <div class="posts-type-one match-view">
                <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                    <!-- Main Content Side -->
                    <div class="uk-width-3-4">
                        <div class="uk-padding">
                            <!-- Slideshow -->
                            <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1"
                                uk-slideshow="autoplay: true, animation: fade">

                                <ul class="uk-slideshow-items">
                                    <li>
                                        <img src="{{ asset('img/latest/djuma.jpg')}}" alt="" uk-cover>
                                    </li>
                                    <li>
                                        <img src="{{ asset('img/latest/afcmikoani.jpg')}}" alt="" uk-cover>
                                    </li>
                                </ul>

                                <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#"
                                    uk-slidenav-previous uk-slideshow-item="previous"></a>
                                <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#"
                                    uk-slidenav-next uk-slideshow-item="next"></a>

                            </div>
                            <!-- Contents -->
                            <!-- Match Stats -->
                            <div class="uk-margin">
                                <div>
                                    <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1"
                                        uk-slider="autoplay: true, autoplay-interval: 500">

                                        <ul class="uk-slider-items uk-child-width-1-5@m uk-grid uk-padding stats-cards">
                                            <!-- Game stat -->
                                            <li>
                                                <div>
                                                    <div class="uk-card uk-card-default uk-card-body uk-animation-toggle"
                                                        tabindex="0">
                                                        <h4>Posession</h4>
                                                        <!-- <div>
                                                            <div class="stat-cont">
                                                                <canvas id="gameStats" width="100%"></canvas>
                                                                <script>
                                                                var ctx = document.getElementById('gameStats')
                                                                    .getContext('2d');

                                                                // Define your data
                                                                var data = {
                                                                    labels: ['Home(%)', 'Away(%)'],
                                                                    datasets: [{
                                                                        data: [70, 30],
                                                                        backgroundColor: ['red', '#3334b1'],
                                                                    }]
                                                                };

                                                                // Create the doughnut chart
                                                                var gameStats = new Chart(ctx, {
                                                                    type: 'doughnut',
                                                                    data: data,
                                                                    options: {
                                                                        plugins: {
                                                                            datalabels: {
                                                                                color: 'white',
                                                                                formatter: function(value,
                                                                                    context) {
                                                                                    return value +
                                                                                        '%';
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                });
                                                                </script>

                                                            </div>
                                                        </div> -->
                                                        <div class="grid" uk-grid>
                                                            <div class="uk-width-1-2">
                                                                <span class="stat-item1">HOME</span>
                                                                <h3 class="stat-item2">60%</h3>
                                                            </div>
                                                            <div class="uk-width-1-2">
                                                                <span class="stat-item1">AWAY</span>
                                                                <h3 class="stat-item2 away">40%</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- Game stat -->
                                            <li>
                                                <div>
                                                    <div class="uk-card uk-card-default uk-card-body uk-animation-toggle"
                                                        tabindex="0">
                                                        <h4>Total Shots</h4>
                                                        <div class="grid" uk-grid>
                                                            <div class="uk-width-1-2">
                                                                <span class="stat-item1">HOME</span>
                                                                <h3 class="stat-item2">60%</h3>
                                                            </div>
                                                            <div class="uk-width-1-2">
                                                                <span class="stat-item1">AWAY</span>
                                                                <h3 class="stat-item2 away">40%</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- Game stat -->
                                            <li>
                                                <div>
                                                    <div class="uk-card uk-card-default uk-card-body uk-animation-toggle"
                                                        tabindex="0">
                                                        <h4>Shots on Target</h4>
                                                        <div class="grid" uk-grid>
                                                            <div class="uk-width-1-2">
                                                                <span class="stat-item1">HOME</span>
                                                                <h3 class="stat-item2">60%</h3>
                                                            </div>
                                                            <div class="uk-width-1-2">
                                                                <span class="stat-item1">AWAY</span>
                                                                <h3 class="stat-item2 away">40%</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- Game stat -->
                                            <li>
                                                <div>
                                                    <div class="uk-card uk-card-default uk-card-body uk-animation-toggle"
                                                        tabindex="0">
                                                        <h4>Total Passes</h4>
                                                        <div class="grid" uk-grid>
                                                            <div class="uk-width-1-2">
                                                                <span class="stat-item1">HOME</span>
                                                                <h3 class="stat-item2">60%</h3>
                                                            </div>
                                                            <div class="uk-width-1-2">
                                                                <span class="stat-item1">AWAY</span>
                                                                <h3 class="stat-item2 away">40%</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- Game stat -->
                                            <li>
                                                <div>
                                                    <div class="uk-card uk-card-default uk-card-body uk-animation-toggle"
                                                        tabindex="0">
                                                        <h4>Passes Completed</h4>
                                                        <div class="grid" uk-grid>
                                                            <div class="uk-width-1-2">
                                                                <span class="stat-item1">HOME</span>
                                                                <h3 class="stat-item2">60%</h3>
                                                            </div>
                                                            <div class="uk-width-1-2">
                                                                <span class="stat-item1">AWAY</span>
                                                                <h3 class="stat-item2 away">40%</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- Game stat -->
                                            <li>
                                                <div>
                                                    <div class="uk-card uk-card-default uk-card-body uk-animation-toggle"
                                                        tabindex="0">
                                                        <h4>Tackles Won</h4>
                                                        <div class="grid" uk-grid>
                                                            <div class="uk-width-1-2">
                                                                <span class="stat-item1">HOME</span>
                                                                <h3 class="stat-item2">60%</h3>
                                                            </div>
                                                            <div class="uk-width-1-2">
                                                                <span class="stat-item1">AWAY</span>
                                                                <h3 class="stat-item2 away">40%</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <!-- Game stat -->
                                            <li>
                                                <div>
                                                    <div class="uk-card uk-card-default uk-card-body uk-animation-toggle"
                                                        tabindex="0">
                                                        <h4>Aerial Duels Won</h4>
                                                        <div class="grid" uk-grid>
                                                            <div class="uk-width-1-2">
                                                                <span class="stat-item1">HOME</span>
                                                                <h3 class="stat-item2">60%</h3>
                                                            </div>
                                                            <div class="uk-width-1-2">
                                                                <span class="stat-item1">AWAY</span>
                                                                <h3 class="stat-item2 away">40%</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#"
                                            uk-slidenav-previous uk-slider-item="previous"></a>
                                        <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#"
                                            uk-slidenav-next uk-slider-item="next"></a>
                                    </div>
                                </div>
                            </div>
                            <!-- Post content -->
                            <div uk-grid class="uk-margin">
                                <div>
                                    <div class="uk-card uk-card-hover uk-card-body uk-text-left">
                                        <h3 class="uk-card-title">AZAM FC YAIBUKA NA USHINDI</h3>
                                        <p>
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime
                                            mollitia,
                                            molestiae quas vel sint commodi repudiandae consequuntur voluptatum
                                            laborum
                                            numquam blanditiis harum quisquam eius sed odit fugiat iusto fuga
                                            praesentium
                                            optio, eaque rerum! Provident similique accusantium nemo autem.
                                            Veritatis
                                            obcaecati tenetur iure eius earum ut molestias architecto voluptate
                                            aliquam
                                            nihil, eveniet aliquid culpa officia aut! Impedit sit sunt quaerat,
                                            odit,
                                            tenetur error, harum nesciunt ipsum debitis quas aliquid. Reprehenderit,
                                            quia.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Side content side -->
                    <div class="uk-width-1-4 uk-background-secondary is-primary">
                        <!-- Match Widget -->
                        <div>
                            <div class="inner-fixtures">
                                <h3> <img src="{{asset('img/league/nbc.png')}}" class="compt-logo"> NBC PREMIER
                                    LEAGUE
                                </h3>
                                <p> WED 16, 2023 </p>
                                <p> AZAM COMPLEX, CHAMAZI</p>
                                <div class="teams-inner-container">
                                    <div class="team-disp-1">
                                        <img src="{{ asset('img/logo.png')}}" class="logo-card-item" alt="Team Logo" />
                                    </div>
                                    <div class="team-disp-1 results-section">
                                        <div class="scr-card">
                                            <span class="hm-team-score">
                                                4
                                            </span>
                                            :
                                            <span class="hm-team-score">
                                                0
                                            </span>

                                        </div>
                                    </div>
                                    <div class="team-disp-1">
                                        <img src="{{ asset('img/teamlogos/tabora.png')}}" class="logo-card-item"
                                            alt="Team Logo" />
                                    </div>
                                </div>
                                <div class="fxture">
                                    <span class="homteam">
                                        AZAM FC
                                    </span>
                                    <span class="faintcol"> VS </span>
                                    <span class="homteam">
                                        TABORA UTD
                                    </span>
                                </div>
                                <div uk-grid>
                                    <div>
                                        <ul class="uk-list uk-align-right">
                                            <li>Feisal <i class="ri-football-line"></i><i
                                                    class="ri-football-line"></i><i class="ri-football-line"></i>
                                            </li>
                                            <li>Dube <i class="ri-football-line"></i></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <ul class="uk-list uk-align-right">
                                            <li></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lineups -->
                        <div class="uk=padding">
                            <div class="widget-header-wrapper-two">
                                <h1 class="uk-heading-divider">LINE-UPS</h1>
                            </div>
                        </div>
                        <div class="uk-grid lineupscol" uk-grid>
                            <div class="uk-width-1-2">
                                <!-- Header -->
                                <h4>Home</h4>
                                <ul class="uk-list">
                                    <li>
                                        <div class="lineup-plyr">
                                            <img src="{{asset('img/players/profiles/player12.png')}}" width="50"
                                                height="50">
                                            <span class="uk-text-middle">Lorem</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="lineup-plyr">
                                            <img src="{{asset('img/players/profiles/player15.png')}}" width="50"
                                                height="50">
                                            <span class="uk-text-middle">Lorem</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="lineup-plyr">
                                            <img src="{{asset('img/players/profiles/player15.png')}}" width="50"
                                                height="50">
                                            <span class="uk-text-middle">Lorem.
                                                <span class="sub-items">
                                                    <span class="sub-item">
                                                        <span class="sub-in off">
                                                            <i class="ri-arrow-right-line"></i> 50
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="lineup-plyr">
                                            <img src="{{asset('img/players/profiles/player15.png')}}" width="50"
                                                height="50">
                                            <span class="uk-text-middle">Lorem
                                                <span class="sub-items">
                                                    <span class="sub-item">
                                                        <span class="sub-in on">
                                                            <i class="ri-arrow-left-line"></i> 50
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="uk-width-1-2">
                                <h4>Away</h4>
                                <ul class="uk-list">
                                    <li>1. Lorem Ipsum</li>
                                    <li>2. Lorem Ipsum</li>
                                    <li>3. Lorem Ipsum</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Subs -->
                        <div class="uk=padding">
                            <div class="widget-header-wrapper-two">
                                <h1 class="uk-heading-divider">SUBSTITUTES</h1>
                            </div>
                        </div>
                        <div class="uk-grid lineupscol" uk-grid>
                            <div class="uk-width-1-2">
                                <!-- Header -->
                                <h4>Home</h4>
                                <ul class="uk-list">
                                    <li>
                                        <div class="lineup-plyr">
                                            <img src="{{asset('img/players/profiles/player12.png')}}" width="50"
                                                height="50">
                                            <span class="uk-text-middle">Lorem</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="lineup-plyr">
                                            <img src="{{asset('img/players/profiles/player15.png')}}" width="50"
                                                height="50">
                                            <span class="uk-text-middle">Lorem</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="lineup-plyr">
                                            <img src="{{asset('img/players/profiles/player15.png')}}" width="50"
                                                height="50">
                                            <span class="uk-text-middle">Lorem.
                                                <span class="sub-items">
                                                    <span class="sub-item">
                                                        <span class="sub-in off">
                                                            <i class="ri-arrow-right-line"></i> 50
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>

                                        </div>
                                    </li>
                                    <li>
                                        <div class="lineup-plyr">
                                            <img src="{{asset('img/players/profiles/player15.png')}}" width="50"
                                                height="50">
                                            <span class="uk-text-middle">Lorem
                                                <span class="sub-items">
                                                    <span class="sub-item">
                                                        <span class="sub-in on">
                                                            <i class="ri-arrow-left-line"></i> 50
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="uk-width-1-2">
                                <h4>Away</h4>
                                <ul class="uk-list">
                                    <li>1. Lorem Ipsum</li>
                                    <li>2. Lorem Ipsum</li>
                                    <li>3. Lorem Ipsum</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection