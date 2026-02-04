<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrdServicesController;


use App\Http\Controllers\BlogController;
use App\Http\Controllers\SitemapController;

// Sitemap Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap-pages.xml', [SitemapController::class, 'pages'])->name('sitemap.pages');
Route::get('/sitemap-services.xml', [SitemapController::class, 'services'])->name('sitemap.services');
Route::get('/sitemap-posts.xml', [SitemapController::class, 'posts'])->name('sitemap.posts');

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

// Ord-services (API GSM Services)
Route::get('/ord-services', [OrdServicesController::class, 'index'])->name('ord-services');

// Blog routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/category/{category}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Other pages
Route::get('/ma-giam-gia', [CouponController::class, 'index'])->name('coupons');
Route::get('/order-history-ip', [OrderHistoryController::class, 'index'])->name('order-history');
Route::get('/order-detail', [OrderHistoryController::class, 'orderDetail'])->name('order-detail');
Route::get('/terms', function () {
    return view('terms');
})->name('terms');
Route::get('/dieu-khoan', function () {
    return view('terms');
})->name('terms.vi');

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Checkout routes
Route::get('/thanh-toan', [CheckoutController::class, 'show'])->name('checkout');
Route::post('/thanh-toan', [CheckoutController::class, 'createOrder'])->name('checkout.create');
Route::get('/order-success', [CheckoutController::class, 'orderSuccess'])->name('order.success');
Route::get('/api/check-payment', [CheckoutController::class, 'checkPayment'])->name('api.check-payment');
Route::post('/api/cancel-order', [CheckoutController::class, 'cancelOrder'])->name('api.cancel-order');
Route::post('/api/pay-with-balance', [CheckoutController::class, 'payWithBalance'])->name('api.pay-with-balance');

// Coupon API routes
Route::get('/api/coupons/active', [CouponController::class, 'getActiveCoupons'])->name('api.coupons.active');
Route::get('/api/coupons/validate', [CouponController::class, 'validateCoupon'])->name('api.coupons.validate');

// Order History (authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/order-history', [OrderHistoryController::class, 'userOrders'])->name('order.history');
});

// Admin Panel Routes
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;

// Admin Auth (no middleware)
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Protected Routes (only 'admin' middleware, not 'auth')
Route::prefix('admin')->middleware('admin')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::post('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');
    
    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    
    // Coupons
    Route::get('/coupons', [AdminController::class, 'coupons'])->name('admin.coupons');
    Route::post('/coupons/{id?}', [AdminController::class, 'saveCoupon'])->name('admin.coupons.save');
    Route::post('/coupons/{id}/toggle', [AdminController::class, 'toggleCoupon'])->name('admin.coupons.toggle');
    
    // Accounts (Tài khoản cho thuê)
    Route::get('/accounts', [AdminController::class, 'accounts'])->name('admin.accounts');
    Route::get('/accounts/{id}/edit', [AdminController::class, 'editAccount'])->name('admin.accounts.edit');
    Route::post('/accounts', [AdminController::class, 'addAccount'])->name('admin.accounts.add');
    Route::post('/accounts/{id}/toggle', [AdminController::class, 'toggleAccount'])->name('admin.accounts.toggle');
    Route::post('/accounts/{id}', [AdminController::class, 'updateAccount'])->name('admin.accounts.update');
    Route::post('/accounts/{id}/change-pass', [AdminController::class, 'changeAccountPassword'])->name('admin.accounts.change-pass');
    Route::post('/accounts/{id}/reset-tg', [AdminController::class, 'resetAccountTG'])->name('admin.accounts.reset-tg');
    Route::delete('/accounts/{id}', [AdminController::class, 'deleteAccount'])->name('admin.accounts.delete');
    
    // Prices (Gói thuê)
    Route::get('/prices', [AdminController::class, 'prices'])->name('admin.prices');
    Route::post('/prices/{id?}', [AdminController::class, 'savePrice'])->name('admin.prices.save');
    Route::delete('/prices/{id}', [AdminController::class, 'deletePrice'])->name('admin.prices.delete');
    
    // Blog
    Route::get('/blog', [AdminController::class, 'blog'])->name('admin.blog');
    Route::get('/blog/create', [AdminController::class, 'blogEdit'])->name('admin.blog.create');
    Route::get('/blog/{id}/edit', [AdminController::class, 'blogEdit'])->name('admin.blog.edit');
    Route::post('/blog/{id?}', [AdminController::class, 'blogSave'])->name('admin.blog.save');
    Route::delete('/blog/{id}', [AdminController::class, 'blogDelete'])->name('admin.blog.delete');
    Route::post('/blog/{id}/toggle', [AdminController::class, 'blogToggle'])->name('admin.blog.toggle');
    
    // ADY Products
    Route::get('/ady-products', [AdminController::class, 'adyProducts'])->name('admin.ady.products');
    
    // ADY Orders
    Route::get('/ady-orders', [AdminController::class, 'adyOrders'])->name('admin.ady.orders');
    
    // ADY Config
    Route::get('/ady-config', [AdminController::class, 'adyConfig'])->name('admin.ady.config');
    Route::post('/ady-config', [AdminController::class, 'saveAdyConfig'])->name('admin.ady.config.save');
    
    // Underpaid Orders (Thiếu tiền)
    Route::get('/underpaid', [AdminController::class, 'underpaidOrders'])->name('admin.underpaid');
    
    // Revenue Reports
    Route::get('/reports', [AdminController::class, 'revenueReports'])->name('admin.reports');
    
    // System Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [AdminController::class, 'saveSettings'])->name('admin.settings.save');
    
    // Activity Logs
    Route::get('/logs', [AdminController::class, 'activityLogs'])->name('admin.logs');
    
    // System Info
    Route::get('/system', [AdminController::class, 'systemInfo'])->name('admin.system');
    Route::post('/system/clear-cache', [AdminController::class, 'clearCache'])->name('admin.system.clear-cache');
    Route::post('/system/clear-views', [AdminController::class, 'clearViews'])->name('admin.system.clear-views');
    Route::get('/system/phpinfo', [AdminController::class, 'phpInfo'])->name('admin.system.phpinfo');
    Route::post('/system/optimize', [AdminController::class, 'optimizeTables'])->name('admin.system.optimize');
    
    // Export / Import
    Route::get('/export', [AdminController::class, 'exportPage'])->name('admin.export');
    Route::post('/export/orders', [AdminController::class, 'exportOrders'])->name('admin.export.orders');
    Route::post('/export/users', [AdminController::class, 'exportUsers'])->name('admin.export.users');
    Route::post('/export/accounts', [AdminController::class, 'exportAccounts'])->name('admin.export.accounts');
    Route::post('/import/accounts', [AdminController::class, 'importAccounts'])->name('admin.import.accounts');
    
    // Backup
    Route::get('/backup', [AdminController::class, 'backupPage'])->name('admin.backup');
    Route::post('/backup/create', [AdminController::class, 'createBackup'])->name('admin.backup.create');
    Route::post('/backup/export-sql', [AdminController::class, 'createBackup'])->name('admin.backup.export-sql');
    Route::get('/backup/download/{filename}', [AdminController::class, 'downloadBackup'])->name('admin.backup.download');
    Route::delete('/backup/{filename}', [AdminController::class, 'deleteBackup'])->name('admin.backup.delete');
    Route::post('/cache/clear-all', [AdminController::class, 'clearAllCache'])->name('admin.cache.clear-all');
    
    // Global Search
    Route::get('/search', [AdminController::class, 'globalSearch'])->name('admin.search');
});
