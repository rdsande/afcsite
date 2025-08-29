<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Player Profile - View
Route::get('viewplayer', [App\Http\Controllers\HomeController::class, 'players'])->name('viewplayer');

//PROFILES - Now handled dynamically by Route::get('player/{id}', [HomeController::class, 'showPlayer'])
// Individual player routes (player1, player2, etc.) have been replaced with dynamic routing


//ACADEMY PROFILES - Now handled dynamically by Route::get('player/{id}', [HomeController::class, 'showPlayer'])
// Individual academy player routes (player-academy1, player-academy2, etc.) have been replaced with dynamic routing

Route::get('match', function () {
    return view('/pages/match');
});

//PROFILES END ACADEMY

//ACADEMY U13, U15, U17 PROFILES - Now handled dynamically by Route::get('player/{id}', [HomeController::class, 'showPlayer'])
// All academy player routes have been replaced with dynamic routing

// All remaining academy player routes (U13, U15, U17) have been replaced with dynamic routing
//Events - View
Route::get('events', function () {
    return view('/pages/events');
});

//Memberships - View
Route::get('membership', function () {
    return view('/pages/membership');
});

//Register - View (Original)
Route::get('register', function () {
    return view('/pages/register');
});

// Fan Registration and Authentication Routes
Route::prefix('fan')->name('fan.')->group(function () {
    // Guest routes
    Route::middleware('guest:fan')->group(function () {
        Route::get('register', [App\Http\Controllers\FanController::class, 'showRegister'])->name('register');
        Route::post('register', [App\Http\Controllers\FanController::class, 'register'])->name('register.submit');
        Route::get('login', [App\Http\Controllers\FanController::class, 'showLogin'])->name('login');
        Route::post('login', [App\Http\Controllers\FanController::class, 'login'])->name('login.submit');
    });
    
    // Authenticated fan routes
    Route::middleware('auth:fan')->group(function () {
        Route::get('dashboard', [App\Http\Controllers\FanController::class, 'dashboard'])->name('dashboard');
        Route::patch('update-jersey', [App\Http\Controllers\FanController::class, 'updateJersey'])->name('update-jersey');
        Route::post('logout', [App\Http\Controllers\FanController::class, 'logout'])->name('logout');
        
        // Jersey orders feature removed - users directed to external shop
        
        // Fan messaging routes
        Route::get('messages', [App\Http\Controllers\FanMessageController::class, 'index'])->name('messages.index');
        Route::get('messages/create', [App\Http\Controllers\FanMessageController::class, 'create'])->name('messages.create');
        Route::post('messages', [App\Http\Controllers\FanMessageController::class, 'store'])->name('messages.store');
        Route::get('messages/{message}', [App\Http\Controllers\FanMessageController::class, 'show'])->name('messages.show');
        Route::delete('messages/{message}', [App\Http\Controllers\FanMessageController::class, 'destroy'])->name('messages.destroy');
        
        // Fan profile routes
        Route::get('profile', [App\Http\Controllers\FanProfileController::class, 'show'])->name('profile.show');
        Route::get('profile/edit', [App\Http\Controllers\FanProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [App\Http\Controllers\FanProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile/image', [App\Http\Controllers\FanProfileController::class, 'deleteImage'])->name('profile.delete-image');
    });
    
    // API routes for location dropdowns
    Route::get('api/districts/{region}', [App\Http\Controllers\FanController::class, 'getDistricts'])->name('api.districts');
});

Route::get('login', function () {
    return view('/pages/login');
});

Route::get('privacy', function () {
    return view('/pages/privacy');
});

Route::get('terms-conditions', function () {
    return view('/pages/terms-conditions');
});

//Team - View
Route::get('viewteam', [App\Http\Controllers\HomeController::class, 'seniorTeam'])->name('team.senior');

//Academy Team Views
Route::get('u20team', [App\Http\Controllers\HomeController::class, 'u20Team'])->name('team.u20');
Route::get('u17team', [App\Http\Controllers\HomeController::class, 'u17Team'])->name('team.u17');
Route::get('u15team', [App\Http\Controllers\HomeController::class, 'u15Team'])->name('team.u15');
Route::get('u13team', [App\Http\Controllers\HomeController::class, 'u13Team'])->name('team.u13');

//Post - View
Route::get('post', function () {
    return view('/posts/viewpost');
});

//About 
//Post - View
Route::get('about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');

Route::get('missionvision', [App\Http\Controllers\HomeController::class, 'missionVision'])->name('mission-vision');

Route::get('history', [App\Http\Controllers\HomeController::class, 'history'])->name('history');

Route::get('trophy', function () {
    return view('/about/trophy');
});

Route::get('azamcomplex', function () {
    return view('/about/azamcomplex');
});

Route::get('senior', function () {
    return view('/about/senior');
});

Route::get('board', function () {
    return view('/about/board');
});

Route::get('contact', function () {
    return view('/pages/contact');
});



//Temp POSTS
//POST ROUTES - Now handled dynamically by HomeController::showNews()
// All individual post routes (post1-post26) have been replaced with dynamic routing
// Use: Route::get('news/{slug}', [HomeController::class, 'showNews'])->name('news.show')
//Latest News - View
Route::get('latestnews', [App\Http\Controllers\HomeController::class, 'news'])->name('latestnews');
//Latest News - View
Route::get('newsupdates', [App\Http\Controllers\HomeController::class, 'news'])->name('newsupdates');
//Latest News - View
Route::get('breakingnews', [App\Http\Controllers\HomeController::class, 'news'])->name('breakingnews');


//Fixtures - View
Route::get('fixtures', [App\Http\Controllers\HomeController::class, 'fixtures'])->name('fixtures');
Route::get('fixture/{fixture}', [App\Http\Controllers\HomeController::class, 'showFixture'])->name('fixture.show');

Route::get('results', [App\Http\Controllers\HomeController::class, 'results'])->name('results');

Route::get('tables', [App\Http\Controllers\HomeController::class, 'tables'])->name('tables');

//AZAMFC TV - View
Route::get('tv', [App\Http\Controllers\HomeController::class, 'tv'])->name('tv');

//About Us - View (duplicate route - keeping this one)
// Route::get('about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');

// News Routes
Route::get('news', [App\Http\Controllers\HomeController::class, 'news'])->name('news.index');
Route::get('news/{slug}', [App\Http\Controllers\HomeController::class, 'showNews'])->name('news.show');

// Player Routes
Route::get('players', [App\Http\Controllers\HomeController::class, 'players'])->name('players');
Route::get('player/{id}', [App\Http\Controllers\HomeController::class, 'showPlayer'])->name('player.show');

// Exclusive Stories Routes (Public access)
Route::get('exclusive-story/{id}', [App\Http\Controllers\HomeController::class, 'showExclusiveStory'])->name('exclusive-story.show');

// Authentication Routes
Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');

// Profile Routes (Protected by authentication)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/image', [App\Http\Controllers\ProfileController::class, 'deleteImage'])->name('profile.delete-image');
});

// Admin Routes (Protected by authentication and admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management (Super Admin and limited Admin access)
    Route::middleware('role:super_admin,admin')->group(function () {
        Route::get('/users', [App\Http\Controllers\AdminController::class, 'userIndex'])->name('users.index');
        Route::get('/users/create', [App\Http\Controllers\AdminController::class, 'userCreate'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\AdminController::class, 'userStore'])->name('users.store');
        Route::get('/users/{user}', [App\Http\Controllers\AdminController::class, 'userShow'])->name('users.show');
        Route::get('/users/{user}/edit', [App\Http\Controllers\AdminController::class, 'userEdit'])->name('users.edit');
        Route::put('/users/{user}', [App\Http\Controllers\AdminController::class, 'userUpdate'])->name('users.update');
        Route::delete('/users/{user}', [App\Http\Controllers\AdminController::class, 'userDestroy'])->name('users.destroy');
    });
    
    // Content Management (Admin and Editor access)
    Route::resource('news', App\Http\Controllers\Admin\NewsController::class);
    Route::resource('players', App\Http\Controllers\Admin\PlayerController::class);
    Route::resource('teams', App\Http\Controllers\Admin\TeamController::class);
    
    // Exclusive Stories Management
    Route::resource('exclusive-stories', App\Http\Controllers\Admin\ExclusiveStoryController::class);
    Route::delete('exclusive-stories/{exclusiveStory}/media', [App\Http\Controllers\Admin\ExclusiveStoryController::class, 'removeMedia'])->name('exclusive-stories.remove-media');
    
    // Tournament Management
    Route::resource('tournaments', App\Http\Controllers\Admin\TournamentController::class);
    Route::patch('tournaments/{tournament}/toggle-status', [App\Http\Controllers\Admin\TournamentController::class, 'toggleStatus'])->name('tournaments.toggle-status');
    
    // Fixture Management
    Route::resource('fixtures', App\Http\Controllers\Admin\FixtureController::class);
    Route::patch('fixtures/{fixture}/status', [App\Http\Controllers\Admin\FixtureController::class, 'updateStatus'])->name('fixtures.updateStatus');
    Route::patch('fixtures/{fixture}/result', [App\Http\Controllers\Admin\FixtureController::class, 'updateResult'])->name('fixtures.update-result');
    Route::get('fixtures/{fixture}/upcoming', [App\Http\Controllers\Admin\FixtureController::class, 'upcoming'])->name('fixtures.upcoming');
    Route::get('fixtures/{fixture}/past', [App\Http\Controllers\Admin\FixtureController::class, 'past'])->name('fixtures.past');
    
    // Match Events Management
    Route::get('fixtures/{fixture}/events', [App\Http\Controllers\Admin\MatchEventController::class, 'index'])->name('fixtures.events.index');
    Route::get('fixtures/{fixture}/events/manage', [App\Http\Controllers\Admin\MatchEventController::class, 'manageLiveEvents'])->name('fixtures.events.manage');
    Route::post('fixtures/{fixture}/events', [App\Http\Controllers\Admin\MatchEventController::class, 'store'])->name('fixtures.events.store');
    Route::put('events/{event}', [App\Http\Controllers\Admin\MatchEventController::class, 'update'])->name('events.update');
    Route::delete('events/{event}', [App\Http\Controllers\Admin\MatchEventController::class, 'destroy'])->name('events.destroy');
    Route::get('fixtures/{fixture}/events/live', [App\Http\Controllers\Admin\MatchEventController::class, 'getLiveEvents'])->name('fixtures.events.live');
    Route::post('fixtures/{fixture}/events/bulk', [App\Http\Controllers\Admin\MatchEventController::class, 'bulkStore'])->name('fixtures.events.bulk');
    
    // Admin Notices Management
    Route::resource('notices', App\Http\Controllers\AdminNoticeController::class);
    Route::patch('notices/{notice}/toggle-status', [App\Http\Controllers\AdminNoticeController::class, 'toggleStatus'])->name('admin.notices.toggle-status');
    
    // Fan Management
    Route::resource('fans', App\Http\Controllers\Admin\FanAdminController::class);
    Route::post('fans/{fan}/add-points', [App\Http\Controllers\Admin\FanAdminController::class, 'addPoints'])->name('fans.add-points');

    
    // Vendor Management
    Route::resource('vendors', App\Http\Controllers\Admin\VendorController::class);
    
    // Message Management
    Route::resource('messages', App\Http\Controllers\Admin\MessageAdminController::class)->only(['index', 'show']);
    Route::post('messages/{message}/reply', [App\Http\Controllers\Admin\MessageAdminController::class, 'reply'])->name('messages.reply');
    Route::patch('messages/{message}/status', [App\Http\Controllers\Admin\MessageAdminController::class, 'updateStatus'])->name('messages.update-status');
    Route::patch('messages/{message}/priority', [App\Http\Controllers\Admin\MessageAdminController::class, 'updatePriority'])->name('messages.update-priority');
    Route::post('messages/bulk-update', [App\Http\Controllers\Admin\MessageAdminController::class, 'bulkUpdate'])->name('messages.bulk-update');

    Route::get('messages/stats', [App\Http\Controllers\Admin\MessageAdminController::class, 'getStats'])->name('messages.stats');
    
    // Settings Management
    Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings/jersey-image', [App\Http\Controllers\Admin\SettingController::class, 'updateJerseyImage'])->name('settings.jersey-image.update');
    Route::get('settings/jersey-image/remove', [App\Http\Controllers\Admin\SettingController::class, 'removeJerseyImage'])->name('settings.jersey-image.remove');
    
    // Jersey Management
    Route::post('jerseys/upload', [App\Http\Controllers\Admin\SettingController::class, 'uploadJersey'])->name('jerseys.upload');
    Route::delete('jerseys/{jersey}', [App\Http\Controllers\Admin\SettingController::class, 'deleteJersey'])->name('jerseys.delete');
    
    // Mobile App Settings Management
    Route::get('mobile-app/settings', [App\Http\Controllers\Admin\MobileAppSettingsController::class, 'index'])->name('mobile-app.settings');
    Route::post('mobile-app/update-config', [App\Http\Controllers\Admin\MobileAppSettingsController::class, 'updateConfig'])->name('mobile-app.update-config');
    Route::post('mobile-app/upload-logo', [App\Http\Controllers\Admin\MobileAppSettingsController::class, 'uploadLogo'])->name('mobile-app.upload-logo');
    Route::post('mobile-app/upload-splash', [App\Http\Controllers\Admin\MobileAppSettingsController::class, 'uploadSplashScreen'])->name('mobile-app.upload-splash');
    Route::post('mobile-app/update-advantages', [App\Http\Controllers\Admin\MobileAppSettingsController::class, 'updateAdvantages'])->name('mobile-app.update-advantages');
    Route::get('mobile-app/preview', [App\Http\Controllers\Admin\MobileAppSettingsController::class, 'preview'])->name('mobile-app.preview');
    Route::get('mobile-app/reset-defaults', [App\Http\Controllers\Admin\MobileAppSettingsController::class, 'resetToDefaults'])->name('mobile-app.reset-defaults');
    
    // League Management
    Route::resource('leagues', App\Http\Controllers\Admin\LeagueController::class);
    Route::get('leagues/api/standings', [App\Http\Controllers\Admin\LeagueController::class, 'getStandings'])->name('admin.leagues.standings');
    
    // TinyMCE Image Upload
    Route::post('/upload-image', [App\Http\Controllers\AdminController::class, 'uploadImage'])->name('upload.image');
});

// Public API routes for league standings
Route::get('/api/league/standings', [App\Http\Controllers\LeagueController::class, 'getStandings'])->name('api.league.standings');
Route::get('/api/league/seasons', [App\Http\Controllers\LeagueController::class, 'getSeasons'])->name('api.league.seasons');
