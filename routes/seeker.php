<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seeker\DashboardController;
use App\Http\Controllers\Seeker\ProfileController;
use App\Http\Controllers\Seeker\ApplicationController;
use App\Http\Controllers\Seeker\SavedJobController;

Route::prefix('my')
    ->name('seeker.')
    ->middleware(['auth', 'role:seeker'])
    ->group(function () {

        Route::get('/dashboard',   [DashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profile',     [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile',     [ProfileController::class, 'update'])->name('profile.update');

        // Applications
        Route::get('/applications',                    [ApplicationController::class, 'index'])->name('applications.index');
        Route::delete('/applications/{application}',   [ApplicationController::class, 'withdraw'])->name('applications.withdraw');

        // Saved jobs
        Route::get('/saved-jobs',        [SavedJobController::class, 'index'])->name('saved.index');
        Route::post('/saved-jobs/{job}', [SavedJobController::class, 'toggle'])->name('saved.toggle');
    });
