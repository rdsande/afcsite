@extends('layouts.admin')

@section('title', 'View Exclusive Story')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">View Exclusive Story</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.exclusive-stories.index') }}">Exclusive Stories</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $exclusiveStory->title }}</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.exclusive-stories.edit', $exclusiveStory) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="{{ route('admin.exclusive-stories.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Story Details -->
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info"><i class="fas fa-info"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Story Details</span>
                                            <div class="mt-2">
                                                <strong>Title:</strong> {{ $exclusiveStory->title }}<br>
                                                <strong>Type:</strong> 
                                                <span class="badge badge-{{ $exclusiveStory->type === 'photos' ? 'info' : 'warning' }}">
                                                    {{ ucfirst($exclusiveStory->type) }}
                                                </span><br>
                                                <strong>Status:</strong> 
                                                <span class="badge badge-{{ $exclusiveStory->status === 'active' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($exclusiveStory->status) }}
                                                </span><br>
                                                @if($exclusiveStory->description)
                                                    <strong>Description:</strong><br>
                                                    <p class="mt-1">{{ $exclusiveStory->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <!-- Meta Information -->
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success"><i class="fas fa-calendar"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Meta Information</span>
                                            <div class="mt-2">
                                                <strong>Created:</strong> {{ $exclusiveStory->created_at->format('M d, Y H:i') }}<br>
                                                <strong>Updated:</strong> {{ $exclusiveStory->updated_at->format('M d, Y H:i') }}<br>
                                                <strong>Media Count:</strong> 
                                @php
                                    $mediaFiles = $exclusiveStory->media_paths ?? [];
                                @endphp
                                {{ count($mediaFiles) }} files<br>
                                                @if($exclusiveStory->thumbnail)
                                                    <strong>Thumbnail:</strong> <span class="badge badge-success">Available</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Thumbnail Preview -->
                            @if($exclusiveStory->thumbnail)
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h4>Story Thumbnail</h4>
                                        <div class="card" style="max-width: 300px;">
                                            <img src="{{ asset('storage/' . $exclusiveStory->thumbnail) }}" 
                                                 class="card-img-top" 
                                                 style="height: 200px; object-fit: cover;" 
                                                 alt="Story Thumbnail">
                                            <div class="card-body p-2">
                                                <small class="text-muted">Thumbnail Image</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Media Gallery -->
                            @if(count($mediaFiles) > 0)
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h4>Media Gallery</h4>
                                        <div class="row">
                                            @foreach($mediaFiles as $index => $media)
                                                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                                    <div class="card">
                                                        @php
                                                            $extension = strtolower(pathinfo($media, PATHINFO_EXTENSION));
                                                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                            $isVideo = in_array($extension, ['mp4', 'mov', 'avi', 'wmv', 'flv']);
                                                        @endphp
                                                        
                                                        @if($isImage)
                                                            <img src="{{ asset('storage/' . $media) }}" 
                                                                 class="card-img-top media-item" 
                                                                 style="height: 200px; object-fit: cover; cursor: pointer;" 
                                                                 data-toggle="modal" 
                                                                 data-target="#mediaModal" 
                                                                 data-src="{{ asset('storage/' . $media) }}"
                                                                 data-type="image"
                                                                 alt="Story Media {{ $index + 1 }}">
                                                        @elseif($isVideo)
                                                            <video class="card-img-top media-item" 
                                                                   style="height: 200px; object-fit: cover; cursor: pointer;" 
                                                                   data-toggle="modal" 
                                                                   data-target="#mediaModal" 
                                                                   data-src="{{ asset('storage/' . $media) }}"
                                                                   data-type="video"
                                                                   muted>
                                                                <source src="{{ asset('storage/' . $media) }}" type="video/{{ $extension }}">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        @else
                                                            <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                                                <div class="text-center">
                                                                    <i class="fas fa-file fa-3x text-muted mb-2"></i>
                                                                    <p class="text-muted mb-0">{{ strtoupper($extension) }} File</p>
                                                                    <a href="{{ asset('storage/' . $media) }}" target="_blank" class="btn btn-sm btn-primary mt-2">
                                                                        <i class="fas fa-download"></i> Download
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        
                                                        <div class="card-body p-2">
                                                            <small class="text-muted">
                                                                File {{ $index + 1 }} - {{ strtoupper($extension) }}
                                                            </small>
                                                            @if($isImage || $isVideo)
                                                                <br>
                                                                <a href="{{ asset('storage/' . $media) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                                                    <i class="fas fa-external-link-alt"></i> Open
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> No media files found for this story.
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- /.card-body -->
                        
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('admin.exclusive-stories.edit', $exclusiveStory) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Edit Story
                                    </a>
                                    <a href="{{ route('admin.exclusive-stories.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-list"></i> Back to List
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <form action="{{ route('admin.exclusive-stories.destroy', $exclusiveStory) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this story? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i> Delete Story
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Media Modal -->
<div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-labelledby="mediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaModalLabel">Media Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div id="modalContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a id="downloadLink" href="#" target="_blank" class="btn btn-primary">
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Handle media modal
    $('.media-item').on('click', function() {
        var src = $(this).data('src');
        var type = $(this).data('type');
        var modalContent = $('#modalContent');
        var downloadLink = $('#downloadLink');
        
        modalContent.empty();
        downloadLink.attr('href', src);
        
        if (type === 'image') {
            modalContent.html('<img src="' + src + '" class="img-fluid" alt="Story Media">');
        } else if (type === 'video') {
            modalContent.html('<video class="img-fluid" controls autoplay><source src="' + src + '" type="video/mp4">Your browser does not support the video tag.</video>');
        }
    });
    
    // Stop video when modal is closed
    $('#mediaModal').on('hidden.bs.modal', function() {
        $('#modalContent video').each(function() {
            this.pause();
            this.currentTime = 0;
        });
    });
});
</script>
@endpush
@endsection