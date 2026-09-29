<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PriceController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AccountController;
use Illuminate\Support\Facades\Route;

// Public user routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/estimate', [HomeController::class, 'priceEstimate'])->name('order.estimate');
Route::post('/count-pdf', [HomeController::class, 'countPdfPages'])->name('order.count-pdf');
Route::post('/order', [HomeController::class, 'storeOrder'])->name('order.store');
Route::get('/order/success/{code}', [HomeController::class, 'orderSuccess'])->name('order.success');
Route::get('/lacak', [HomeController::class, 'trackForm'])->name('order.track');
Route::post('/lacak', [HomeController::class, 'trackFind'])->name('order.track.find');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('logout',[AuthController::class, 'logout'])->name('logout')->middleware('auth');

    Route::middleware('auth')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('prices', [PriceController::class, 'index'])->name('prices');
        Route::post('prices', [PriceController::class, 'update'])->name('prices.update');

        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
        Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
        Route::get('orders/{order}/download', [AdminOrderController::class, 'download'])->name('orders.download');

        Route::get('expenses', [ExpenseController::class, 'index'])->name('expenses.index');
        Route::post('expenses', [ExpenseController::class, 'store'])->name('expenses.store');
        Route::delete('expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

        Route::get('reports', [ReportController::class, 'index'])->name('reports');

        Route::get('account', [AccountController::class, 'edit'])->name('account');
        Route::post('account', [AccountController::class, 'update'])->name('account.update');
    });
});
