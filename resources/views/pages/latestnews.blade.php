@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc">
    <div class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle"
        style="background-image: url(img/breadcrumbs/image3.png);">
        <h1 class="page-title"> LATEST NEWS </h1>
    </div>
</div>

<!-- Section begin -->
<div class="uk-section pull-top-two whiteptn team-inner latestnews">
    <div class="uk-container uk-container-medium">
        <div class="home-posts team-section shadow-one">

            <!-- News -->
            <div class="posts-type-one team-display">
                @include('includes/posts.post_type_one')
            </div>
        </div>
    </div>
</div>

@endsection