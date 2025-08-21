@extends('layouts.admin')

@section('title', 'Message Management')

@section('breadcrumb')
    <li class="breadcrumb-item active">Messages</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-2 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($stats['total_messages']) }}</h3>
                    <p>Total Messages</p>
                </div>
                <div class="icon">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($stats['pending_messages']) }}</h3>
                    <p>Pending</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($stats['replied_messages']) }}</h3>
                    <p>Replied</p>
                </div>
                <div class="icon">
                    <i class="fas fa-reply"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ number_format($stats['closed_messages']) }}</h3>
                    <p>Closed</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ number_format($stats['high_priority']) }}</h3>
                    <p>High Priority</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ number_format($stats['new_today']) }}</h3>
                    <p>New Today</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Average Response Time -->
    @if($stats['avg_response_time'])
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Average Response Time:</strong> {{ $stats['avg_response_time'] }}
                </div>
            </div>
        </div>
    @endif

    <!-- Filters and Search -->
    <div class="card card-default collapsed-card mb-4">
        <div class="card-header">
            <h3 class="card-title">Search & Filters</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="card-body" style="display: none;">
            <form method="GET" action="{{ route('admin.messages.index') }}" id="filterForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Search</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Message content, fan name, phone...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">All Statuses</option>
                                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Replied</option>
                                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="priority">Priority</label>
                            <select class="form-control" id="priority" name="priority">
                                <option value="">All Priorities</option>
                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date_from">From Date</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" 
                                   value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date_to">To Date</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" 
                                   value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sort">Sort By</label>
                            <select class="form-control" id="sort" name="sort">
                                <option value="created_at" {{ request('sort', 'created_at') == 'created_at' ? 'selected' : '' }}>Date Created</option>
                                <option value="priority" {{ request('sort') == 'priority' ? 'selected' : '' }}>Priority</option>
                                <option value="status" {{ request('sort') == 'status' ? 'selected' : '' }}>Status</option>
                                <option value="fan_name" {{ request('sort') == 'fan_name' ? 'selected' : '' }}>Fan Name</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Clear Filters
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Messages Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Messages ({{ $messages->total() }})</h3>
            <div class="card-tools">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-cog"></i> Bulk Actions
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#" onclick="bulkUpdateStatus('open')">
                            <i class="fas fa-clock text-warning"></i> Mark as Pending
                        </a>
                        <a class="dropdown-item" href="#" onclick="bulkUpdateStatus('replied')">
                            <i class="fas fa-reply text-success"></i> Mark as Replied
                        </a>
                        <a class="dropdown-item" href="#" onclick="bulkUpdateStatus('closed')">
                            <i class="fas fa-check-circle text-secondary"></i> Mark as Closed
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" onclick="bulkUpdatePriority('low')">
                            <i class="fas fa-arrow-down text-info"></i> Set Low Priority
                        </a>
                        <a class="dropdown-item" href="#" onclick="bulkUpdatePriority('medium')">
                            <i class="fas fa-minus text-warning"></i> Set Medium Priority
                        </a>
                        <a class="dropdown-item" href="#" onclick="bulkUpdatePriority('high')">
                            <i class="fas fa-arrow-up text-danger"></i> Set High Priority
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="#" onclick="bulkDelete()">
                            <i class="fas fa-trash"></i> Delete Selected
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            @if($messages->count() > 0)
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th width="30">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="selectAll">
                                    <label for="selectAll"></label>
                                </div>
                            </th>
                            <th>ID</th>
                            <th>Fan</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                            <tr class="{{ $message->is_read ? '' : 'font-weight-bold' }}">
                                <td>
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="check{{ $message->id }}" name="selected_messages[]" value="{{ $message->id }}">
                                        <label for="check{{ $message->id }}"></label>
                                    </div>
                                </td>
                                <td>{{ $message->id }}</td>
                                <td>
                                    <div>
                                        <strong>{{ $message->fan->full_name }}</strong>
                                        <br><small class="text-muted">{{ $message->fan->phone }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;">
                                        {{ $message->subject }}
                                        @if(!$message->is_read)
                                            <span class="badge badge-primary badge-sm ml-1">New</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 250px;">
                                        {{ Str::limit($message->message, 80) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $message->status == 'open' ? 'warning' : ($message->status == 'replied' ? 'success' : 'secondary') }}">
                                        {{ ucfirst($message->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $message->priority == 'high' ? 'danger' : ($message->priority == 'medium' ? 'warning' : 'info') }}">
                                        {{ ucfirst($message->priority) }}
                                    </span>
                                </td>
                                <td>
                                    <small>
                                        {{ $message->created_at->format('M d, Y') }}<br>
                                        <span class="text-muted">{{ $message->created_at->format('H:i') }}</span>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.messages.show', $message) }}" 
                                           class="btn btn-info btn-sm" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($message->status != 'closed')
                                            <button type="button" class="btn btn-success btn-sm" 
                                                    onclick="quickReply('{{ $message->id }}')" title="Quick Reply">
                                                <i class="fas fa-reply"></i>
                                            </button>
                                        @endif
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle dropdown-toggle-split" 
                                                    data-toggle="dropdown" title="More Actions">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('admin.fans.show', $message->fan) }}">
                                                    <i class="fas fa-user"></i> View Fan
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#" onclick="updateStatus('{{ $message->id }}', 'open')">
                                                    <i class="fas fa-clock text-warning"></i> Mark Pending
                                                </a>
                                                <a class="dropdown-item" href="#" onclick="updateStatus('{{ $message->id }}', 'replied')">
                                                    <i class="fas fa-reply text-success"></i> Mark Replied
                                                </a>
                                                <a class="dropdown-item" href="#" onclick="updateStatus('{{ $message->id }}', 'closed')">
                                                    <i class="fas fa-check-circle text-secondary"></i> Mark Closed
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger" href="#" onclick="deleteMessage('{{ $message->id }}')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-envelope fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No messages found</h4>
                    <p class="text-muted">No messages match your current filters.</p>
                </div>
            @endif
        </div>
        @if($messages->hasPages())
            <div class="card-footer">
                {{ $messages->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Quick Reply Modal -->
<div class="modal fade" id="quickReplyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="quickReplyForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Quick Reply</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="originalMessage" class="mb-3"></div>
                    <div class="form-group">
                        <label for="reply_message">Reply Message</label>
                        <textarea class="form-control" id="reply_message" name="reply_message" 
                                  rows="4" required placeholder="Type your reply..."></textarea>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="mark_as_replied" name="mark_as_replied" checked>
                            <label class="form-check-label" for="mark_as_replied">
                                Mark as replied after sending
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane"></i> Send Reply
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-submit filters on change
    $('#status, #priority, #sort').change(function() {
        $('#filterForm').submit();
    });
    
    // Select all checkbox
    $('#selectAll').change(function() {
        $('input[name="selected_messages[]"]').prop('checked', this.checked);
    });
    
    // Update select all when individual checkboxes change
    $(document).on('change', 'input[name="selected_messages[]"]', function() {
        const total = $('input[name="selected_messages[]"]').length;
        const checked = $('input[name="selected_messages[]"]:checked').length;
        $('#selectAll').prop('indeterminate', checked > 0 && checked < total);
        $('#selectAll').prop('checked', checked === total);
    });
});

