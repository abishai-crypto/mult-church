<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PastoralCareController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasswordSecurityController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

// Public Website / Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/submit-prayer', [HomeController::class, 'submitPrayer'])->name('home.prayer');
Route::post('/give-online', [HomeController::class, 'giveOnline'])->name('home.giveOnline');

// Real Authentication (No Demo Simulation)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetRequest'])->name('password.email');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard & Profile
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Super Admin Routes
    Route::prefix('superadmin')->name('superadmin.')->middleware(['role:super_admin'])->group(function () {
        Route::get('/churches', [SuperAdminController::class, 'index'])->name('churches.index');
        Route::get('/churches/create', [SuperAdminController::class, 'create'])->name('churches.create');
        Route::post('/churches', [SuperAdminController::class, 'store'])->name('churches.store');
        Route::get('/churches/{church}/edit', [SuperAdminController::class, 'edit'])->name('churches.edit');
        Route::put('/churches/{church}', [SuperAdminController::class, 'update'])->name('churches.update');
        Route::post('/churches/{church}/toggle', [SuperAdminController::class, 'toggleStatus'])->name('churches.toggle');
        Route::get('/switch/{church}', [SuperAdminController::class, 'switchTenant'])->name('switch');
        Route::get('/clear-tenant', [SuperAdminController::class, 'clearTenant'])->name('clearTenant');
    });

    // Members Management & Exports
    Route::get('/members/export/csv', [MemberController::class, 'exportCsv'])->name('members.export.csv');
    Route::get('/members/directory/print', [MemberController::class, 'printDirectory'])->name('members.directory.print');
    Route::resource('members', MemberController::class);

    // Attendance & Services & Exports
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('index');
        Route::get('/export/csv', [AttendanceController::class, 'exportCsv'])->name('export.csv');
        Route::get('/summary/print', [AttendanceController::class, 'printSummary'])->name('summary.print');
        Route::get('/create', [AttendanceController::class, 'create'])->name('create');
        Route::post('/', [AttendanceController::class, 'store'])->name('store');
        Route::get('/services', [AttendanceController::class, 'services'])->name('services');
        Route::post('/services', [AttendanceController::class, 'storeService'])->name('services.store');
    });

    // Church Finances, Tithes/Offerings Dual-Control & Exports
    Route::prefix('finances')->name('finances.')->group(function () {
        Route::get('/', [FinanceController::class, 'index'])->name('index');
        Route::get('/export/csv', [FinanceController::class, 'exportCsv'])->name('export.csv');
        Route::get('/statement/print', [FinanceController::class, 'printStatement'])->name('statement.print');
        Route::get('/create', [FinanceController::class, 'create'])->name('create');
        Route::post('/', [FinanceController::class, 'store'])->name('store');
        Route::post('/{transaction}/confirm', [FinanceController::class, 'confirm'])->name('confirm');
        Route::post('/{transaction}/reverse', [FinanceController::class, 'reverse'])->name('reverse');

        // Expenses
        Route::get('/expenses', [FinanceController::class, 'expenses'])->name('expenses');
        Route::get('/expenses/create', [FinanceController::class, 'createExpense'])->name('expenses.create');
        Route::post('/expenses', [FinanceController::class, 'storeExpense'])->name('expenses.store');
        Route::post('/expenses/{expense}/approve', [FinanceController::class, 'approveExpense'])->name('expenses.approve');
    });

    // SMS Communication Console
    Route::prefix('sms')->name('sms.')->group(function () {
        Route::get('/', [\App\Http\Controllers\SmsController::class, 'index'])->name('index');
        Route::post('/send', [\App\Http\Controllers\SmsController::class, 'send'])->name('send');
    });

    // Departments Management
    Route::prefix('departments')->name('departments.')->group(function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('index');
        Route::get('/create', [DepartmentController::class, 'create'])->name('create');
        Route::post('/', [DepartmentController::class, 'store'])->name('store');
        Route::get('/{department}', [DepartmentController::class, 'show'])->name('show');
        Route::post('/{department}/members', [DepartmentController::class, 'addMember'])->name('addMember');
        Route::delete('/{department}/members/{member}', [DepartmentController::class, 'removeMember'])->name('removeMember');
        Route::post('/{department}/finances', [DepartmentController::class, 'storeFinance'])->name('storeFinance');
    });

    // Pastoral Care & Prayer Requests
    Route::prefix('pastoral-care')->name('pastoral.')->group(function () {
        Route::get('/', [PastoralCareController::class, 'index'])->name('index');
        Route::post('/visits', [PastoralCareController::class, 'storeVisit'])->name('visits.store');
        Route::post('/prayer-requests', [PastoralCareController::class, 'storePrayer'])->name('prayers.store');
        Route::post('/prayer-requests/{prayerRequest}/status', [PastoralCareController::class, 'updatePrayerStatus'])->name('prayers.updateStatus');
    });

    // Document Library
    Route::prefix('documents')->name('documents.')->group(function () {
        Route::get('/', [DocumentController::class, 'index'])->name('index');
        Route::post('/', [DocumentController::class, 'store'])->name('store');
        Route::get('/{document}/download', [DocumentController::class, 'download'])->name('download');
    });

    // YouTube Media & Live Streams
    Route::prefix('media')->name('media.')->group(function () {
        Route::get('/', [MediaController::class, 'index'])->name('index');
        Route::post('/', [MediaController::class, 'store'])->name('store');
        Route::post('/{video}/toggle-live', [MediaController::class, 'toggleLive'])->name('toggleLive');
    });

    // Projects & Assets
    Route::prefix('projects')->name('projects.')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('index');
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        Route::get('/assets', [ProjectController::class, 'assets'])->name('assets');
        Route::post('/assets', [ProjectController::class, 'storeAsset'])->name('assets.store');
    });

    // Announcements & Events
    Route::prefix('announcements')->name('announcements.')->group(function () {
        Route::get('/', [AnnouncementController::class, 'index'])->name('index');
        Route::post('/', [AnnouncementController::class, 'store'])->name('store');
        Route::post('/events', [AnnouncementController::class, 'storeEvent'])->name('events.store');
    });

    // System Audit Trail
    Route::get('/audit-logs', [AuditController::class, 'index'])->name('audit.index');

    // Ecclesiastical Password Security & Oversight Console (Pastor, Elders, Admin)
    Route::prefix('security')->name('security.')->group(function () {
        Route::get('/passwords', [PasswordSecurityController::class, 'index'])->name('passwords.index');
        Route::post('/passwords/reset/{user}', [PasswordSecurityController::class, 'resetUserPassword'])->name('passwords.reset');
        Route::post('/passwords/approve/{resetRequest}', [PasswordSecurityController::class, 'approveRequest'])->name('passwords.approve');
        Route::post('/passwords/reject/{resetRequest}', [PasswordSecurityController::class, 'rejectRequest'])->name('passwords.reject');
    });
});
