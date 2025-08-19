@extends('layouts.admin')

@section('title', 'Edit News Article')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Edit Article: {{ Str::limit($news->title, 50) }}</h3>
                    <div>
                        <a href="{{ route('news.show', $news->slug) }}" class="btn btn-outline-primary" target="_blank">
                            <i class="fas fa-eye"></i> Preview
                        </a>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to News
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title', $news->title) }}" 
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Slug -->
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('slug') is-invalid @enderror" 
                                           id="slug" 
                                           name="slug" 
                                           value="{{ old('slug', $news->slug) }}" 
                                           required>
                                    <div class="form-text">URL-friendly version of the title</div>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Excerpt -->
                                <div class="mb-3">
                                    <label for="excerpt" class="form-label">Excerpt</label>
                                    <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                              id="excerpt" 
                                              name="excerpt" 
                                              rows="3">{{ old('excerpt', $news->excerpt) }}</textarea>
                                    <div class="form-text">Brief summary of the article</div>
                                    @error('excerpt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Content -->
                                <div class="mb-3">
                                    <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                                    <div id="quill-editor" class="@error('content') is-invalid @enderror">{!! old('content', $news->content) !!}</div>
                                    <input type="hidden" name="content" id="content-input" value="{{ old('content', $news->content) }}">
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Category -->
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-control @error('category_id') is-invalid @enderror" 
                                            id="category_id" 
                                            name="category_id" 
                                            required>
                                        <option value="">Select Category</option>
                                        @foreach(App\Models\Category::where('is_active', true)->orderBy('sort_order')->get() as $category)
                                            <option value="{{ $category->id }}" 
                                                    {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Current Featured Image -->
                                @if($news->featured_image)
                                    <div class="mb-3">
                                        <label class="form-label">Current Featured Image</label>
                                        <div class="text-center">
                                            <img src="{{ asset('storage/' . $news->featured_image) }}" 
                                                 alt="{{ $news->title }}" 
                                                 class="img-fluid rounded" 
                                                 style="max-height: 200px;">
                                        </div>
                                    </div>
                                @endif

                                <!-- Featured Image -->
                                <div class="mb-3">
                                    <label for="featured_image" class="form-label">
                                        {{ $news->featured_image ? 'Replace Featured Image' : 'Featured Image' }}
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('featured_image') is-invalid @enderror" 
                                           id="featured_image" 
                                           name="featured_image" 
                                           accept="image/*">
                                    <div class="form-text">Recommended size: 1200x800px</div>
                                    @error('featured_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Publication Status -->
                                <div class="mb-3">
                                    <input type="hidden" name="is_published" value="0">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_published" 
                                               name="is_published" 
                                               value="1" 
                                               {{ old('is_published', $news->is_published) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_published">
                                            <strong>Publish Article</strong>
                                        </label>
                                    </div>
                                    <div class="form-text">Check to make the article visible to the public</div>
                                    @error('is_published')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Featured -->
                                <div class="mb-3">
                                    <input type="hidden" name="is_featured" value="0">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_featured" 
                                               name="is_featured" 
                                               value="1" 
                                               {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            Featured Article
                                        </label>
                                    </div>
                                    <div class="form-text">Featured articles appear in the hero section</div>
                                </div>

                                <!-- Published Date -->
                                <div class="mb-3">
                                    <label for="published_at" class="form-label">Published Date</label>
                                    <input type="datetime-local" 
                                           class="form-control @error('published_at') is-invalid @enderror" 
                                           id="published_at" 
                                           name="published_at" 
                                           value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}">
                                    @error('published_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Meta Keywords -->
                                <div class="mb-3">
                                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                    <input type="text" 
                                           class="form-control @error('meta_keywords') is-invalid @enderror" 
                                           id="meta_keywords" 
                                           name="meta_keywords" 
                                           value="{{ old('meta_keywords', $news->meta_keywords) }}">
                                    <div class="form-text">Comma-separated keywords for SEO</div>
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Meta Description -->
                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                              id="meta_description" 
                                              name="meta_description" 
                                              rows="3">{{ old('meta_description', $news->meta_description) }}</textarea>
                                    <div class="form-text">SEO description (max 160 characters)</div>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Article Info -->
                                <div class="mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">Article Information</h6>
                                            <small class="text-muted">
                                                <strong>Created:</strong> {{ $news->created_at->format('M d, Y H:i') }}<br>
                                                <strong>Updated:</strong> {{ $news->updated_at->format('M d, Y H:i') }}<br>
                                                <strong>Author:</strong> {{ $news->author->name ?? 'Unknown' }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                                        Cancel
                                    </a>
                                    <div>
                                        <button type="submit" name="action" value="save" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Update Article
                                        </button>
                                        <button type="submit" name="action" value="save_and_continue" class="btn btn-success">
                                            <i class="fas fa-save"></i> Update & Continue Editing
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-editor {
        min-height: 400px;
        font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        font-size: 14px;
    }
    .ql-container {
        border-radius: 0 0 0.375rem 0.375rem;
    }
    .ql-toolbar {
        border-radius: 0.375rem 0.375rem 0 0;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    // Initialize Quill
    var quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'align': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    // Update hidden input on content change
    quill.on('text-change', function() {
        document.getElementById('content-input').value = quill.root.innerHTML;
    });

    // Handle form submission
    document.querySelector('form').addEventListener('submit', function() {
        // Ensure content is updated before submission
        document.getElementById('content-input').value = quill.root.innerHTML;
    });

    // Auto-generate slug from title (only if slug is empty or matches current title)
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    const originalSlug = slugInput.value;
    
    titleInput.addEventListener('input', function() {
        const title = this.value;
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '') // Remove invalid chars
            .replace(/\s+/g, '-') // Replace spaces with -
            .replace(/-+/g, '-') // Replace multiple - with single -
            .trim('-'); // Trim - from start and end
        
        // Only auto-update slug if it hasn't been manually changed
        if (slugInput.value === originalSlug || slugInput.value === '') {
            slugInput.value = slug;
        }
    });

    // Character counter for meta description
    const metaDesc = document.getElementById('meta_description');
    if (metaDesc) {
        // Initial check
        checkMetaDescLength();
        
        metaDesc.addEventListener('input', checkMetaDescLength);
        
        function checkMetaDescLength() {
            const length = metaDesc.value.length;
            const maxLength = 160;
            const remaining = maxLength - length;
            
            let helpText = metaDesc.nextElementSibling;
            if (remaining < 0) {
                helpText.innerHTML = `SEO description (<span class="text-danger">${Math.abs(remaining)} characters over limit</span>)`;
                metaDesc.classList.add('is-invalid');
            } else {
                helpText.innerHTML = `SEO description (${remaining} characters remaining)`;
                metaDesc.classList.remove('is-invalid');
            }
        }
    }
</script>
@endpush