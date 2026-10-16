<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\{
    AcceptInvitationController,
    CompanyController,
    CompanyInvitationController,
    DashboardController,
    ShortUrlController,
    TeamInvitationController,
    UserShortUrlController
};

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])
        ->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])
        ->name('login');

    Route::get('/invite/{token}', [AcceptInvitationController::class, 'show'])
        ->name('invitations.show');
    Route::post('/invite/{token}', [AcceptInvitationController::class, 'store'])
        ->name('invitations.accept');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])
        ->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::middleware('role:superadmin')->group(function () {
        Route::post('/invitations/company', [CompanyInvitationController::class, 'store'])
            ->name('invitations.company');
        Route::get('/companies/{company}/users', [CompanyController::class, 'users'])
            ->name('companies.users');
        Route::get('/companies/{company}/short-urls', [CompanyController::class, 'shortUrls'])
            ->name('companies.short-urls');
    });

    Route::get('/users/{member}/short-urls', [UserShortUrlController::class, 'index'])
        ->middleware('role:superadmin,admin')
        ->name('users.short-urls');

    Route::get('/short-urls', [ShortUrlController::class, 'index'])
        ->name('short-urls.index');

    Route::post('/short-urls', [ShortUrlController::class, 'store'])
        ->middleware('role:admin,member')
        ->name('short-urls.store');

    Route::post('/invitations/team', [TeamInvitationController::class, 'store'])
        ->middleware('role:admin')
        ->name('invitations.team');
});

// public - anyone with the link gets redirected
Route::get('/s/{code}', [ShortUrlController::class, 'redirect'])
    ->name('short-urls.redirect');

Route::redirect('/', '/login');
