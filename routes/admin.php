<?php

use Illuminate\Support\Facades\Route;

Auth::routes();



Route::middleware('auth')->get('/', function () {
    return view('admin.index');
});
Route::get('/confirm', function () {
    return view('auth.register');
});