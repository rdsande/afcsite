<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MobileAppController;
use App\Http\Controllers\Api\NewsApiController;
use App\Http\Controllers\Api\FixtureApiController;
use App\Http\Controllers\Api\PlayerApiController;
use App\Http\Controllers\Api\FanApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Mobile App API Routes
Route::prefix('mobile')->name('mobile.')->group(function () {

    // Public endpoints (no authentication required)
    Route::get('/config', [MobileAppController::class, 'getConfig'])->name('config');
    Route::get('/splash-screen', [MobileAppController::class, 'getSplashScreen'])->name('splash-screen');

    // News endpoints
    Route::get('/news', [NewsApiController::class, 'index'])->name('news.index');
    Route::get('/news/featured', [NewsApiController::class, 'featured'])->name('news.featured');
    Route::get('/news/category/{category}', [NewsApiController::class, 'byCategory'])->name('news.byCategory');
    Route::get('/news/{news}', [NewsApiController::class, 'show'])->name('news.show');

    // Fixtures endpoints
    Route::get('/fixtures', [FixtureApiController::class, 'index'])->name('fixtures.index');
    Route::get('/fixtures/upcoming', [FixtureApiController::class, 'upcoming'])->name('fixtures.upcoming');
    Route::get('/fixtures/results', [FixtureApiController::class, 'results'])->name('fixtures.results');
    Route::get('/fixtures/{fixture}', [FixtureApiController::class, 'show'])->name('fixtures.show');

    // Players endpoints
    Route::get('/players', [PlayerApiController::class, 'index'])->name('players.index');
    Route::get('/players/senior', [PlayerApiController::class, 'senior'])->name('players.senior');
    Route::get('/players/academy/{team}', [PlayerApiController::class, 'academy'])->name('players.academy');
    Route::get('/players/{player}', [PlayerApiController::class, 'show'])->name('players.show');

    // Location endpoints (public)
    Route::get('/regions', [FanApiController::class, 'getRegions'])->name('regions');
    Route::get('/districts/{regionId}', [FanApiController::class, 'getDistricts'])->name('districts');

    // Fan authentication endpoints
    Route::post('/fan/register', [FanApiController::class, 'register'])->name('fan.register');
    Route::post('/fan/login', [FanApiController::class, 'login'])->name('fan.login');

    // Protected fan endpoints (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/fan/profile', [FanApiController::class, 'profile'])->name('fan.profile');
        Route::put('/fan/profile', [FanApiController::class, 'updateProfile'])->name('fan.updateProfile');
        Route::post('/fan/logout', [FanApiController::class, 'logout'])->name('fan.logout');
        Route::get('/fan/points', [FanApiController::class, 'getPoints'])->name('fan.points');
    });
});
