@extends('layouts.admin')

@section('title', 'Fan Details - ' . $fan->full_name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.fans.index') }}">Fans</a></li>
    <li class="breadcrumb-item active">{{ $fan->full_name }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Fan Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <div class="profile-user-img img-fluid img-circle bg-primary d-inline-flex align-items-center justify-content-center" 
                             style="width: 100px; height: 100px; font-size: 2rem; color: white;">
                            {{ strtoupper(substr($fan->first_name, 0, 1) . substr($fan->last_name, 0, 1)) }}
                        </div>
                    </div>

                    <h3 class="profile-username text-center">{{ $fan->full_name }}</h3>

                    <p class="text-muted text-center">
                        <i class="fas fa-phone"></i> {{ $fan->phone }}
                        @if($fan->email)
                            <br><i class="fas fa-envelope"></i> {{ $fan->email }}
                        @endif
                    </p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Total Points</b> 
                            <a class="float-right">
                                <span class="badge badge-success badge-lg">
                                    <i class="fas fa-star"></i> {{ number_format($stats['total_points']) }}
                                </span>
                            </a>
                        </li>
                        <li class="list-group-item">
                            <b>Messages Sent</b> <a class="float-right">{{ $stats['total_messages'] }}</a>
                        </li>

                        <li class="list-group-item">
                            <b>Member Since</b> 
                            <a class="float-right">{{ $fan->created_at->format('M d, Y') }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Last Login</b> 
                            <a class="float-right">
                                @if($fan->last_login)
                                    {{ $fan->last_login->diffForHumans() }}
                                @else
                                    <span class="badge badge-warning">Never</span>
                                @endif
                            </a>
                        </li>
                    </ul>

                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('admin.fans.edit', $fan) }}" class="btn btn-warning btn-block">
                                <i class="fas fa-edit"></i> Edit Fan
                            </a>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#addPointsModal">
                                <i class="fas fa-plus"></i> Add Points
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Fan Information -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Personal Information</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Full Name:</dt>
                        <dd class="col-sm-8">{{ $fan->full_name }}</dd>
                        
                        <dt class="col-sm-4">Phone:</dt>
                        <dd class="col-sm-8">
                            <a href="tel:{{ $fan->phone }}" class="text-primary">
                                {{ $fan->phone }}
                            </a>
                        </dd>
                        
                        <dt class="col-sm-4">Email:</dt>
                        <dd class="col-sm-8">
                            @if($fan->email)
                                <a href="mailto:{{ $fan->email }}" class="text-primary">
                                    {{ $fan->email }}
                                </a>
                            @else
                                <span class="text-muted">Not provided</span>
                            @endif
                        </dd>
                        
                        <dt class="col-sm-4">Gender:</dt>
                        <dd class="col-sm-8">
                            <span class="badge badge-{{ $fan->gender == 'male' ? 'primary' : ($fan->gender == 'female' ? 'pink' : 'secondary') }}">
                                {{ ucfirst($fan->gender) }}
                            </span>
                        </dd>
                        
                        <dt class="col-sm-4">Region:</dt>
                        <dd class="col-sm-8">{{ $fan->region }}</dd>
                        
                        <dt class="col-sm-4">District:</dt>
                        <dd class="col-sm-8">{{ $fan->district }}</dd>
                        
                        @if($fan->ward)
                            <dt class="col-sm-4">Ward:</dt>
                            <dd class="col-sm-8">{{ $fan->ward }}</dd>
                        @endif
                        
                        @if($fan->street)
                            <dt class="col-sm-4">Street:</dt>
                            <dd class="col-sm-8">{{ $fan->street }}</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <!-- Points Breakdown -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Points Breakdown</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fas fa-sign-in-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Login Points</span>
                                    <span class="info-box-number">{{ number_format($stats['login_points']) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box bg-success">
                                <span class="info-box-icon"><i class="fas fa-trophy"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Team Win Points</span>
                                    <span class="info-box-number">{{ number_format($stats['team_win_points']) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($stats['pending_messages'] > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            This fan has <strong>{{ $stats['pending_messages'] }}</strong> pending message(s).
                            <a href="{{ route('admin.messages.index', ['search' => $fan->phone]) }}" class="alert-link">
                                View Messages
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Point Transactions -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Point Transactions</h3>
                </div>
                <div class="card-body">
                    @if($recentTransactions->count() > 0)
                        <div class="timeline">
                            @foreach($recentTransactions as $transaction)
                                <div class="time-label">
                                    <span class="bg-{{ $transaction->points > 0 ? 'success' : 'danger' }}">
                                        {{ $transaction->created_at->format('M d') }}
                                    </span>
                                </div>
                                <div>
                                    <i class="fas fa-{{ $transaction->points > 0 ? 'plus' : 'minus' }} bg-{{ $transaction->points > 0 ? 'success' : 'danger' }}"></i>
                                    <div class="timeline-item">
                                        <span class="time">
                                            <i class="fas fa-clock"></i> {{ $transaction->created_at->format('H:i') }}
                                        </span>
                                        <h3 class="timeline-header">
                                            <span class="badge badge-{{ $transaction->points > 0 ? 'success' : 'danger' }}">
                                                {{ $transaction->points > 0 ? '+' : '' }}{{ $transaction->points }} points
                                            </span>
                                        </h3>
                                        <div class="timeline-body">
                                            <strong>{{ ucfirst(str_replace('_', ' ', $transaction->type)) }}</strong><br>
                                            {{ $transaction->description }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-4">
                            <i class="fas fa-star fa-2x mb-2"></i><br>
                            No point transactions yet.
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Messages -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Messages</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.messages.index', ['search' => $fan->phone]) }}" class="btn btn-tool">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($recentMessages->count() > 0)
                        @foreach($recentMessages as $message)
                            <div class="card card-outline card-{{ $message->status == 'open' ? 'warning' : ($message->status == 'replied' ? 'success' : 'secondary') }} mb-2">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        {{ $message->subject }}
                                        <span class="badge badge-{{ $message->priority == 'high' ? 'danger' : ($message->priority == 'medium' ? 'warning' : 'secondary') }} ml-2">
                                            {{ ucfirst($message->priority) }}
                                        </span>
                                    </h5>
                                    <div class="card-tools">
                                        <span class="badge badge-{{ $message->status == 'open' ? 'warning' : ($message->status == 'replied' ? 'success' : 'secondary') }}">
                                            {{ ucfirst($message->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body py-2">
                                    <p class="mb-1">{{ Str::limit($message->message, 100) }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> {{ $message->created_at->diffForHumans() }}
                                    </small>
                                    <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-sm btn-outline-primary float-right">
                                        View
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center py-4">
                            <i class="fas fa-envelope fa-2x mb-2"></i><br>
                            No messages from this fan yet.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Points Modal -->
<div class="modal fade" id="addPointsModal" tabindex="-1" role="dialog" aria-labelledby="addPointsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.fans.add-points', $fan) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addPointsModalLabel">Add Points to {{ $fan->full_name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="points">Points to Add</label>
                        <input type="number" class="form-control" id="points" name="points" 
                               min="1" max="1000" required placeholder="Enter points (1-1000)">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" 
                                  required placeholder="Reason for adding points..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-plus"></i> Add Points
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
    // Focus on points input when modal opens
    $('#addPointsModal').on('shown.bs.modal', function () {
        $('#points').focus();
    });
});
</script>
@endpush