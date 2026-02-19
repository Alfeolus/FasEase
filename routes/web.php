<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\Item\UserItemController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Booking\UserBookingController;
use App\Http\Controllers\Booking\AdminBookingController;
use App\Http\Controllers\Organization\OrganizationController;

/*
|--------------------------------------------------------------------------
| GUEST AREA (GLOBAL AUTH - SUPERADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Login & Register Superadmin
    Route::get('fasease/login', [SessionsController::class, 'create'])->name('login-superadmin-index');
    Route::post('fasease/session', [SessionsController::class, 'store'])->name('login-superadmin-store');

    Route::get('fasease/register', [RegisterController::class, 'create'])->name('register-superadmin-index');
    Route::post('fasease/register', [RegisterController::class, 'store'])->name('register-superadmin-store');

    // Password Reset (Global)
    Route::get('/login/forgot-password', [ResetController::class, 'create'])->name('login.forgot-password');
    Route::post('/forgot-password', [ResetController::class, 'sendEmail'])->name('forgot-password-email');
    Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
    Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

    // Google register
    Route::get('fasease/auth/google', [GoogleAuthController::class, 'redirectToGoogleSuperadmin'])
        ->name('superadmin.google.login');
    Route::get('fasease/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallbackSuperadmin']);
});

/*
|--------------------------------------------------------------------------
| AUTHENTICATED AREA (GLOBAL)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Route::get('/', [HomeController::class, 'home']);
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::get('/logout', [SessionsController::class, 'destroy'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| SUPERADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('superadmin.dashboard');
    Route::get('fasease/user-profile', [InfoUserController::class, 'create'])->name('superadmin.user-profile-index');
    Route::post('fasease/user-profile', [InfoUserController::class, 'store'])->name('superadmin.user-profile-store');

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

    Route::get('organization/login/{token}', [SessionsController::class, 'tenantLinkLogin'])
        ->name('organization.login.link');

    Route::post('organization/login', [SessionsController::class, 'tenantLogin'])
        ->name('organization.login.submit');

    Route::get('organization/register/{token}', [RegisterController::class, 'create_organization'])->name('organization.register-index');
    Route::post('organization/register', [RegisterController::class, 'store_organization'])->name('organization.register-store');

    Route::get('organization/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallbackTenant'])
        ->name('organization.google.callback');
    Route::get('organization/auth/google/{token}', [GoogleAuthController::class, 'redirectToGoogleTenant'])
        ->name('organization.google.login');
});

/*
|--------------------------------------------------------------------------
| TENANT AREA (ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'tenant'])->group(function () {

    Route::get('/organization/user-profile', [InfoUserController::class, 'create'])->name('org.user-profile-index');
    Route::post('organization/user-profile', [InfoUserController::class, 'store'])->name('org.user-profile-store');

    Route::middleware(['admin'])->group(function () {

        Route::get('/organization/dashboard', [HomeController::class, 'home_tenant'])
        ->name('org.dashboard-admin');

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

    Route::middleware(['user'])->group(function () {
        Route::get('/organization/user/dashboard', [HomeController::class, 'home_tenant_user'])
        ->name('org.dashboard-user');

        Route::get('/organization/user/user-profile', [InfoUserController::class, 'create'])->name('org.user-user-profile-index');
        Route::post('organization/user/user-profile', [InfoUserController::class, 'store'])->name('org.user-user-profile-store');
        Route::get('/organization/user/booking-history', [UserBookingController::class, 'show_booking_history'])->name('org.user-booking-history');
        Route::get('/organization/user/my-bookings', [UserBookingController::class, 'show_user_current_booking'])->name('org.user-current-booking');
        
        // Item
        Route::get('/organization/user/{slug}/item', [UserItemController::class, 'index'])->name('org.user-item-index');

        // Booking
        Route::post('//organization/user/booking/store', [UserBookingController::class, 'store'])->name('org.user-booking-store');
        Route::get('/organization/user/booking/check-availability', [UserBookingController::class, 'checkAvailability'])->name('org.user-booking-check');
        Route::post('/organization/user/booking/{id}/cancel', [UserBookingController::class, 'cancel']);
    });
    
});
