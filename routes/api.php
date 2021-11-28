<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/login', [App\Http\Controllers\UserController::class, 'index'])->name('login');










Route::group(['middleware' => 'auth:sanctum'], function () {
    //All secure URL's
    Route::get('/test', [App\Http\Controllers\TestingController::class, 'test']);

    Route::post('/register_user', [App\Http\Controllers\AdminController::class, 'registeruser']);
    Route::post('/edit_user', [App\Http\Controllers\AdminController::class, 'edituser']);
    Route::post('/delete_user', [App\Http\Controllers\AdminController::class, 'deleteuser']);
    Route::post('/list_user', [App\Http\Controllers\AdminController::class, 'listuser']);
    Route::post('/add_contact_admin', [App\Http\Controllers\AdminController::class, 'addcontact']);
    Route::post('/edit_contact_admin', [App\Http\Controllers\AdminController::class, 'editcontact']);
    Route::post('/delete_contact_admin', [App\Http\Controllers\AdminController::class, 'deletecontact']);
    Route::post('/list_contact_admin', [App\Http\Controllers\AdminController::class, 'listcontact']);
    Route::post('/list_contact_admin_dashboard', [App\Http\Controllers\AdminController::class, 'listcontactdashboard']);


    //users
    Route::post('/add_contact', [App\Http\Controllers\UserController::class, 'addcontact']);
    Route::post('/edit_contact', [App\Http\Controllers\UserController::class, 'editcontact']);
    Route::post('/delete_contact', [App\Http\Controllers\UserController::class, 'deletecontact']);
    Route::post('/list_contact', [App\Http\Controllers\UserController::class, 'listcontact']);
});
