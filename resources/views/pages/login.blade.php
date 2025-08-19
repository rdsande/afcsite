@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc">
    <div class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle"
        style="background-image: url(img/breadcrumbs/image2.png);">
        <h1 class="page-title"> INGIA </h1>
    </div>
</div>

<!-- Section begin -->
<div class="uk-section pull-top-two whiteptn team-inner">
    <div class="uk-container uk-container-medium">
        <div class="home-posts team-section shadow-one">
            <div class="uk-grid-collapse uk-child-width-expand@s uk-text-center" uk-grid>
                <div class="uk-width-1-2">
                    <div>
                        <div class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle"
                            style="background-image: url({{asset('img/events/preseason.jpg')}});">
                            <div class="uk-overlay-primary uk-position-cover primary"></div>
                            <h1 class="page-title"> TIMU BORA, BIDHAA BORA, <br /> <span class="hight">MASHABIKI
                                    BORA</span></h1>
                        </div>
                    </div>
                </div>
                <div class="uk-width-1-2">
                    <form class="uk-grid-small uk-text-left uk-padding" uk-grid>
                        <div class="uk-width-1-2@s">
                            <label class="uk-form-label" for="form-stacked-select">Username:</label>
                            <div class="uk-inline">
                                <a class="uk-form-icon"> <i class="ri-user-line"></i></a>
                                <input class="uk-input" type="text" aria-label="Clickable icon">
                            </div>
                        </div>
                        <div class="uk-width-1-2@s">
                            <label class="uk-form-label" for="form-stacked-select">Password:</label>
                            <div class="uk-inline">
                                <a class="uk-form-icon"> <i class="ri-user-line"></i></a>
                                <input class="uk-input" type="password" aria-label="Clickable icon">
                            </div>
                        </div>
                        <div class="uk-width-1-2@s">
                            <button class="uk-button uk-button-primary" type="button"
                                aria-haspopup="true">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection