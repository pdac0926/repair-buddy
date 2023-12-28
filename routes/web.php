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
        //Shop Owner (admin panel)
        Route::get('/shop-owners', [App\Http\Controllers\Admin\ShopOwnerConstroller::class, 'index'])->name('admin.shop.owners');
        Route::get('/add-shop-owners', [App\Http\Controllers\Admin\ShopOwnerConstroller::class, 'viewAddShopOwner'])->name('admin.add.shop.owners');
        Route::post('/add-shop-owner', [App\Http\Controllers\Admin\ShopOwnerConstroller::class, 'storeAddShopOwner'])->name('admin.store.shop.owners');
        Route::get('/edit-shop-owner/{id}', [App\Http\Controllers\Admin\ShopOwnerConstroller::class, 'viewEditShopOwner'])->name('admin.edit.shop.owners');
        Route::post('/update-shop-owner/{id}', [App\Http\Controllers\Admin\ShopOwnerConstroller::class, 'updateShopOwner'])->name('admin.update.shop.owners');
        Route::post('/approve-shop-owner/{id}', [App\Http\Controllers\Admin\ShopOwnerConstroller::class, 'approveShopOwner'])->name('admin.approve.shop.owner');
        Route::post('/delete-shop-owner/{id}', [App\Http\Controllers\Admin\ShopOwnerConstroller::class, 'deleteShopOwner'])->name('admin.delete.shop.owner');

        //Driver (admin panel)
        Route::get('/drivers', [App\Http\Controllers\Admin\DriverController::class, 'index'])->name('admin.drivers');
        Route::get('/add-drivers', [App\Http\Controllers\Admin\DriverController::class, 'viewAddDriver'])->name('admin.add.drivers');
        Route::post('/add-driver', [App\Http\Controllers\Admin\DriverController::class, 'storeAddDriver'])->name('admin.store.drivers');
        Route::get('/edit-driver/{id}', [App\Http\Controllers\Admin\DriverController::class, 'viewEditDriver'])->name('admin.edit.drivers');
        Route::post('/update-driver/{id}', [App\Http\Controllers\Admin\DriverController::class, 'updateDriver'])->name('admin.update.drivers');
        Route::post('/approve-driver/{id}', [App\Http\Controllers\Admin\DriverController::class, 'approveDriver'])->name('admin.approve.drivers');
        Route::post('/delete-driver/{id}', [App\Http\Controllers\Admin\DriverController::class, 'deleteDriver'])->name('admin.delete.drivers');

        //Mechanics (admin panel)
        Route::get('/mechanics', [App\Http\Controllers\Admin\MechanicController::class, 'index'])->name('admin.mechanics');
    });


    Route::middleware('isOwner')->group(function () {
        Route::get('/manage-mechanics', [App\Http\Controllers\HomeController::class, 'index'])->name('shop.owners.manage.mechanics');
    });


    Route::middleware('isDriver')->group(function () {
        Route::get('/load-shop-locations', [App\Http\Controllers\Driver\DashboardController::class, 'loadShopLocations'])->name('driver.load.shop.locations');
        Route::get('/manage-account', [App\Http\Controllers\Driver\ManageAccountController::class, 'index'])->name('driver.manage.account');
        Route::get('/shop-owner/{id}', [App\Http\Controllers\Driver\DashboardController::class, 'index'])->name('driver.view.shop.owner');
        // Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('driver.manage.account');
    });
});
