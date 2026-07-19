<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EconomyController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\ShipmentMonitoringController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\Admin\ArticleAnalysisController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/risk', [RiskController::class, 'index'])
    ->name('risk.index');
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Weather
    |--------------------------------------------------------------------------
    */

    Route::get('/weather', [WeatherController::class, 'index'])
        ->name('weather.index');

    Route::get('/weather/sync', [WeatherController::class, 'sync'])
        ->name('weather.sync');

    /*
    |--------------------------------------------------------------------------
    | Economy
    |--------------------------------------------------------------------------
    */

    Route::get('/economy', [EconomyController::class, 'index'])
        ->name('economy.index');

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    */

    Route::get('/currency', [CurrencyController::class, 'index'])
        ->name('currency.index');

    Route::get('/currency/sync', [CurrencyController::class, 'sync'])
        ->name('currency.sync');

    /*
    |--------------------------------------------------------------------------
    | Comparison
    |--------------------------------------------------------------------------
    */

    Route::get('/comparison', [ComparisonController::class, 'index'])
        ->name('comparison');

    /*
    |--------------------------------------------------------------------------
    | Watchlist
    |--------------------------------------------------------------------------
    */

    Route::get('/watchlists', [WatchlistController::class, 'index'])
        ->name('watchlists.index');

    Route::post('/watchlists/{country}', [WatchlistController::class, 'store'])
        ->name('watchlists.store');

    Route::delete('/watchlists/{id}', [WatchlistController::class, 'destroy'])
        ->name('watchlists.destroy');

    /*
    |--------------------------------------------------------------------------
    | Shipments
    |--------------------------------------------------------------------------
    */

    Route::get('/shipments', [ShipmentController::class, 'index'])
        ->name('shipments.index');

    Route::get('/shipments/{shipment}', [ShipmentController::class, 'show'])
        ->name('shipments.show');

    Route::get('/shipment-monitoring', [ShipmentMonitoringController::class, 'index'])
        ->name('shipment.monitoring');

    /*
    |--------------------------------------------------------------------------
    | News
    |--------------------------------------------------------------------------
    */

    Route::get('/news', [NewsController::class, 'index'])
        ->name('news.index');

    Route::get('/news/sync', [NewsController::class, 'sync'])
        ->name('news.sync');

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')->group(function () {

        Route::get('/analysis', [ArticleAnalysisController::class, 'index'])
    ->name('admin.analysis');

        Route::get('/', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');

        // Users
        Route::get('/users', [AdminController::class, 'users'])
            ->name('admin.users');

        Route::get('/users/create', [AdminController::class, 'createUser'])
            ->name('admin.users.create');

        Route::post('/users', [AdminController::class, 'storeUser'])
            ->name('admin.users.store');

        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])
            ->name('admin.users.edit');

        Route::put('/users/{user}', [AdminController::class, 'updateUser'])
            ->name('admin.users.update');

        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])
            ->name('admin.users.destroy');

        // Ports
        Route::get('/ports', [AdminController::class, 'ports'])
            ->name('admin.ports');

        // Articles
     // Articles
Route::get('/articles', [AdminController::class, 'articles'])
    ->name('admin.articles');

Route::get('/articles/create', [AdminController::class, 'createArticle'])
    ->name('admin.articles.create');

Route::post('/articles', [AdminController::class, 'storeArticle'])
    ->name('admin.articles.store');

Route::get('/articles/{article}/edit', [AdminController::class, 'editArticle'])
    ->name('admin.articles.edit');

Route::put('/articles/{article}', [AdminController::class, 'updateArticle'])
    ->name('admin.articles.update');

Route::delete('/articles/{article}', [AdminController::class, 'destroyArticle'])
    ->name('admin.articles.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';