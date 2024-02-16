<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

//Main Pages
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories');
Route::get('/categories/{id}', [App\Http\Controllers\CategoryController::class, 'detail'])->name('categories-detail');
Route::get('/details/{id}', [App\Http\Controllers\DetailController::class, 'index'])->name('detail');
Route::post('/details/{id}', [App\Http\Controllers\DetailController::class, 'add'])->name('detail-add');

Route::post('/checkout/callback', [App\Http\Controllers\CheckoutController::class, 'callback'])->name('midtrans-callback');

Route::get('/success', [App\Http\Controllers\CartController::class, 'success'])->name('success');

//Register
Route::get('/register/success', [App\Http\Controllers\Auth\RegisterController::class, 'success'])
    ->name('register-success');



Route::group(['middleware' => ['auth']], function () {
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
    Route::delete('/cart/{id}', [App\Http\Controllers\CartController::class, 'delete'])->name('cart-delete');

    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkput');

    //Dashboard Product
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/dashboard/products', [App\Http\Controllers\DashboardProductController::class, 'index'])
        ->name('dashboard-products');
    Route::get('/dashboard/products/create', [App\Http\Controllers\DashboardProductController::class, 'create'])
        ->name('dashboard-products-create');
    Route::post('/dashboard/products/store', [App\Http\Controllers\DashboardProductController::class, 'store'])
        ->name('dashboard-products-store');
    Route::get('/dashboard/products/{id}', [App\Http\Controllers\DashboardProductController::class, 'details'])
        ->name('dashboard-products-details');
    Route::post('/dashboard/products/{id}', [App\Http\Controllers\DashboardProductController::class, 'update'])
        ->name('dashboard-products-update');

    Route::post('/dashboard/products/gallery/upload', [App\Http\Controllers\DashboardProductController::class, 'uploadGallery'])
        ->name('dashboard-products-gallery-upload');
    Route::get('/dashboard/products/gallery/delete/{id}', [App\Http\Controllers\DashboardProductController::class, 'deleteGallery'])
        ->name('dashboard-products-gallery-delete');

    //Dashboard Transaction
    Route::get('/dashboard/transaction', [App\Http\Controllers\DashboardTransactionController::class, 'index'])
        ->name('dashboard-transaction');
    Route::get('/dashboard/transaction/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'details'])
        ->name('dashboard-transaction-details');
    Route::post('/dashboard/transaction/{id}', [App\Http\Controllers\DashboardTransactionController::class, 'update'])
        ->name('dashboard-transaction-update');

    //Dashboard Setting
    Route::get('/dashboard/settings', [App\Http\Controllers\DashboardSettingController::class, 'store'])
        ->name('dashboard-settings-store');
    Route::get('/dashboard/account', [App\Http\Controllers\DashboardSettingController::class, 'account'])
        ->name('dashboard-settings-account');
    Route::post('/dashboard/account/{redirect}', [App\Http\Controllers\DashboardSettingController::class, 'update'])
        ->name('dashboard-settings-redirect');
});

//Admin Area
Route::prefix('admin')
    ->namespace('Admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('admin-dashboard');
        Route::resource('category', CategoryController::class);
        Route::resource('user', UserController::class);
        Route::resource('product', ProductController::class);
        Route::resource('product-gallery', ProductGalleryController::class);
    });

Auth::routes();
