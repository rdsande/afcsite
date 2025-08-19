@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc z-back">
    <div class="uk-background-cover uk-height-large uk-panel uk-flex uk-flex-center uk-flex-middle"
        style="background-image: url('/img/latest/crdbfinal.jpg');">
        <h1>AZAM FC Vows Stronger Comeback After League
            Runner-Up Finish and CRDB Confederation Cup Loss</h1>
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
                    <i class="ri-time-line"></i> Published on: 03/06/2024
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Post content -->
<div class="uk-section">
    <div class="uk-container uk-container-small">
        <p?> In the wake of a hard-fought season that saw AZAM FC clinch the runner-up position in the league standings
            and narrowly miss out on the CRDB Confederation Cup trophy, the club is gearing up for an emphatic comeback.
            Despite the setbacks, AZAM FC remains steadfast in its commitment to reclaiming its dominance in Tanzanian
            football.</p>
            <p>

                Reflecting on the season's challenges, AZAM FC's management expressed pride in the team's resilience and
                determination. "Finishing second in the league and reaching the final of the CRDB Confederation Cup is
                no
                small feat," remarked the club's spokesperson. "It demonstrates the strength and talent of our players
                and
                coaching staff."</p>



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