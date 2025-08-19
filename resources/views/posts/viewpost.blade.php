@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
@php
    $backgroundImage = $article->featured_image ? asset('storage/' . $article->featured_image) : asset('img/events/preseason.jpg');
@endphp
<div class="page-brdc z-back">
    <div class="uk-background-cover uk-height-large uk-panel uk-flex uk-flex-center uk-flex-middle"
        style="background-image: url('{{ $backgroundImage }}');">
        <h1>{{ $article->title }}</h1>
    </div>
</div>

<!-- Post Meta -->
<div class="uk-container uk-container-small meta-sec">
    <div class="post-metas">
        <div class="uk-grid-collapse uk-child-width-expand@s uk-text-center" uk-grid>
            <div>
                <div class="uk-padding">
                    <div>
                        <img src="{{ asset('img/players/akaminko.png')}}" width="50" height="50">
                        <span class="uk-text-middle"> By: {{ $article->author->name ?? 'Azam FC' }}</span>
                    </div>
                </div>
            </div>
            <div class="time-col">
                <div class="uk-padding time-col">
                    <i class="ri-time-line"></i> Published on: {{ $article->published_at ? $article->published_at->format('d/m/Y | H:i A') : 'Not published' }}
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Post content -->
<div class="uk-section">
    <div class="uk-container uk-container-small">
        @if($article->excerpt)
            <div class="uk-text-lead uk-margin-bottom">
                {{ $article->excerpt }}
            </div>
        @endif
        
        <div class="article-content">
            {!! $article->content !!}
        </div>
        
        @if($article->views > 0)
            <div class="uk-margin-top uk-text-muted uk-text-small">
                <i class="ri-eye-line"></i> {{ $article->views }} {{ $article->views == 1 ? 'view' : 'views' }}
            </div>
        @endif
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
                        <h2 class="widget-header__title">HABARI ZAIDI</h2>
                    </header>
                </div>

                <div class="widget-header-wrapper__content ">
                    <a href="/" class="widget-header__link-to "> Tazama Zote <i class="ri-arrow-right-s-line"></i>
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