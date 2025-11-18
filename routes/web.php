<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GalleryImageController;
use App\Http\Controllers\Admin\SyllabusController;
use App\Http\Controllers\Admin\CircularController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\MilestoneController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// User Dashboard (Breeze default)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Blog Management - accessible by super-admin and blogger
    Route::middleware('role:super-admin|blogger')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('posts', PostController::class);

        // Events
        Route::resource('events', EventController::class);

        // Galleries
        Route::resource('galleries', GalleryController::class);
        Route::post('galleries/{gallery}/images', [GalleryImageController::class, 'store'])->name('galleries.images.store');
        Route::delete('gallery-images/{image}', [GalleryImageController::class, 'destroy'])->name('gallery-images.destroy');

        // Resources
        Route::resource('syllabi', SyllabusController::class);
        Route::resource('circulars', CircularController::class);
    });

    // Shop Management - accessible by super-admin and shop-manager
    Route::middleware('role:super-admin|shop-manager')->group(function () {
        Route::resource('product-categories', ProductCategoryController::class);
        Route::resource('products', ProductController::class);
    });

    // Site Management - super-admin only
    Route::middleware('role:super-admin')->group(function () {
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::resource('milestones', MilestoneController::class);
    });
});

require __DIR__.'/auth.php';
