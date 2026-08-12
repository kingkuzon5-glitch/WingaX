<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ShopController as AdminShopController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductFeedController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public marketplace routes (span every shop)
|--------------------------------------------------------------------------
*/

Route::get('/', [ProductFeedController::class, 'index'])->name('home');
Route::get('/feed/more', [ProductFeedController::class, 'more'])->name('feed.more');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/deals', [DealController::class, 'index'])->name('deals.index');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');

Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{product:slug}/view', [ProductController::class, 'recordView'])->name('products.view');

Route::get('/whatsapp/{product:slug}', [WhatsAppController::class, 'redirect'])->name('whatsapp.redirect');

/*
|--------------------------------------------------------------------------
| Vendor auth
|--------------------------------------------------------------------------
*/

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

/*
|--------------------------------------------------------------------------
| Vendor admin dashboard
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');

    Route::get('/shop', [AdminShopController::class, 'edit'])->name('shop.edit');
    Route::put('/shop', [AdminShopController::class, 'update'])->name('shop.update');

    Route::resource('products', AdminProductController::class)->except(['show'])->scoped(['product' => 'id']);
    Route::delete('products/{product}/images/{image}', [AdminProductController::class, 'destroyImage'])->name('products.images.destroy');
    Route::delete('products/{product}/video/{video}', [AdminProductController::class, 'destroyVideo'])->name('products.video.destroy');

    Route::resource('categories', AdminCategoryController::class)->except(['show'])->scoped(['category' => 'id']);
});

/*
|--------------------------------------------------------------------------
| Shop storefronts — catch-all, must be registered last
|--------------------------------------------------------------------------
*/

Route::get('/{store:slug}', [ShopController::class, 'show'])->name('shop.show');
