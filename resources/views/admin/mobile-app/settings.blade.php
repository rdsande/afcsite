@extends('layouts.admin')

@section('title', 'Mobile App Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Mobile App Settings</h3>
                    <div>
                        <button type="button" class="btn btn-info btn-sm" onclick="previewConfig()">
                            <i class="fas fa-eye"></i> Preview
                        </button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="resetToDefaults()">
                            <i class="fas fa-undo"></i> Reset to Defaults
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Navigation Tabs -->
                    <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="config-tab" data-toggle="tab" href="#config" role="tab">
                                <i class="fas fa-cog"></i> App Configuration
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="assets-tab" data-toggle="tab" href="#assets" role="tab">
                                <i class="fas fa-images"></i> Assets & Media
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="advantages-tab" data-toggle="tab" href="#advantages" role="tab">
                                <i class="fas fa-star"></i> App Advantages
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="settingsTabContent">
                        <!-- App Configuration Tab -->
                        <div class="tab-pane fade show active" id="config" role="tabpanel">
                            <form action="{{ route('admin.mobile-app.update-config') }}" method="POST" class="mt-3">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="app_name">App Name</label>
                                            <input type="text" class="form-control @error('app_name') is-invalid @enderror" 
                                                   id="app_name" name="app_name" value="{{ old('app_name', $settings['app_name']) }}" required>
                                            @error('app_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="app_version">App Version</label>
                                            <input type="text" class="form-control @error('app_version') is-invalid @enderror" 
                                                   id="app_version" name="app_version" value="{{ old('app_version', $settings['app_version']) }}" required>
                                            @error('app_version')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="team_name">Team Name</label>
                                            <input type="text" class="form-control @error('team_name') is-invalid @enderror" 
                                                   id="team_name" name="team_name" value="{{ old('team_name', $settings['team_name']) }}" required>
                                            @error('team_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="team_description">Team Description</label>
                                            <input type="text" class="form-control @error('team_description') is-invalid @enderror" 
                                                   id="team_description" name="team_description" value="{{ old('team_description', $settings['team_description']) }}">
                                            @error('team_description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="welcome_title">Welcome Title</label>
                                    <input type="text" class="form-control @error('welcome_title') is-invalid @enderror" 
                                           id="welcome_title" name="welcome_title" value="{{ old('welcome_title', $settings['welcome_title']) }}" required>
                                    @error('welcome_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="welcome_message">Welcome Message</label>
                                    <textarea class="form-control @error('welcome_message') is-invalid @enderror" 
                                              id="welcome_message" name="welcome_message" rows="3" required>{{ old('welcome_message', $settings['welcome_message']) }}</textarea>
                                    @error('welcome_message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="primary_color">Primary Color</label>
                                            <input type="color" class="form-control @error('primary_color') is-invalid @enderror" 
                                                   id="primary_color" name="primary_color" value="{{ old('primary_color', $settings['primary_color']) }}" required>
                                            @error('primary_color')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="secondary_color">Secondary Color</label>
                                            <input type="color" class="form-control @error('secondary_color') is-invalid @enderror" 
                                                   id="secondary_color" name="secondary_color" value="{{ old('secondary_color', $settings['secondary_color']) }}" required>
                                            @error('secondary_color')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="enable_notifications" 
                                                       name="enable_notifications" value="1" {{ old('enable_notifications', $settings['enable_notifications']) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="enable_notifications">Enable Notifications</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="enable_shop" 
                                                       name="enable_shop" value="1" {{ old('enable_shop', $settings['enable_shop']) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="enable_shop">Enable Shop</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="enable_news" 
                                                       name="enable_news" value="1" {{ old('enable_news', $settings['enable_news']) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="enable_news">Enable News</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="enable_fixtures" 
                                                       name="enable_fixtures" value="1" {{ old('enable_fixtures', $settings['enable_fixtures']) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="enable_fixtures">Enable Fixtures</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Configuration
                                </button>
                            </form>
                        </div>

                        <!-- Assets & Media Tab -->
                        <div class="tab-pane fade" id="assets" role="tabpanel">
                            <div class="mt-3">
                                <div class="row">
                                    <!-- Logo Upload -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">App Logo</h5>
                                            </div>
                                            <div class="card-body">
                                                <form action="{{ route('admin.mobile-app.upload-logo') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="logo">Upload Logo (PNG, JPG, JPEG, SVG - Max 2MB)</label>
                                                        <input type="file" class="form-control-file @error('logo') is-invalid @enderror" 
                                                               id="logo" name="logo" accept="image/*" required>
                                                        @error('logo')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-upload"></i> Upload Logo
                                                    </button>
                                                </form>
                                                @if(Storage::exists('mobile-app/logo.png'))
                                                    <div class="mt-3">
                                                        <img src="{{ Storage::url('mobile-app/logo.png') }}" alt="Current Logo" class="img-thumbnail" style="max-width: 150px;">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Splash Screens -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-title mb-0">Splash Screens</h5>
                                            </div>
                                            <div class="card-body">
                                                <form action="{{ route('admin.mobile-app.upload-splash') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="screen_type">Screen Type</label>
                                                        <select class="form-control @error('screen_type') is-invalid @enderror" id="screen_type" name="screen_type" required>
                                                            <option value="">Select Screen Type</option>
                                                            <option value="welcome">Welcome Screen</option>
                                                            <option value="advantages">Advantages Screen</option>
                                                            <option value="language">Language Selection Screen</option>
                                                        </select>
                                                        @error('screen_type')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="splash_screen">Upload Image (PNG, JPG, JPEG - Max 5MB)</label>
                                                        <input type="file" class="form-control-file @error('splash_screen') is-invalid @enderror" 
                                                               id="splash_screen" name="splash_screen" accept="image/*" required>
                                                        @error('splash_screen')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-upload"></i> Upload Splash Screen
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Current Splash Screens -->
                                <div class="row mt-3">
                                    @foreach(['welcome', 'advantages', 'language'] as $type)
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6 class="card-title mb-0">{{ ucfirst($type) }} Screen</h6>
                                                </div>
                                                <div class="card-body text-center">
                                                    @if(Storage::exists("mobile-app/splash_{$type}.png"))
                                                        <img src="{{ Storage::url("mobile-app/splash_{$type}.png") }}" alt="{{ ucfirst($type) }} Screen" class="img-thumbnail" style="max-width: 100%;">
                                                    @else
                                                        <div class="text-muted">
                                                            <i class="fas fa-image fa-3x"></i>
                                                            <p class="mt-2">No image uploaded</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- App Advantages Tab -->
                        <div class="tab-pane fade" id="advantages" role="tabpanel">
                            <form action="{{ route('admin.mobile-app.update-advantages') }}" method="POST" class="mt-3">
                                @csrf
                                <div id="advantages-container">
                                    @php
                                        $advantages = app('App\Http\Controllers\Admin\MobileAppSettingsController')->getAdvantages();
                                    @endphp
                                    @foreach($advantages as $index => $advantage)
                                        <div class="advantage-item card mb-3">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0">Advantage {{ $index + 1 }}</h6>
                                                <button type="button" class="btn btn-danger btn-sm remove-advantage">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Title</label>
                                                            <input type="text" class="form-control" name="advantages[{{ $index }}][title]" 
                                                                   value="{{ old("advantages.{$index}.title", $advantage['title']) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <textarea class="form-control" name="advantages[{{ $index }}][description]" 
                                                                      rows="2" required>{{ old("advantages.{$index}.description", $advantage['description']) }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Icon</label>
                                                            <input type="text" class="form-control" name="advantages[{{ $index }}][icon]" 
                                                                   value="{{ old("advantages.{$index}.icon", $advantage['icon']) }}" placeholder="star">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mb-3">
                                    <button type="button" class="btn btn-success" id="add-advantage">
                                        <i class="fas fa-plus"></i> Add Advantage
                                    </button>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Advantages
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mobile App Preview</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="preview-content">
                <!-- Preview content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    var advantageIndex = {{ count($advantages) }};

    // Add new advantage
    $('#add-advantage').click(function() {
        var advantageHtml = '<div class="advantage-item card mb-3">' +
            '<div class="card-header d-flex justify-content-between align-items-center">' +
                '<h6 class="mb-0">Advantage ' + (advantageIndex + 1) + '</h6>' +
                '<button type="button" class="btn btn-danger btn-sm remove-advantage">' +
                    '<i class="fas fa-trash"></i>' +
                '</button>' +
            '</div>' +
            '<div class="card-body">' +
                '<div class="row">' +
                    '<div class="col-md-4">' +
                        '<div class="form-group">' +
                            '<label>Title</label>' +
                            '<input type="text" class="form-control" name="advantages[' + advantageIndex + '][title]" required>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                        '<div class="form-group">' +
                            '<label>Description</label>' +
                            '<textarea class="form-control" name="advantages[' + advantageIndex + '][description]" rows="2" required></textarea>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-2">' +
                        '<div class="form-group">' +
                            '<label>Icon</label>' +
                            '<input type="text" class="form-control" name="advantages[' + advantageIndex + '][icon]" placeholder="star">' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>';
        $('#advantages-container').append(advantageHtml);
        advantageIndex++;
    });

    // Remove advantage
    $(document).on('click', '.remove-advantage', function() {
        if ($('.advantage-item').length > 1) {
            $(this).closest('.advantage-item').remove();
        } else {
            alert('At least one advantage is required.');
        }
    });
});

// Preview configuration
function previewConfig() {
    $.get('{{ route("admin.mobile-app.preview") }}', function(response) {
        if (response.success) {
            var data = response.data;
            var previewHtml = '<div class="row">' +
                '<div class="col-md-6">' +
                    '<h6>App Configuration</h6>' +
                    '<table class="table table-sm">' +
                        '<tr><td><strong>App Name:</strong></td><td>' + data.settings.app_name + '</td></tr>' +
                        '<tr><td><strong>Version:</strong></td><td>' + data.settings.app_version + '</td></tr>' +
                        '<tr><td><strong>Team:</strong></td><td>' + data.settings.team_name + '</td></tr>' +
                        '<tr><td><strong>Welcome Title:</strong></td><td>' + data.settings.welcome_title + '</td></tr>' +
                    '</table>' +
                '</div>' +
                '<div class="col-md-6">' +
                    '<h6>Features Enabled</h6>' +
                    '<ul class="list-unstyled">' +
                        '<li><i class="fas fa-' + (data.settings.enable_news ? 'check text-success' : 'times text-danger') + '"></i> News</li>' +
                        '<li><i class="fas fa-' + (data.settings.enable_fixtures ? 'check text-success' : 'times text-danger') + '"></i> Fixtures</li>' +
                        '<li><i class="fas fa-' + (data.settings.enable_shop ? 'check text-success' : 'times text-danger') + '"></i> Shop</li>' +
                        '<li><i class="fas fa-' + (data.settings.enable_notifications ? 'check text-success' : 'times text-danger') + '"></i> Notifications</li>' +
                    '</ul>' +
                '</div>' +
            '</div>' +
            '<hr>' +
            '<h6>App Advantages</h6>' +
            '<div class="row">';
            
            data.advantages.forEach(function(advantage) {
                previewHtml += '<div class="col-md-6 mb-2">' +
                    '<div class="d-flex align-items-center">' +
                        '<i class="fas fa-' + advantage.icon + ' mr-2"></i>' +
                        '<div>' +
                            '<strong>' + advantage.title + '</strong><br>' +
                            '<small class="text-muted">' + advantage.description + '</small>' +
                        '</div>' +
                    '</div>' +
                '</div>';
            });
            
            previewHtml += '</div>';
            
            $('#preview-content').html(previewHtml);
            $('#previewModal').modal('show');
        }
    });
}

// Reset to defaults
function resetToDefaults() {
    if (confirm('Are you sure you want to reset all settings to defaults? This action cannot be undone.')) {
        window.location.href = '{{ route("admin.mobile-app.reset-defaults") }}';
    }
}
</script>
@endsection