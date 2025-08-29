@extends('layouts.admin')

@section('title', 'Edit Exclusive Story')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Exclusive Story</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.exclusive-stories.index') }}">Exclusive Stories</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                            <h3 class="card-title">Edit Story: {{ $exclusiveStory->title }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <form action="{{ route('admin.exclusive-stories.update', $exclusiveStory) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-8">
                                        <!-- Title -->
                                        <div class="form-group">
                                            <label for="title">Story Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                                   id="title" name="title" value="{{ old('title', $exclusiveStory->title) }}" 
                                                   placeholder="Enter story title" required>
                                            @error('title')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Description -->
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                      id="description" name="description" rows="4" 
                                                      placeholder="Enter story description (optional)">{{ old('description', $exclusiveStory->description) }}</textarea>
                                            @error('description')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Video Link -->
                                        <div class="form-group" id="video-link-group" style="display: none;">
                                            <label for="video_link">Video Link</label>
                                            <input type="url" class="form-control @error('video_link') is-invalid @enderror" 
                                                   id="video_link" name="video_link" value="{{ old('video_link', $exclusiveStory->video_link) }}" 
                                                   placeholder="Enter YouTube or Vimeo video URL">
                                            @error('video_link')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                            <small class="form-text text-muted">
                                                <i class="fas fa-info-circle"></i> 
                                                Enter a YouTube or Vimeo video URL (e.g., https://www.youtube.com/watch?v=VIDEO_ID)
                                            </small>
                                        </div>

                                        <!-- Thumbnail Upload for Video -->
                                        <div class="form-group" id="thumbnail-upload-group" style="display: {{ old('type', $exclusiveStory->type) === 'video' ? 'block' : 'none' }};">
                                            <label for="thumbnail">Video Thumbnail</label>
                                            @if($exclusiveStory->thumbnail)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $exclusiveStory->thumbnail) }}" class="img-thumbnail" style="max-height: 100px;">
                                                    <small class="text-muted d-block">Current thumbnail</small>
                                                </div>
                                            @endif
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('thumbnail') is-invalid @enderror" 
                                                       id="thumbnail" name="thumbnail" 
                                                       accept="image/*">
                                                <label class="custom-file-label" for="thumbnail">Choose new thumbnail image...</label>
                                                @error('thumbnail')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <small class="form-text text-muted">
                                                <i class="fas fa-info-circle"></i> 
                                                Upload a thumbnail image for your video (JPG, PNG, GIF - Max 5MB)
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <!-- Type -->
                                        <div class="form-group">
                                            <label for="type">Story Type <span class="text-danger">*</span></label>
                                            <select class="form-control @error('type') is-invalid @enderror" 
                                                    id="type" name="type" required>
                                                <option value="">Select Type</option>
                                                <option value="photos" {{ old('type', $exclusiveStory->type) === 'photos' ? 'selected' : '' }}>Photos Gallery</option>
                                                <option value="video" {{ old('type', $exclusiveStory->type) === 'video' ? 'selected' : '' }}>Video</option>
                                            </select>
                                            @error('type')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Status -->
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $exclusiveStory->is_active) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="is_active">Active Story</label>
                                            </div>
                                            <small class="form-text text-muted">Toggle to make this story visible to members</small>
                                        </div>

                                        <!-- Featured -->
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $exclusiveStory->is_featured) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="is_featured">Featured Story</label>
                                            </div>
                                            <small class="form-text text-muted">Featured stories appear on mobile app home screen</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Current Media -->
                                @if($exclusiveStory->media_paths)
                                @php
                                    $mediaFiles = $exclusiveStory->media_paths ?? [];
                                @endphp
                                    @if(count($mediaFiles) > 0)
                                        <div class="form-group">
                                            <label>Current Media Files</label>
                                            <div class="row" id="current-media">
                                                @foreach($mediaFiles as $index => $media)
                                                    <div class="col-md-2 mb-3" data-media-index="{{ $index }}">
                                                        <div class="card">
                                                            @if(in_array(pathinfo($media, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                                <img src="{{ asset('storage/' . $media) }}" class="card-img-top" style="height: 120px; object-fit: cover;">
                                                            @else
                                                                <video class="card-img-top" style="height: 120px; object-fit: cover;" controls>
                                                                    <source src="{{ asset('storage/' . $media) }}" type="video/mp4">
                                                                </video>
                                                            @endif
                                                            <div class="card-body p-2">
                                                                <button type="button" class="btn btn-danger btn-sm btn-block remove-media" 
                                                                        data-media="{{ $media }}" data-index="{{ $index }}">
                                                                    <i class="fas fa-trash"></i> Remove
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                <!-- New Media Upload Section -->
                                <div class="form-group" id="media-files-group">
                                    <label for="media_files">Add New Media Files <span id="media-required" class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('media_files') is-invalid @enderror" 
                                               id="media_files" name="media_files[]" multiple 
                                               accept="image/*,video/*">
                                        <label class="custom-file-label" for="media_files">Choose files...</label>
                                        @error('media_files')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                        @error('media_files.*')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i> 
                                        Maximum file size: 20MB per file. 
                                        Supported formats: JPG, PNG, GIF, MP4, MOV, AVI.
                                        For video stories, you can either upload files or provide a video link.
                                        New files will be added to existing media.
                                    </small>
                                </div>

                                <!-- Preview Area -->
                                <div id="preview-area" class="mt-3" style="display: none;">
                                    <h5>New Files Preview:</h5>
                                    <div id="preview-container" class="row"></div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Story
                                </button>
                                <a href="{{ route('admin.exclusive-stories.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                                <a href="{{ route('admin.exclusive-stories.show', $exclusiveStory) }}" class="btn btn-info">
                                    <i class="fas fa-eye"></i> View Story
                                </a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Update file input label
    $('#media_files').on('change', function() {
        var files = this.files;
        var label = $(this).next('.custom-file-label');
        
        if (files.length === 1) {
            label.text(files[0].name);
        } else if (files.length > 1) {
            label.text(files.length + ' files selected');
        } else {
            label.text('Choose files...');
        }
        
        // Show preview
        showPreview(files);
    });
    
    // Update thumbnail file input label
    $('#thumbnail').on('change', function() {
        var files = this.files;
        var label = $(this).next('.custom-file-label');
        
        if (files.length === 1) {
            label.text(files[0].name);
        } else {
            label.text('Choose new thumbnail image...');
        }
    });
    
    // Remove media handler
    $('.remove-media').on('click', function() {
        var mediaPath = $(this).data('media');
        var index = $(this).data('index');
        var card = $(this).closest('[data-media-index]');
        
        if (confirm('Are you sure you want to remove this media file?')) {
            $.ajax({
                url: '{{ route("admin.exclusive-stories.remove-media", $exclusiveStory) }}',
                method: 'DELETE',
                data: {
                    media_path: mediaPath,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        card.fadeOut(300, function() {
                            $(this).remove();
                        });
                        
                        // Show success message
                        if ($('.alert-success').length === 0) {
                            $('.card-body').prepend('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Media file removed successfully.</div>');
                        }
                    } else {
                        alert('Error removing media file: ' + response.message);
                    }
                },
                error: function() {
                    alert('Error removing media file. Please try again.');
                }
            });
        }
    });
    
    // Type change handler
    $('#type').on('change', function() {
        var type = $(this).val();
        var fileInput = $('#media_files');
        var videoLinkGroup = $('#video-link-group');
        var thumbnailUploadGroup = $('#thumbnail-upload-group');
        
        if (type === 'photos') {
            fileInput.attr('accept', 'image/*');
            fileInput.attr('multiple', true);
            videoLinkGroup.hide();
            thumbnailUploadGroup.hide();
        } else if (type === 'video') {
            fileInput.attr('accept', 'video/*');
            fileInput.attr('multiple', false);
            videoLinkGroup.show();
            thumbnailUploadGroup.show();
        } else {
            videoLinkGroup.hide();
            thumbnailUploadGroup.hide();
        }
        
        // Clear current selection
        fileInput.val('');
        fileInput.next('.custom-file-label').text('Choose files...');
        $('#thumbnail').val('');
        $('#thumbnail').next('.custom-file-label').text('Choose new thumbnail image...');
        $('#preview-area').hide();
        
        // Update media files requirement based on video link
        updateMediaRequirement();
    });
    
    // Video link change handler
    $('#video_link').on('input', function() {
        updateMediaRequirement();
    });
    
    // Function to update media files requirement
    function updateMediaRequirement() {
        var type = $('#type').val();
        var videoLink = $('#video_link').val().trim();
        var mediaFiles = $('#media_files')[0].files;
        var hasExistingMedia = $('#current-media .col-md-2').length > 0;
        
        if (type === 'video' && (videoLink || mediaFiles.length > 0 || hasExistingMedia)) {
            $('#media_files').removeAttr('required');
            $('#media-required').hide();
        } else if (type === 'video') {
            $('#media_files').attr('required', true);
            $('#media-required').show();
        } else if (type === 'photos') {
            if (hasExistingMedia) {
                $('#media_files').removeAttr('required');
                $('#media-required').hide();
            } else {
                $('#media_files').attr('required', true);
                $('#media-required').show();
            }
        }
    }
    
    // Initialize on page load
    var initialType = $('#type').val();
    if (initialType === 'video') {
        $('#video-link-group').show();
        $('#thumbnail-upload-group').show();
    }
    updateMediaRequirement();
    
    function showPreview(files) {
        var previewContainer = $('#preview-container');
        var previewArea = $('#preview-area');
        
        previewContainer.empty();
        
        if (files.length === 0) {
            previewArea.hide();
            return;
        }
        
        previewArea.show();
        
        for (var i = 0; i < Math.min(files.length, 6); i++) {
            var file = files[i];
            var reader = new FileReader();
            
            reader.onload = function(e) {
                var col = $('<div class="col-md-2 mb-2"></div>');
                
                if (file.type.startsWith('image/')) {
                    col.html('<img src="' + e.target.result + '" class="img-fluid rounded" style="height: 100px; object-fit: cover;">');
                } else if (file.type.startsWith('video/')) {
                    col.html('<video class="img-fluid rounded" style="height: 100px; object-fit: cover;" controls><source src="' + e.target.result + '" type="' + file.type + '"></video>');
                }
                
                previewContainer.append(col);
            };
            
            reader.readAsDataURL(file);
        }
        
        if (files.length > 6) {
            previewContainer.append('<div class="col-md-2 mb-2"><div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 100px;"><span class="text-muted">+' + (files.length - 6) + ' more</span></div></div>');
        }
    }
});
</script>
@endpush
@endsection