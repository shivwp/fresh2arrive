<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AppSettingController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\VendorProductController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\FaqController;

Auth::routes();

Route::redirect('/', '/login');
// Route::redirect('/home', '/');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {

    Route::GET('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::RESOURCE('banks', BankController::class);
    Route::RESOURCE('users', UserController::class);
    Route::GET('users/change-status/{id}', [UserController::class, 'changeStatus'])->name('users.change-status');
    Route::RESOURCE('site-setting', SettingController::class);
    Route::RESOURCE('app-setting', AppSettingController::class);
    Route::RESOURCE('pages', PageController::class);
    Route::RESOURCE('categories', CategoryController::class);
    Route::GET('categories/change-status/{id}', [CategoryController::class, 'changeStatus'])->name('categories.change-status');
    Route::RESOURCE('products', ProductController::class);
    Route::GET('products/change-status/{id}', [ProductController::class, 'changeStatus'])->name('products.change-status');
    Route::RESOURCE('vendor-products', VendorProductController::class);
    Route::GET('vendor-products/change-status/{id}', [VendorProductController::class, 'changeStatus'])->name('vendor-products.change-status');
    Route::GET('vendor-products/products/{category_id}', [VendorProductController::class, 'getProductsByCategory'])->name('vendor-products.products');
    Route::GET('vendor-products/products-details/{product_id}', [VendorProductController::class, 'getProductsById'])->name('vendor-products.products-details');
    Route::RESOURCE('coupons', CouponController::class);
    Route::GET('coupons/change-status/{id}', [CouponController::class, 'changeStatus'])->name('coupons.change-status');

    Route::RESOURCE('sliders', SliderController::class);
    Route::GET('sliders/change-status/{id}', [SliderController::class, 'changeStatus'])->name('sliders.change-status');
    Route::RESOURCE('faqs', FaqController::class);
    Route::GET('faqs/change-status/{id}', [FaqController::class, 'changeStatus'])->name('faqs.change-status');
});
