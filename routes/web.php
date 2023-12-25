<?php

use Illuminate\Support\Facades\Route;



Auth::routes();

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome')->middleware('guest');
    Route::get('/register-certificates', [App\Http\Controllers\Auth\RegisterController::class, 'showRegisterCertificate'])->name('register.certificate');
    Route::post('/register-certificates', [App\Http\Controllers\Auth\RegisterController::class, 'storeRegisterCertificate'])->name('store.register.certificate');
});

Route::middleware('auth')->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::middleware('isAdmin')->group(function () {
        Route::get('/shop-owners', [App\Http\Controllers\Admin\ShopOwnerConstroller::class, 'index'])->name('admin.shop.owners');
        Route::get('/add-shop-owners', [App\Http\Controllers\Admin\ShopOwnerConstroller::class, 'viewAddShopOwner'])->name('admin.add.shop.owners');
        Route::post('/add-shop-owners', [App\Http\Controllers\Admin\ShopOwnerConstroller::class, 'storeAddShopOwner'])->name('admin.store.shop.owners');
        Route::get('/edit-shop-owners/{id}', [App\Http\Controllers\Admin\ShopOwnerConstroller::class, 'viewEditShopOwner'])->name('admin.edit.shop.owners');
        Route::get('/drivers', [App\Http\Controllers\Admin\DriverController::class, 'index'])->name('admin.drivers');
        Route::get('/mechanics', [App\Http\Controllers\Admin\MechanicController::class, 'index'])->name('admin.mechanics');
    });


    Route::middleware('isOwner')->group(function () {
        Route::get('/manage-mechanics', [App\Http\Controllers\HomeController::class, 'index'])->name('shop.owners.manage.mechanics');
    });


    Route::middleware('isDriver')->group(function () {
        Route::get('/manage-account', [App\Http\Controllers\HomeController::class, 'index'])->name('driver.manage.account');
        // Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('driver.manage.account');
    });
});
