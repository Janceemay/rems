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

Route::get('/','AuthController@showLogin')->name('login');
Route::get('/login','AuthController@showLogin')->name('login');
Route::post('/login','AuthController@login')->name('login.post');
Route::get('/register','AuthController@showRegister')->name('register');
Route::post('/register','AuthController@register')->name('register.post');
Route::post('/logout','AuthController@logout')->name('logout');

Route::middleware(['auth'])->group(function(){

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

    // Properties
    Route::get('/properties',[PropertyController::class,'index'])->name('properties.index');
    Route::get('/properties/create',[PropertyController::class,'create'])->name('properties.create');
    Route::post('/properties',[PropertyController::class,'store'])->name('properties.store');
    Route::get('/properties/{property}',[PropertyController::class,'show'])->name('properties.show');

    // Transactions
    Route::get('/transactions',[TransactionController::class,'index'])->name('transactions.index');
    Route::get('/transactions/create',[TransactionController::class,'create'])->name('transactions.create');
    Route::post('/transactions',[TransactionController::class,'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}',[TransactionController::class,'show'])->name('transactions.show');
    Route::post('/transactions/{transaction}/approve',[TransactionController::class,'approve'])->name('transactions.approve');
    Route::post('/transactions/{transaction}/cancel',[TransactionController::class,'cancel'])->name('transactions.cancel');

    // Payments
    Route::get('/payments',[PaymentController::class,'index'])->name('payments.index');
    Route::post('/payments',[PaymentController::class,'store'])->name('payments.store');

    // Commissions
    Route::get('/commissions',[CommissionController::class,'index'])->name('commissions.index');
    Route::post('/commissions/{commission}/approve',[CommissionController::class,'approve'])->name('commissions.approve');

    // Developers
    Route::resource('developers', DeveloperController::class);

    // Clients and Agents
    Route::get('/clients',[ClientController::class,'index'])->name('clients.index');
    Route::get('/clients/{client}',[ClientController::class,'show'])->name('clients.show');

    Route::get('/agents',[AgentController::class,'index'])->name('agents.index');

    // Reports
    Route::get('/reports',[ReportController::class,'index'])->name('reports.index');
    Route::post('/reports/generate',[ReportController::class,'generate'])->name('reports.generate');

    // Notifications
    Route::get('/notifications',[NotificationController::class,'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read',[NotificationController::class,'markRead'])->name('notifications.read');

});
