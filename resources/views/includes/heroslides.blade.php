<div class="uk-position-relative uk-visible-toggle uk-light afc-carousel" tabindex="-1" uk-slideshow="ratio: 7:3; animation: fade; autoplay: true; autoplay-interval: 4000">
    <div class="uk-slideshow-items hero-slides">
        @if(isset($featuredNews) && $featuredNews->count() > 0)
            @foreach($featuredNews as $index => $news)
                <div class="afc-slide {{ $index === 0 ? 'active' : '' }}" uk-img="loading: eager">
                    <img src="{{ $news->featured_image ? asset('storage/' . $news->featured_image) : asset('/img/default-news.jpg') }}" alt="{{ $news->title }}" uk-cover>
                    <span class="ovrlay"></span>
                    <div class="uk-position-center uk-position-small uk-text-center uk-light caption-div">
                        <h2 class="uk-margin-remove hero-title">
                            <a href="{{ route('news.show', $news->slug) }}">{{ $news->title }}</a>
                        </h2>
                        <p class="uk-margin-remove">
                            <i class="ri-price-tag-3-fill"></i> News <i class="ri-time-line emptspc"></i>{{ $news->published_at->format('d/m/Y') }}
                        </p>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Fallback slide when no featured news available -->
            <div class="afc-slide active" uk-img="loading: eager">
                <img src="{{ asset('/img/default-hero.jpg') }}" alt="Welcome to Azam FC" uk-cover>
                <span class="ovrlay"></span>
                <div class="uk-position-center uk-position-small uk-text-center uk-light caption-div">
                    <h2 class="uk-margin-remove hero-title">
                        <a href="{{ route('news.index') }}">Welcome to Azam FC</a>
                    </h2>
                    <p class="uk-margin-remove">
                        <i class="ri-price-tag-3-fill"></i> News
                    </p>
                </div>
            </div>
        @endif
    </div>

    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href uk-slidenav-previous uk-slideshow-item="previous"></a>
    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href uk-slidenav-next uk-slideshow-item="next"></a>
</div>