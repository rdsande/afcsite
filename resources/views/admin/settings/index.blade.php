@extends('layouts.admin')

@section('title', 'Jersey Management')

@section('breadcrumb')
    <li class="breadcrumb-item active">Jersey Management</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Jersey Templates Management</h3>
                </div>
                
                <div class="card-body">
                    <!-- Jersey Types Tabs -->
                    <ul class="nav nav-tabs" id="jerseyTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab">
                                <i class="fas fa-home"></i> Home Jersey
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="away-tab" data-toggle="tab" href="#away" role="tab">
                                <i class="fas fa-plane"></i> Away Jersey
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="third-tab" data-toggle="tab" href="#third" role="tab">
                                <i class="fas fa-star"></i> Third Jersey
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content mt-3" id="jerseyTabContent">
                        @foreach(['home', 'away', 'third'] as $type)
                        <div class="tab-pane fade {{ $type === 'home' ? 'show active' : '' }}" id="{{ $type }}" role="tabpanel">
                            <div class="row">
                                <div class="col-md-8">
                                    <form method="POST" action="{{ route('admin.jerseys.upload') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="jersey_type" value="{{ $type }}">
                                        
                                        <div class="form-group">
                                            <label for="{{ $type }}_jersey">{{ ucfirst($type) }} Jersey Image</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input @error($type.'_jersey') is-invalid @enderror" 
                                                           id="{{ $type }}_jersey" name="jersey_image" accept="image/*">
                                                    <label class="custom-file-label" for="{{ $type }}_jersey">Choose {{ $type }} jersey image</label>
                                                </div>
                                            </div>
                                            @error($type.'_jersey')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="{{ $type }}_name">Jersey Name</label>
                                            <input type="text" class="form-control" id="{{ $type }}_name" name="jersey_name" 
                                                   placeholder="e.g., AZAM FC {{ ucfirst($type) }} Kit 2024/25" 
                                                   value="AZAM FC {{ ucfirst($type) }} Kit {{ date('Y') }}/{{ date('y', strtotime('+1 year')) }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="{{ $type }}_description">Description (Optional)</label>
                                            <textarea class="form-control" id="{{ $type }}_description" name="description" rows="3" 
                                                      placeholder="Brief description of this jersey..."></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-upload"></i> Upload {{ ucfirst($type) }} Jersey
                                        </button>
                                    </form>
                                </div>
                                
                                <div class="col-md-4">
                                    @php
                                        $currentJersey = $jerseys->where('type', $type)->where('is_active', true)->first();
                                    @endphp
                                    
                                    @if($currentJersey)
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Current {{ ucfirst($type) }} Jersey</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <img src="{{ asset('storage/' . $currentJersey->template_image) }}" 
                                                 alt="{{ $currentJersey->name }}" 
                                                 class="img-thumbnail mb-2" 
                                                 style="max-width: 200px; max-height: 200px;">
                                            <h6>{{ $currentJersey->name }}</h6>
                                            @if($currentJersey->description)
                                                <p class="text-muted small">{{ $currentJersey->description }}</p>
                                            @endif
                                            <div class="mt-2">
                                                <form method="POST" action="{{ route('admin.jerseys.delete', $currentJersey->id) }}" 
                                                      style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" 
                                                            onclick="return confirm('Are you sure you want to delete this jersey?')">
                                                        <i class="fas fa-trash"></i> Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-shirt fa-3x text-muted mb-3"></i>
                                            <h6 class="text-muted">No {{ $type }} jersey uploaded</h6>
                                            <p class="text-muted small">Upload a {{ $type }} jersey image to get started.</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Jersey Management Information</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Jersey Types:</strong></p>
                            <ul>
                                <li><strong>Home Jersey:</strong> Primary team colors, used for home matches</li>
                                <li><strong>Away Jersey:</strong> Alternative colors, used for away matches</li>
                                <li><strong>Third Jersey:</strong> Special design, used when other jerseys clash</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Usage:</strong></p>
                            <ul>
                                <li>Jerseys will be displayed on fan dashboards and mobile app</li>
                                <li>Fans can select their preferred jersey type</li>
                                <li>Fans can personalize jerseys with their name and number</li>
                                <li>Images should be high quality for best results</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <p><strong>File Requirements:</strong></p>
                            <ul>
                                <li>Maximum file size: 2MB</li>
                                <li>Supported formats: JPEG, PNG, JPG, GIF</li>
                                <li>Recommended dimensions: 400x400 pixels or larger</li>
                                <li>Square or rectangular images work best</li>
                            </ul>
                        </div>
                    </div>
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
    
    // Auto-generate jersey names based on type
    $('input[name="jersey_type"]').each(function() {
        var type = $(this).val();
        var currentYear = new Date().getFullYear();
        var nextYear = (currentYear + 1).toString().slice(-2);
        var defaultName = 'AZAM FC ' + type.charAt(0).toUpperCase() + type.slice(1) + ' Kit ' + currentYear + '/' + nextYear;
        
        $(this).closest('form').find('input[name="jersey_name"]').attr('placeholder', defaultName);
    });
});
</script>
@endpush