@extends('layouts.admin')

@section('title', 'Settings')

@section('breadcrumb')
    <li class="breadcrumb-item active">Settings</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Jersey Image Settings</h3>
                </div>
                
                <form method="POST" action="{{ route('admin.settings.jersey-image.update') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label for="jersey_image">Jersey Image</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('jersey_image') is-invalid @enderror" 
                                           id="jersey_image" name="jersey_image" accept="image/*">
                                    <label class="custom-file-label" for="jersey_image">Choose jersey image</label>
                                </div>
                            </div>
                            @error('jersey_image')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small class="form-text text-muted">
                                Upload a jersey image that will be used for all fan profiles. Maximum file size: 2MB. Supported formats: JPEG, PNG, JPG, GIF.
                            </small>
                        </div>

                        @if($jerseyImage)
                        <div class="form-group">
                            <label>Current Jersey Image</label>
                            <div class="mb-2">
                                <img src="{{ \App\Models\Setting::getJerseyImage() }}" 
                                     alt="Current Jersey" 
                                     class="img-thumbnail" 
                                     style="max-width: 200px; max-height: 200px;">
                            </div>
                            <a href="{{ route('admin.settings.jersey-image.remove') }}" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to remove the current jersey image? This will revert to the default image.')">
                                <i class="fas fa-trash"></i> Remove Current Image
                            </a>
                        </div>
                        @else
                        <div class="form-group">
                            <label>Current Jersey Image</label>
                            <div class="mb-2">
                                <img src="{{ asset('images/jezi.png') }}" 
                                     alt="Default Jersey" 
                                     class="img-thumbnail" 
                                     style="max-width: 200px; max-height: 200px;">
                            </div>
                            <small class="text-muted">Currently using default jersey image</small>
                        </div>
                        @endif
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Jersey Image
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Information</h3>
                </div>
                <div class="card-body">
                    <p><strong>Jersey Image Usage:</strong></p>
                    <ul>
                        <li>This image will be displayed on all fan dashboards</li>
                        <li>Fans can personalize it with their name and number</li>
                        <li>The image should be high quality for best results</li>
                        <li>Recommended dimensions: 400x400 pixels or larger</li>
                    </ul>
                    
                    <p><strong>File Requirements:</strong></p>
                    <ul>
                        <li>Maximum file size: 2MB</li>
                        <li>Supported formats: JPEG, PNG, JPG, GIF</li>
                        <li>Square images work best</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Update file input label when file is selected
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
    });
});
</script>
@endpush