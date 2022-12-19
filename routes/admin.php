<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\CategoryController;

Auth::routes();

Route::redirect('/', '/login');
// Route::redirect('/home', '/');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {

    Route::GET('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::RESOURCE('banks', BankController::class);
    Route::RESOURCE('users', UserController::class);
    Route::GET('users/change-status/{id}', [UserController::class, 'changeStatus'])->name('users.change-status');
    Route::RESOURCE('setting', SettingController::class);
    Route::RESOURCE('pages', PageController::class);
    Route::RESOURCE('categories', CategoryController::class);
    Route::GET('categories/change-status/{id}', [CategoryController::class, 'changeStatus'])->name('categories.change-status');
});
