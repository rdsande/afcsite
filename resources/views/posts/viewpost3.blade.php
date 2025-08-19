@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc z-back">
    <div class="uk-background-cover uk-height-large uk-panel uk-flex uk-flex-center uk-flex-middle uk-background-fixed"
        style="background-image: url(img/latest/vkmc.jpg);">
        <h1>Azam FC Dominates KMC in Spectacular 5-0 Victory</h1>
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
                    <i class="ri-time-line"></i> Published on: 08/12/2023
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Post content -->
<div class="uk-section">
    <div class="uk-container uk-container-small" uk-scrollspy="target: > p; cls: uk-animation-fade; delay: 500">
        <p class="uk-text-lead">In a thrilling showdown at the Azam Complex, Chamazi, Azam FC asserted their dominance with an impressive 5-0 triumph over KMC, solidifying their position at the summit of the NBC Premier League.
        </p>
        <p>
            <strong>Scintillating Performance by Dube:</strong><br>

Azam's victory was fueled by a remarkable performance from striker Dube, who netted two goals, showcasing his prowess in front of the goalpost. His clinical finishes left KMC's defense stunned and contributed significantly to Azam's commanding lead.</p><p>

<strong>Contributions from Kipre Jr, Sillah, and Feisal:</strong><br>

The goal-scoring extravaganza didn't stop with Dube. Kipre Jr, Sillah, and Feisal also found the back of the net, each displaying exceptional skill and teamwork. The diversified scoring demonstrated Azam's offensive prowess and the depth of talent within their squad.</p>
 <p>
<strong>Azam FC Claims the Top Spot:</strong><br>

With this resounding victory, Azam FC now sits proudly at the top of the NBC Premier League table. The team's stellar performance has not only earned them three crucial points but has also solidified their status as a formidable force in the league.</p>
        </p>
    </div>
</div>

<!-- Related -->
@include('includes/sections.relatedposts')

@endsection