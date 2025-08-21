@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add New Vendor</h3>
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

                    <form action="{{ route('admin.vendors.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Vendor Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                                           id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required>
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
                                        <option value="Dar es Salaam" {{ old('region') == 'Dar es Salaam' ? 'selected' : '' }}>Dar es Salaam</option>
                                        <option value="Mwanza" {{ old('region') == 'Mwanza' ? 'selected' : '' }}>Mwanza</option>
                                        <option value="Arusha" {{ old('region') == 'Arusha' ? 'selected' : '' }}>Arusha</option>
                                        <option value="Dodoma" {{ old('region') == 'Dodoma' ? 'selected' : '' }}>Dodoma</option>
                                        <option value="Mbeya" {{ old('region') == 'Mbeya' ? 'selected' : '' }}>Mbeya</option>
                                        <option value="Kilimanjaro" {{ old('region') == 'Kilimanjaro' ? 'selected' : '' }}>Kilimanjaro</option>
                                        <option value="Tanga" {{ old('region') == 'Tanga' ? 'selected' : '' }}>Tanga</option>
                                        <option value="Morogoro" {{ old('region') == 'Morogoro' ? 'selected' : '' }}>Morogoro</option>
                                        <option value="Pwani" {{ old('region') == 'Pwani' ? 'selected' : '' }}>Pwani</option>
                                        <option value="Lindi" {{ old('region') == 'Lindi' ? 'selected' : '' }}>Lindi</option>
                                        <option value="Mtwara" {{ old('region') == 'Mtwara' ? 'selected' : '' }}>Mtwara</option>
                                        <option value="Ruvuma" {{ old('region') == 'Ruvuma' ? 'selected' : '' }}>Ruvuma</option>
                                        <option value="Iringa" {{ old('region') == 'Iringa' ? 'selected' : '' }}>Iringa</option>
                                        <option value="Njombe" {{ old('region') == 'Njombe' ? 'selected' : '' }}>Njombe</option>
                                        <option value="Rukwa" {{ old('region') == 'Rukwa' ? 'selected' : '' }}>Rukwa</option>
                                        <option value="Katavi" {{ old('region') == 'Katavi' ? 'selected' : '' }}>Katavi</option>
                                        <option value="Songwe" {{ old('region') == 'Songwe' ? 'selected' : '' }}>Songwe</option>
                                        <option value="Kigoma" {{ old('region') == 'Kigoma' ? 'selected' : '' }}>Kigoma</option>
                                        <option value="Tabora" {{ old('region') == 'Tabora' ? 'selected' : '' }}>Tabora</option>
                                        <option value="Singida" {{ old('region') == 'Singida' ? 'selected' : '' }}>Singida</option>
                                        <option value="Simiyu" {{ old('region') == 'Simiyu' ? 'selected' : '' }}>Simiyu</option>
                                        <option value="Shinyanga" {{ old('region') == 'Shinyanga' ? 'selected' : '' }}>Shinyanga</option>
                                        <option value="Geita" {{ old('region') == 'Geita' ? 'selected' : '' }}>Geita</option>
                                        <option value="Kagera" {{ old('region') == 'Kagera' ? 'selected' : '' }}>Kagera</option>
                                        <option value="Mara" {{ old('region') == 'Mara' ? 'selected' : '' }}>Mara</option>
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
                                           id="district" name="district" value="{{ old('district') }}" required>
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
                                           id="ward" name="ward" value="{{ old('ward') }}">
                                    @error('ward')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="street">Street</label>
                                    <input type="text" class="form-control @error('street') is-invalid @enderror" 
                                           id="street" name="street" value="{{ old('street') }}">
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
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active Vendor
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Vendor
                            </button>
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