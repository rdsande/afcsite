@extends('layouts.app')

@section('title', 'Fan Dashboard - AZAM FC')

@section('content')
<style>
.jersey-container {
    position: relative;
    display: inline-block;
    max-width: 300px;
}

.jersey-name {
    position: absolute;
    top: 15%;
    left: 50%;
    transform: translateX(-50%);
    font-family: 'Barlow', 'Arial Black', Arial, sans-serif;
    font-weight: 700;
    color: #fff;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
    font-size: 18px;
    letter-spacing: 2px;
    text-transform: uppercase;
    /* Curved text effect */
    transform: translateX(-50%) perspective(200px) rotateX(15deg);
}

.jersey-number {
    position: absolute;
    top: 45%;
    left: 50%;
    transform: translateX(-50%);
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    font-weight: bold;
    color: #fff;
    text-shadow: 3px 3px 6px rgba(0,0,0,0.9);
    font-size: 48px;
    /* Add some depth to the number */
    transform: translateX(-50%) perspective(300px) rotateX(10deg);
}

.jersey-image {
    width: 100%;
    height: auto;
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
}

@media (max-width: 768px) {
    .jersey-name {
        font-size: 14px;
        letter-spacing: 1px;
    }
    
    .jersey-number {
        font-size: 36px;
    }
    
    .jersey-container {
        max-width: 250px;
    }
}
</style>
<div class="uk-section uk-section-default">
    <div class="uk-container">
        <!-- Welcome Header -->
        <div class="uk-card uk-card-primary uk-card-body uk-margin-bottom">
            <div class="uk-grid-match" uk-grid>
                <div class="uk-width-expand">
                    <h1 class="uk-card-title uk-text-white">Welcome back, {{ $fan->full_name }}!</h1>
                    <p class="uk-text-white uk-margin-remove">You have <strong>{{ $fan->points }} points</strong> in your account</p>
                </div>
                <div class="uk-width-auto">
                    <form method="POST" action="{{ route('fan.logout') }}">
                        @csrf
                        <button type="submit" class="uk-button uk-button-default">
                            <span uk-icon="sign-out"></span> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="uk-alert-success" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Admin Notices -->
        @if($adminNotices->count() > 0)
        <div class="uk-margin-bottom">
            @foreach($adminNotices as $notice)
            <div class="uk-alert-{{ $notice->type_color }}" uk-alert>
                @if($notice->is_dismissible)
                    <a class="uk-alert-close" uk-close></a>
                @endif
                <div class="uk-grid-small uk-flex-middle" uk-grid>
                    <div class="uk-width-auto">
                        @if($notice->priority === 'high')
                            <span uk-icon="warning" class="uk-text-{{ $notice->priority_color }}"></span>
                        @elseif($notice->type === 'info')
                            <span uk-icon="info" class="uk-text-{{ $notice->type_color }}"></span>
                        @elseif($notice->type === 'success')
                            <span uk-icon="check" class="uk-text-{{ $notice->type_color }}"></span>
                        @else
                            <span uk-icon="bell" class="uk-text-{{ $notice->type_color }}"></span>
                        @endif
                    </div>
                    <div class="uk-width-expand">
                        <h4 class="uk-margin-remove-bottom">{{ $notice->title }}</h4>
                        <div class="uk-text-small uk-margin-small-top">
                            {!! nl2br(e($notice->content)) !!}
                        </div>
                        @if($notice->priority === 'high')
                            <div class="uk-text-small uk-text-muted uk-margin-small-top">
                                <span uk-icon="clock"></span> Posted {{ $notice->created_at->diffForHumans() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Personalized Jersey Section -->
        <div class="uk-margin-large-bottom">
            <div class="uk-card uk-card-default uk-card-body uk-text-center">
                <h3 class="uk-card-title"><span uk-icon="shirt"></span> Your Personalized Jersey</h3>
                
                <div class="jersey-container">
                    @php
                        $jerseyType = $fan->favorite_jersey_type ?? 'home';
                        $jersey = \App\Models\Jersey::active()->byType($jerseyType)->first();
                        $jerseyImage = $jersey && $jersey->template_image ? asset('storage/jerseys/' . $jersey->template_image) : \App\Models\Setting::getJerseyImage();
                    @endphp
                    <img src="{{ $jerseyImage }}" alt="Azam FC {{ ucfirst($jerseyType) }} Jersey" class="jersey-image">
                    
                    <!-- Jersey Name (curved text) -->
                    <div class="jersey-name">
                        {{ $fan->favorite_jersey_name ?: 'YOUR NAME' }}
                    </div>
                    
                    <!-- Jersey Number -->
                    <div class="jersey-number">
                        {{ $fan->favorite_jersey_number ?: '10' }}
                    </div>
                </div>
                
                <div class="uk-margin-small-top uk-text-center">
                    <span class="uk-text-small uk-text-muted">
                        {{ $jersey ? $jersey->name : ucfirst($jerseyType) . ' Jersey' }}
                    </span>
                </div>
                
                <div class="uk-margin-top">
                    <button class="uk-button uk-button-primary uk-button-small" uk-toggle="target: #jersey-edit-modal">
                        <span uk-icon="pencil"></span> Edit Jersey Details
                    </button>
                </div>
            </div>
        </div>

        <div class="uk-grid-match" uk-grid>
            <!-- Profile Information -->
            <div class="uk-width-1-3@m">
                <div class="uk-card uk-card-default uk-card-body">
                    <h3 class="uk-card-title"><span uk-icon="user"></span> Profile Information</h3>
                    
                    <dl class="uk-description-list">
                        <dt>Full Name</dt>
                        <dd>{{ $fan->full_name }}</dd>
                        
                        <dt>Age</dt>
                        <dd>{{ $fan->age }} years old</dd>
                        
                        <dt>Phone</dt>
                        <dd>{{ $fan->phone }}</dd>
                        
                        @if($fan->email)
                        <dt>Email</dt>
                        <dd>{{ $fan->email }}</dd>
                        @endif
                        
                        <dt>Gender</dt>
                        <dd>{{ ucfirst($fan->gender) }}</dd>
                        
                        <dt>Location</dt>
                        <dd>
                            {{ $fan->district }}, {{ $fan->region }}<br>
                            {{ $fan->country }}
                            @if($fan->ward)
                                <br><small class="uk-text-muted">Ward: {{ $fan->ward }}</small>
                            @endif
                            @if($fan->street)
                                <br><small class="uk-text-muted">Street: {{ $fan->street }}</small>
                            @endif
                        </dd>
                        
                        <dt>Member Since</dt>
                        <dd>{{ $fan->created_at->format('F Y') }}</dd>
                        
                        @if($fan->last_login)
                        <dt>Last Login</dt>
                        <dd>{{ $fan->last_login->diffForHumans() }}</dd>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Points & Gamification -->
            <div class="uk-width-1-3@m">
                <div class="uk-card uk-card-default uk-card-body">
                    <h3 class="uk-card-title"><span uk-icon="star"></span> Your Points</h3>
                    
                    <div class="uk-text-center uk-margin">
                        <div class="uk-heading-large uk-text-primary">{{ $fan->points }}</div>
                        <p class="uk-text-lead">Total Points</p>
                    </div>
                    
                    <div class="uk-alert-primary" uk-alert>
                        <h4>How to Earn Points:</h4>
                        <ul class="uk-list uk-list-bullet">
                            <li><strong>+1 point</strong> for each login</li>
                            <li><strong>+5 points</strong> when AZAM FC wins</li>
                            <li><strong>+10 points</strong> welcome bonus (received!)</li>
                        </ul>
                    </div>
                    
                    <div class="uk-margin-top">
                        <h4>Points Breakdown:</h4>
                        <div class="uk-grid-small uk-child-width-1-2" uk-grid>
                            <div>
                                <div class="uk-text-center">
                                    <div class="uk-text-large uk-text-success">{{ $fan->getPointsByType('login') }}</div>
                                    <div class="uk-text-small">Login Points</div>
                                </div>
                            </div>
                            <div>
                                <div class="uk-text-center">
                                    <div class="uk-text-large uk-text-warning">{{ $fan->getPointsByType('win') }}</div>
                                    <div class="uk-text-small">Win Points</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="uk-width-1-3@m">
                <div class="uk-card uk-card-default uk-card-body">
                    <h3 class="uk-card-title"><span uk-icon="bolt"></span> Quick Actions</h3>
                    
                    <div class="uk-margin">
                        <a href="{{ route('home') }}" class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom">
                            <span uk-icon="home"></span> Visit Homepage
                        </a>
                        
                        <a href="{{ route('fixtures') }}" class="uk-button uk-button-default uk-width-1-1 uk-margin-small-bottom">
                            <span uk-icon="calendar"></span> View All Fixtures
                        </a>
                        
                        <a href="{{ route('results') }}" class="uk-button uk-button-default uk-width-1-1 uk-margin-small-bottom">
                            <span uk-icon="list"></span> View Results
                        </a>
                        
                        <a href="https://shop.azamfc.co.tz" target="_blank" class="uk-button uk-button-secondary uk-width-1-1 uk-margin-small-bottom">
                            <span uk-icon="cart"></span> Shop Jerseys & Merchandise
                        </a>
                        
                        <a href="{{ route('fan.messages.index') }}" class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom">
                            <span uk-icon="mail"></span> My Messages
                        </a>
                        
                        <a href="{{ route('fan.messages.create') }}" class="uk-button uk-button-default uk-width-1-1">
                            <span uk-icon="plus"></span> Send Message
                        </a>
                    </div>
                </div>
            </div>
    </div>

    <!-- Your Closest Azam FC Shop -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">
            <i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>
            Your Closest Azam FC Shop
        </h3>
        
        @if($closestVendors->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($closestVendors as $vendor)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <h4 class="font-semibold text-gray-800 mb-2">{{ $vendor->name }}</h4>
                        <div class="text-sm text-gray-600 space-y-1">
                            <div class="flex items-center">
                                <i class="fas fa-phone text-blue-500 mr-2 w-4"></i>
                                <span>{{ $vendor->phone_number }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-red-500 mr-2 w-4"></i>
                                <span>{{ $vendor->fullAddress }}</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Active
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600 mb-2">
                    @if($closestVendors->first() && $closestVendors->first()->district === $fan->district)
                        Showing shops in your district: <strong>{{ $fan->district }}</strong>
                    @else
                        No shops found in your district. Showing shops in your region: <strong>{{ $fan->region }}</strong>
                    @endif
                </p>
                <a href="https://shop.azamfc.co.tz" target="_blank" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    Visit Online Shop
                </a>
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-store text-4xl"></i>
                </div>
                <p class="text-gray-600 mb-4">No physical shops found in your area yet.</p>
                <a href="https://shop.azamfc.co.tz" target="_blank" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    Shop Online Instead
                </a>
            </div>
        @endif
    </div>

    <!-- Upcoming Fixtures -->
        @if($upcomingFixtures->count() > 0)
        <div class="uk-margin-large-top">
            <h2 class="uk-heading-line"><span>Upcoming Fixtures</span></h2>
            
            <div class="uk-grid-match uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid>
                @foreach($upcomingFixtures as $fixture)
                <div>
                    <div class="uk-card uk-card-default uk-card-hover">
                        <div class="uk-card-header">
                            <div class="uk-grid-small uk-flex-middle" uk-grid>
                                <div class="uk-width-auto">
                                    <img class="uk-border-circle" width="40" height="40" 
                                         src="{{ $fixture->homeTeam && $fixture->homeTeam->logo ? asset('storage/' . $fixture->homeTeam->logo) : asset('img/logo.png') }}" 
                                         alt="{{ $fixture->homeTeam->name ?? $fixture->home_team }}">
                                </div>
                                <div class="uk-width-expand">
                                    <h3 class="uk-card-title uk-margin-remove-bottom">{{ $fixture->homeTeam->name ?? $fixture->home_team }}</h3>
                                    <p class="uk-text-meta uk-margin-remove-top">vs {{ $fixture->awayTeam->name ?? $fixture->away_team }}</p>
                                </div>
                                <div class="uk-width-auto">
                                    <img class="uk-border-circle" width="40" height="40" 
                                         src="{{ $fixture->awayTeam && $fixture->awayTeam->logo ? asset('storage/' . $fixture->awayTeam->logo) : asset('img/logo.png') }}" 
                                         alt="{{ $fixture->awayTeam->name ?? $fixture->away_team }}">
                                </div>
                            </div>
                        </div>
                        <div class="uk-card-body">
                            <p class="uk-text-center">
                                <span uk-icon="calendar"></span> {{ $fixture->formatted_date }}<br>
                                <span uk-icon="clock"></span> {{ $fixture->formatted_time }}<br>
                                <span uk-icon="location"></span> {{ $fixture->stadium }}
                            </p>
                        </div>
                        <div class="uk-card-footer">
                            <a href="{{ route('fixture.show', $fixture->id) }}" class="uk-button uk-button-text">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="uk-margin-large-top">
            <div class="uk-alert-primary" uk-alert>
                <h3>No Upcoming Fixtures</h3>
                <p>There are currently no upcoming fixtures scheduled. Check back later for updates!</p>
            </div>
        </div>
        @endif
        
        <!-- Recent Point Transactions -->
        <div class="uk-margin-large-top">
            <h2 class="uk-heading-line"><span>Recent Point Activity</span></h2>
            
            @php
                $recentTransactions = $fan->getRecentTransactions(5);
            @endphp
            
            @if($recentTransactions->count() > 0)
            <div class="uk-overflow-auto">
                <table class="uk-table uk-table-hover uk-table-divider">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Activity</th>
                            <th>Points</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $transaction)
                        <tr>
                            <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                            <td>
                                @if($transaction->type === 'login')
                                    <span class="uk-label uk-label-success">Login</span>
                                @elseif($transaction->type === 'win')
                                    <span class="uk-label uk-label-warning">Victory</span>
                                @else
                                    <span class="uk-label">{{ ucfirst($transaction->type) }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="uk-text-success uk-text-bold">+{{ $transaction->points }}</span>
                            </td>
                            <td>{{ $transaction->description ?? 'No description' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="uk-alert-primary" uk-alert>
                <h3>No Point Activity Yet</h3>
                <p>Start earning points by logging in daily and supporting AZAM FC!</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Jersey Edit Modal -->
<div id="jersey-edit-modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Edit Jersey Details</h2>
        
        <form action="{{ route('fan.update-jersey') }}" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="uk-margin">
                <label class="uk-form-label" for="jersey-name">Jersey Name</label>
                <div class="uk-form-controls">
                    <input class="uk-input" id="jersey-name" name="favorite_jersey_name" type="text" 
                           value="{{ $fan->favorite_jersey_name }}" placeholder="Enter your name" maxlength="20">
                    <div class="uk-text-small uk-text-muted uk-margin-small-top">
                        This will appear on the back of your jersey (max 20 characters)
                    </div>
                </div>
            </div>
            
            <div class="uk-margin">
                <label class="uk-form-label" for="jersey-number">Jersey Number</label>
                <div class="uk-form-controls">
                    <input class="uk-input" id="jersey-number" name="favorite_jersey_number" type="number" 
                           value="{{ $fan->favorite_jersey_number }}" placeholder="10" min="1" max="99">
                    <div class="uk-text-small uk-text-muted uk-margin-small-top">
                        Choose a number between 1 and 99
                    </div>
                </div>
            </div>
            
            <div class="uk-margin">
                <label class="uk-form-label" for="jersey-type">Jersey Type</label>
                <div class="uk-form-controls">
                    <select class="uk-select" id="jersey-type" name="favorite_jersey_type">
                        @php
                            $availableJerseys = \App\Models\Jersey::active()->get()->groupBy('type');
                        @endphp
                        <option value="home" {{ ($fan->favorite_jersey_type ?? 'home') == 'home' ? 'selected' : '' }}>
                            {{ $availableJerseys->has('home') ? $availableJerseys['home']->first()->name : 'Home Jersey' }}
                        </option>
                        <option value="away" {{ ($fan->favorite_jersey_type ?? 'home') == 'away' ? 'selected' : '' }}>
                            {{ $availableJerseys->has('away') ? $availableJerseys['away']->first()->name : 'Away Jersey' }}
                        </option>
                        <option value="third" {{ ($fan->favorite_jersey_type ?? 'home') == 'third' ? 'selected' : '' }}>
                            {{ $availableJerseys->has('third') ? $availableJerseys['third']->first()->name : 'Third Jersey' }}
                        </option>
                    </select>
                    <div class="uk-text-small uk-text-muted uk-margin-small-top">
                        Choose your preferred jersey design
                    </div>
                </div>
            </div>
            
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                <button class="uk-button uk-button-primary" type="submit">
                    <span uk-icon="check"></span> Save Changes
                </button>
            </p>
        </form>
    </div>
</div>

@endsection