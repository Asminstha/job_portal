<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Company\DashboardController;
use App\Http\Controllers\Company\JobController;
use App\Http\Controllers\Company\ApplicationController;
use App\Http\Controllers\Company\SubscriptionController;
use App\Http\Controllers\Company\TeamController;
use App\Http\Controllers\Company\ProfileController;

Route::prefix('dashboard')
    ->name('company.')
    ->middleware(['auth', 'role:company_admin,recruiter', 'company.active'])
    ->group(function () {

        Route::get('/',  [DashboardController::class, 'index'])->name('dashboard');

        // Jobs
        Route::get('/jobs',                   [JobController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/create',            [JobController::class, 'create'])->name('jobs.create');
        Route::post('/jobs',                  [JobController::class, 'store'])->name('jobs.store')->middleware('plan.limit');
        Route::get('/jobs/{job}/edit',        [JobController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{job}',             [JobController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{job}',          [JobController::class, 'destroy'])->name('jobs.destroy');
        Route::patch('/jobs/{job}/toggle',    [JobController::class, 'toggleStatus'])->name('jobs.toggle');

        // Applications
        Route::get('/jobs/{job}/applications',              [ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}',           [ApplicationController::class, 'show'])->name('applications.show');
        Route::patch('/applications/{application}/status',  [ApplicationController::class, 'updateStatus'])->name('applications.status');

        // Subscription
        Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription.index');

        // Team
        Route::get('/team',          [TeamController::class, 'index'])->name('team.index');
        Route::post('/team/invite',  [TeamController::class, 'invite'])->name('team.invite');
        Route::delete('/team/{user}',[TeamController::class, 'remove'])->name('team.remove');

        // Company profile
        Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    });
