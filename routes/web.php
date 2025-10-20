<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QuotaController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\ManagerController;

// temporary route for welcome page
Route::get('/', function () {
    return view('index');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::middleware('role:Admin')->get('/dashboard/admin', [DashboardController::class, 'showAdminDashboard'])->name('dashboard.admin');
    Route::middleware('role:Sales Manager')->get('/dashboard/manager', [DashboardController::class, 'showManagerDashboard'])->name('dashboard.manager');
    Route::middleware('role:Agent')->get('/dashboard/agent', [DashboardController::class, 'showAgentDashboard'])->name('dashboard.agent');
    Route::middleware('role:Client')->get('/dashboard/client', [DashboardController::class, 'showClientDashboard'])->name('dashboard.client');

    Route::middleware('role:Admin,Sales Manager')->group(function () {
        Route::resource('properties', PropertyController::class)->except(['show']);
    });

    Route::middleware('role:Admin,Sales Manager')->group(function () {
        Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
        Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
        Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
        Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
        Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');
    });

    Route::middleware(['auth', 'role:Admin,Sales Manager'])->group(function () {
        Route::resource('agents', AgentController::class);
    });

    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

    Route::middleware('role:Agent,Client,Sales Manager,Admin')->group(function () {
        Route::resource('transactions', TransactionController::class)->except(['edit', 'update', 'destroy']);
        Route::post('/transactions/{transaction}/approve', [TransactionController::class, 'approve'])->name('transactions.approve');
        Route::post('/transactions/{transaction}/cancel', [TransactionController::class, 'cancel'])->name('transactions.cancel');
    });

    Route::middleware('role:Agent,Sales Manager')->group(function () {
        Route::resource('payments', PaymentController::class)->except(['show']);
    });

    Route::middleware('role:Sales Manager,Admin')->group(function () {
        Route::resource('commissions', CommissionController::class);
        Route::post('/commissions/{commission}/approve', [CommissionController::class, 'approve'])->name('commissions.approve');
        Route::post('/commissions/{commission}/reject', [CommissionController::class, 'reject'])->name('commissions.reject');
    });

    Route::middleware('role:Admin')->resource('developers', DeveloperController::class);

    Route::middleware('role:Admin,Sales Manager')->group(function () {
        Route::resource('clients', ClientController::class)->except(['destroy']);
        Route::resource('agents', AgentController::class)->except(['destroy']);
    });

    Route::middleware('role:Admin,Sales Manager')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
    });

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');

    // profile viewing
    Route::get('/profiles/client', [ClientController::class, 'profile'])->name('profiles.client');
    Route::post('/client/profile/update', [ClientController::class, 'updateProfile'])->name('client.update');

    Route::get('/agent/profile', [AgentController::class, 'profile'])->name('profiles.agent');
    Route::post('/agent/profile/update', [AgentController::class, 'updateProfile'])->name('agent.update');

    Route::get('/manager/profile', [ManagerController::class, 'profile'])->name('profiles.manager');
    Route::post('/manager/profile/update', [ManagerController::class, 'updateProfile'])->name('manager.update');

    Route::middleware('role:Sales Manager,Admin')->resource('quotas', QuotaController::class);

    Route::middleware('role:Sales Manager,Admin')->resource('teams', TeamController::class);

    Route::middleware('role:Admin')->get('/audits', [AuditController::class, 'index'])->name('audits.index');
});