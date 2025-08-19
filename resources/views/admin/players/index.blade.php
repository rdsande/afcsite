@extends('layouts.admin')

@section('title', 'Manage Players')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Players</h3>
                    <a href="{{ route('admin.players.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Player
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Filter Tabs -->
                    <ul class="nav nav-tabs mb-3" id="playerTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ !request('team') ? 'active' : '' }}" 
                               href="{{ route('admin.players.index') }}">
                                All Players ({{ $totalCount }})
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ request('team') === 'senior' ? 'active' : '' }}" 
                               href="{{ route('admin.players.index', ['team' => 'senior']) }}">
                                Senior Team ({{ $seniorCount }})
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ request('team') === 'academy' ? 'active' : '' }}" 
                               href="{{ route('admin.players.index', ['team' => 'academy']) }}">
                                Academy ({{ $academyCount }})
                            </a>
                        </li>
                    </ul>

                    <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Jersey #</th>
                                            <th>Player</th>
                                            <th>Position</th>
                                            <th>Team</th>
                                            <th>Age</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($players as $player)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-primary fs-6">
                                                        {{ $player->jersey_number ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($player->profile_image)
                                                <img src="{{ asset('storage/' . $player->profile_image) }}" 
                                                                 alt="{{ $player->name }}" 
                                                                 class="rounded-circle me-2" 
                                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-secondary rounded-circle me-2 d-flex align-items-center justify-content-center" 
                                                                 style="width: 40px; height: 40px;">
                                                                <i class="fas fa-user text-white"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <strong>{{ $player->name }}</strong>
                                                            @if($player->nationality)
                                                                <br><small class="text-muted">{{ $player->nationality }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $player->position ?? 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $player->team_category === 'senior' ? 'success' : 'warning' }}">
                                                {{ ucfirst($player->team_category ?? 'N/A') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($player->date_of_birth)
                                                        {{ \Carbon\Carbon::parse($player->date_of_birth)->age }} years
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $player->status === 'active' ? 'success' : 'secondary' }}">
                                                        {{ ucfirst($player->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('player.show', $player->id) }}" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           target="_blank" 
                                                           title="View Profile">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.players.edit', $player) }}" 
                                                           class="btn btn-sm btn-outline-warning" 
                                                           title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.players.destroy', $player) }}" 
                                                              method="POST" 
                                                              class="d-inline" 
                                                              onsubmit="return confirm('Are you sure you want to delete this player?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-danger" 
                                                                    title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="fas fa-users fa-3x mb-3"></i>
                                                        <p>No players found.</p>
                                                        <a href="{{ route('admin.players.create') }}" class="btn btn-primary">
                                                            Add your first player
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                    </div>

                    @if($players->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $players->links() }}
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