<?php

use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\ConversionController;
use App\Http\Controllers\FeatureRequestController;
use App\Http\Controllers\ReportBugController;
use App\Http\Controllers\SuperAdmin\AuditLogController;
use App\Http\Controllers\SuperAdmin\AuthController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use App\Http\Controllers\SuperAdmin\FeatureRequestController as AdminFeatureRequestController;
use App\Http\Controllers\SuperAdmin\ReportBugController as AdminReportBugController;
use App\Http\Controllers\SuperAdmin\RoleController;
use App\Http\Controllers\SuperAdmin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('conversion')->group(function () {
    Route::get('/', [ConversionController::class, 'index'])->name('conversion.index');
    $categories = config('conversion.categories', []);

    foreach ($categories as $category) {
        $categorySlug = $category['slug'] ?? null;
        $tools = $category['tools'] ?? [];

        if (! is_string($categorySlug) || $categorySlug === '' || ! is_array($tools)) {
            continue;
        }

        foreach ($tools as $tool) {
            $toolSlug = $tool['slug'] ?? null;
            $routeName = $tool['route_name'] ?? null;
            $toolKey = $tool['key'] ?? null;

            if (! is_string($toolSlug) || $toolSlug === '' || ! is_string($routeName) || $routeName === '' || ! is_string($toolKey) || $toolKey === '') {
                continue;
            }

            Route::get("/{$categorySlug}/{$toolSlug}", [ConversionController::class, 'show'])
                ->defaults('calculator', $toolKey)
                ->name($routeName);
        }
    }
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/report-a-bug', [ReportBugController::class, 'create'])->name('report-bug.create');
Route::post('/report-a-bug', [ReportBugController::class, 'store'])->name('report-bug.store');
Route::get('/request-a-feature', [FeatureRequestController::class, 'create'])->name('feature-request.create');
Route::post('/request-a-feature', [FeatureRequestController::class, 'store'])->name('feature-request.store');
Route::get('/contact', [ContactMessageController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactMessageController::class, 'store'])->name('contact.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/email/verify', [AuthController::class, 'verificationNotice'])->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])
            ->middleware('signed')
            ->name('email.verify');
        Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])
            ->middleware('throttle:6,1')
            ->name('verification.send');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::middleware('admin.access')->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::patch('/users/{user}/status', [UserController::class, 'updateStatus'])->name('users.status.update');
        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
        Route::get('/audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('audit-logs.show');
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::get('/profile', [App\Http\Controllers\SuperAdmin\ProfileController::class, 'show'])->name('profile.show');
        Route::put('/profile', [App\Http\Controllers\SuperAdmin\ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [App\Http\Controllers\SuperAdmin\ProfileController::class, 'updatePassword'])->name('profile.password.update');
        Route::delete('/profile', [App\Http\Controllers\SuperAdmin\ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::get('/feature-requests', [AdminFeatureRequestController::class, 'index'])->name('feature-requests.index');
        Route::put('/feature-requests/{featureRequest}', [AdminFeatureRequestController::class, 'update'])->name('feature-requests.update');
        Route::get('/contact-messages', [App\Http\Controllers\SuperAdmin\ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::put('/contact-messages/{contactMessage}', [App\Http\Controllers\SuperAdmin\ContactMessageController::class, 'update'])->name('contact-messages.update');
        Route::get('/bug-reports', [AdminReportBugController::class, 'index'])->name('bug-reports.index');
        Route::put('/bug-reports/{reportBug}', [AdminReportBugController::class, 'update'])->name('bug-reports.update');
    });
});

Route::get('/email/verify', fn () => redirect()->route('admin.verification.notice'))
    ->middleware('auth')
    ->name('verification.notice');
Route::get('/admin/email/verify/{id}/{hash}', [AuthController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');
