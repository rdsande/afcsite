@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc z-back">
    <div class="uk-background-cover uk-height-large uk-panel uk-flex uk-flex-center uk-flex-middle"
        style="background-image: url('/img/latest/finalmatch.jpg');">
        <h1>AZAM FC Clinches CAF Champions League Spot, Feisal Secures Second Top Scorer Title!</h1>
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
                    <i class="ri-time-line"></i> Published on: 28/05/2024
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Post content -->
<div class="uk-section">
    <div class="uk-container uk-container-small">
        <p> In a thrilling finale to the NBC Premier League 2023/2024 season, AZAM FC secured their position as
            runners-up with a spectacular 2-0 victory in their last game away against Geita Gold. Their triumph not only
            solidifies their standing
            as one of the league's top teams but also guarantees their participation in the prestigious CAF Champions
            League next season.</p>

        <p><strong>Feisal Emerges as Second Top Scorer of the Season!</strong></p>

        <p>
            Adding to the celebrations, AZAM FC's Feisal distinguished himself on the field, scoring a crucial goal in
            the final game. This achievement not only sealed their victory but also propelled Feisal to the esteemed
            position of second top scorer in the NBC Premier League for the 2023/2024 season.
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