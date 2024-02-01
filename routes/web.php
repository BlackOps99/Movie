<?php

use App\Http\Controllers\AttendeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\Auth\Admin\AuthenticatedAdminSessionController;
use App\Http\Controllers\Auth\User\AuthenticatedSessionController;
use App\Http\Controllers\ShowtimeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventRegistrationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//User Routes START
Route::middleware('guest:web')->group(function () {
    Route::get('/', [MovieController::class, 'index'])->name('home');
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('user-login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::middleware('throttle:60,1')
            ->resource('/event-registration', EventRegistrationController::class);
});

Route::middleware('auth:web')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('user-logout');
});
//User Routes END

//Admin Routes START
Route::middleware('guest:admin')->group(function () {
    Route::get('admin-login', [AuthenticatedAdminSessionController::class, 'create'])->name('admin-login');
    Route::post('admin-login', [AuthenticatedAdminSessionController::class, 'store']);
});

Route::middleware('auth:admin')->group(function () {
    Route::post('admin-logout', [AuthenticatedAdminSessionController::class, 'destroy'])->name('admin-logout');
    Route::resource('/attende', AttendeController::class);
});
//Admin Routes END

Route::resource('/events', EventController::class);
Route::resource('/show-times', ShowtimeController::class);
Route::resource('/movies', MovieController::class);