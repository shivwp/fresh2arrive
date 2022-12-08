<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\UserController;

Auth::routes();

Route::redirect('/', '/login');
// Route::redirect('/home', '/');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::resource('bank', BankController::class);
    Route::resource('user', UserController::class);
});
