<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ScoutSectionController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\PublicPostController;
use App\Http\Controllers\PublicGalleryController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\PublicShopController;
use App\Http\Controllers\ContactController;
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
Route::get('/', [HomeController::class, 'index'])->name('home');

// About Routes
Route::prefix('about')->name('about.')->group(function () {
    Route::get('/', [AboutController::class, 'index'])->name('index');
    Route::get('/history', [AboutController::class, 'history'])->name('history');
    Route::get('/team', [AboutController::class, 'team'])->name('team');
    Route::get('/vision', [AboutController::class, 'vision'])->name('vision');
});

// Scout Sections Routes
Route::prefix('sections')->name('sections.')->group(function () {
    Route::get('/', [ScoutSectionController::class, 'index'])->name('index');
    Route::get('/{section}', [ScoutSectionController::class, 'show'])->name('show');
});

// Events Routes
Route::prefix('events')->name('events.')->group(function () {
    Route::get('/', [PublicEventController::class, 'index'])->name('index');
    Route::get('/{slug}', [PublicEventController::class, 'show'])->name('show');
});

// News/Blog Routes
Route::prefix('news')->name('news.')->group(function () {
    Route::get('/', [PublicPostController::class, 'index'])->name('index');
    Route::get('/{slug}', [PublicPostController::class, 'show'])->name('show');
});

// Gallery Routes
Route::prefix('gallery')->name('gallery.')->group(function () {
    Route::get('/', [PublicGalleryController::class, 'index'])->name('index');
    Route::get('/{slug}', [PublicGalleryController::class, 'show'])->name('show');
});

// Resources Routes
Route::prefix('resources')->name('resources.')->group(function () {
    Route::get('/circulars', [ResourceController::class, 'circulars'])->name('circulars');
    Route::get('/syllabus', [ResourceController::class, 'syllabus'])->name('syllabus');
});

// Shop Routes
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', [PublicShopController::class, 'index'])->name('index');
    Route::get('/{slug}', [PublicShopController::class, 'show'])->name('show');
});

// Contact Routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

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
        Route::post('galleries/{gallery}/images/order', [GalleryImageController::class, 'updateOrder'])->name('galleries.images.order');
        Route::patch('gallery-images/{image}/caption', [GalleryImageController::class, 'updateCaption'])->name('gallery-images.caption');
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
