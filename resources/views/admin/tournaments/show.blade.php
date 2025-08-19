@extends('layouts.admin')

@section('title', 'Tournament Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Tournament Details</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.tournaments.index') }}">Tournaments</a></li>
                        <li class="breadcrumb-item active">{{ $tournament->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">{{ $tournament->name }}</h4>
                    <div>
                        <span class="badge bg-{{ $tournament->is_active ? 'success' : 'secondary' }} me-2">
                            {{ $tournament->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        <span class="badge bg-primary">
                            {{ ucfirst($tournament->type) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Short Name:</td>
                                    <td>{{ $tournament->short_name ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Type:</td>
                                    <td>{{ ucfirst($tournament->type) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Format:</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $tournament->format)) }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Season:</td>
                                    <td>{{ $tournament->season ?: 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Start Date:</td>
                                    <td>{{ $tournament->start_date ? $tournament->start_date->format('M d, Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">End Date:</td>
                                    <td>{{ $tournament->end_date ? $tournament->end_date->format('M d, Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Duration:</td>
                                    <td>
                                        @if($tournament->start_date && $tournament->end_date)
                                            {{ $tournament->start_date->diffInDays($tournament->end_date) }} days
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Created:</td>
                                    <td>{{ $tournament->created_at->format('M d, Y') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    @if($tournament->description)
                        <div class="mt-3">
                            <h6 class="fw-bold">Description:</h6>
                            <p class="text-muted">{{ $tournament->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Fixtures Section -->
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Tournament Fixtures</h5>
                    <a href="{{ route('admin.fixtures.create', ['tournament' => $tournament->id]) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i> Add Fixture
                    </a>
                </div>
                <div class="card-body">
                    @if($tournament->fixtures->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Match</th>
                                        <th>Status</th>
                                        <th>Result</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tournament->fixtures->sortBy('match_date') as $fixture)
                                        <tr>
                                            <td>
                                                <div class="fw-bold">{{ $fixture->match_date->format('M d, Y') }}</div>
                                                <small class="text-muted">{{ $fixture->match_date->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <div class="fw-bold">{{ $fixture->homeTeam->name ?? 'TBD' }} vs {{ $fixture->awayTeam->name ?? 'TBD' }}</div>
                                                        @if($fixture->stadium)
                                                            <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ $fixture->stadium }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'scheduled' => 'secondary',
                                                        'live' => 'success',
                                                        'completed' => 'primary',
                                                        'postponed' => 'warning',
                                                        'cancelled' => 'danger'
                                                    ];
                                                @endphp
                                                <span class="badge bg-{{ $statusColors[$fixture->status] ?? 'secondary' }}">
                                                    {{ ucfirst($fixture->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($fixture->home_score !== null && $fixture->away_score !== null)
                                                    <span class="fw-bold">{{ $fixture->home_score }} - {{ $fixture->away_score }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.fixtures.show', $fixture) }}" class="btn btn-outline-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.fixtures.edit', $fixture) }}" class="btn btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No fixtures found</h5>
                            <p class="text-muted">Start by adding fixtures to this tournament.</p>
                            <a href="{{ route('admin.fixtures.create', ['tournament' => $tournament->id]) }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Add First Fixture
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Tournament Logo -->
            @if($tournament->logo)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Tournament Logo</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ Storage::url($tournament->logo) }}" 
                             alt="{{ $tournament->name }} Logo" 
                             class="img-fluid" 
                             style="max-width: 200px; max-height: 200px;">
                    </div>
                </div>
            @endif
            
            <!-- Statistics -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-1">{{ $tournament->fixtures->count() }}</h4>
                                <p class="text-muted mb-0">Total Fixtures</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-1">{{ $tournament->fixtures->where('status', 'completed')->count() }}</h4>
                            <p class="text-muted mb-0">Completed</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-warning mb-1">{{ $tournament->fixtures->where('status', 'live')->count() }}</h4>
                                <p class="text-muted mb-0">Live</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-secondary mb-1">{{ $tournament->fixtures->where('status', 'scheduled')->count() }}</h4>
                            <p class="text-muted mb-0">Scheduled</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.tournaments.edit', $tournament) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> Edit Tournament
                        </a>
                        
                        <form action="{{ route('admin.tournaments.toggle-status', $tournament) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-{{ $tournament->is_active ? 'warning' : 'success' }} w-100">
                                <i class="fas fa-{{ $tournament->is_active ? 'pause' : 'play' }} me-1"></i>
                                {{ $tournament->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        
                        <a href="{{ route('admin.fixtures.create', ['tournament' => $tournament->id]) }}" class="btn btn-info">
                            <i class="fas fa-plus me-1"></i> Add Fixture
                        </a>
                        
                        <hr>
                        
                        <form action="{{ route('admin.tournaments.destroy', $tournament) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this tournament? This action cannot be undone and will affect all associated fixtures.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-1"></i> Delete Tournament
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <a href="{{ route('admin.tournaments.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Tournaments
            </a>
        </div>
    </div>
</div>
@endsection