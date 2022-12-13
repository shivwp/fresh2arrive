<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\UserController;

Auth::routes();

Route::redirect('/', '/login');
// Route::redirect('/home', '/');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {

    Route::GET('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::RESOURCE('bank', BankController::class);
    Route::RESOURCE('user', UserController::class);
    Route::GET('user/change-status/{id}', [UserController::class, 'changeStatus'])->name('user.change-status');
});
