@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc">
    <div class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle"
        style="background-image: url(img/breadcrumbs/image2.png);">
        <h1 class="page-title"> AZAMFC TV </h1>
    </div>
</div>

<!-- Section begin -->
<div class="uk-section pull-top-two whiteptn team-inner tvbg">
    <div class="uk-container uk-container-medium">
        <div class="home-posts team-section shadow-one uk-padding">
            <div>
                <iframe width="1920" height="1080" src="https://www.youtube.com/embed/J1TxvDu4olg"
                    title="AZAM FC TV (19/09/2023) | Maandalizi ya nguvu kuwakabili Singida Big Stars" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen uk-responsive uk-video="automute: true"></iframe>
            </div>
            <div class="uk-grid-column-small uk-grid-row-large uk-child-width-1-3@s uk-text-center afc-videos uk-padding"
                uk-grid uk-grid uk-grid uk-height-match="target: > div > .afc-vid-item">
                <!-- Video Item -->
                <div class="afc-vid-item">
                    <div class="uk-card uk-card-default uk-card-body">
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                                    <span class="bgtop"></span>
                                    <img class="uk-transition-scale-up uk-transition-opaque"
                                        src="{{ asset('/img/thumbs/kitayosce.jpg')}}" width="1800" height="1200" alt="">
                                </div>
                                <div class="player-card-details">
                                    <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                                        <div>
                                            <div uk-lightbox class="vid-item">
                                                <a class="uk-button" href="https://youtu.be/_oAYJ-9Vswg"
                                                    data-attrs="width: 1280; height: 720;">
                                                    <h2>
                                                        <span class="vid-icon"><i class="ri-vidicon-line"></i></span>
                                                        AZAMFC V KITAYOSCE
                                                    </h2>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="datepub"> Thur, 22/08/2023 </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Video Item -->
                <div class="afc-vid-item">
                    <div class="uk-card uk-card-default uk-card-body">
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                                    <span class="bgtop"></span>
                                    <img class="uk-transition-scale-up uk-transition-opaque"
                                        src="{{ asset('/img/thumbs/dabo.jpg')}}" width="1800" height="1200" alt="">
                                </div>
                                <div class="player-card-details">
                                    <div class="uk-child-width-expand@s uk-text-center" uk-grid>
                                        <div>
                                            <div uk-lightbox class="vid-item">
                                                <a class="uk-button" href="https://youtu.be/qKFKvzc_VyQ"
                                                    data-attrs="width: 1280; height: 720;">
                                                    <h2>
                                                        <span class="vid-icon"><i class="ri-vidicon-line"></i></span>
                                                        AZAM FC TV 29/08/2023
                                                    </h2>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="datepub"> Thur, 22/08/2023 </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal with iframe -->
<div id="my-id" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title"></h2>
        <button class="uk-modal-close" type="button"></button>
    </div>
</div>

@endsection