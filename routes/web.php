<?php

use App\Http\Controllers\Booking\AdminBookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Organization\OrganizationController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Item\ItemController;

/*
|--------------------------------------------------------------------------
| GUEST AREA (GLOBAL AUTH - SUPERADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Login & Register Superadmin
    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/session', [SessionsController::class, 'store']);

    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);

    // Password Reset (Global)
    Route::get('/login/forgot-password', [ResetController::class, 'create']);
    Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
    Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
    Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED AREA (GLOBAL)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/', [HomeController::class, 'home']);

    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::get('/profile', fn () => view('profile'))->name('profile');
    

    Route::get('/logout', [SessionsController::class, 'destroy'])->name('logout');

    Route::get('/user-profile', [InfoUserController::class, 'create']);
    Route::post('/user-profile', [InfoUserController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| SUPERADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'superadmin'])->group(function () {

    // User Management
    Route::prefix('user-management')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user-management-index');
        Route::get('/create', [UserController::class, 'create'])->name('user-management-create');
        Route::post('/create', [UserController::class, 'store'])->name('user-management-store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user-management-edit');
        Route::put('/{id}/edit', [UserController::class, 'update'])->name('user-management-update');
        Route::delete('/{id}/delete', [UserController::class, 'destroy'])->name('user-management-destroy');
    });

    // Organization Management
    Route::prefix('organization-management')->group(function () {
        Route::get('/', [OrganizationController::class, 'index'])->name('organization-management-index');
        Route::get('/create', [OrganizationController::class, 'create'])->name('organization-management-create');
        Route::post('/create', [OrganizationController::class, 'store'])->name('organization-management-store');
        Route::get('/{slug}/edit', [OrganizationController::class, 'edit'])->name('organization-management-edit');
        Route::put('/{slug}/edit', [OrganizationController::class, 'update'])->name('organization-management-update');
        Route::delete('/{slug}/delete', [OrganizationController::class, 'destroy'])->name('organization-management-destroy');
    });
});

/*
|--------------------------------------------------------------------------
| TENANT AUTH (LOGIN VIA TOKEN)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::get('/login/organization/{token}', [SessionsController::class, 'tenantLinkLogin'])
        ->name('organization.login.link');

    Route::post('/login/organization', [SessionsController::class, 'tenantLogin'])
        ->name('organization.login.submit');
});

/*
|--------------------------------------------------------------------------
| TENANT AREA (ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'tenant', 'admin'])->group(function () {

    Route::get('/organization/dashboard', [HomeController::class, 'home_tenant'])
        ->name('org.dashboard');

    // Category Management
    Route::prefix('organization/category-management')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('org.category-management-index');
        Route::get('/create', [CategoryController::class, 'create'])->name('org.category-management-create');
        Route::post('/create', [CategoryController::class, 'store'])->name('org.category-management-store');
        Route::get('/{slug}/edit', [CategoryController::class, 'edit'])->name('org.category-management-edit');
        Route::put('/{slug}/edit', [CategoryController::class, 'update'])->name('org.category-management-update');
        Route::delete('/{slug}/delete', [CategoryController::class, 'destroy'])->name('org.category-management-destroy');
    });

    // Item Management
    Route::prefix('organization/item-management')->group(function () {
        Route::get('/', [ItemController::class, 'index'])->name('org.item-management-index');
        Route::get('/create', [ItemController::class, 'create'])->name('org.item-management-create');
        Route::post('/create', [ItemController::class, 'store'])->name('org.item-management-store');
        Route::get('/{slug}/edit', [ItemController::class, 'edit'])->name('org.item-management-edit');
        Route::put('/{slug}/edit', [ItemController::class, 'update'])->name('org.item-management-update');
        Route::delete('/{slug}/delete', [ItemController::class, 'destroy'])->name('org.item-management-destroy');
    });

    // Booking Management
    Route::get('/organization/booking-management', [AdminBookingController::class, 'index'])->name('org.booking-management-index');
    Route::get('/organization/booking-history', [AdminBookingController::class, 'show_booking_history'])->name('org.booking-history');
    Route::post('/organization/booking/{id}/approve', [AdminBookingController::class, 'approve']);
    Route::post('/organization/booking/{id}/reject', [AdminBookingController::class, 'reject']);
});
