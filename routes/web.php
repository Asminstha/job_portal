<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\JobController as PublicJobController;
use App\Http\Controllers\Public\CompanyController as PublicCompanyController;

// ── Public routes ──────────────────────────────────────────────
Route::get('/',           [HomeController::class, 'index'])->name('home');
Route::get('/jobs',       [PublicJobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [PublicJobController::class, 'show'])->name('jobs.show');
Route::get('/companies',  [PublicCompanyController::class, 'index'])->name('companies.index');
Route::get('/companies/{company}', [PublicCompanyController::class, 'show'])->name('companies.show');
Route::get('/pricing',    fn() => view('public.pricing'))->name('pricing');

// ── Auth routes (guests only) ──────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',              [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',             [AuthController::class, 'login'])->name('login.post');
    Route::get('/register',           [AuthController::class, 'showRegister'])->name('register');
    Route::get('/register/company',   [AuthController::class, 'showRegisterCompany'])->name('register.company');
    Route::post('/register/company',  [AuthController::class, 'registerCompany'])->name('register.company.post');
    Route::get('/register/seeker',    [AuthController::class, 'showRegisterSeeker'])->name('register.seeker');
    Route::post('/register/seeker',   [AuthController::class, 'registerSeeker'])->name('register.seeker.post');
});

// ── Logout ─────────────────────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ── Sub route files ────────────────────────────────────────────
require __DIR__ . '/company.php';
require __DIR__ . '/seeker.php';
require __DIR__ . '/admin.php';
