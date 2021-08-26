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


Route::get('/profile/{email?}', [App\Http\Controllers\ClientsController::class, 'show'])->name('client.profile')->middleware(['verified']);

// ajax
Route::get('/availablerooms/{startdate}/{enddate}/{roomtype}', [App\Http\Controllers\RoomsController::class, 'availableRooms'])->name('rooms.available');
Route::get('/computebook/{quantity}/{startdate}/{enddate}/{roomtype}', [App\Http\Controllers\BookingsController::class, 'computeBooking'])->name('book.compute');
Route::get('/storebooking/{email}/{amount}/{roomtype}/{startdate}/{enddate}/{quantity}/{cost}', [App\Http\Controllers\BookingsController::class, 'store'])->name('booking.store')->middleware(['verified']);

Route::middleware([App\Http\Middleware\ProtectClientRoutesMiddleware::class])->group(function () {

    Route::any('/updateprofile', [App\Http\Controllers\ClientsController::class, 'update'])->name('client.update');    

});

Route::middleware([App\Http\Middleware\ProtectAdminRoutesMiddleware::class])->group(function () {

    Route::any('/admin', [App\Http\Controllers\UsersController::class, 'adminView'])->name('admin.view');

});
