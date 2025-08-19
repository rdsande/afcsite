@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc z-back">
    <div class="uk-background-cover uk-height-large uk-panel uk-flex uk-flex-center uk-flex-middle uk-background-fixed" style="background-image: url(img/latest/afcmikoani.jpg);">
        <h1>AZAM FC TO FACE ALLIANCE FC - ASFC 2023</h1>
    </div>
</div>

<!-- Post Meta -->
<div class="uk-container uk-container-small meta-sec" uk-scrollspy="cls:uk-animation-fade">
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
                    <i class="ri-time-line"></i> Published on: 04/12/2023
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Post content -->
<div class="uk-section">

    <div class="uk-container uk-container-small" uk-scrollspy="target: > p; cls: uk-animation-fade; delay: 500">

        <p class="uk-text-lead">ALL is set for the Azam Sports Federation Cup (ASFC) that is to commence soon featuring 64 teams.</p>
        <p>Tanzania Football Federation (TFF) Competitions Manager, Baraka Kizuguto revealed the ASFC fixtures in Dar es Salaam.

            The teams include Mainland Premier League teams, Championship League teams, First League and Regional League teams. Kizuguto highlighted that the second round of the competition will be staged from 15th to 17th December.
            According to the fixtures, last season’s finalist, Azam FC will meet Mwanza based side Alliance FC at the Azam Complex in Dar es Salaam.</p>

        <img src="{{ asset('img/latest/afcmtibwa.jpeg')}}" />
    </div>
</div>

<!-- Related -->
@include('includes/sections.relatedposts')

@endsection