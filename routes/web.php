<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WhitelistController;

use Illuminate\Support\Facades\Mail;
use App\Mail\MyMail;


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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    Route::get('/whitelist/activate/{id}', [WhitelistController::class, 'activate']);
    Route::resource('whitelist', WhitelistController::class);
    Route::get('activate', 'WhitelistController@showActivate')->name('activate');

    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/home', 'DashboardController@index')->name('home');

    // Route::group(['middleware' => ['verified']], function() {       
    //     Route::get('/home', 'DashboardController@index')->name('home');
    // });
});

Auth::routes(['verify' => true]);




