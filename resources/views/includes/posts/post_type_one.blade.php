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
        <div>
            <div class="uk-card uk-card-default uk-card-body">
                <div class="uk-text-center">
                    <div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                        <img loading="lazy" class="uk-transition-scale-up uk-transition-opaque"
                            src="{{ asset('/img/default-news.jpg') }}" width="1800" height="1200" alt="No news available">
                    </div>
                </div>
                <div class="desc-container">
                    <div class="toppart">
                        <h3 class="uk-card-title">No news available at the moment</h3>
                    </div>
                    <div class="bottompart">
                        <div class="uk-column-1-2">
                            <p>Stay tuned for updates | <span class="post-tag"><a href="{{ route('news.index') }}">News</a></span></p>
                            <p class="text-right" id="sharetosocial"><i class="ri-share-line"></i></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>