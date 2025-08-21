@extends('layouts.admin')

@section('title', 'Edit Fan - ' . $fan->full_name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.fans.index') }}">Fans</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.fans.show', $fan) }}">{{ $fan->full_name }}</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Fan Information</h3>
                </div>
                
                <form method="POST" action="{{ route('admin.fans.update', $fan) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                           id="first_name" name="first_name" 
                                           value="{{ old('first_name', $fan->first_name) }}" required>
                                    @error('first_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           id="last_name" name="last_name" 
                                           value="{{ old('last_name', $fan->last_name) }}" required>
                                    @error('last_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" 
                                           value="{{ old('phone', $fan->phone) }}" required>
                                    @error('phone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" 
                                           value="{{ old('email', $fan->email) }}">
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">Gender <span class="text-danger">*</span></label>
                                    <select class="form-control @error('gender') is-invalid @enderror" 
                                            id="gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender', $fan->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $fan->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $fan->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="region">Region <span class="text-danger">*</span></label>
                                    <select class="form-control @error('region') is-invalid @enderror" 
                                            id="region" name="region" required>
                                        <option value="">Select Region</option>
                                        <option value="Arusha" {{ old('region', $fan->region) == 'Arusha' ? 'selected' : '' }}>Arusha</option>
                                        <option value="Dar es Salaam" {{ old('region', $fan->region) == 'Dar es Salaam' ? 'selected' : '' }}>Dar es Salaam</option>
                                        <option value="Dodoma" {{ old('region', $fan->region) == 'Dodoma' ? 'selected' : '' }}>Dodoma</option>
                                        <option value="Geita" {{ old('region', $fan->region) == 'Geita' ? 'selected' : '' }}>Geita</option>
                                        <option value="Iringa" {{ old('region', $fan->region) == 'Iringa' ? 'selected' : '' }}>Iringa</option>
                                        <option value="Kagera" {{ old('region', $fan->region) == 'Kagera' ? 'selected' : '' }}>Kagera</option>
                                        <option value="Katavi" {{ old('region', $fan->region) == 'Katavi' ? 'selected' : '' }}>Katavi</option>
                                        <option value="Kigoma" {{ old('region', $fan->region) == 'Kigoma' ? 'selected' : '' }}>Kigoma</option>
                                        <option value="Kilimanjaro" {{ old('region', $fan->region) == 'Kilimanjaro' ? 'selected' : '' }}>Kilimanjaro</option>
                                        <option value="Lindi" {{ old('region', $fan->region) == 'Lindi' ? 'selected' : '' }}>Lindi</option>
                                        <option value="Manyara" {{ old('region', $fan->region) == 'Manyara' ? 'selected' : '' }}>Manyara</option>
                                        <option value="Mara" {{ old('region', $fan->region) == 'Mara' ? 'selected' : '' }}>Mara</option>
                                        <option value="Mbeya" {{ old('region', $fan->region) == 'Mbeya' ? 'selected' : '' }}>Mbeya</option>
                                        <option value="Morogoro" {{ old('region', $fan->region) == 'Morogoro' ? 'selected' : '' }}>Morogoro</option>
                                        <option value="Mtwara" {{ old('region', $fan->region) == 'Mtwara' ? 'selected' : '' }}>Mtwara</option>
                                        <option value="Mwanza" {{ old('region', $fan->region) == 'Mwanza' ? 'selected' : '' }}>Mwanza</option>
                                        <option value="Njombe" {{ old('region', $fan->region) == 'Njombe' ? 'selected' : '' }}>Njombe</option>
                                        <option value="Pwani" {{ old('region', $fan->region) == 'Pwani' ? 'selected' : '' }}>Pwani</option>
                                        <option value="Rukwa" {{ old('region', $fan->region) == 'Rukwa' ? 'selected' : '' }}>Rukwa</option>
                                        <option value="Ruvuma" {{ old('region', $fan->region) == 'Ruvuma' ? 'selected' : '' }}>Ruvuma</option>
                                        <option value="Shinyanga" {{ old('region', $fan->region) == 'Shinyanga' ? 'selected' : '' }}>Shinyanga</option>
                                        <option value="Simiyu" {{ old('region', $fan->region) == 'Simiyu' ? 'selected' : '' }}>Simiyu</option>
                                        <option value="Singida" {{ old('region', $fan->region) == 'Singida' ? 'selected' : '' }}>Singida</option>
                                        <option value="Songwe" {{ old('region', $fan->region) == 'Songwe' ? 'selected' : '' }}>Songwe</option>
                                        <option value="Tabora" {{ old('region', $fan->region) == 'Tabora' ? 'selected' : '' }}>Tabora</option>
                                        <option value="Tanga" {{ old('region', $fan->region) == 'Tanga' ? 'selected' : '' }}>Tanga</option>
                                    </select>
                                    @error('region')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="district">District <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('district') is-invalid @enderror" 
                                           id="district" name="district" 
                                           value="{{ old('district', $fan->district) }}" required>
                                    @error('district')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ward">Ward</label>
                                    <input type="text" class="form-control @error('ward') is-invalid @enderror" 
                                           id="ward" name="ward" 
                                           value="{{ old('ward', $fan->ward) }}">
                                    @error('ward')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="street">Street</label>
                            <input type="text" class="form-control @error('street') is-invalid @enderror" 
                                   id="street" name="street" 
                                   value="{{ old('street', $fan->street) }}">
                            @error('street')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        

                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Fan
                        </button>
                        <a href="{{ route('admin.fans.show', $fan) }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Points Management Sidebar -->
        <div class="col-md-4">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Points Management</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <h2 class="text-success">
                            <i class="fas fa-star"></i> {{ number_format($fan->points) }}
                        </h2>
                        <p class="text-muted">Current Points</p>
                    </div>
                    
                    <form method="POST" action="{{ route('admin.fans.add-points', $fan) }}" class="mb-3">
                        @csrf
                        <div class="form-group">
                            <label for="points_add">Add Points</label>
                            <input type="number" class="form-control @error('points') is-invalid @enderror" 
                                   id="points_add" name="points" min="1" max="1000" 
                                   placeholder="Enter points to add">
                            @error('points')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description_add">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description_add" name="description" rows="2" 
                                      placeholder="Reason for adding points..."></textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-plus"></i> Add Points
                        </button>
                    </form>
                    
                    <hr>
                    
                    <form method="POST" action="{{ route('admin.fans.add-points', $fan) }}">
                        @csrf
                        <div class="form-group">
                            <label for="points_subtract">Subtract Points</label>
                            <input type="number" class="form-control" 
                                   id="points_subtract" name="points" min="1" max="{{ $fan->points }}" 
                                   placeholder="Enter points to subtract">
                        </div>
                        <div class="form-group">
                            <label for="description_subtract">Description</label>
                            <textarea class="form-control" 
                                      id="description_subtract" name="description" rows="2" 
                                      placeholder="Reason for subtracting points..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning btn-block" 
                                onclick="document.getElementById('points_subtract').value = '-' + document.getElementById('points_subtract').value">
                            <i class="fas fa-minus"></i> Subtract Points
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Recent Transactions -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Recent Transactions</h3>
                </div>
                <div class="card-body p-0">
                    @if($fan->pointTransactions()->latest()->limit(5)->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($fan->pointTransactions()->latest()->limit(5)->get() as $transaction)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge badge-{{ $transaction->points > 0 ? 'success' : 'danger' }}">
                                                {{ $transaction->points > 0 ? '+' : '' }}{{ $transaction->points }}
                                            </span>
                                            <small class="text-muted d-block">
                                                {{ $transaction->created_at->format('M d, Y H:i') }}
                                            </small>
                                        </div>
                                        <small class="text-muted">
                                            {{ ucfirst(str_replace('_', ' ', $transaction->type)) }}
                                        </small>
                                    </div>
                                    @if($transaction->description)
                                        <small class="text-muted d-block mt-1">
                                            {{ Str::limit($transaction->description, 50) }}
                                        </small>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-star text-muted"></i>
                            <p class="text-muted mb-0">No transactions yet</p>
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
$(document).ready(function() {
    // Auto-focus on first input
    $('#first_name').focus();
    
    // Prevent negative values in points inputs
    $('#points_add, #points_subtract').on('input', function() {
        if (this.value < 0) {
            this.value = Math.abs(this.value);
        }
    });
    
    // Validate subtract points doesn't exceed current points
    $('#points_subtract').on('input', function() {
        const currentPoints = parseInt($(this).attr('max'));
        if (parseInt(this.value) > currentPoints) {
            this.value = currentPoints;
        }
    });
});
</script>
@endpush