<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ApparatusController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TransparencyController;
use Illuminate\Support\Facades\Route;
use App\Models\Budget;
use App\Models\News;
use App\Models\Apparatus;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicController;

use App\Http\Controllers\SetupController;

// Setup Wizard Routes
Route::prefix('setup')->group(function () {
    Route::get('/', [SetupController::class, 'index'])->name('setup.index');
    Route::get('/step2', [SetupController::class, 'step2'])->name('setup.step2');
    Route::post('/configure', [SetupController::class, 'configureDatabase'])->name('setup.configure');
    Route::get('/step3', [SetupController::class, 'step3'])->name('setup.step3');
    Route::post('/install', [SetupController::class, 'install'])->name('setup.install');
    Route::get('/finished', [SetupController::class, 'finished'])->name('setup.finished');
});

// Public Routes
Route::get('/', [HomeController::class, 'index']);

Route::get('/transparansi', [PublicController::class, 'transparency'])->name('transparency.index');
Route::get('/berita', [PublicController::class, 'news']);
Route::get('/berita/{news:slug}', [PublicController::class, 'newsDetail'])->name('news.show');
Route::get('/api/search', [PublicController::class, 'search'])->name('api.search');
Route::get('/kontak', [PublicController::class, 'contact'])->name('contact');
Route::get('/api/weather', [PublicController::class, 'weatherProxy'])->name('api.weather');

// Profil Desa Routes
Route::redirect('/profil', '/profil/visi-misi');
Route::prefix('profil')->group(function () {
    Route::get('/sejarah', [PublicController::class, 'history'])->name('profile.sejarah');
    Route::get('/visi-misi', [PublicController::class, 'visimisi'])->name('profile.visimisi');
    Route::get('/struktur', [PublicController::class, 'structure'])->name('profile.structure');
    Route::get('/produk-hukum', [PublicController::class, 'legalProducts'])->name('profile.legal');
});

Route::get('/marketplace', [PublicController::class, 'marketplace']);

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/register/activate/{token}', [AuthController::class, 'activate'])->name('register.activate');
Route::post('/register/resend', [AuthController::class, 'resendActivation'])->name('register.resend');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// Dashboard Routes (Protected)
Route::middleware(['auth', 'role:admin,aparatur'])->prefix('admin')->group(function () {
    // Shared Dasbor Entry
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Group: Admin Only
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', App\Http\Controllers\Admin\UserController::class)->names('admin.users');
        Route::post('users/{user}/toggle-active', [App\Http\Controllers\Admin\UserController::class, 'toggleActive'])->name('admin.users.toggle-active');
        Route::post('apparatus/update-order', [ApparatusController::class, 'updateOrder'])->name('apparatus.update-order');
        Route::post('apparatus/update-hierarchy', [ApparatusController::class, 'updateHierarchy'])->name('apparatus.update-hierarchy');
        Route::resource('apparatus', ApparatusController::class)->parameters([
            'apparatus' => 'apparatus'
        ])->except(['show']);
        Route::resource('legal-products', App\Http\Controllers\Admin\LegalProductController::class)->names('admin.legal-products');
        Route::get('settings', [SettingsController::class, 'index'])->name('admin.settings.index');
        Route::post('settings', [SettingsController::class, 'update'])->name('admin.settings.update');
        Route::resource('transparency', TransparencyController::class)->names('admin.transparency');
        Route::post('transparency/scrape', [TransparencyController::class, 'scrape'])->name('admin.transparency.scrape');
        Route::delete('transparency/year/{year}', [TransparencyController::class, 'destroyByYear'])->name('admin.transparency.destroy-year');
        Route::post('transparency/summary', [TransparencyController::class, 'updateSummary'])->name('admin.transparency.update-summary');
        Route::post('transparency/import-html', [TransparencyController::class, 'importHtml'])->name('admin.transparency.import-html');
    });

    // Group: Admin & Aparatur
    Route::middleware(['role:admin,aparatur'])->group(function () {
        Route::resource('agendas', App\Http\Controllers\Admin\AgendaController::class);
        Route::resource('news', App\Http\Controllers\Admin\NewsController::class)->names('admin.news');
        Route::get('marketplace', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.marketplace.index');
        Route::delete('marketplace/{product}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('admin.marketplace.destroy');
    });
});

// Residents (Warga) Routes
Route::middleware(['auth', 'role:warga'])->prefix('resident')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Resident\DashboardController::class, 'index'])->name('resident.dashboard');
    Route::resource('products', App\Http\Controllers\Resident\ResidentProductController::class)->names('resident.products');
    Route::patch('products/{product}/toggle', [App\Http\Controllers\Resident\ResidentProductController::class, 'toggleStatus'])->name('resident.products.toggle');
    
    // Profile Management
    Route::get('/profile', [App\Http\Controllers\Resident\ProfileController::class, 'index'])->name('resident.profile');
    Route::post('/profile', [App\Http\Controllers\Resident\ProfileController::class, 'update'])->name('resident.profile.update');
    Route::post('/profile/password', [App\Http\Controllers\Resident\ProfileController::class, 'updatePassword'])->name('resident.profile.password');
});

// Region API Routes
Route::get('/api/provinces', [App\Http\Controllers\RegionController::class, 'provinces']);
Route::get('/api/regencies', [App\Http\Controllers\RegionController::class, 'regencies']);
Route::get('/api/districts', [App\Http\Controllers\RegionController::class, 'districts']);
Route::get('/api/villages', [App\Http\Controllers\RegionController::class, 'villages']);
Route::get('/api/bmkg-lookup', [App\Http\Controllers\RegionController::class, 'searchBmkg']);

