<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PageController;

Auth::routes();

Route::redirect('/', '/login');
// Route::redirect('/home', '/');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {

    Route::GET('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::RESOURCE('banks', BankController::class);
    Route::RESOURCE('users', UserController::class);
    Route::GET('user/change-status/{id}', [UserController::class, 'changeStatus'])->name('user.change-status');
    Route::RESOURCE('setting', SettingController::class);
    Route::RESOURCE('pages', PageController::class);
});
