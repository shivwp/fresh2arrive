<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\VendorController;
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

// Without login api's - Without Token
Route::post('login', [AuthController::class, 'login']);
Route::POST('verify-otp', [AuthController::class, 'verifyOtp']);
Route::GET('logout', [AuthController::class, 'logout']);
Route::POST('resend-otp', [AuthController::class, 'resendOtp']);


// 
Route::get('categories', [CategoryController::class, 'list']);
Route::get('category/{categoryId}', [CategoryController::class, 'view']);

Route::get('products', [ProductController::class, 'list']);
Route::get('product/{productId}', [ProductController::class, 'view']);

Route::get('coupons', [CouponController::class, 'list']);


Route::group(['as' => 'api.', 'middleware' =>['auth:api']], function(){
    Route::get('stores', [VendorController::class, 'list']);
    Route::get('user-profile', [AuthController::class, 'userProfile']);
    Route::POST('update-profile', [AuthController::class, 'updateProfile']);
    
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
