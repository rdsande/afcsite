@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h2 class="card-title mb-1">
                        <i class="fas fa-tachometer-alt"></i>
                        Welcome to Azam FC Admin Dashboard
                    </h2>
                    <p class="card-text mb-0">Manage your football club's content and data efficiently</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-1">{{ $newsCount ?? 0 }}</h3>
                            <p class="card-text mb-0">News Articles</p>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-newspaper fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('admin.news.index') }}" class="text-white text-decoration-none">
                        <i class="fas fa-arrow-right"></i> Manage News
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-1">{{ $playersCount ?? 0 }}</h3>
                            <p class="card-text mb-0">Players</p>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('admin.players.index') }}" class="text-white text-decoration-none">
                        <i class="fas fa-arrow-right"></i> Manage Players
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-1">{{ $fixturesCount ?? 0 }}</h3>
                            <p class="card-text mb-0">Fixtures</p>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('admin.fixtures.index') }}" class="text-white text-decoration-none">
                        <i class="fas fa-arrow-right"></i> Manage Fixtures
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title mb-1">{{ $upcomingFixtures ?? 0 }}</h3>
                            <p class="card-text mb-0">Upcoming Matches</p>
                        </div>
                        <div class="card-icon">
                            <i class="fas fa-futbol fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="{{ route('admin.fixtures.index') }}?filter=upcoming" class="text-white text-decoration-none">
                        <i class="fas fa-arrow-right"></i> View Upcoming
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-bolt"></i>
                        Quick Actions
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.news.create') }}" class="btn btn-outline-primary btn-lg w-100">
                                <i class="fas fa-plus-circle mb-2 d-block"></i>
                                Add News Article
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.players.create') }}" class="btn btn-outline-success btn-lg w-100">
                                <i class="fas fa-user-plus mb-2 d-block"></i>
                                Add Player
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('admin.fixtures.create') }}" class="btn btn-outline-warning btn-lg w-100">
                                <i class="fas fa-calendar-plus mb-2 d-block"></i>
                                Add Fixture
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-info btn-lg w-100">
                                <i class="fas fa-external-link-alt mb-2 d-block"></i>
                                View Website
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-clock"></i>
                        Recent News Articles
                    </h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-primary">
                            View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(isset($recentNews) && $recentNews->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Published</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentNews as $news)
                                        <tr>
                                            <td>
                                                <strong>{{ Str::limit($news->title, 50) }}</strong>
                                                @if($news->is_featured)
                                                    <span class="badge badge-warning ml-1">Featured</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $news->status === 'published' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($news->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $news->published_at ? $news->published_at->format('M d, Y') : 'Not published' }}</td>
                                            <td>
                                                <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No news articles yet. <a href="{{ route('admin.news.create') }}">Create your first article</a></p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-calendar-check"></i>
                        Upcoming Fixtures
                    </h4>
                    <div class="card-tools">
                        <a href="{{ route('admin.fixtures.index') }}" class="btn btn-sm btn-warning">
                            View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(isset($upcomingFixturesList) && $upcomingFixturesList->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($upcomingFixturesList as $fixture)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $fixture->homeTeam->name ?? 'TBD' }} vs {{ $fixture->awayTeam->name ?? 'TBD' }}</h6>
                                            <p class="mb-1 text-muted small">
                                                <i class="fas fa-calendar"></i> {{ $fixture->match_date->format('M d, Y') }}
                                                <i class="fas fa-clock ml-2"></i> {{ $fixture->match_date->format('H:i') }}
                                            </p>
                                            @if($fixture->competition)
                                                <small class="text-muted">{{ $fixture->competition }}</small>
                                            @endif
                                        </div>
                                        <div class="ml-2">
                                            <a href="{{ route('admin.fixtures.edit', $fixture) }}" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No upcoming fixtures. <a href="{{ route('admin.fixtures.create') }}">Schedule a match</a></p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-icon {
        opacity: 0.8;
    }
    
    .card-footer a:hover {
        text-decoration: underline !important;
    }
    
    .btn-lg i {
        font-size: 1.5rem;
    }
    
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush