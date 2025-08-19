@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc z-back">
    <div class="uk-background-cover uk-height-large uk-panel uk-flex uk-flex-center uk-flex-middle"
        style="background-image: url('/img/latest/dubegoal.jpg');">
        <h1> Azam FC Holds Simba SC to a 1-1 Draw in Dramatic Showdown - Azam Shines Early, Simba Strikes Late </h1>
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
                    <i class="ri-time-line"></i> Published on: 09/02/2024
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Post content -->
<div class="uk-section">
    <div class="uk-container uk-container-small">
        <p class="uk-text-lead">The atmosphere was electric at Kirumba Stadium in Mwanza as Azam FC clashed with Simba
            SC in a highly anticipated showdown that kept spectators on the edge of their seats until the final whistle.
        </p>
        <p>The match kicked off with fervor, and Azam FC wasted no time in asserting their dominance. Prince Dube
            ignited
            the crowd with a spectacular goal on the 15th minute. Assisted by Msindo, Dube's clinical finish showcased
            Azam's attacking prowess and set the stage
            for an enthralling encounter.</p>
        <p>As the first half came to a close, Azam FC maintained their relentless attack, with Msindo adding a third
            goal in the 45th minute. The home crowd erupted in cheers as their team demonstrated exceptional skill and
            coordination on the field.</p>
        <p>Although disappointed not to claim all three points, Azam FC showcased resilience and tenacity throughout the
            match, earning the respect of fans and opponents alike. The draw serves as a testament to Azam's strength as
            a formidable competitor in Tanzanian football. Azam FC will regroup and continue their quest for success,
            fueled by the passion and support of their loyal supporters at Kirumba Stadium.</p>
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