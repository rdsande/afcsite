@extends('layouts.admin')

@section('title', 'Notices Management')

@section('content')
<div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Notices Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Notices</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ isset($stats['total_notices']) ? number_format($stats['total_notices']) : '0' }}</h3>
                            <p>Total Notices</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ isset($stats['active_notices']) ? number_format($stats['active_notices']) : '0' }}</h3>
                            <p>Active</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ isset($stats['draft_notices']) ? number_format($stats['draft_notices']) : '0' }}</h3>
                            <p>Draft</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-edit"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ isset($stats['archived_notices']) ? number_format($stats['archived_notices']) : '0' }}</h3>
                            <p>Archived</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-archive"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notices Table -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Notices</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.notices.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New Notice
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($notices) && $notices->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Priority</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notices as $notice)
                                        <tr>
                                            <td>{{ $notice->id }}</td>
                                            <td>
                                                <strong>{{ $notice->title }}</strong>
                                                @if($notice->content)
                                                    <br><small class="text-muted">{{ Str::limit($notice->content, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($notice->status == 'active')
                                                    <span class="badge badge-success">Active</span>
                                                @elseif($notice->status == 'draft')
                                                    <span class="badge badge-warning">Draft</span>
                                                @else
                                                    <span class="badge badge-secondary">Archived</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($notice->priority == 'high')
                                                    <span class="badge badge-danger">High</span>
                                                @elseif($notice->priority == 'medium')
                                                    <span class="badge badge-warning">Medium</span>
                                                @else
                                                    <span class="badge badge-info">Low</span>
                                                @endif
                                            </td>
                                            <td>{{ $notice->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.notices.show', $notice) }}" 
                                                       class="btn btn-info btn-sm" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.notices.edit', $notice) }}" 
                                                       class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" 
                                                            onclick="deleteNotice('{{ $notice->id }}')" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if(method_exists($notices, 'links'))
                            <div class="d-flex justify-content-center">
                                {{ $notices->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No notices found</h4>
                            <p class="text-muted">Create your first notice to get started.</p>
                            <a href="{{ route('admin.notices.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add New Notice
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

<script>
function deleteNotice(noticeId) {
    if (confirm('Are you sure you want to delete this notice?')) {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/notices/' + noticeId;
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        form.appendChild(csrfToken);
        
        // Add method override
        const methodOverride = document.createElement('input');
        methodOverride.type = 'hidden';
        methodOverride.name = '_method';
        methodOverride.value = 'DELETE';
        form.appendChild(methodOverride);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection