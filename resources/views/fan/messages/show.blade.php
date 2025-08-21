@extends('layouts.app')

@section('title', 'Message Details')

@section('content')
<div class="uk-container uk-container-small uk-margin-top">
    <!-- Header -->
    <div class="uk-flex uk-flex-between uk-flex-middle uk-margin-bottom">
        <div>
            <h1 class="uk-heading-small uk-margin-remove">Message Details</h1>
            <p class="uk-text-muted uk-margin-remove">{{ $message->created_at->format('F d, Y \a\t h:i A') }}</p>
        </div>
        <div>
            <span class="uk-label uk-label-{{ $message->status_color }}">{{ ucfirst($message->status) }}</span>
            <span class="uk-label uk-label-{{ $message->priority_color }}">{{ ucfirst($message->priority) }}</span>
        </div>
    </div>

    <!-- Message Thread -->
    <div class="uk-grid-small" uk-grid>
        <!-- Original Message -->
        <div class="uk-width-1-1">
            <div class="uk-card uk-card-default">
                <div class="uk-card-header">
                    <div class="uk-flex uk-flex-between uk-flex-middle">
                        <div>
                            <h3 class="uk-card-title uk-margin-remove">{{ $message->subject }}</h3>
                            <p class="uk-text-meta uk-margin-remove">
                                Category: <strong>{{ ucfirst($message->category) }}</strong> • 
                                Priority: <strong>{{ ucfirst($message->priority) }}</strong>
                            </p>
                        </div>
                        <div class="uk-text-right">
                            <div class="uk-flex uk-flex-middle">
                                <span uk-icon="user" class="uk-margin-small-right"></span>
                                <div>
                                    <p class="uk-text-small uk-margin-remove">{{ $message->fan->name }}</p>
                                    <p class="uk-text-meta uk-margin-remove">You</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-card-body">
                    <div class="uk-text-break">
                        {!! nl2br(e($message->message)) !!}
                    </div>
                </div>
                <div class="uk-card-footer uk-padding-small">
                    <div class="uk-flex uk-flex-between uk-flex-middle">
                        <p class="uk-text-meta uk-margin-remove">
                            Sent {{ $message->created_at->diffForHumans() }}
                        </p>
                        @if($message->isPending())
                            <form action="{{ route('fan.messages.destroy', $message) }}" method="POST" class="uk-display-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="uk-button uk-button-danger uk-button-small" 
                                        onclick="return confirm('Are you sure you want to delete this message?')">
                                    <span uk-icon="trash"></span> Delete
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Reply -->
        @if($message->isReplied())
            <div class="uk-width-1-1">
                <div class="uk-card uk-card-primary uk-light">
                    <div class="uk-card-header">
                        <div class="uk-flex uk-flex-between uk-flex-middle">
                            <div>
                                <h4 class="uk-card-title uk-margin-remove">
                                    <span uk-icon="reply" class="uk-margin-small-right"></span>
                                    Admin Reply
                                </h4>
                            </div>
                            <div class="uk-text-right">
                                <div class="uk-flex uk-flex-middle">
                                    <span uk-icon="user" class="uk-margin-small-right"></span>
                                    <div>
                                        <p class="uk-text-small uk-margin-remove">
                                            {{ $message->repliedBy ? $message->repliedBy->name : 'AZAM FC Admin' }}
                                        </p>
                                        <p class="uk-text-meta uk-margin-remove">Admin</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-card-body">
                        <div class="uk-text-break">
                            {!! nl2br(e($message->admin_reply)) !!}
                        </div>
                    </div>
                    <div class="uk-card-footer uk-padding-small">
                        <p class="uk-text-meta uk-margin-remove">
                            Replied {{ $message->replied_at->diffForHumans() }} 
                            ({{ $message->replied_at->format('M d, Y \a\t h:i A') }})
                        </p>
                    </div>
                </div>
            </div>
        @else
            <!-- Waiting for Reply -->
            <div class="uk-width-1-1">
                <div class="uk-card uk-card-muted uk-card-body uk-text-center">
                    <span uk-icon="icon: clock; ratio: 2" class="uk-text-muted"></span>
                    <h4 class="uk-margin-top">Waiting for Reply</h4>
                    <p class="uk-text-muted">
                        @if($message->status === 'open')
                            Your message is pending review. We typically respond within 24-48 hours.
                        @elseif($message->status === 'in_progress')
                            Your message is being processed. An admin will respond soon.
                        @else
                            Your message has been received and is being reviewed.
                        @endif
                    </p>
                    
                    @if($message->status === 'open')
                        <div class="uk-alert-primary uk-margin-top" uk-alert>
                            <p class="uk-text-small uk-margin-remove">
                                <strong>Tip:</strong> You can still delete this message if you need to make changes.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Message Status Timeline -->
    <div class="uk-card uk-card-default uk-card-body uk-margin-top">
        <h4>Message Status</h4>
        <div class="uk-grid-small uk-child-width-auto" uk-grid>
            <div>
                <span class="uk-label uk-label-success">
                    <span uk-icon="check"></span> Sent
                </span>
                <p class="uk-text-small uk-text-muted uk-margin-remove">{{ $message->created_at->format('M d, h:i A') }}</p>
            </div>
            
            @if($message->status !== 'open')
                <div>
                    <span class="uk-label uk-label-primary">
                        <span uk-icon="refresh"></span> In Progress
                    </span>
                    <p class="uk-text-small uk-text-muted uk-margin-remove">Being reviewed</p>
                </div>
            @endif
            
            @if($message->isReplied())
                <div>
                    <span class="uk-label uk-label-success">
                        <span uk-icon="reply"></span> Replied
                    </span>
                    <p class="uk-text-small uk-text-muted uk-margin-remove">{{ $message->replied_at->format('M d, h:i A') }}</p>
                </div>
            @endif
            
            @if($message->status === 'resolved')
                <div>
                    <span class="uk-label uk-label-success">
                        <span uk-icon="check"></span> Resolved
                    </span>
                    <p class="uk-text-small uk-text-muted uk-margin-remove">Issue resolved</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Actions -->
    <div class="uk-margin-top uk-text-center">
        <div class="uk-button-group">
            <a href="{{ route('fan.messages.index') }}" class="uk-button uk-button-default">
                <span uk-icon="arrow-left"></span> Back to Messages
            </a>
            
            @if($message->isResolved())
                <a href="{{ route('fan.messages.create') }}" class="uk-button uk-button-primary">
                    <span uk-icon="plus"></span> New Message
                </a>
            @endif
        </div>
    </div>

    <!-- Help Section -->
    @if(!$message->isReplied())
        <div class="uk-card uk-card-muted uk-card-body uk-margin-top">
            <h4>Need Immediate Help?</h4>
            <p class="uk-text-small">
                If this is an urgent matter, you can also contact us directly:
            </p>
            <div class="uk-grid-small uk-child-width-1-2@s uk-text-small" uk-grid>
                <div>
                    <p><span uk-icon="phone"></span> <strong>Phone:</strong> +255 123 456 789</p>
                </div>
                <div>
                    <p><span uk-icon="mail"></span> <strong>Email:</strong> support@azamfc.co.tz</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
@if(!$message->isReplied() && $message->isPending())
<script>
    // Auto-refresh page every 30 seconds if message is pending
    setTimeout(function() {
        location.reload();
    }, 30000);
</script>
@endif
@endsection