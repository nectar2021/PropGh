<?php

use App\Http\Controllers\Admin\AgentController as AdminAgentController;
use App\Http\Controllers\Admin\AuthenticatedSessionController as AdminAuthenticatedSessionController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LegalPageController as AdminLegalPageController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\PropertyController as AdminPropertyController;
use App\Http\Controllers\Admin\SiteSettingController as AdminSiteSettingController;
use App\Http\Controllers\Admin\SubscriberController as AdminSubscriberController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::redirect('/home', '/');
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/map', [PropertyController::class, 'map'])->name('properties.map');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::view('/contact', 'contact')->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/terms', function () {
    $page = \App\Models\LegalPage::findBySlug('terms');

    return view('terms', ['page' => $page]);
})->name('terms');
Route::get('/privacy', function () {
    $page = \App\Models\LegalPage::findBySlug('privacy');

    return view('privacy', ['page' => $page]);
})->name('privacy');

Route::middleware('guest')->group(function (): void {
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('guest')->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/login', [AdminAuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AdminAuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware('admin.auth')->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/properties', [AdminPropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/create', [AdminPropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [AdminPropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{property}/edit', [AdminPropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{property}', [AdminPropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{property}', [AdminPropertyController::class, 'destroy'])->name('properties.destroy');
    Route::get('/messages', [AdminContactMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{contactMessage}', [AdminContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{contactMessage}', [AdminContactMessageController::class, 'destroy'])->name('messages.destroy');
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/settings', [AdminSiteSettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [AdminSiteSettingController::class, 'update'])->name('settings.update');
    Route::get('/subscribers', [AdminSubscriberController::class, 'index'])->name('subscribers.index');
    Route::delete('/subscribers/{subscriber}', [AdminSubscriberController::class, 'destroy'])->name('subscribers.destroy');
    Route::get('/legal-pages', [AdminLegalPageController::class, 'index'])->name('legal-pages.index');
    Route::get('/legal-pages/{legalPage}/edit', [AdminLegalPageController::class, 'edit'])->name('legal-pages.edit');
    Route::put('/legal-pages/{legalPage}', [AdminLegalPageController::class, 'update'])->name('legal-pages.update');
    Route::get('/agents', [AdminAgentController::class, 'index'])->name('agents.index');
    Route::put('/agents/{user}/verify', [AdminAgentController::class, 'verify'])->name('agents.verify');
    Route::put('/agents/{user}/unverify', [AdminAgentController::class, 'unverify'])->name('agents.unverify');
});
