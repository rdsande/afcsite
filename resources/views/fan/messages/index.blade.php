@extends('layouts.app')

@section('title', 'My Messages')

@section('content')
<div class="uk-container uk-container-large uk-margin-top">
    <!-- Header -->
    <div class="uk-flex uk-flex-between uk-flex-middle uk-margin-bottom">
        <div>
            <h1 class="uk-heading-small uk-margin-remove">My Messages</h1>
            <p class="uk-text-muted uk-margin-remove">View and manage your messages with the club</p>
        </div>
        <a href="{{ route('fan.messages.create') }}" class="uk-button uk-button-primary">
            <span uk-icon="plus"></span> New Message
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="uk-alert-success" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="uk-alert-danger" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="uk-grid-small uk-child-width-1-3@m uk-child-width-1-1@s" uk-grid>
        <div>
            <div class="uk-card uk-card-default uk-card-body uk-text-center">
                <h3 class="uk-card-title uk-margin-remove">{{ $stats['total'] }}</h3>
                <p class="uk-text-muted uk-margin-remove">Total Messages</p>
            </div>
        </div>
        <div>
            <div class="uk-card uk-card-default uk-card-body uk-text-center">
                <h3 class="uk-card-title uk-margin-remove uk-text-warning">{{ $stats['pending'] }}</h3>
                <p class="uk-text-muted uk-margin-remove">Pending</p>
            </div>
        </div>
        <div>
            <div class="uk-card uk-card-default uk-card-body uk-text-center">
                <h3 class="uk-card-title uk-margin-remove uk-text-success">{{ $stats['resolved'] }}</h3>
                <p class="uk-text-muted uk-margin-remove">Resolved</p>
            </div>
        </div>
    </div>

    <!-- Messages List -->
    <div class="uk-margin-top">
        @if($messages->count() > 0)
            <div class="uk-grid-small uk-child-width-1-1" uk-grid>
                @foreach($messages as $message)
                    <div>
                        <div class="uk-card uk-card-default uk-card-hover">
                            <div class="uk-card-header">
                                <div class="uk-flex uk-flex-between uk-flex-middle">
                                    <div>
                                        <h3 class="uk-card-title uk-margin-remove">
                                            <a href="{{ route('fan.messages.show', $message) }}" class="uk-link-reset">
                                                {{ $message->subject }}
                                            </a>
                                        </h3>
                                        <p class="uk-text-meta uk-margin-remove">
                                            <span class="uk-label uk-label-{{ $message->status_color }}">{{ ucfirst($message->status) }}</span>
                                            <span class="uk-label uk-label-{{ $message->priority_color }}">{{ ucfirst($message->priority) }}</span>
                                            <span class="uk-text-muted">{{ ucfirst($message->category) }}</span>
                                        </p>
                                    </div>
                                    <div class="uk-text-right">
                                        <p class="uk-text-small uk-margin-remove">{{ $message->created_at->format('M d, Y') }}</p>
                                        <p class="uk-text-meta uk-margin-remove">{{ $message->created_at->format('h:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-card-body uk-padding-small">
                                <p class="uk-text-small uk-margin-remove">{{ Str::limit($message->message, 150) }}</p>
                                @if($message->isReplied())
                                    <div class="uk-margin-small-top">
                                        <span class="uk-text-success uk-text-small">
                                            <span uk-icon="icon: check; ratio: 0.8"></span> Admin replied
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="uk-card-footer uk-padding-small">
                                <div class="uk-flex uk-flex-between uk-flex-middle">
                                    <a href="{{ route('fan.messages.show', $message) }}" class="uk-button uk-button-text uk-button-small">
                                        View Details
                                    </a>
                                    @if($message->isPending())
                                        <form action="{{ route('fan.messages.destroy', $message) }}" method="POST" class="uk-display-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="uk-button uk-button-danger uk-button-small" 
                                                    onclick="return confirm('Are you sure you want to delete this message?')">
                                                <span uk-icon="trash"></span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="uk-margin-top uk-text-center">
                {{ $messages->links() }}
            </div>
        @else
            <div class="uk-card uk-card-default uk-card-body uk-text-center">
                <span uk-icon="icon: mail; ratio: 3" class="uk-text-muted"></span>
                <h3 class="uk-margin-top">No Messages Yet</h3>
                <p class="uk-text-muted">You haven't sent any messages to the club yet.</p>
                <a href="{{ route('fan.messages.create') }}" class="uk-button uk-button-primary uk-margin-top">
                    Send Your First Message
                </a>
            </div>
        @endif
    </div>

    <!-- Back to Dashboard -->
    <div class="uk-margin-top uk-text-center">
        <a href="{{ route('fan.dashboard') }}" class="uk-button uk-button-default">
            <span uk-icon="arrow-left"></span> Back to Dashboard
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        UIkit.notification.closeAll();
    }, 5000);
</script>
@endsection