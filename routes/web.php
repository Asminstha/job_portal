<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\JobController as PublicJobController;
use App\Http\Controllers\Public\CompanyController as PublicCompanyController;

// ── Public routes ──────────────────────────────────────────────
Route::get('/',            [HomeController::class, 'index'])->name('home');
Route::get('/jobs',        [PublicJobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{slug}', [PublicJobController::class, 'show'])->name('jobs.show');
Route::post('/jobs/{slug}/apply', [PublicJobController::class, 'apply'])
    ->middleware('auth')
    ->name('jobs.apply');
Route::get('/companies',          [PublicCompanyController::class, 'index'])->name('companies.index');
Route::get('/companies/{slug}',   [PublicCompanyController::class, 'show'])->name('companies.show');
Route::get('/pricing',            fn() => view('public.pricing'))->name('pricing');

// ── Guest only routes ──────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',             [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',            [AuthController::class, 'login'])->name('login.post');
    Route::get('/register',          [AuthController::class, 'showRegister'])->name('register');
    Route::get('/register/company',  [AuthController::class, 'showRegisterCompany'])->name('register.company');
    Route::post('/register/company', [AuthController::class, 'registerCompany'])->name('register.company.post');
    Route::get('/register/seeker',   [AuthController::class, 'showRegisterSeeker'])->name('register.seeker');
    Route::post('/register/seeker',  [AuthController::class, 'registerSeeker'])->name('register.seeker.post');
});

// ── Logout ─────────────────────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')->name('logout');

// ── Sub route files ────────────────────────────────────────────
require __DIR__ . '/company.php';
require __DIR__ . '/seeker.php';
require __DIR__ . '/admin.php';


// SEO
Route::get('/robots.txt', function () {
    $content = "User-agent: *\nAllow: /\n\nDisallow: /admin\nDisallow: /dashboard\nDisallow: /my\n\nSitemap: " . config('app.url') . "/sitemap.xml";
    return response($content, 200)->header('Content-Type', 'text/plain');
});

Route::get('/sitemap.xml', function () {
    $jobs      = \App\Models\Job::withoutGlobalScopes()
                    ->where('status', 'active')->get();
    $companies = \App\Models\Company::where('is_active', true)->get();

    return response()->view('sitemap', compact('jobs', 'companies'))
        ->header('Content-Type', 'application/xml');
});


// Password reset
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password',        [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password',       [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password',        [AuthController::class, 'resetPassword'])->name('password.update');
});


//  ccontact page
Route::get('/contact', fn() => view('public.contact'))->name('contact');
Route::post('/contact', [App\Http\Controllers\Public\ContactController::class, 'send'])->name('contact.send');

// about page

Route::get('/about', fn() => view('public.about'))->name('about');


Route::get('/privacy', fn() => view('public.privacy'))->name('privacy');
Route::get('/terms',   fn() => view('public.terms'))->name('terms');
