@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc">
    <div class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle"
        style="background-image: url(img/breadcrumbs/image2.png);">
        <h1 class="page-title"> EVENTS </h1>
    </div>
</div>

<!-- Section begin -->
<div class="uk-section pull-top-two whiteptn team-inner">
    <div class="uk-container uk-container-medium">
        <div class="home-posts team-section shadow-one uk-padding">
            <div class="uk-grid-collapse uk-child-width-expand@s uk-text-center" uk-grid
                uk-scrollspy="cls: uk-animation-fade; target: .uk-card; delay: 100; repeat: false">
                <div class="uk-padding">
                    <!-- Achievement -->
                    <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>
                        <div class="uk-card-media-left uk-cover-container">
                            <!-- <img src="{{ asset('img/latest/afc1.jpg')}}" alt="" uk-cover>
                            <canvas width="600" height="400"></canvas> -->
                            <iframe loading=“lazy” width="100%" height="100%"
                                src="https://www.youtube.com/embed/tT9kLzmp4J4" title="LIVE:  AZAM FC FESTIVAL 2020"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>

                        </div>
                        <div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title">AZAM FESTIVAL - 2020</h3>
                                <p>Listen to the Vice-chairman's (Mr. Omary Kuwe) interview prior to the event</p>
                                <p><audio controls>
                                        <source src="{{asset('audio/kuwe.mp3')}}" type="audio/mp3" />
                                    </audio></p>

                                <label class="uk-success"> <a class="uk-button uk-button-primary"
                                        href="https://www.youtube.com/watch?v=8QO2fQBwVqM&embeds_referring_euri=http%3A%2F%2F127.0.0.1%3A8000%2F&source_ve_path=MTc4NDI0&ab_channel=AzamFootballClub">
                                        Watch full event</a></label>
                            </div>
                        </div>
                    </div>

                    <!-- Achievement -->
                    <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>
                        <div class="uk-card-media-left uk-cover-container">
                            <!-- <img src="{{ asset('img/latest/afc1.jpg')}}" alt="" uk-cover>
                            <canvas width="600" height="400"></canvas> -->
                            <iframe loading=“lazy” width="100%" height="100%"
                                src="https://www.youtube.com/embed/7NfG_HpYMyQ"
                                title="LIVE -  AZAM FC INAZINDUA NEMBO MPYA - AZAM TV 14/08/2021" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                        <div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title">SIKU YA MTOTO WA AZAM (AZAM CHILD DAY) | 2020</h3>
                                <p>Explore the heartwarming moments and celebrations of "Siku ya Mtoto wa Azam" (Azam
                                    Child Day) in this 2020 video. Join the joyous festivities as Azam embraces the
                                    spirit of childhood, capturing precious memories and highlighting the importance of
                                    nurturing and cherishing the future generation. Witness a day filled with laughter,
                                    activities, and a vibrant showcase of the love and care dedicated to the children of
                                    Azam.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Achievement -->
                    <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>
                        <div class="uk-card-media-left uk-cover-container">
                            <!-- <img src="{{ asset('img/latest/afc1.jpg')}}" alt="" uk-cover>
                            <canvas width="600" height="400"></canvas> -->
                            <iframe loading=“lazy” width="100%" height="100%"
                                src="https://www.youtube.com/embed/o381W8-_NJI"
                                title="LIVE -  AZAM FC INAZINDUA NEMBO MPYA - AZAM TV 14/08/2021" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                        <div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title">SIKU YA MTOTO WA AZAM (AZAM CHILD DAY)| 2021</h3>
                                <p>
                                    Dive into the enchanting world of "Siku ya Mtoto wa Azam" (Azam Child Day) with this
                                    captivating 2021 video. Experience the magic as Azam celebrates the spirit of
                                    childhood, offering a glimpse into a day dedicated to joy, learning, and creativity
                                    for the young ones. From exciting activities to heartwarming moments, join in the
                                    festivities that highlight the commitment to nurturing and empowering the children
                                    of Azam. Explore the vibrant tapestry of love and laughter woven throughout this
                                    special day in 2021. </p>
                            </div>
                        </div>
                    </div>

                    <!-- Achievement -->
                    <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>
                        <div class="uk-card-media-left uk-cover-container">
                            <!-- <img src="{{ asset('img/latest/afc1.jpg')}}" alt="" uk-cover>
                            <canvas width="600" height="400"></canvas> -->
                            <iframe loading=“lazy” width="100%" height="100%"
                                src="https://www.youtube.com/embed/oQf10GlcVBk"
                                title="LIVE -  AZAM FC INAZINDUA NEMBO MPYA - AZAM TV 14/08/2021" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                        <div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title">NEW AZAM FC LOGO LAUNCHING | Aug 14, 2021</h3>
                                <p>
                                    Step into the exciting world of football as Azam FC unveils its brand new logo in
                                    this captivating video from August 14, 2021. Experience the anticipation and
                                    enthusiasm surrounding the logo launch, as the club embraces a fresh identity and
                                    sets the stage for a new era. Immerse yourself in the symbolism and design elements
                                    that define Azam FC's commitment to excellence. Join the celebration of tradition,
                                    innovation, and the thrilling journey ahead for one of the most iconic football
                                    clubs.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Achievement -->
                    <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>
                        <div class="uk-card-media-left uk-cover-container">
                            <!-- <img src="{{ asset('img/latest/afc1.jpg')}}" alt="" uk-cover>
                            <canvas width="600" height="400"></canvas> -->
                            <iframe loading=“lazy” width="100%" height="100%"
                                src="https://www.youtube.com/embed/k9SqC3fv-fs"
                                title="LIVE -  AZAM FC INAZINDUA NEMBO MPYA - AZAM TV 14/08/2021" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                        <div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title">AZAMKA | 2022</h3>
                                <p>Step into the exhilarating world of "AZAMKA | 2022," where the spirit of football and
                                    festivity collide in the ultimate AZAM FC Festival. Join the excitement as the
                                    passionate fans, talented players, and vibrant energy come together to celebrate the
                                    essence of the beautiful game. From thrilling matches to fan engagement activities,
                                    experience the pulse-pounding moments that make this football festival a must-watch.
                                    Get ready to witness the unity, passion, and electrifying atmosphere that define
                                    AZAMKA in 2022</p>
                            </div>
                        </div>
                    </div>

                    <!-- Achievement -->
                    <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>
                        <div class="uk-card-media-left uk-cover-container">
                            <!-- <img src="{{ asset('img/latest/afc1.jpg')}}" alt="" uk-cover>
                            <canvas width="600" height="400"></canvas> -->
                            <iframe loading=“lazy” width="100%" height="100%"
                                src="https://www.youtube.com/embed/hx99Ss1XbZI"
                                title="AZAMKA 2022 | Tazama utambulisho wa wachezaji uliofanywa na Azam FC"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>

                        </div>
                        <div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title">LED PERIMETER BOARDS LAUNCHING - 2023 (PT 1)</h3>
                                <p>This video takes you behind the scenes of the groundbreaking event, showcasing the
                                    cutting-edge technology and innovation that define the new era in perimeter
                                    advertising. Immerse yourself in the dynamic visuals and unveil the power of LED
                                    technology in revolutionizing sports and event advertising. Don't miss the
                                    excitement as we introduce a game-changing solution that promises to elevate the
                                    spectator experience. Get ready for the next level in advertising with the launch of
                                    LED Perimeter Boards!</p>
                            </div>
                        </div>
                    </div>

                    <!-- Achievement -->
                    <div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" uk-grid>
                        <div class="uk-card-media-left uk-cover-container">
                            <!-- <img src="{{ asset('img/latest/afc1.jpg')}}" alt="" uk-cover>
                            <canvas width="600" height="400"></canvas> -->
                            <iframe loading=“lazy” width="100%" height="100%"
                                src="https://www.youtube.com/embed/QXCasd92LT8"
                                title="AZAMKA 2022 | Tazama utambulisho wa wachezaji uliofanywa na Azam FC"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>

                        </div>
                        <div>
                            <div class="uk-card-body">
                                <h3 class="uk-card-title">LED PERIMETER BOARDS LAUNCHING - 2023 (PT 2)</h3>
                                <p>This video takes you behind the scenes of the groundbreaking event, showcasing the
                                    cutting-edge technology and innovation that define the new era in perimeter
                                    advertising. Immerse yourself in the dynamic visuals and unveil the power of LED
                                    technology in revolutionizing sports and event advertising. Don't miss the
                                    excitement as we introduce a game-changing solution that promises to elevate the
                                    spectator experience. Get ready for the next level in advertising with the launch of
                                    LED Perimeter Boards!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection