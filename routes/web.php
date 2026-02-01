<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/plan/{plan}', [HomeController::class, 'showPlan'])->name('plan.show');

// Auth routes
// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// User protected routes
Route::middleware('auth')->group(function () {
    Route::get('/history', [HomeController::class, 'history'])->name('history');
    Route::get('/order/{order}', [HomeController::class, 'showOrder'])->name('order.show');
    Route::get('/plan/{plan}/checkout', [HomeController::class, 'showCheckout'])->name('plan.checkout');
    Route::post('/plan/{plan}/purchase', [HomeController::class, 'initiatePurchase'])->name('plan.purchase');
    Route::get('/order/{order}/waiting', [HomeController::class, 'waitingPayment'])->name('order.waiting');
    Route::get('/order/{order}/status', [HomeController::class, 'checkPaymentStatus'])->name('order.status');
    Route::get('/order/{order}/success', [HomeController::class, 'orderSuccess'])->name('order.success');
});

// Admin routes
Route::prefix('admin')->middleware(AdminMiddleware::class)->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Settings
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::post('/settings', [DashboardController::class, 'updateSettings'])->name('settings.update');

    // Users
    Route::get('/users', [DashboardController::class, 'users'])->name('users');
    Route::post('/users/{user}/toggle', [DashboardController::class, 'toggleUser'])->name('users.toggle');

    // Sales
    Route::get('/sales', [DashboardController::class, 'sales'])->name('sales');

    // Plans
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');
    Route::get('/plans/{plan}/edit', [PlanController::class, 'edit'])->name('plans.edit');
    Route::put('/plans/{plan}', [PlanController::class, 'update'])->name('plans.update');
    Route::delete('/plans/{plan}', [PlanController::class, 'destroy'])->name('plans.destroy');
    Route::post('/plans/{plan}/toggle', [PlanController::class, 'toggle'])->name('plans.toggle');

    // Configs
    Route::get('/configs', [ConfigController::class, 'index'])->name('configs.index');
    Route::get('/configs/create', [ConfigController::class, 'create'])->name('configs.create');
    Route::post('/configs', [ConfigController::class, 'store'])->name('configs.store');
    Route::post('/configs/bulk', [ConfigController::class, 'bulkStore'])->name('configs.bulk');
    Route::get('/configs/{config}/edit', [ConfigController::class, 'edit'])->name('configs.edit');
    Route::put('/configs/{config}', [ConfigController::class, 'update'])->name('configs.update');
    Route::delete('/configs/{config}', [ConfigController::class, 'destroy'])->name('configs.destroy');
    Route::delete('/configs-all', [ConfigController::class, 'destroyAll'])->name('configs.destroyAll');
});
