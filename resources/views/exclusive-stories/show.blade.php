@extends('layouts.app')

@section('content')
<main class="afc-main">
    <!-- Breadcrumb -->
    <div class="uk-section uk-section-small bg-primary">
        <div class="uk-container uk-container-medium">
            <nav aria-label="Breadcrumb">
                <ul class="uk-breadcrumb uk-light">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><span>Exclusive Stories</span></li>
                    <li><span>{{ $story->title }}</span></li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Story Content -->
    <div class="uk-section">
        <div class="uk-container uk-container-medium">
            <div class="uk-grid-large" uk-grid>
                <!-- Main Content -->
                <div class="uk-width-2-3@m">
                    <article class="exclusive-story-detail">
                        <!-- Story Header -->
                        <header class="story-header uk-margin-large-bottom">
                            <div class="story-type-indicator">
                                @if($story->type === 'photos')
                                    <span class="uk-label uk-label-success">
                                        <i class="ri-image-line"></i> Photo Gallery
                                    </span>
                                @else
                                    <span class="uk-label uk-label-warning">
                                        <i class="ri-play-circle-line"></i> Video Story
                                    </span>
                                @endif
                                <span class="uk-label uk-label-primary uk-margin-small-left">
                                    <i class="ri-lock-line"></i> Members Only
                                </span>
                            </div>
                            <h1 class="uk-article-title uk-margin-top">{{ $story->title }}</h1>
                            @if($story->description)
                                <p class="uk-article-lead">{{ $story->description }}</p>
                            @endif
                            <div class="story-meta uk-margin-top">
                                <span class="uk-text-muted">
                                    <i class="ri-time-line"></i> {{ $story->created_at->format('F d, Y \a\t H:i') }}
                                </span>
                                <span class="uk-text-muted uk-margin-left">
                                    <i class="ri-folder-line"></i> {{ $story->media_paths ? count($story->media_paths) : 0 }} {{ $story->type === 'photos' ? 'Photos' : 'Videos' }}
                                </span>
                            </div>
                        </header>

                        <!-- Media Gallery -->
                        @if($story->type === 'photos')
                            <!-- Photo Gallery -->
                            <div class="photo-gallery">
                                @if($story->media_paths && count($story->media_paths) > 0)
                                    <div class="uk-grid-small uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid uk-lightbox="animation: slide">
                                        @foreach($story->media_paths as $mediaPath)
                                            <div>
                                                <a class="uk-inline" href="{{ asset('storage/' . $mediaPath) }}" data-caption="{{ $story->title }}">
                                                    <img src="{{ asset('storage/' . $mediaPath) }}" alt="{{ $story->title }}" class="gallery-image">
                                                    <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-transition-slide-bottom">
                                                        <p class="uk-h4 uk-margin-remove"><i class="ri-zoom-in-line"></i></p>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="uk-alert uk-alert-warning">
                                        <p>No photos available for this story.</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <!-- Video Gallery -->
                            <div class="video-gallery">
                                @if($story->video_link)
                                    <!-- Embedded Video from YouTube/Vimeo -->
                                    <div class="embedded-video uk-margin-bottom">
                                        @php
                                            $embedUrl = null;
                                            if (str_contains($story->video_link, 'youtube.com') || str_contains($story->video_link, 'youtu.be')) {
                                                // Extract YouTube video ID
                                                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $story->video_link, $matches);
                                                if (isset($matches[1])) {
                                                    $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                                                }
                                            } elseif (str_contains($story->video_link, 'vimeo.com')) {
                                                // Extract Vimeo video ID
                                                preg_match('/vimeo\.com\/(\d+)/', $story->video_link, $matches);
                                                if (isset($matches[1])) {
                                                    $embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
                                                }
                                            }
                                        @endphp
                                        
                                        @if($embedUrl)
                                            <div class="video-embed-container">
                                                <iframe src="{{ $embedUrl }}" 
                                                        frameborder="0" 
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                        allowfullscreen
                                                        class="embedded-video-iframe">
                                                </iframe>
                                            </div>
                                        @else
                                            <div class="uk-alert uk-alert-warning">
                                                <p>Unable to embed video. <a href="{{ $story->video_link }}" target="_blank" class="uk-link">Watch on original platform</a></p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                
                                @if($story->media_paths && count($story->media_paths) > 0)
                                    <div class="uk-grid-small uk-child-width-1-1@s uk-child-width-1-2@m" uk-grid>
                                        @foreach($story->media_paths as $mediaPath)
                                            @php
                                                $isVideo = in_array(pathinfo($mediaPath, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']);
                                            @endphp
                                            <div>
                                                @if($isVideo)
                                                    <video controls class="uk-width-1-1 video-player" poster="{{ $story->thumbnail ? asset('storage/' . $story->thumbnail) : '' }}">
                                                        <source src="{{ asset('storage/' . $mediaPath) }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @else
                                                    <img src="{{ asset('storage/' . $mediaPath) }}" alt="{{ $story->title }}" class="uk-width-1-1">
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif(!$story->video_link)
                                    <div class="uk-alert uk-alert-warning">
                                        <p>No videos available for this story.</p>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="story-actions uk-margin-large-top uk-text-center">
                            <a href="{{ route('home') }}" class="uk-button uk-button-default">
                                <i class="ri-arrow-left-line"></i> Back to Home
                            </a>
                        </div>
                    </article>
                </div>

                <!-- Sidebar -->
                <div class="uk-width-1-3@m">
                    <aside class="story-sidebar">
                        <!-- Related Stories -->
                        @if($relatedStories && $relatedStories->count() > 0)
                            <div class="uk-card uk-card-default uk-card-body">
                                <h3 class="uk-card-title">More Exclusive Stories</h3>
                                <div class="related-stories">
                                    @foreach($relatedStories as $relatedStory)
                                        <div class="related-story-item uk-margin-bottom">
                                            <div class="uk-grid-small uk-flex-middle" uk-grid>
                                                <div class="uk-width-auto">
                                    @if($relatedStory->thumbnail)
                                        <img src="{{ asset('storage/' . $relatedStory->thumbnail) }}" 
                                             alt="{{ $relatedStory->title }}" 
                                             class="related-story-thumb uk-border-rounded" 
                                             width="60" height="60">
                                    @elseif($relatedStory->media_paths && count($relatedStory->media_paths) > 0)
                                        <img src="{{ asset('storage/' . $relatedStory->media_paths[0]) }}" 
                                             alt="{{ $relatedStory->title }}" 
                                             class="related-story-thumb uk-border-rounded" 
                                             width="60" height="60">
                                    @else
                                        <div class="related-story-placeholder uk-border-rounded">
                                            <i class="ri-image-line"></i>
                                        </div>
                                    @endif
                                </div>
                                                <div class="uk-width-expand">
                                                    <h4 class="uk-margin-remove-bottom">
                                                        <a href="{{ route('exclusive-story.show', $relatedStory->id) }}" class="uk-link-reset">
                                                            {{ Str::limit($relatedStory->title, 50) }}
                                                        </a>
                                                    </h4>
                                                    <p class="uk-text-small uk-text-muted uk-margin-remove-top">
                                                        <i class="ri-time-line"></i> {{ $relatedStory->created_at->format('M d, Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Story Info -->
                        <div class="uk-card uk-card-default uk-card-body uk-margin-top">
                            <h3 class="uk-card-title">Story Information</h3>
                            <dl class="uk-description-list">
                                <dt>Type</dt>
                                <dd>{{ ucfirst($story->type) }}</dd>
                                <dt>Published</dt>
                                <dd>{{ $story->created_at->format('F d, Y') }}</dd>
                                <dt>Media Count</dt>
                                <dd>{{ $story->media_paths ? count($story->media_paths) : 0 }} {{ $story->type === 'photos' ? 'Photos' : 'Videos' }}</dd>
                                <dt>Status</dt>
                                <dd>
                                    <span class="uk-label uk-label-success">{{ ucfirst($story->status) }}</span>
                                </dd>
                            </dl>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.exclusive-story-detail {
    background: white;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.story-header {
    border-bottom: 1px solid #e5e5e5;
    padding-bottom: 1.5rem;
}

.gallery-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 4px;
    transition: transform 0.3s ease;
}

.gallery-image:hover {
    transform: scale(1.05);
}

.video-player {
    border-radius: 8px;
    max-height: 400px;
}

.video-embed-container {
    position: relative;
    width: 100%;
    height: 0;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    margin-bottom: 1rem;
}

.embedded-video-iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 8px;
}

.related-story-thumb {
    object-fit: cover;
}

.related-story-placeholder {
    width: 60px;
    height: 60px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
}

.story-type-indicator .uk-label {
    font-size: 0.75rem;
}

.story-meta {
    border-top: 1px solid #e5e5e5;
    padding-top: 1rem;
}

.related-story-item {
    padding: 0.75rem;
    border: 1px solid #e5e5e5;
    border-radius: 4px;
    transition: background-color 0.2s ease;
}

.related-story-item:hover {
    background-color: #f8f9fa;
}

@media (max-width: 768px) {
    .exclusive-story-detail {
        padding: 1rem;
    }
    
    .gallery-image {
        height: 150px;
    }
}
</style>
@endsection