@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc">
    <div class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle"
        style="background-image: url(img/breadcrumbs/image2.png);">
        <h1 class="page-title"> ABOUT AZAMFC </h1>
    </div>
</div>

<!-- Section begin -->
<div class="uk-section pull-top-two whiteptn about-page">
    <div class="uk-container uk-container-medium">
        <div class="home-posts team-section shadow-one uk-padding">
            <div class="uk-section">
                <div class="uk-container">
                    <div class="uk-position-relative uk-margin-medium js-example about-vertical">

                        <ul uk-tab="swiping: false" role="tablist" class="uk-tab sidebar">
                            <li class="" role="presentation"><a href="#" aria-selected="true" role="tab"
                                    id="uk-tab-5-tab-0" aria-controls="uk-tab-5-tabpanel-0">About</a></li>
                            <li role="presentation" class=""><a href="#" aria-selected="false" role="tab"
                                    id="uk-tab-5-tab-1" aria-controls="uk-tab-5-tabpanel-1" tabindex="-1">Mission &
                                    Vision</a></li>
                            <li role="presentation" class=""><a href="#" aria-selected="false" role="tab"
                                    id="uk-tab-5-tab-2" aria-controls="uk-tab-5-tabpanel-2" tabindex="-1">Club
                                    History</a></li>
                            <li role="presentation" class=""><a href="#" aria-selected="false" role="tab"
                                    id="uk-tab-5-tab-3" aria-controls="uk-tab-5-tabpanel-3" tabindex="-1">Club Achievements</a></li>
                            <li role="presentation" class=""><a href="#" aria-selected="false" role="tab"
                                    id="uk-tab-5-tab-5" aria-controls="uk-tab-5-tabpanel-5" tabindex="-1">Azam
                                    Complex</a></li>
                            <li role="presentation" class="uk-active"><a href="#" aria-selected="false" role="tab"
                                    id="uk-tab-5-tab-6" aria-controls="uk-tab-5-tabpanel-6" tabindex="-1">Senior
                                    Management</a></li>
                            <li role="presentation" class=""><a href="#" aria-selected="false" role="tab"
                                    id="uk-tab-5-tab-7" aria-controls="uk-tab-5-tabpanel-7" tabindex="-1">Azam FC
                                    Board</a></li>
                        </ul>

                        <ul class="uk-switcher uk-margin sidemain uk-margin-large-bottom"" role=" presentation">
                            <!-- About -->
                            <li class="" id="uk-tab-5-tabpanel-0" role="tabpanel" aria-labelledby="uk-tab-5-tab-0">
                                <!-- About -->
                                <div class="uk-grid-small uk-child-width-expand@s" uk-grid>
                                    <div class="uk-container uk-container-medium">

                                        <div class="uk-column-1-2 uk-padding">
                                            <p>
                                                <img src="{{ asset('img/latest/afcmikoani.jpg')}}" />
                                            </p>

                                            <p>
                                                <!-- <h1 class="headings-normal"> WE ARE AZAM FOOTBALL CLUB!</h1> -->
                                                <span class="abt-content">
                                                    <p><strong>Azam Football Club</strong> is a
                                                        professional football
                                                        club based in Chamazi, Temeke, Dar es Salaam, Tanzania, that
                                                        competes in the Tanzanian Premier League. Nicknamed Wana
                                                        Lambalamba,
                                                        Chamazi Millionaires or the Bakers, the club was founded as
                                                        Mzizima
                                                        Football Club in 2004, changed its name to Azam Sports Club in
                                                        2005,
                                                        then Azam Football Club in 2006 and moved to its current
                                                        stadium,
                                                        Azam Complex Chamazi, in 2010.</p>

                                                    <p>Azam FC have won <strong><span class="prim-text">10
                                                                Trophies,</span></strong> one
                                                        Premier League, a record 5
                                                        Mapinduzi Cup, two Kagame Cup, one Tanzania FA Cup and one
                                                        Community
                                                        Shield.</p>

                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="uk-grid-small uk-child-width-expand@s go-down" uk-grid>
                                    <div class="uk-container uk-container-medium">
                                        <div class="box-scrl">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                    </div>
                                    </div>
                                </div> -->
                                <div class="uk-grid-small uk-child-width-expand@s" uk-grid>
                                    <!-- <div class="uk-container uk-container-medium uk-padding">

                                        <div class="uk-child-width-1-3@s uk-light" uk-grid>
                                            <div>
                                                <div class="uk-background-cover uk-height-small uk-panel uk-flex uk-flex-center uk-flex-middle"
                                                    style="background-image: url(img/events/azamteam.png);">
                                                    <p class="uk-h4">SENIOR MANAGEMENT</p>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="uk-background-contain uk-background-muted uk-height-small uk-panel uk-flex uk-flex-center uk-flex-middle"
                                                    style="background-image: url(img/events/preseason.jpg);">
                                                    <p class="uk-h4">CAREERS</p>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="uk-background-contain uk-background-muted uk-height-small uk-panel uk-flex uk-flex-center uk-flex-middle"
                                                    style="background-image: url(img/events/azamteam.png);">
                                                    <p class="uk-h4">COMMUNITY</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <img src="{{asset('img/unbeaten.jpg')}}" class="banner-inner-one"
                                        alt="unbeaten 2013/14" title="unbeaten champions" />
                                </div>

                                <div class="uk-grid-small uk-child-width-expand@s" uk-grid>
                                    <article class="uk-article uk-padding">
                                        <p>In the 2013/14 season, Azam FC won the league unbeaten, and by so doing, the
                                            club became only the second (after Simba SC 2009/10) to win the league
                                            without losing a single game.</p>

                                        <p>Azam FC were undefeated in the league (26 matches) in a run that stretched
                                            to a 38 games, from the 18th round of 2012/13 season to the 4th round of
                                            2014/15. In 2015, the club became the first in the history of Tanzanian
                                            clubs to win the Kagame Cup without conceding a goal.</p>

                                        <p class="uk-margin-large-bottom"> Azam FC is one of the most widely supported
                                            football
                                            clubs in Tanzania, and
                                            has rivalries with Yanga SC, Simba SC, Mtibwa Sugar FC and African Lyon.</p>

                                    </article>
                                </div>
                            </li>
                            <li id="uk-tab-5-tabpanel-1" role="tabpanel" aria-labelledby="uk-tab-5-tab-1" class="">
                                <!-- Mission & Vision -->
                                <div class="uk-grid-small uk-child-width-expand@s" uk-grid>
                                    <div class="uk-container uk-container-medium">
                                        <div class="uk-grid-collapse uk-child-width-expand@s uk-text-center" uk-grid>
                                            <div class="uk-height-medium">
                                                <div class="uk-background-muted uk-padding-large uk-text-center">
                                                    <h1 class="headings-normal uk-text-center"> OUR MISSION
                                                    </h1>
                                                    <span class="abt-content uk-padding">
                                                        To establish a professionally run and sustainable football club
                                                        on and off the field, that attracts experienced senior players
                                                        while developing young talent to bring success on the pitch for
                                                        its supportersand awareness to the Group's Flagship brand Azam.
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="uk-height-medium">
                                                <div class="uk-background-primary uk-padding-large uk-light">
                                                    <h1 class="headings-normal"> OUR VISION
                                                    </h1>
                                                    <span class="abt-content">
                                                        AZAM FC aspires to become an African Football Club powerhouse
                                                        with local and continental success, establishing a model for the
                                                        region while revolutionizing Tanzanian football at the
                                                        International level.
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Our Values -->

                                <div class="uk-padding">
                                    <h1 class="headings-normal uk-text-center"> OUR VALUES </h1>
                                </div>

                                <div class="uk-grid-small uk-child-width-expand@s uk-text-center uk-padding-small values-icons"
                                    uk-grid>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-body">
                                            <i class="ri-hand-heart-line"></i>
                                            Humility
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-body">
                                            <i class="ri-home-4-line"></i>
                                            Respect
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-body">
                                            <i class="ri-honour-line"></i>
                                            Intergrity
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-body">
                                            <i class="ri-team-line"></i>
                                            Teamwork
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-body">
                                            <i class="ri-trophy-line"></i>
                                            Great Effort
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-body">
                                            <i class="ri-focus-2-line"></i>
                                            Discpline
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-card uk-card-default uk-card-body">
                                            <i class="ri-award-line"></i>
                                            Ambition
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li id="uk-tab-5-tabpanel-2" role="tabpanel" aria-labelledby="uk-tab-5-tab-2" class="">
                                <!-- Club History -->
                                <div class="uk-grid-small uk-child-width-expand@s" uk-grid>
                                    @include('includes/about.founded')
                                </div>
                            </li>
                            <li id="uk-tab-5-tabpanel-3" role="tabpanel" aria-labelledby="uk-tab-5-tab-3" class="">
                                <!--Achievements -->
                                <div class="uk-grid-small uk-child-width-expand@s" uk-grid>
                                    <div class="uk-container uk-container-medium uk-width-1-1">
                                        <div class="uk-padding">
                                            <h4 class="uk-heading-line uk-text-left uk-padding">
                                                <span>
                                                    <select id="floorplanSelect" class="uk-select"
                                                        onchange="changeTab()">
                                                        <option value="tab-pane1">Senior Team</option>
                                                        <option value="tab-pane2">Under 13</option>
                                                        <option value="tab-pane3">Under 15</option>
                                                        <option value="tab-pane4">Under 17</option>
                                                        <option value="tab-pane5">Under 20</option>
                                                    </select>
                                        </div>
                                        </span>
                                        </h4>
                                    </div>
                                    <div
                                        class="uk-container uk-container-medium uk-width-1-1 inner-afc-cont tab-content">
                                        <div role="tabpanel" class="tab-pane fade active in" id="tab-pane1">
                                            @include('includes/about.trophies')
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="tab-pane2">
                                            @include('includes/about.trophiesu13')
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="tab-pane3">
                                            @include('includes/about.trophiesu15')
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="tab-pane4">
                                            @include('includes/about.trophiesu17')
                                        </div>
                                        <div role="tabpanel" class="tab-pane fade" id="tab-pane5">
                                            @include('includes/about.trophiesu20')
                                        </div>
                                    </div>
                                </div>

                                <script type="text/javascript">
                                function changeTab() {
                                    var selectValue = document.getElementById('floorplanSelect').value;
                                    var tabs = document.querySelectorAll('.tab-pane');

                                    tabs.forEach(function(tab) {
                                        tab.classList.remove('active', 'in');
                                    });

                                    var selectedTab = document.getElementById(selectValue);
                                    selectedTab.classList.add('active', 'in');
                                }
                                </script>

                            </li>
                            <li id="uk-tab-5-tabpanel-5" role="tabpanel" aria-labelledby="uk-tab-5-tab-5" class="">
                                <!-- Player stats -->
                                <div class="uk-grid-small uk-child-width-expand@s" uk-grid>
                                    <div class="uk-container uk-container-medium">
                                        <div class="uk-padding">
                                            <h1 class="headings-normal"> AZAM COMPLEX </h1>
                                        </div>
                                        <div class="uk-padding inner-afc-cont">
                                            @include('includes/about.chamazi')
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li id="uk-tab-5-tabpanel-6" role="tabpanel" aria-labelledby="uk-tab-5-tab-5"
                                class="uk-active">
                                <!-- Player stats -->
                                <div class="uk-grid-small uk-child-width-expand@s" uk-grid>
                                    <div class="uk-container uk-container-medium">
                                        <div class="uk-padding">
                                            <h1 class="headings-normal"> SENIOR MANAGEMENT </h1>
                                        </div>
                                        <div class="uk-padding inner-afc-cont">
                                            @include('includes/about.seniormanagement')
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li id="uk-tab-5-tabpanel-7" role="tabpanel" aria-labelledby="uk-tab-5-tab-5" class="">
                                <!-- Player stats -->
                                <div class="uk-grid-small uk-child-width-expand@s" uk-grid>
                                    <div class="uk-container uk-container-medium">
                                        <div class="uk-padding">
                                            <h1 class="headings-normal"> AZAM FC BOARD </h1>
                                        </div>
                                        <div class="uk-padding inner-afc-cont">
                                            @include('includes/about.board')
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection