@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc z-back">
    <div class="uk-background-cover uk-height-large uk-panel uk-flex uk-flex-center uk-flex-middle"
        style="background-image: url('/img/latest/nadogoals.jpg');">
        <h1> AZAM FC SECURES VICTORY AGAINST GEITA GOLD </h1>
    </div>
</div>

<!-- Post Meta -->
<div class="uk-container uk-container-small meta-sec">
    <div class="post-metas">
        <div class="uk-grid-collapse uk-child-width-expand@s uk-text-center" uk-grid>
            <div>
                <div class="uk-padding">
                    <div>
                        <img src="{{ asset('img/logo.png')}}" width="50" height="50">
                        <span class="uk-text-middle"> By: Azam FC</span>
                    </div>
                </div>
            </div>
            <div class="time-col">
                <div class="uk-padding time-col">
                    <i class="ri-time-line"></i> Published on: 17/02/2024
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Post content -->
<div class="uk-section">
    <div class="uk-container uk-container-small">
        <p class="uk-text-lead">In a pulsating display of football prowess at the Azam Complex Stadium, Azam FC emerged
            triumphant in a
            closely contested match against Geita Gold. The encounter, filled with anticipation and fervor, kept
            spectators on the edge of their seats until the final whistle blew, sealing Azam FC's victory with a 2-1
            scoreline.
        </p>
        <p>

            The game unfolded with Geita Gold taking an early lead, showcasing their determination to dominate the
            pitch. However, Azam FC responded with resilience, swiftly equalizing in the 44th minute courtesy of a
            stunning goal by Syllah. This pivotal moment injected newfound energy into the stadium, setting the stage
            for a riveting showdown in the second half. </p>
        <p>
            As the match intensified, both teams demonstrated skillful maneuvering and strategic play, captivating the
            audience with each thrilling moment. With tensions running high and time ticking away, Azam FC seized the
            opportunity to secure their win in the 84th minute, unleashing a collective roar of celebration from their
            loyal supporters. </p>
        <p>
            The victory underscores Azam FC's formidable presence in the league and their unwavering commitment to
            excellence. Commendations are due to both teams for delivering a captivating display of football prowess,
            showcasing the beauty and excitement of the sport. </p>
        <p>
            As the dust settles on this exhilarating encounter, football enthusiasts eagerly anticipate the next chapter
            in this captivating season. Until then, the echoes of Azam FC's triumph will reverberate throughout the
            footballing world, leaving an indelible mark on the hearts of fans everywhere.
        </p>

    </div>
</div>

<!-- Related -->
<!-- Posts Part Two -->
<div class="uk-section pull-top-one whiteptn">
    <div class="uk-container uk-container-medium">
        <div class="home-posts shadow-one">
            <!-- Post Header -->
            <div class="widget-header-wrapper ">
                <div class="widget-header-wrapper__header">
                    <header class="widget-header  ">
                        <h2 class="widget-header__title">YOU MIGHT ALSO LIKE</h2>
                    </header>
                </div>

                <div class="widget-header-wrapper__content ">
                    <a href="/" class="widget-header__link-to "> View all <i class="ri-arrow-right-s-line"></i>
                    </a>
                </div>
            </div>
            <!-- Post Header -->
            <div class="posts-type-one">
                @include('includes/posts.post_type_two')
            </div>
        </div>
    </div>
</div>

@endsection