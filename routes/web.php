<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderHistoryController;

Route::get('/', function () {
    return view('welcome');
});

// Service pages
Route::get('/thue-unlocktool', [ServiceController::class, 'unlocktool'])->name('service.unlocktool');
Route::get('/thue-vietmap', [ServiceController::class, 'vietmap'])->name('service.vietmap');
Route::get('/thue-griffin', [ServiceController::class, 'griffin'])->name('service.griffin');
Route::get('/thue-amt', [ServiceController::class, 'amt'])->name('service.amt');
Route::get('/thue-tsm', [ServiceController::class, 'tsm'])->name('service.tsm');
Route::get('/thue-dft', [ServiceController::class, 'dft'])->name('service.dft');
Route::get('/thue-kg-killer', [ServiceController::class, 'kgKiller'])->name('service.kg-killer');
Route::get('/thue-samsung-tool', [ServiceController::class, 'samsungTool'])->name('service.samsung-tool');

// Other pages
Route::get('/ma-giam-gia', [CouponController::class, 'index'])->name('coupons');
Route::get('/blog', function () {
    return view('pages.blog');
})->name('blog');
Route::get('/order-history-ip', [OrderHistoryController::class, 'index'])->name('order-history');

// Auth pages
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

