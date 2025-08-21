@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Vendor: {{ $vendor->name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.vendors.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Vendors
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.vendors.update', $vendor) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Vendor Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $vendor->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                                           id="phone_number" name="phone_number" value="{{ old('phone_number', $vendor->phone_number) }}" required>
                                    @error('phone_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="region">Region <span class="text-danger">*</span></label>
                                    <select class="form-control @error('region') is-invalid @enderror" id="region" name="region" required>
                                        <option value="">Select Region</option>
                                        <option value="Dar es Salaam" {{ old('region', $vendor->region) == 'Dar es Salaam' ? 'selected' : '' }}>Dar es Salaam</option>
                                        <option value="Mwanza" {{ old('region', $vendor->region) == 'Mwanza' ? 'selected' : '' }}>Mwanza</option>
                                        <option value="Arusha" {{ old('region', $vendor->region) == 'Arusha' ? 'selected' : '' }}>Arusha</option>
                                        <option value="Dodoma" {{ old('region', $vendor->region) == 'Dodoma' ? 'selected' : '' }}>Dodoma</option>
                                        <option value="Mbeya" {{ old('region', $vendor->region) == 'Mbeya' ? 'selected' : '' }}>Mbeya</option>
                                        <option value="Kilimanjaro" {{ old('region', $vendor->region) == 'Kilimanjaro' ? 'selected' : '' }}>Kilimanjaro</option>
                                        <option value="Tanga" {{ old('region', $vendor->region) == 'Tanga' ? 'selected' : '' }}>Tanga</option>
                                        <option value="Morogoro" {{ old('region', $vendor->region) == 'Morogoro' ? 'selected' : '' }}>Morogoro</option>
                                        <option value="Pwani" {{ old('region', $vendor->region) == 'Pwani' ? 'selected' : '' }}>Pwani</option>
                                        <option value="Lindi" {{ old('region', $vendor->region) == 'Lindi' ? 'selected' : '' }}>Lindi</option>
                                        <option value="Mtwara" {{ old('region', $vendor->region) == 'Mtwara' ? 'selected' : '' }}>Mtwara</option>
                                        <option value="Ruvuma" {{ old('region', $vendor->region) == 'Ruvuma' ? 'selected' : '' }}>Ruvuma</option>
                                        <option value="Iringa" {{ old('region', $vendor->region) == 'Iringa' ? 'selected' : '' }}>Iringa</option>
                                        <option value="Njombe" {{ old('region', $vendor->region) == 'Njombe' ? 'selected' : '' }}>Njombe</option>
                                        <option value="Rukwa" {{ old('region', $vendor->region) == 'Rukwa' ? 'selected' : '' }}>Rukwa</option>
                                        <option value="Katavi" {{ old('region', $vendor->region) == 'Katavi' ? 'selected' : '' }}>Katavi</option>
                                        <option value="Songwe" {{ old('region', $vendor->region) == 'Songwe' ? 'selected' : '' }}>Songwe</option>
                                        <option value="Kigoma" {{ old('region', $vendor->region) == 'Kigoma' ? 'selected' : '' }}>Kigoma</option>
                                        <option value="Tabora" {{ old('region', $vendor->region) == 'Tabora' ? 'selected' : '' }}>Tabora</option>
                                        <option value="Singida" {{ old('region', $vendor->region) == 'Singida' ? 'selected' : '' }}>Singida</option>
                                        <option value="Simiyu" {{ old('region', $vendor->region) == 'Simiyu' ? 'selected' : '' }}>Simiyu</option>
                                        <option value="Shinyanga" {{ old('region', $vendor->region) == 'Shinyanga' ? 'selected' : '' }}>Shinyanga</option>
                                        <option value="Geita" {{ old('region', $vendor->region) == 'Geita' ? 'selected' : '' }}>Geita</option>
                                        <option value="Kagera" {{ old('region', $vendor->region) == 'Kagera' ? 'selected' : '' }}>Kagera</option>
                                        <option value="Mara" {{ old('region', $vendor->region) == 'Mara' ? 'selected' : '' }}>Mara</option>
                                    </select>
                                    @error('region')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="district">District <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('district') is-invalid @enderror" 
                                           id="district" name="district" value="{{ old('district', $vendor->district) }}" required>
                                    @error('district')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ward">Ward</label>
                                    <input type="text" class="form-control @error('ward') is-invalid @enderror" 
                                           id="ward" name="ward" value="{{ old('ward', $vendor->ward) }}">
                                    @error('ward')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="street">Street</label>
                                    <input type="text" class="form-control @error('street') is-invalid @enderror" 
                                           id="street" name="street" value="{{ old('street', $vendor->street) }}">
                                    @error('street')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" 
                                               {{ old('is_active', $vendor->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active Vendor
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Vendor
                            </button>
                            <a href="{{ route('admin.vendors.show', $vendor) }}" class="btn btn-info">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            <a href="{{ route('admin.vendors.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection