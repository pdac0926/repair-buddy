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

    // Administrator routes
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

    // Shop Owner Routes
    Route::middleware('isOwner')->group(function () {
        Route::get('/mechanics', [App\Http\Controllers\ShopOwner\MechanicController::class, 'index'])->name('shop.owners.mechanics');
        Route::get('/add-mechanics', [App\Http\Controllers\ShopOwner\MechanicController::class, 'addMechanics'])->name('shop.owners.add.mechanics');
        Route::post('/add-mechanics', [App\Http\Controllers\ShopOwner\MechanicController::class, 'storeMechanics'])->name('shop.owners.store.mechanics');
        Route::get('/edit-mechanics/{id}', [App\Http\Controllers\ShopOwner\MechanicController::class, 'editMechanics'])->name('shop.owners.edit.mechanics');
        Route::post('/update-mechanics/{id}', [App\Http\Controllers\ShopOwner\MechanicController::class, 'updateMechanics'])->name('shop.owners.update.mechanics');
        Route::post('/update-mechanics-availability/{id}', [App\Http\Controllers\ShopOwner\MechanicController::class, 'updateMechanicsAvailability'])->name('shop.owners.update.mechanics.availability');

        Route::get('/services', [App\Http\Controllers\ShopOwner\ServicesController::class, 'index'])->name('shop.owners.services');
        Route::get('/add-services', [App\Http\Controllers\ShopOwner\ServicesController::class, 'addServices'])->name('shop.owners.add.services');
        Route::post('/add-services', [App\Http\Controllers\ShopOwner\ServicesController::class, 'storeServices'])->name('shop.owners.store.services');
        Route::get('/edit-services/{id}', [App\Http\Controllers\ShopOwner\ServicesController::class, 'editServices'])->name('shop.owners.edit.services');
        Route::post('/update-services/{id}', [App\Http\Controllers\ShopOwner\ServicesController::class, 'updateServices'])->name('shop.owners.update.services');
        Route::post('/delete-services/{id}', [App\Http\Controllers\ShopOwner\ServicesController::class, 'deleteServices'])->name('shop.owners.delete.services');

        Route::get('/pending-avail', [App\Http\Controllers\ShopOwner\ServicesController::class, 'pendingAvail'])->name('shop.owners.pending.avail');
        Route::post('/update-service-status/{id}', [App\Http\Controllers\ShopOwner\ServicesController::class, 'updateServiceStatus'])->name('shop.owners.update.services.status');

        //pending / paid
        Route::get('/ongoing-avail', [App\Http\Controllers\ShopOwner\ServicesController::class, 'ongoingAvail'])->name('shop.owners.ongoing.avail');
        Route::get('/paid', [App\Http\Controllers\ShopOwner\ServicesController::class, 'paidAvail'])->name('shop.owners.ongoing.paid');

        // messages
        Route::get('/messages', [App\Http\Controllers\ShopOwner\MessagesController::class, 'index'])->name('shop.owners.messages');
        Route::post('/send-to-driver/{driverID}', [App\Http\Controllers\ShopOwner\MessagesController::class, 'sendMessage'])->name('shop.owners.send.messages');

        // update the pakshit
        Route::post('/update-service-price/{serviceID}', [App\Http\Controllers\ShopOwner\ServicesController::class, 'updatePrice'])->name('shop.owners.update.price');
    });

    // load locations from map
    Route::get('/load-shop-locations', [App\Http\Controllers\Driver\DashboardController::class, 'loadShopLocations'])->name('driver.load.shop.locations');

    // Dirver routes
    Route::middleware('isDriver')->group(function () {
        Route::get('/maintenance-history', [App\Http\Controllers\Driver\MaintenanceController::class, 'index'])->name('driver.maintenance.history');
        Route::get('/shop-owner/{id}', [App\Http\Controllers\Driver\ShopOwnerController::class, 'index'])->name('driver.view.shop.owner');
        Route::get('/contact-shop-owner/{id}', [App\Http\Controllers\Driver\ContactShopOwnerController::class, 'index'])->name('driver.view.contact.shop.owner');

        // avail services
        Route::get('/avail-service/{id}/{shopId}', [App\Http\Controllers\Driver\AvailServiceController::class, 'availService'])->name('driver.avail.service');
        Route::post('/avail-service/{id}', [App\Http\Controllers\Driver\AvailServiceController::class, 'storeService'])->name('driver.store.service');
        
        Route::get('/cancel-service/{id}/', [App\Http\Controllers\Driver\AvailServiceController::class, 'cancelService'])->name('driver.cancel.service');
        

        // messages
        Route::get('/shop-messages', [App\Http\Controllers\Driver\MessagesController::class, 'messages'])->name('driver.messages');

        // service availed
        Route::get('/appointment', [App\Http\Controllers\Driver\AvailServiceController::class, 'serviceAvailed'])->name('driver.service.availed');

        // messages
        Route::post('/send-to-shop-owner/{shopOwnerId}', [App\Http\Controllers\Driver\ContactShopOwnerController::class, 'sendToOwner'])->name('driver.send.message');

        //ratings and reviews
        Route::get('/review/{shopID}/{serviceID}', [App\Http\Controllers\Driver\ReviewController::class, 'addReview'])->name('driver.add.review');
        Route::post('/store-review', [App\Http\Controllers\Driver\ReviewController::class, 'storeReview'])->name('driver.store.review');
    });
});
