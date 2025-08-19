@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc z-back">
    <div class="uk-background-cover uk-height-large uk-panel uk-flex uk-flex-center uk-flex-middle"
        style="background-image: url('/img/latest/kagerawin.jpg');">
        <h1>Azam FC Thrashes Kagera Sugar 5-1 in Stunning
            Display of Dominance</h1>
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
                    <i class="ri-time-line"></i> Published on: 27/05/2024
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Post content -->
<div class="uk-section">
    <div class="uk-container uk-container-small">
        <p> In a scintillating display of football mastery, Azam FC roared to a commanding 5-1 victory over Kagera
            Sugar, fueled by outstanding performances from Fei Toto, Kipre Jr., and Sillah.
        </p>
        <p>Fei Toto emerged as the hero of the match, delivering two breathtaking goals that left the opposition stunned
            and the crowd on their feet. His clinical finishing and impeccable timing proved to be instrumental in Azam
            FC's dominant performance.
        </p>
        <p>Not to be outdone, Kipre Jr. showcased his scoring prowess with a sensational goal of his own, adding to Azam
            FC's growing tally and solidifying their grip on the match. His combination of speed, agility, and accuracy
            posed a constant threat to Kagera Sugar's defense.
        </p>
        <p>Sillah also left his mark on the game with a well-deserved goal, further extending Azam FC's lead and sealing
            their victory in spectacular fashion. His technical brilliance and tactical awareness were on full display
            throughout the match, earning him accolades from fans and teammates alike.</p>

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