@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc z-back">
    <div class="uk-background-cover uk-height-large uk-panel uk-flex uk-flex-center uk-flex-middle"
        style="background-image: url('/img/latest/vkagera.jpg');">
        <h1> Azam FC Extends Dominance with Big win as they beat
            Kagera Sugar </h1>
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
                    <i class="ri-time-line"></i> Published on: 21/12/2023
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Post content -->
<div class="uk-section">
    <div class="uk-container uk-container-small">
        <p class="uk-text-lead">Azam FC showcased their prowess once again as they secured yet another convincing
            victory, continuing their
            remarkable winning streak in the NBC Tanzania Premier League. The match, held at Kaitaba Stadium, saw an
            outstanding performance from Azam FC, with a 4-0 triumph over their opponents.
        </p>
        <p>The scoring spree began early in the 9th minute when Fei Toto found the back of the net, setting the tone for
            Azam FC's dominance. The momentum only intensified as Dube netted another goal in the 12th minute, leaving
            their opponents struggling to keep pace.</p>
        <p>As the first half came to a close, Azam FC maintained their relentless attack, with Msindo adding a third
            goal in the 45th minute. The home crowd erupted in cheers as their team demonstrated exceptional skill and
            coordination on the field.</p>
        <p>Alassane sealed the victory in the 85th minute with a spectacular goal, further solidifying Azam FC's
            position at the summit of the NBC Tanzania Premier League. The team's consistent success is a testament to
            their dedication, skill, and effective teamwork.</p>
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
                        <h2 class="widget-header__title">YOU MIGHT LIKE</h2>
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