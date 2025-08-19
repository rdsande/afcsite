@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="page-brdc">
    <div class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" style="background-image: url('/img/breadcrumbs/image3.png');">
        <h1 class="page-title">ALL NEWS</h1>
    </div>
</div>

<!-- Section begin -->
<div class="uk-section pull-top-two whiteptn team-inner">
    <div class="uk-container uk-container-medium">
        <div class="home-posts team-section shadow-one">
            <!-- News -->
            <div class="posts-type-one team-display">
                <div class="uk-child-width-1-4@m" uk-grid
                    uk-scrollspy="cls: uk-animation-fade; target: .uk-card; delay: 100; repeat: false" uk-height-match>
                    @if(isset($news) && $news->count() > 0)
                        @foreach($news as $article)
                            <!-- Post Item -->
                            <div>
                                <a href="{{ route('news.show', $article->slug) }}">
                                    <div class="uk-card uk-card-default uk-card-body">
                                        <div class="uk-text-center">
                                            <div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                                                <img loading="lazy" class="uk-transition-scale-up uk-transition-opaque"
                                                    src="{{ $article->featured_image ? asset('storage/' . $article->featured_image) : asset('/img/default-news.jpg') }}" 
                                                    width="1800" height="1200" alt="{{ $article->title }}">
                                            </div>
                                        </div>
                                        <div class="desc-container">
                                            <div class="toppart">
                                                <h3 class="uk-card-title">{{ Str::limit($article->title, 80) }}</h3>
                                            </div>
                                            <div class="bottompart">
                                                <div class="uk-column-1-2">
                                                    <p>{{ $article->published_at->format('d/m/Y') }} | <span class="post-tag"><a href="{{ route('news.index') }}">News</a></span></p>
                                                    <p class="text-right" id="sharetosocial"><i class="ri-share-line"></i></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <!-- Fallback when no news available -->
                        <div class="uk-width-1-1">
                            <div class="uk-card uk-card-default uk-card-body uk-text-center">
                                <h3>No news articles available at the moment</h3>
                                <p>Stay tuned for updates!</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Pagination -->
            @if(isset($news) && $news->hasPages())
                <div class="uk-margin-large-top uk-text-center">
                    {{ $news->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection