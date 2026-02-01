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
    Route::get('/login', App\Livewire\Auth\Login::class)->name('login');
    Route::get('/register', App\Livewire\Auth\Register::class)->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// User protected routes
Route::middleware('auth')->group(function () {
    Route::get('/history', App\Livewire\User\History::class)->name('history');
    Route::get('/order/{order}', [HomeController::class, 'showOrder'])->name('order.show');
    Route::get('/plan/{plan}/checkout', [HomeController::class, 'showCheckout'])->name('plan.checkout');
    Route::post('/plan/{plan}/purchase', [HomeController::class, 'initiatePurchase'])->name('plan.purchase');
    Route::get('/order/{order}/waiting', [HomeController::class, 'waitingPayment'])->name('order.waiting');
    Route::get('/order/{order}/status', [HomeController::class, 'checkPaymentStatus'])->name('order.status');
    Route::get('/order/{order}/success', [HomeController::class, 'orderSuccess'])->name('order.success');
});

// Admin routes
Route::prefix('admin')->middleware(AdminMiddleware::class)->name('admin.')->group(function () {
    Route::get('/', App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('/settings', App\Livewire\Admin\Settings::class)->name('settings');
    // Route::post('/settings', [DashboardController::class, 'updateSettings'])->name('settings.update'); // Handled in Livewire now
    Route::get('/users', App\Livewire\Admin\Users\Index::class)->name('users');
    // Route::post('/users/{user}/toggle', [DashboardController::class, 'toggleUser'])->name('users.toggle'); // Handled in Livewire
    Route::get('/sales', App\Livewire\Admin\Sales\Index::class)->name('sales');

    // Plans
    Route::get('/plans', App\Livewire\Admin\Plans\Index::class)->name('plans.index');
    Route::get('/plans/create', App\Livewire\Admin\Plans\Create::class)->name('plans.create');
    Route::get('/plans/{plan}/edit', App\Livewire\Admin\Plans\Edit::class)->name('plans.edit');
    // Route::post('/plans/{plan}/toggle', [PlanController::class, 'toggle'])->name('plans.toggle'); // Handled in Livewire now

    // Configs
    Route::get('/configs', App\Livewire\Admin\Configs\Index::class)->name('configs.index');
    Route::get('/configs/create', App\Livewire\Admin\Configs\Create::class)->name('configs.create');
    Route::get('/configs/{config}/edit', App\Livewire\Admin\Configs\Edit::class)->name('configs.edit');
    // Route::post('/configs', [ConfigController::class, 'store'])->name('configs.store'); // Handled in Livewire
    // Route::post('/configs/bulk', [ConfigController::class, 'bulkStore'])->name('configs.bulk'); // Handled in Livewire
    // Route::put('/configs/{config}', [ConfigController::class, 'update'])->name('configs.update'); // Handled in Livewire
    // Route::delete('/configs/{config}', [ConfigController::class, 'destroy'])->name('configs.destroy'); // Handled in Livewire
    // Route::delete('/configs-all', [ConfigController::class, 'destroyAll'])->name('configs.destroyAll'); // Handled in Livewire
});

// TEMPORARY: Fix Plans Data & Debug View
Route::get('/fix-plans', function () {
    $plans = \App\Models\Plan::all();
    $results = [];
    foreach ($plans as $plan) {
        $plan->is_active = true; // FORCE ENABLE
        $plan->save();
        $results[] = "Fixed: {$plan->name} (Active: 1) -> Group: {$plan->group_key}";
    }

    // Debug View
    $viewStatus = "✅ View 'livewire.plan-list' found.";
    try {
        if (!view()->exists('livewire.plan-list')) {
            $viewStatus = "❌ CRITICAL: View 'resources/views/livewire/plan-list.blade.php' NOT FOUND on server.";
        } else {
            // Try to make sure it has no syntax errors
            view('livewire.plan-list', ['plans' => $plans, 'activeTab' => 'week_1'])->render();
        }
    } catch (\Exception $e) {
        $viewStatus = "❌ View Error: " . $e->getMessage();
    }

    return '<h1>Diagnostics Check</h1>' .
        '<h3>View Status:</h3>' . $viewStatus .
        '<h3>Plans Fixed:</h3><pre>' . implode("\n", $results) . '</pre><br><a href="/">Go Home</a>';
});
