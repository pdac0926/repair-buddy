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
        Route::get('/mechanics', [App\Http\Controllers\ShopOwner\MechanicController::class, 'index'])->name('shop.owners.mechanics');
        Route::get('/add-mechanics', [App\Http\Controllers\ShopOwner\MechanicController::class, 'addMechanics'])->name('shop.owners.add.mechanics');
        Route::post('/add-mechanics', [App\Http\Controllers\ShopOwner\MechanicController::class, 'storeMechanics'])->name('shop.owners.store.mechanics');
        Route::get('/edit-mechanics/{id}', [App\Http\Controllers\ShopOwner\MechanicController::class, 'editMechanics'])->name('shop.owners.edit.mechanics');
        Route::post('/update-mechanics/{id}', [App\Http\Controllers\ShopOwner\MechanicController::class, 'updateMechanics'])->name('shop.owners.update.mechanics');

        // messages
        Route::get('/messages', [App\Http\Controllers\ShopOwner\MessagesController::class, 'index'])->name('shop.owners.messages');
    });


    // load locations from map
    Route::get('/load-shop-locations', [App\Http\Controllers\Driver\DashboardController::class, 'loadShopLocations'])->name('driver.load.shop.locations');

    Route::middleware('isDriver')->group(function () {
        Route::get('/manage-account', [App\Http\Controllers\Driver\ManageAccountController::class, 'index'])->name('driver.manage.account');
        Route::get('/shop-owner/{id}', [App\Http\Controllers\Driver\ShopOwnerController::class, 'index'])->name('driver.view.shop.owner');
        Route::get('/contact-shop-owner/{id}', [App\Http\Controllers\Driver\ContactShopOwnerController::class, 'index'])->name('driver.view.contact.shop.owner');

        // messages
        Route::post('/send-message/{shopOwnerId}', [App\Http\Controllers\Driver\ContactShopOwnerController::class, 'sendMessage'])->name('driver.send.message');
    });
});
