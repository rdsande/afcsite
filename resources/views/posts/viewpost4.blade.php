@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc z-back">
    <div class="uk-background-cover uk-height-large uk-panel uk-flex uk-flex-center uk-flex-middle uk-background-fixed"
        style="background-image: url(img/latest/nado.jpg);">
        <h1>Azam FC Secures Home Victory with Late Nado Goal at Chamazi Stadium</h1>
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
                    <i class="ri-time-line"></i> Published on: 11/12/2023
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Post content -->
<div class="uk-section">
    <div class="uk-container uk-container-small" uk-scrollspy="target: > p; cls: uk-animation-fade; delay: 500">
        <p class="uk-text-lead">In a gripping match at the Azam Complex, Chamazi Stadium, Azam FC emerged victorious yet again, adding another win to their impressive record. The home crowd erupted in joy as the team showcased skill and determination on the field. </p>

        <p>The excitement kicked off early in the game when Bajana netted the first goal, putting Azam FC in the lead. His early strike set the tone for an action-packed encounter, keeping fans on the edge of their seats.
        </p>
        <p>As the match unfolded, both teams displayed commendable performances, creating numerous opportunities. The suspense reached its peak when, in the 84th minute, Nado delivered a stunning late goal that sealed the victory for Azam FC. The crowd erupted into cheers, celebrating the team's resilience and ability to secure a win in the dying moments of the game.</p>
        <p>The late heroics of Nado not only solidified Azam FC's position in the league but also highlighted the team's knack for delivering under pressure. The players' dedication and teamwork were evident throughout the match, earning them the admiration of fans and football enthusiasts alike.</p>
    </div>
</div>

<!-- Related -->
@include('includes/sections.relatedposts')

@endsection