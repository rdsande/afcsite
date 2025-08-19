@extends('layouts.admin')

@section('title', 'Manage News')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">News Articles</h3>
                    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Article
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th>Published Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($news as $article)
                                    <tr>
                                        <td>{{ $article->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($article->featured_image)
                                                    <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                                         alt="{{ $article->title }}" 
                                                         class="img-thumbnail me-2" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <strong>{{ Str::limit($article->title, 50) }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ Str::limit($article->excerpt, 80) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $article->author->name ?? 'Unknown' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $article->is_published ? 'success' : 'warning' }}">
                                                {{ $article->is_published ? 'Published' : 'Draft' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($article->is_featured)
                                                <span class="badge bg-primary">Featured</span>
                                            @else
                                                <span class="badge bg-light text-dark">Regular</span>
                                            @endif
                                        </td>
                                        <td>{{ $article->published_at ? $article->published_at->format('M d, Y') : 'Not published' }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('news.show', $article->slug) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   target="_blank" 
                                                   title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.news.edit', $article) }}" 
                                                   class="btn btn-sm btn-outline-warning" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.news.destroy', $article) }}" 
                                                      method="POST" 
                                                      class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to delete this article?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger" 
                                                            title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-newspaper fa-3x mb-3"></i>
                                                <p>No news articles found.</p>
                                                <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                                                    Create your first article
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($news->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $news->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-hide success alerts after 5 seconds
    setTimeout(function() {
        $('.alert-success').fadeOut('slow');
    }, 5000);
</script>
@endpush