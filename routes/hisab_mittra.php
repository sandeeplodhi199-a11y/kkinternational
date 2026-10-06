<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HisabMittra\HisabMittraController;

// Public Website Routes
Route::get('/', [HisabMittraController::class, 'home'])->name('hisab.home');
Route::get('/features', [HisabMittraController::class, 'features'])->name('hisab.features');
Route::get('/hrm', [HisabMittraController::class, 'hrm'])->name('hisab.hrm');
Route::get('/crm-platform', [HisabMittraController::class, 'crm'])->name('hisab.crm');
Route::get('/crm', [HisabMittraController::class, 'crm']);
Route::get('/pricing', [HisabMittraController::class, 'pricing'])->name('hisab.pricing');
Route::get('/about', [HisabMittraController::class, 'about'])->name('hisab.about');
Route::get('/contact', [HisabMittraController::class, 'contact'])->name('hisab.contact');
Route::post('/contact/submit', [HisabMittraController::class, 'postContact'])->name('hisab.contact.submit');
Route::get('/book-demo', [HisabMittraController::class, 'bookDemo'])->name('hisab.demo');
Route::post('/book-demo/submit', [HisabMittraController::class, 'postDemo'])->name('hisab.demo.submit');
Route::get('/blog', [HisabMittraController::class, 'blog'])->name('hisab.blog');
Route::get('/help', [HisabMittraController::class, 'help'])->name('hisab.help');

// Convenience Direct Logins & Dashboard Shortcuts
Route::get('/login', function () {
    return redirect()->route('crm.login');
})->name('login');

Route::get('/admin', function () {
    return redirect()->route('crm.admin.dashboard');
})->name('admin');
