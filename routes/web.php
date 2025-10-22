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
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Dynamic Dashboard
    Route::get('/dashboard', function () {
        $role = strtolower(Auth::user()->role->role_name ?? '');

        return match ($role) {
            'client' => redirect()->route('dashboard.client'),
            'agent' => redirect()->route('dashboard.agent'),
            'sales manager' => redirect()->route('dashboard.manager'),
            'admin' => redirect()->route('dashboard.admin'),
            default => abort(403, 'Unauthorized role.'),
        };
    })->name('dashboard');

    // Dynamic Profile
    Route::get('/profile', function () {
        $user = Auth::user();
        $role = strtolower($user->role->role_name ?? '');

        return match ($role) {
            'client' => app(ClientController::class)->profile(),
            'agent' => app(AgentController::class)->profile(),
            'sales manager' => app(ManagerController::class)->profile(),
            default => abort(403, 'Unauthorized role.'),
        };
    })->name('profile');

    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'show'])->middleware('auth')->name('dashboard');    

    // Property Routes
    Route::middleware('role:Admin,Sales Manager')->group(function () {
        Route::resource('properties', PropertyController::class)->except(['show']);
        Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
        Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
        Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
        Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
        Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');
    });

    Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

    // Agent Routes
    Route::middleware(['auth', 'role:Admin,Sales Manager'])->group(function () {
        Route::resource('agents', AgentController::class);
    });

    // Transaction Routes
    Route::middleware('role:Agent,Client,Sales Manager,Admin')->group(function () {
        Route::resource('transactions', TransactionController::class)->except(['edit', 'update', 'destroy']);
        Route::post('/transactions/{transaction}/approve', [TransactionController::class, 'approve'])->name('transactions.approve');
        Route::post('/transactions/{transaction}/cancel', [TransactionController::class, 'cancel'])->name('transactions.cancel');
    });

    // Payment Routes
    Route::middleware('role:Agent,Sales Manager')->group(function () {
        Route::resource('payments', PaymentController::class)->except(['show']);
    });

    // Commission Routes
    Route::middleware('role:Sales Manager,Admin')->group(function () {
        Route::resource('commissions', CommissionController::class);
        Route::post('/commissions/{commission}/approve', [CommissionController::class, 'approve'])->name('commissions.approve');
        Route::post('/commissions/{commission}/reject', [CommissionController::class, 'reject'])->name('commissions.reject');
    });

    // Developer Routes
    Route::middleware('role:Admin')->resource('developers', DeveloperController::class);

    // Client Routes
    Route::middleware('role:Admin,Sales Manager')->group(function () {
        Route::resource('clients', ClientController::class)->except(['destroy']);
        Route::resource('agents', AgentController::class)->except(['destroy']);
    });

    // Report Routes
    Route::middleware('role:Admin,Sales Manager')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::post('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
    });

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');

    // Profile Routes
    Route::post('/client/profile/update', [ClientController::class, 'updateProfile'])->name('client.update');
    Route::post('/agent/profile/update', [AgentController::class, 'updateProfile'])->name('agent.update');
    Route::post('/manager/profile/update', [ManagerController::class, 'updateProfile'])->name('manager.update');

    // Quota & Team Routes
    Route::middleware('role:Sales Manager,Admin')->resource('quotas', QuotaController::class);
    Route::middleware('role:Sales Manager,Admin')->resource('teams', TeamController::class);

    // Audit Routes
    Route::middleware('role:Admin')->get('/audits', [AuditController::class, 'index'])->name('audits.index');
});
