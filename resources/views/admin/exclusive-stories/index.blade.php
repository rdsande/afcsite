@extends('layouts.admin')

@section('title', 'Exclusive Stories Management')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Exclusive Stories</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Exclusive Stories</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Exclusive Stories</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.exclusive-stories.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add New Story
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($stories->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Title</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Media Count</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($stories as $story)
                                                <tr>
                                                    <td>{{ $story->id }}</td>
                                                    <td>{{ $story->title }}</td>
                                                    <td>
                                                        <span class="badge badge-{{ $story->type === 'photos' ? 'info' : 'warning' }}">
                                                            {{ ucfirst($story->type) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-{{ $story->is_active ? 'success' : 'secondary' }}">
                                                            {{ $story->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $story->media_paths ? count($story->media_paths) : 0 }}</td>
                                                    <td>{{ $story->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('admin.exclusive-stories.show', $story) }}" class="btn btn-info btn-sm">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('admin.exclusive-stories.edit', $story) }}" class="btn btn-warning btn-sm">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('admin.exclusive-stories.destroy', $story) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this story?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center">
                                    {{ $stories->links() }}
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                                    <h4 class="text-muted">No Exclusive Stories Found</h4>
                                    <p class="text-muted">Start by creating your first exclusive story for members.</p>
                                    <a href="{{ route('admin.exclusive-stories.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Add New Story
                                    </a>
                                </div>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection