<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CouponController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::POST('login', [AuthController::class, 'login']);
Route::POST('verify-otp', [AuthController::class, 'verifyOtp']);
Route::GET('logout', [AuthController::class, 'logout']);
Route::POST('resend-otp', [AuthController::class, 'resendOtp']);

Route::get('categories', [CategoryController::class, 'categoriesList']);
Route::get('category/{categoryId}', [CategoryController::class, 'category']);

Route::get('products', [ProductController::class, 'allProductsList']);
Route::get('product/{productId}', [ProductController::class, 'product']);

Route::get('coupons', [CouponController::class, 'allCouponsList']);

Route::group(['as' => 'api.', 'middleware' =>['auth:api']], function(){

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
