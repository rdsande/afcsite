@extends('layouts.admin')

@section('title', 'Teams Management')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Teams Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Teams</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Teams</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.teams.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Add New Team
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Logo</th>
                                        <th>Name</th>
                                        <th>Short Name</th>
                                        <th>Stadium</th>
                                        <th>Founded</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($teams as $team)
                                        <tr>
                                            <td>
                                                @if($team->logo)
                                                    <img src="{{ Storage::url($team->logo) }}" alt="{{ $team->name }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-secondary d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 4px;">
                                                        <i class="fas fa-shield-alt text-white"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ $team->name }}</td>
                                            <td>{{ $team->short_name ?? '-' }}</td>
                                            <td>{{ $team->home_stadium ?? '-' }}</td>
                                            <td>{{ $team->founded_year ?? '-' }}</td>
                                            <td>
                                                @if($team->is_active)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.teams.show', $team) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.teams.destroy', $team) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this team?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No teams found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($teams->hasPages())
                            <div class="d-flex justify-content-center">
                                {{ $teams->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection