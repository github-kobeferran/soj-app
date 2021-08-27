<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/hotel', [App\Http\Controllers\RoomTypesController::class, 'clientView'])->name('roomtypes.clientview');
Route::get('/restaurant', [App\Http\Controllers\RoomTypesController::class, 'clientView'])->name('roomtypes.clientview');


Route::get('/profile/{email?}', [App\Http\Controllers\ClientsController::class, 'show'])->name('client.profile')->middleware(['verified']);

// ajax
Route::get('/availablerooms/{startdate}/{enddate}/{roomtype}', [App\Http\Controllers\RoomsController::class, 'availableRooms'])->name('rooms.available');
Route::get('/computebook/{quantity}/{startdate}/{enddate}/{roomtype}', [App\Http\Controllers\BookingsController::class, 'computeBooking'])->name('book.compute');
Route::get('/storebooking/{email}/{amount}/{roomtype}/{startdate}/{enddate}/{quantity}/{cost}', [App\Http\Controllers\BookingsController::class, 'store'])->name('booking.store')->middleware(['verified']);

Route::middleware([App\Http\Middleware\ProtectClientRoutesMiddleware::class])->group(function () {

    Route::any('/updateprofile', [App\Http\Controllers\ClientsController::class, 'update'])->name('client.update');    
    Route::any('/paybalance', [App\Http\Controllers\ClientsController::class, 'payBalance'])->name('client.paybalance');    
    Route::any('/cancelbook', [App\Http\Controllers\BookingsController::class, 'cancel'])->name('booking.cancel');

});

Route::middleware([App\Http\Middleware\ProtectAdminRoutesMiddleware::class])->group(function () {

    Route::get('/admin', [App\Http\Controllers\UsersController::class, 'adminView'])->name('admin.view');
    Route::get('/clients', [App\Http\Controllers\ClientsController::class, 'view'])->name('client.view');
    Route::get('/rooms', [App\Http\Controllers\RoomsController::class, 'view'])->name('room.view');
    Route::any('/roomtypestore', [App\Http\Controllers\RoomTypesController::class, 'store'])->name('roomtype.store');
    Route::any('/roomtypeupdate', [App\Http\Controllers\RoomTypesController::class, 'update'])->name('roomtype.update');
    Route::any('/roomtypedelete', [App\Http\Controllers\RoomTypesController::class, 'delete'])->name('roomtype.delete');
    Route::any('/roomstore', [App\Http\Controllers\RoomsController::class, 'store'])->name('room.store');
    Route::any('/roomupdate', [App\Http\Controllers\RoomsController::class, 'update'])->name('room.update');
    Route::any('/roomdelete', [App\Http\Controllers\RoomsController::class, 'delete'])->name('room.delete');
    Route::any('/featurestore', [App\Http\Controllers\FeaturesController::class, 'store'])->name('feature.store');
    Route::any('/featureupdate', [App\Http\Controllers\FeaturesController::class, 'update'])->name('feature.update');
    Route::any('/featuredelete', [App\Http\Controllers\FeaturesController::class, 'delete'])->name('feature.delete');
    Route::any('/bedstore', [App\Http\Controllers\BedsController::class, 'store'])->name('bed.store');
    Route::any('/bedupdate', [App\Http\Controllers\BedsController::class, 'update'])->name('bed.update');
    Route::any('/beddelete', [App\Http\Controllers\BedsController::class, 'delete'])->name('bed.delete');
    Route::any('/checkin', [App\Http\Controllers\BookingsController::class, 'checkIn'])->name('booking.checkin');
    Route::any('/bookdone', [App\Http\Controllers\BookingsController::class, 'done'])->name('booking.done');    

});
