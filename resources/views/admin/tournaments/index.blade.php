@extends('layouts.admin')

@section('title', 'Tournament Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Tournament Management</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tournaments</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title mb-0">All Tournaments</h4>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.tournaments.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Add Tournament
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Logo</th>
                                    <th>Tournament Name</th>
                                    <th>Type</th>
                                    <th>Season</th>
                                    <th>Duration</th>
                                    <th>Fixtures</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tournaments as $tournament)
                                    <tr>
                                        <td>
                                            @if($tournament->logo)
                                                <img src="{{ asset('storage/' . $tournament->logo) }}" 
                                                     alt="{{ $tournament->name }}" 
                                                     class="rounded" 
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-trophy text-white"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <h6 class="mb-0">{{ $tournament->name }}</h6>
                                                @if($tournament->short_name)
                                                    <small class="text-muted">{{ $tournament->short_name }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ ucfirst($tournament->type) }}</span>
                                            @if($tournament->format)
                                                <br><small class="text-muted">{{ ucfirst(str_replace('_', ' ', $tournament->format)) }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $tournament->season ?? 'N/A' }}</td>
                                        <td>
                                            @if($tournament->start_date && $tournament->end_date)
                                                <small>
                                                    {{ $tournament->start_date->format('M d, Y') }}<br>
                                                    to {{ $tournament->end_date->format('M d, Y') }}
                                                </small>
                                            @elseif($tournament->start_date)
                                                <small>From {{ $tournament->start_date->format('M d, Y') }}</small>
                                            @else
                                                <small class="text-muted">Not set</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $tournament->fixtures_count ?? 0 }} fixtures</span>
                                        </td>
                                        <td>
                                            @if($tournament->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-warning">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.tournaments.show', $tournament) }}" 
                                                   class="btn btn-sm btn-outline-info" 
                                                   title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.tournaments.edit', $tournament) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.tournaments.toggle-status', $tournament) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="btn btn-sm {{ $tournament->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}" 
                                                            title="{{ $tournament->is_active ? 'Deactivate' : 'Activate' }}">
                                                        <i class="fas {{ $tournament->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                                                    </button>
                                                </form>
                                                @if($tournament->fixtures_count == 0)
                                                    <form action="{{ route('admin.tournaments.destroy', $tournament) }}" 
                                                          method="POST" 
                                                          class="d-inline" 
                                                          onsubmit="return confirm('Are you sure you want to delete this tournament?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-outline-danger" 
                                                                title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-trophy fa-3x mb-3"></i>
                                                <p>No tournaments found.</p>
                                                <a href="{{ route('admin.tournaments.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus me-1"></i> Create First Tournament
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($tournaments->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $tournaments->links() }}
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
    // Auto-hide success alerts after 5 seconds
    setTimeout(function() {
        $('.alert-success').fadeOut('slow');
    }, 5000);
</script>
@endpush