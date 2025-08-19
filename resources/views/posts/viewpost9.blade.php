@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc z-back">
    <div class="uk-background-cover uk-height-large uk-panel uk-flex uk-flex-center uk-flex-middle"
        style="background-image: url('/img/latest/tabora.jpg');">
        <h1> Azam FC and Tabora United in a goalless draw. </h1>
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
                    <i class="ri-time-line"></i> Published on: 20/02/2024
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Post content -->
<div class="uk-section">
    <div class="uk-container uk-container-small">
        <p class="uk-text-lead">
            In a tightly contested match, Azam FC and Tabora United played to a hard-fought draw, with neither team able
            to
            break the deadlock.
        </p>
        <p>
            Both sides displayed resilience in defense, denying scoring opportunities and ensuring a stalemate at the
            final whistle. The battle for supremacy ended in a goalless draw, leaving fans eager for the next encounter
            to see if either team can claim victory. </p>

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