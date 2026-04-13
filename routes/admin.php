<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\SubscriptionController;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Companies
        Route::get('/companies',                    [CompanyController::class, 'index'])->name('companies.index');
        Route::get('/companies/{company}',          [CompanyController::class, 'show'])->name('companies.show');
        Route::patch('/companies/{company}/toggle', [CompanyController::class, 'toggle'])->name('companies.toggle');
        Route::patch('/companies/{company}/plan',   [CompanyController::class, 'changePlan'])->name('companies.plan');

        // Users
        Route::get('/users',                  [UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/toggle',  [UserController::class, 'toggle'])->name('users.toggle');

        // Jobs
        Route::get('/jobs',               [JobController::class, 'index'])->name('jobs.index');
        Route::patch('/jobs/{job}/toggle',[JobController::class, 'toggle'])->name('jobs.toggle');
        Route::delete('/jobs/{job}',      [JobController::class, 'destroy'])->name('jobs.destroy');

        // Plans
        Route::resource('/plans', PlanController::class)->except('show');

        // Subscriptions
        Route::get('/subscriptions',                         [SubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::patch('/subscriptions/{subscription}/approve',[SubscriptionController::class, 'approve'])->name('subscriptions.approve');
        Route::patch('/subscriptions/{subscription}/reject', [SubscriptionController::class, 'reject'])->name('subscriptions.reject');
    });
