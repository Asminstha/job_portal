<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', fn() => 'Jobs page coming soon')->name('jobs.index');
Route::get('/companies', fn() => 'Companies page coming soon')->name('companies.index');
Route::get('/pricing', fn() => 'Pricing page coming soon')->name('pricing');
Route::get('/login', fn() => 'Login coming soon')->name('login');
Route::get('/register', fn() => 'Register coming soon')->name('register');
Route::get('/register/company', fn() => 'Company register coming soon')->name('register.company');
Route::get('/register/seeker', fn() => 'Seeker register coming soon')->name('register.seeker');
Route::post('/logout', fn() => redirect('/'))->name('logout');

// Placeholder dashboard routes
Route::get('/dashboard', fn() => 'Company dashboard coming soon')->name('company.dashboard');
Route::get('/my/dashboard', fn() => 'Seeker dashboard coming soon')->name('seeker.dashboard');
Route::get('/admin', fn() => 'Admin panel coming soon')->name('admin.dashboard');
