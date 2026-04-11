<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\PlanController;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/',                     [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/companies',            [CompanyController::class, 'index'])->name('companies.index');
        Route::get('/companies/{company}',  [CompanyController::class, 'show'])->name('companies.show');
        Route::patch('/companies/{company}/toggle', [CompanyController::class, 'toggle'])->name('companies.toggle');
        Route::resource('/plans', PlanController::class)->except('show');
    });
