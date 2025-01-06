<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CustomerHomeController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimeController;

Route::get('/api/current-time', [TimeController::class, 'currentTime']);

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Password Reset
Route::get('/password/reset', [AuthController::class, 'showResetRequest'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'resetPassword']);
Route::post('/password/generate', [AuthController::class, 'generateResetLink'])->name('password.generate');
Route::post('/password/update', [AuthController::class, 'updatePassword'])->name('password.update');

// Home Routes
// Route::get('/home-admin', [HomeController::class, 'homeAdmin'])->name('home.admin')->middleware('admin');
// Route::get('/home-customer', [HomeController::class, 'homeCustomer'])->name('home.customer')->middleware('authenticated');
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/update-ajax', [ProfileController::class, 'updateAjax'])->name('profile.update.ajax');
// Admin Home
Route::get('/home-admin', [HomeController::class, 'homeAdmin'])->name('home.admin');
Route::get('/admin/users', [ProfileController::class, 'showAdmin'])->name('admin.users.show');
Route::get('/admin/users/{id}/edit', [ProfileController::class, 'editUser'])->name('admin.users.edit');
Route::put('/admin/users/{id}', [ProfileController::class, 'updateUser'])->name('admin.users.update');
Route::delete('/admin/users/{id}', [ProfileController::class, 'deleteUser'])->name('admin.users.delete');
// Route::get('/profile', [ProfileController::class, 'show'])->name('profile.admin-show');
// Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.delete');

// Transaction History
Route::get('/transactions/admin-history', [TransactionController::class, 'index'])->name('transactions.admin-history');
Route::post('/transactions/cancel', [TransactionController::class, 'cancel'])
    ->name('transactions.cancel');
Route::get('/transactions/admin-get', [TransactionController::class, 'getAdminTransactions'])->name('transactions.admin-get');

//Customer
Route::get('/home-customer', [CustomerHomeController::class, 'index'])->name('home.customer');
Route::get('/topup', [TopUpController::class, 'showForm'])->name('topup');
Route::post('/topup/process', [TopUpController::class, 'process'])->name('topup.process');
Route::get('/transactions/history', [TransactionController::class, 'history'])->name('transactions.history');
Route::post('/transactions/confirm', [TransactionController::class, 'confirm'])->name('transactions.confirm');
Route::get('/transactions/get', [TransactionController::class, 'getTransactions'])->name('transactions.get');


