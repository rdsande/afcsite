@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc z-back">
    <div class="uk-background-cover uk-height-large uk-panel uk-flex uk-flex-center uk-flex-middle"
        style="background-image: url('/img/latest/greenwarriors.jpg');">
        <h1> Azam FC Dominates Green Warriors with a 5-0 Victory </h1>
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
                    <i class="ri-time-line"></i> Published on: 28/02/2024
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Post content -->
<div class="uk-section">
    <div class="uk-container uk-container-small">
        <p class="uk-text-lead">
            In a thrilling match held at the Azam Complex in Chamazi, Azam FC showcased their dominance on the field by
            securing a resounding 5-0 victory against Green Warriors. The match, which was filled with remarkable
            moments and stellar performances, highlighted Azam FC's prowess and determination.
        </p>
        <p>
            The scoring spree commenced in the 31st minute when Nado found the back of the net, setting the tone for
            Azam FC's offensive onslaught. Just two minutes later, Kipre Jr extended the lead with another goal, further
            solidifying Azam FC's control of the game. </p>
        <p>As the match progressed, Azam FC continued to exert pressure on their opponents, resulting in an own goal by
            Green Warriors in the 56th minute, further widening the goal margin. Sopu further added to the tally in the
            64th minute, demonstrating Azam FC's depth in offensive capabilities.</p>
        <p>The final blow came in the 84th minute, courtesy of Lyanga, sealing Azam FC's victory with a remarkable 5-0
            scoreline. The collective effort and stellar performances by the players underscored Azam FC's determination
            to dominate the field and maintain their position as a formidable force in the league.</p>
        <p>The electrifying atmosphere at the Azam Complex was testament to the fans' unwavering support, cheering on
            their team as they delivered a memorable performance. With this commanding win, Azam FC continues to make
            strides in their pursuit of excellence, leaving a mark of superiority in the realm of football.</p>
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