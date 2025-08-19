@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc z-back">
    <div class="uk-background-cover uk-height-large uk-panel uk-flex uk-flex-center uk-flex-middle uk-background-fixed" style="background-image: url(img/latest/afcwin.jpeg);">
        <h1>OUR 5 GOAL WIN AGAINST MTIBWA</h1>
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
        <p class="uk-text-lead">The hometeam, Azam FC, emerged with a 5-0 victory against Mtibwa Sugar in NBC Premier League match at Azam Complex, Chamazi in Dar es Salaam. </p>

        <p>Azam FC's goals were scored by Ivorian attacking midfielder, Kipre Junior, in the 29th, 43rd, and 63rd minutes, while defender Lusajo Mwaikenda scored in the 61st minute, and midfielder Feisal Salum in the 86th minute.
        </p>
    </div>
</div>

<!-- Related -->
@include('includes/sections.relatedposts')

@endsection