function quickReply(messageId) {
    // Load message details and show modal
    $.get(`/admin/messages/${messageId}`, function(data) {
        $('#originalMessage').html(`
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h6 class="mb-0">Original Message from ${data.fan.full_name}</h6>
                </div>
                <div class="card-body">
                    <strong>Subject:</strong> ${data.subject}<br>
                    <strong>Message:</strong> ${data.message}
                </div>
            </div>
        `);
        $('#quickReplyForm').attr('action', `/admin/messages/${messageId}/reply`);
        $('#quickReplyModal').modal('show');
    });
}

function updateStatus(messageId, status) {
    if (confirm(`Are you sure you want to mark this message as ${status}?`)) {
        $.post(`/admin/messages/${messageId}/status`, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            status: status
        }, function() {
            location.reload();
        });
    }
}

function deleteMessage(messageId) {
    if (confirm('Are you sure you want to delete this message? This action cannot be undone.')) {
        $.ajax({
            url: `/admin/messages/${messageId}`,
            type: 'DELETE',
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function() {
                location.reload();
            }
        });
    }
}

function bulkUpdateStatus(status) {
    const selected = $('input[name="selected_messages[]"]:checked').map(function() {
        return this.value;
    }).get();
    
    if (selected.length === 0) {
        alert('Please select at least one message.');
        return;
    }
    
    if (confirm(`Are you sure you want to mark ${selected.length} message(s) as ${status}?`)) {
        $.post('/admin/messages/bulk-status', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            message_ids: selected,
            status: status
        }, function() {
            location.reload();
        });
    }
}

function bulkUpdatePriority(priority) {
    const selected = $('input[name="selected_messages[]"]:checked').map(function() {
        return this.value;
    }).get();
    
    if (selected.length === 0) {
        alert('Please select at least one message.');
        return;
    }
    
    if (confirm(`Are you sure you want to set ${selected.length} message(s) to ${priority} priority?`)) {
        $.post('/admin/messages/bulk-priority', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            message_ids: selected,
            priority: priority
        }, function() {
            location.reload();
        });
    }
}

function bulkDelete() {
    const selected = $('input[name="selected_messages[]"]:checked').map(function() {
        return this.value;
    }).get();
    
    if (selected.length === 0) {
        alert('Please select at least one message.');
        return;
    }
    
    if (confirm(`Are you sure you want to delete ${selected.length} message(s)? This action cannot be undone.`)) {
        $.post('/admin/messages/bulk-delete', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            message_ids: selected
        }, function() {
            location.reload();
        });
    }
}
</script>
@endpush