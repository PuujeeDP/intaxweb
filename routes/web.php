<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController as FrontendPostController;
use App\Http\Controllers\Frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\Frontend\PageController as FrontendPageController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\TeamMemberController as FrontendTeamMemberController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Admin\CompanyHistoryController;
use App\Http\Controllers\Frontend\CompanyHistoryController as FrontendCompanyHistoryController;

// Redirect root to default locale
Route::get('/', function () {
    return redirect('/zh');
});

// Redirect old site URLs to new structure
Route::get('/mn/magic-group/news.html', function () {
    return redirect('/mn/posts');
});

// Localized frontend routes
Route::prefix('{locale}')->where(['locale' => 'mn|en|zh'])->group(function () {
    // Posts (define specific routes before home)
    Route::get('posts', [FrontendPostController::class, 'index'])->name('posts.index');
    Route::get('post/{slug}', [FrontendPostController::class, 'show'])->name('posts.show');

    // Categories
    Route::get('category/{slug}', [FrontendCategoryController::class, 'show'])->name('categories.show');

   

    // About, Services, Team, Contact, History
    //Route::get('about', [AboutController::class, 'index'])->name('about.index');
    Route::get('services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('service/{slug}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('team', [FrontendTeamMemberController::class, 'index'])->name('team.index');
    Route::get('history', [FrontendCompanyHistoryController::class, 'index'])->name('history.index');
    Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('contact', [ContactController::class, 'submit'])->name('contact.submit');

    // Pages
    Route::get('/{slug}', [FrontendPageController::class, 'show'])->name('pages.show');

    // Home (define last to avoid matching other routes)
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/admin/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Posts
    Route::resource('posts', AdminPostController::class);

    // Pages
    Route::resource('pages', AdminPageController::class);

    // Categories
    Route::resource('categories', AdminCategoryController::class);

    // Media
    Route::resource('media', MediaController::class)->except(['create', 'show', 'edit']);

    // Services
    Route::resource('services', AdminServiceController::class);

    // Sliders
    Route::resource('sliders', SliderController::class);

    // Team Members
    Route::resource('team', TeamMemberController::class);

    // Clients
    Route::resource('clients', ClientController::class);

    // Testimonials
    Route::resource('testimonials', TestimonialController::class);

    // Company History
    Route::resource('company-histories', CompanyHistoryController::class)->except(['show']);

    // Widgets
    Route::resource('widgets', \App\Http\Controllers\Admin\WidgetController::class);

    // Users
    Route::resource('users', UserController::class);

    // Menus
    Route::resource('menus', MenuController::class)->except(['show']);
    Route::post('menus/{menu}/items', [MenuController::class, 'saveItems'])->name('menus.items.save');
    Route::post('menus/{menu}/items/reorder', [MenuController::class, 'reorderItems'])->name('menus.items.reorder');
    Route::delete('menu-items/{menuItem}', [MenuController::class, 'destroyItem'])->name('menu-items.destroy');

    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
});
