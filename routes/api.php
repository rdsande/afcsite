<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MobileAppController;
use App\Http\Controllers\Api\NewsApiController;
use App\Http\Controllers\Api\FixtureApiController;
use App\Http\Controllers\Api\PlayerApiController;
use App\Http\Controllers\Api\FanApiController;
use App\Http\Controllers\Api\ShopApiController;
use App\Http\Controllers\Api\AdminNoticeApiController;
use App\Http\Controllers\Api\JerseyApiController;

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

    // Fans endpoints (public)
    Route::get('/fans', [FanApiController::class, 'getAllFans'])->name('fans.index');

    // Fan authentication endpoints
    Route::post('/fan/register', [FanApiController::class, 'register'])->name('fan.register');
    Route::post('/fan/login', [FanApiController::class, 'login'])->name('fan.login');

    // Protected fan endpoints (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/fan/profile', [FanApiController::class, 'profile'])->name('fan.profile');
        Route::put('/fan/profile', [FanApiController::class, 'updateProfile'])->name('fan.updateProfile');
        Route::post('/fan/logout', [FanApiController::class, 'logout'])->name('fan.logout');
        Route::get('/fan/points', [FanApiController::class, 'getPoints'])->name('fan.points');
        Route::get('/fan/jersey', [FanApiController::class, 'getJersey'])->name('fan.jersey');
        Route::put('/fan/jersey', [FanApiController::class, 'updateJersey'])->name('fan.updateJersey');
    });

    // Shop endpoints (public)
    Route::get('/shop/products', [ShopApiController::class, 'getProducts'])->name('shop.products');
    Route::get('/shop/products/featured', [ShopApiController::class, 'getFeaturedProducts'])->name('shop.products.featured');
    Route::get('/shop/products/category/{category}', [ShopApiController::class, 'getProductsByCategory'])->name('shop.products.category');
    Route::get('/shop/products/{id}', [ShopApiController::class, 'getProduct'])->name('shop.products.show');

    // Admin notices endpoints (public)
    Route::get('/admin-notices', [AdminNoticeApiController::class, 'index'])->name('admin-notices.index');
    Route::get('/admin-notices/dashboard', [AdminNoticeApiController::class, 'forDashboard'])->name('admin-notices.dashboard');

    // Jersey endpoints (public)
    Route::get('/jerseys', [JerseyApiController::class, 'index'])->name('jerseys.index');
    Route::get('/jerseys/types', [JerseyApiController::class, 'getTypes'])->name('jerseys.types');
    Route::get('/jerseys/type/{type}', [JerseyApiController::class, 'getByType'])->name('jerseys.byType');
    Route::get('/jerseys/{jersey}', [JerseyApiController::class, 'show'])->name('jerseys.show');
});
