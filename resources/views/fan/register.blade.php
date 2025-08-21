@extends('layouts.app')

@section('title', 'Fan Registration - AZAM FC')

@section('content')
<div class="uk-section uk-section-default">
    <div class="uk-container uk-container-small">
        <div class="uk-card uk-card-default uk-card-body uk-box-shadow-large">
            <div class="uk-text-center uk-margin-bottom">
                <h1 class="uk-heading-medium uk-text-primary">Join AZAM FC Family</h1>
                <p class="uk-text-lead">Register as an official AZAM FC fan and get exclusive benefits!</p>
            </div>

            @if ($errors->any())
                <div class="uk-alert-danger" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <ul class="uk-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('fan.register.submit') }}" class="uk-form-stacked">
                @csrf
                
                <div class="uk-grid-small" uk-grid>
                    <!-- First Name -->
                    <div class="uk-width-1-2@s">
                        <label class="uk-form-label" for="first_name">First Name *</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="first_name" name="first_name" type="text" 
                                   value="{{ old('first_name') }}" required>
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div class="uk-width-1-2@s">
                        <label class="uk-form-label" for="last_name">Last Name *</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="last_name" name="last_name" type="text" 
                                   value="{{ old('last_name') }}" required>
                        </div>
                    </div>
                </div>

                <div class="uk-grid-small uk-margin" uk-grid>
                    <!-- Date of Birth -->
                    <div class="uk-width-1-2@s">
                        <label class="uk-form-label" for="date_of_birth">Date of Birth *</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="date_of_birth" name="date_of_birth" type="date" 
                                   value="{{ old('date_of_birth') }}" required>
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="uk-width-1-2@s">
                        <label class="uk-form-label" for="gender">Gender *</label>
                        <div class="uk-form-controls">
                            <select class="uk-select" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Phone Number -->
                <div class="uk-margin">
                    <label class="uk-form-label" for="phone">Phone Number *</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="phone" name="phone" type="tel" 
                               placeholder="e.g., +255712345678" value="{{ old('phone') }}" required>
                        <small class="uk-text-muted">This will be used for login</small>
                    </div>
                </div>

                <!-- Email (Optional) -->
                <div class="uk-margin">
                    <label class="uk-form-label" for="email">Email Address (Optional)</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="email" name="email" type="email" 
                               value="{{ old('email') }}">
                    </div>
                </div>

                <div class="uk-grid-small uk-margin" uk-grid>
                    <!-- Region -->
                    <div class="uk-width-1-2@s">
                        <label class="uk-form-label" for="region_id">Region *</label>
                        <div class="uk-form-controls">
                            <select class="uk-select" id="region_id" name="region_id" required>
                                <option value="">Select Region</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                        {{ $region->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- District -->
                    <div class="uk-width-1-2@s">
                        <label class="uk-form-label" for="district_id">District *</label>
                        <div class="uk-form-controls">
                            <select class="uk-select" id="district_id" name="district_id" required disabled>
                                <option value="">Select District</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="uk-grid-small uk-margin" uk-grid>
                    <!-- Ward -->
                    <div class="uk-width-1-2@s">
                        <label class="uk-form-label" for="ward">Ward</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="ward" name="ward" type="text" 
                                   value="{{ old('ward') }}">
                        </div>
                    </div>

                    <!-- Street -->
                    <div class="uk-width-1-2@s">
                        <label class="uk-form-label" for="street">Street</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="street" name="street" type="text" 
                                   value="{{ old('street') }}">
                        </div>
                    </div>
                </div>

                <div class="uk-grid-small uk-margin" uk-grid>
                    <!-- Password -->
                    <div class="uk-width-1-2@s">
                        <label class="uk-form-label" for="password">Password *</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="password" name="password" type="password" 
                                   minlength="6" required>
                            <small class="uk-text-muted">Minimum 6 characters</small>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="uk-width-1-2@s">
                        <label class="uk-form-label" for="password_confirmation">Confirm Password *</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="password_confirmation" name="password_confirmation" 
                                   type="password" minlength="6" required>
                        </div>
                    </div>
                </div>

                <div class="uk-margin uk-text-center">
                    <button class="uk-button uk-button-primary uk-button-large" type="submit">
                        <span uk-icon="user"></span> Register as Fan
                    </button>
                </div>

                <div class="uk-text-center uk-margin">
                    <p>Already have an account? <a href="{{ route('fan.login') }}" class="uk-link">Login here</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Cascading dropdown for Region -> District
const apiUrl = '{{ url('fan/api/districts') }}';
const oldDistrictId = '{{ old('district_id') }}';

document.getElementById('region_id').addEventListener('change', function() {
    const regionId = this.value;
    const districtSelect = document.getElementById('district_id');
    
    // Clear and disable district dropdown
    districtSelect.innerHTML = '<option value="">Select District</option>';
    districtSelect.disabled = true;
    
    if (regionId) {
        // Fetch districts for selected region
        fetch(apiUrl + '/' + regionId)
            .then(response => response.json())
            .then(districts => {
                districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.id;
                    option.textContent = district.name;
                    
                    // Restore old selection if exists
                    if (oldDistrictId == district.id) {
                        option.selected = true;
                    }
                    
                    districtSelect.appendChild(option);
                });
                districtSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error fetching districts:', error);
            });
    }
});

// Trigger change event on page load if region is pre-selected
if (document.getElementById('region_id').value) {
    document.getElementById('region_id').dispatchEvent(new Event('change'));
}
</script>
@endsection