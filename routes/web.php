<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::group(['middleware' => ['guest']], function () {
    Route::get('/register-certificates', [App\Http\Controllers\Auth\RegisterController::class, 'showRegisterCertificate'])->name('register.certificate');
    Route::post('/register-certificates', [App\Http\Controllers\Auth\RegisterController::class, 'storeRegisterCertificate'])->name('store.register.certificate');
});

Route::middleware('auth')->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
});