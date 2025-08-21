@extends('layouts.admin')

@section('title', 'Message Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.messages.index') }}">Messages</a></li>
    <li class="breadcrumb-item active">Message #{{ $message->id }}</li>
@endsection

@section('content')
<div class="container-fluid" data-message-id="{{ $message->id }}" data-message-unread="{{ $message->is_read ? 'false' : 'true' }}">
    <div class="row">
        <!-- Message Details -->
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-envelope"></i> {{ $message->subject }}
                        @if(!$message->is_read)
                            <span class="badge badge-primary ml-2">New</span>
                        @endif
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-{{ $message->status == 'open' ? 'warning' : ($message->status == 'replied' ? 'success' : 'secondary') }} mr-2">
                            {{ ucfirst($message->status) }}
                        </span>
                        <span class="badge badge-{{ $message->priority == 'high' ? 'danger' : ($message->priority == 'medium' ? 'warning' : 'info') }}">
                            {{ ucfirst($message->priority) }} Priority
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Message Content -->
                    <div class="message-content mb-4">
                        <div class="d-flex align-items-start mb-3">
                            <div class="profile-user-img img-fluid img-circle bg-primary d-inline-flex align-items-center justify-content-center mr-3" 
                                 style="width: 50px; height: 50px; font-size: 1.2rem; color: white;">
                                {{ strtoupper(substr($message->fan->first_name, 0, 1) . substr($message->fan->last_name, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1">
                                    <a href="{{ route('admin.fans.show', $message->fan) }}" class="text-primary">
                                        {{ $message->fan->full_name }}
                                    </a>
                                </h5>
                                <p class="text-muted mb-1">
                                    <i class="fas fa-phone"></i> {{ $message->fan->phone }}
                                    @if($message->fan->email)
                                        <br><i class="fas fa-envelope"></i> {{ $message->fan->email }}
                                    @endif
                                </p>
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> {{ $message->created_at->format('M d, Y \\a\\t H:i') }}
                                    ({{ $message->created_at->diffForHumans() }})
                                </small>
                            </div>
                        </div>
                        
                        <div class="message-text bg-light p-3 rounded">
                            {!! nl2br(e($message->message)) !!}
                        </div>
                    </div>

                    <!-- Reply History -->
                    @if($message->admin_reply)
                        <div class="reply-history">
                            <h5 class="mb-3">
                                <i class="fas fa-reply text-success"></i> Admin Reply
                            </h5>
                            <div class="d-flex align-items-start mb-3">
                                <div class="profile-user-img img-fluid img-circle bg-success d-inline-flex align-items-center justify-content-center mr-3" 
                                     style="width: 40px; height: 40px; font-size: 1rem; color: white;">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Admin</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> {{ $message->replied_at ? $message->replied_at->format('M d, Y \\a\\t H:i') : 'N/A' }}
                                        @if($message->replied_at)
                                            ({{ $message->replied_at->diffForHumans() }})
                                        @endif
                                    </small>
                                </div>
                            </div>
                            
                            <div class="reply-text bg-success-light p-3 rounded border-left border-success">
                                {!! nl2br(e($message->admin_reply)) !!}
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Reply Form -->
                @if($message->status != 'closed')
                    <div class="card-footer">
                        <form method="POST" action="{{ route('admin.messages.reply', $message) }}">
                            @csrf
                            <div class="form-group">
                                <label for="reply_message">Reply to {{ $message->fan->full_name }}</label>
                                <textarea class="form-control @error('reply_message') is-invalid @enderror" 
                                          id="reply_message" name="reply_message" rows="4" 
                                          placeholder="Type your reply message here..." required>{{ old('reply_message') }}</textarea>
                                @error('reply_message')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status after reply</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="resolved" {{ old('status', 'resolved') == 'resolved' ? 'selected' : '' }}>Mark as Resolved</option>
                                            <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Mark as Closed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-paper-plane"></i> Send Reply
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- Message Actions Sidebar -->
        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="btn-group-vertical btn-block">
                        @if($message->status == 'open')
                            <button type="button" class="btn btn-success mb-2" onclick="updateStatus('replied')">
                                <i class="fas fa-reply"></i> Mark as Replied
                            </button>
                        @endif
                        
                        @if($message->status != 'closed')
                            <button type="button" class="btn btn-secondary mb-2" onclick="updateStatus('closed')">
                                <i class="fas fa-check-circle"></i> Close Message
                            </button>
                        @else
                            <button type="button" class="btn btn-warning mb-2" onclick="updateStatus('open')">
                                <i class="fas fa-undo"></i> Reopen Message
                            </button>
                        @endif
                        
                        <div class="btn-group mb-2">
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-flag"></i> Priority: {{ ucfirst($message->priority) }}
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="updatePriority('low')">
                                    <i class="fas fa-arrow-down text-info"></i> Low Priority
                                </a>
                                <a class="dropdown-item" href="#" onclick="updatePriority('medium')">
                                    <i class="fas fa-minus text-warning"></i> Medium Priority
                                </a>
                                <a class="dropdown-item" href="#" onclick="updatePriority('high')">
                                    <i class="fas fa-arrow-up text-danger"></i> High Priority
                                </a>
                            </div>
                        </div>
                        
                        <a href="{{ route('admin.fans.show', $message->fan) }}" class="btn btn-primary mb-2">
                            <i class="fas fa-user"></i> View Fan Profile
                        </a>
                        
                        <button type="button" class="btn btn-danger" onclick="deleteMessage()">
                            <i class="fas fa-trash"></i> Delete Message
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Message Information -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Message Information</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-5">Message ID:</dt>
                        <dd class="col-sm-7">#{{ $message->id }}</dd>
                        
                        <dt class="col-sm-5">Status:</dt>
                        <dd class="col-sm-7">
                            <span class="badge badge-{{ $message->status == 'open' ? 'warning' : ($message->status == 'replied' ? 'success' : 'secondary') }}">
                                {{ ucfirst($message->status) }}
                            </span>
                        </dd>
                        
                        <dt class="col-sm-5">Priority:</dt>
                        <dd class="col-sm-7">
                            <span class="badge badge-{{ $message->priority == 'high' ? 'danger' : ($message->priority == 'medium' ? 'warning' : 'info') }}">
                                {{ ucfirst($message->priority) }}
                            </span>
                        </dd>
                        
                        <dt class="col-sm-5">Received:</dt>
                        <dd class="col-sm-7">
                            {{ $message->created_at->format('M d, Y') }}<br>
                            <small class="text-muted">{{ $message->created_at->format('H:i') }}</small>
                        </dd>
                        
                        @if($message->replied_at)
                            <dt class="col-sm-5">Replied:</dt>
                            <dd class="col-sm-7">
                                {{ $message->replied_at->format('M d, Y') }}<br>
                                <small class="text-muted">{{ $message->replied_at->format('H:i') }}</small>
                            </dd>
                        @endif
                        
                        <dt class="col-sm-5">Read Status:</dt>
                        <dd class="col-sm-7">
                            @if($message->is_read)
                                <span class="badge badge-success">Read</span>
                            @else
                                <span class="badge badge-warning">Unread</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
            
            <!-- Fan Quick Info -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Fan Information</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="profile-user-img img-fluid img-circle bg-primary d-inline-flex align-items-center justify-content-center" 
                             style="width: 60px; height: 60px; font-size: 1.5rem; color: white;">
                            {{ strtoupper(substr($message->fan->first_name, 0, 1) . substr($message->fan->last_name, 0, 1)) }}
                        </div>
                        <h5 class="mt-2 mb-1">{{ $message->fan->full_name }}</h5>
                        <p class="text-muted mb-0">{{ $message->fan->phone }}</p>
                    </div>
                    
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Points</b> 
                            <a class="float-right">
                                <span class="badge badge-success">
                                    {{ number_format($message->fan->points) }}
                                </span>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>Messages</b> 
                            <a class="float-right">{{ $message->fan->fanMessages()->count() }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Member Since</b> 
                            <a class="float-right">{{ $message->fan->created_at->format('M Y') }}</a>
                        </li>
                    </ul>
                    
                    <a href="{{ route('admin.fans.show', $message->fan) }}" class="btn btn-primary btn-block mt-3">
                        <i class="fas fa-user"></i> View Full Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const messageId = $('.container-fluid').data('message-id');
const isUnread = $('.container-fluid').data('message-unread') === 'true';

function updateStatus(status) {
    if (confirm(`Are you sure you want to mark this message as ${status}?`)) {
        $.post(`/admin/messages/${messageId}/status`, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            status: status
        }, function() {
            location.reload();
        }).fail(function() {
            alert('Error updating message status. Please try again.');
        });
    }
}

function updatePriority(priority) {
    if (confirm(`Are you sure you want to set this message priority to ${priority}?`)) {
        $.post(`/admin/messages/${messageId}/priority`, {
            _token: $('meta[name="csrf-token"]').attr('content'),
            priority: priority
        }, function() {
            location.reload();
        }).fail(function() {
            alert('Error updating message priority. Please try again.');
        });
    }
}

function deleteMessage() {
    if (confirm('Are you sure you want to delete this message? This action cannot be undone.')) {
        $.ajax({
            url: `/admin/messages/${messageId}`,
            type: 'DELETE',
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function() {
                window.location.href = '/admin/messages';
            },
            error: function() {
                alert('Error deleting message. Please try again.');
            }
        });
    }
}

$(document).ready(function() {
    // Mark message as read when viewed
    if (isUnread) {
        $.post(`/admin/messages/${messageId}/mark-read`, {
            _token: $('meta[name="csrf-token"]').attr('content')
        });
    }
    
    // Auto-focus on reply textarea
    $('#reply_message').focus();
});
</script>
@endpush