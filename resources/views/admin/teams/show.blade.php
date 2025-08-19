@extends('layouts.admin')

@section('title', 'Team Details')

@section('content')
<style>
.team-color-swatch {
    width: 50px;
    height: 50px;
    display: inline-block;
    margin: 0 auto;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.team-color-swatch').forEach(function(element) {
        const color = element.getAttribute('data-color');
        if (color) {
            element.style.backgroundColor = color;
        }
    });
});
</script>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $team->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.teams.index') }}">Teams</a></li>
                    <li class="breadcrumb-item active">{{ $team->name }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @if($team->logo)
                                <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }} Logo" style="width: 128px; height: 128px; object-fit: cover;">
                            @else
                                <div class="profile-user-img img-fluid img-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 128px; height: 128px; margin: 0 auto;">
                                    <i class="fas fa-shield-alt fa-3x text-white"></i>
                                </div>
                            @endif
                        </div>

                        <h3 class="profile-username text-center">{{ $team->name }}</h3>
                        @if($team->short_name)
                            <p class="text-muted text-center">{{ $team->short_name }}</p>
                        @endif

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Status</b>
                                <span class="float-right">
                                    @if($team->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </span>
                            </li>
                            @if($team->home_stadium)
                                <li class="list-group-item">
                                    <b>Home Stadium</b>
                                    <span class="float-right">{{ $team->home_stadium }}</span>
                                </li>
                            @endif
                            @if($team->founded_year)
                                <li class="list-group-item">
                                    <b>Founded</b>
                                    <span class="float-right">{{ $team->founded_year }}</span>
                                </li>
                            @endif
                            @if($team->website)
                                <li class="list-group-item">
                                    <b>Website</b>
                                    <span class="float-right">
                                        <a href="{{ $team->website }}" target="_blank" class="text-primary">
                                            <i class="fas fa-external-link-alt"></i> Visit
                                        </a>
                                    </span>
                                </li>
                            @endif
                        </ul>

                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-primary btn-block">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>
                            <div class="col-6">
                                <form action="{{ route('admin.teams.destroy', $team) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this team? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-block">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if($team->primary_color || $team->secondary_color)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Team Colors</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if($team->primary_color)
                                    <div class="col-6">
                                        <div class="text-center">
                                            <div class="team-color-swatch mx-auto mb-2 rounded-circle border" data-color="{{ $team->primary_color }}" title="Primary Color"></div>
                                            <small class="text-muted">Primary<br>{{ $team->primary_color }}</small>
                                        </div>
                                    </div>
                                @endif
                                @if($team->secondary_color)
                                    <div class="col-6">
                                        <div class="text-center">
                                            <div class="team-color-swatch mx-auto mb-2 rounded-circle border" data-color="{{ $team->secondary_color }}" title="Secondary Color"></div>
                                            <small class="text-muted">Secondary<br>{{ $team->secondary_color }}</small>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-8">
                @if($team->description)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">About {{ $team->name }}</h3>
                        </div>
                        <div class="card-body">
                            <p>{{ $team->description }}</p>
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Fixtures</h3>
                    </div>
                    <div class="card-body">
                        @if($recentFixtures->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Competition</th>
                                            <th>Home Team</th>
                                            <th>Score</th>
                                            <th>Away Team</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentFixtures as $fixture)
                                            <tr>
                                                <td>{{ $fixture->match_date ? $fixture->match_date->format('M d, Y') : 'TBD' }}</td>
                                                <td>{{ $fixture->competition_type ?? 'League' }}</td>
                                                <td>
                                                    @if($fixture->homeTeam)
                                                        {{ $fixture->homeTeam->name }}
                                                    @else
                                                        {{ $fixture->home_team ?? 'TBD' }}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($fixture->home_score !== null && $fixture->away_score !== null)
                                                        <span class="badge badge-info">{{ $fixture->home_score }} - {{ $fixture->away_score }}</span>
                                                    @else
                                                        <span class="text-muted">vs</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($fixture->awayTeam)
                                                        {{ $fixture->awayTeam->name }}
                                                    @else
                                                        {{ $fixture->away_team ?? 'TBD' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($fixture->status === 'completed')
                                                        <span class="badge badge-success">Completed</span>
                                                    @elseif($fixture->status === 'live')
                                                        <span class="badge badge-warning">Live</span>
                                                    @else
                                                        <span class="badge badge-secondary">Scheduled</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">No recent fixtures found for this team.</p>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Team Statistics</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="fas fa-calendar"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Fixtures</span>
                                        <span class="info-box-number">{{ $totalFixtures }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="fas fa-trophy"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Wins</span>
                                        <span class="info-box-number">{{ $wins }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-warning"><i class="fas fa-handshake"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Draws</span>
                                        <span class="info-box-number">{{ $draws }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-danger"><i class="fas fa-times"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Losses</span>
                                        <span class="info-box-number">{{ $losses }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-footer">
                        <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Teams List
                        </a>
                        <a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Team
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection