<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\BusScheduleController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AdminUserProfileController;
use App\Http\Controllers\PopupController;

// public routes 
Route::get('/', function () { return view('index');})->name('home'); 
Route::get('/about', function () { return view('about');})->name('about');
Route::get('/services', function () { return view('services');})->name('services');
Route::get('/popup', [PopupController::class, 'index']);

Route::post('/process_signup', [AuthController::class, 'signUp']);
Route::post('/login', [AuthController::class, 'logIn'])->name('login');
Route::get('/users/search/{name}', [AdminUserProfileController::class, 'searchUserByName']);
Route::view('/get_login_form', 'login');

/**auth routes
 * 
 * user has to be authenticated to access
 */

Route::group(['middleware'=>['auth:sanctum']] , function () {
    
    Route::get('/view_user_profile/{user_id}', [UserProfileController::class, 'viewUserInfo']);
    Route::put('/edit_user_profile/{id}', [UserProfileController::class, 'editUserInfo']);
    Route::delete('/delete_user_profile/{id}', [UserProfileController::class, 'deleteUserProfile']);

    //bus related routes
    Route::middleware(['bus_operator'])->group(function () {
        Route::post('/operator/input_bus_details', [BusController::class, 'inputBus']);
        Route::get('/operator/view_bus_details/{id}', [BusController::class, 'viewBusDetails']);
        Route::put('/operator/edit_bus_details/{id}', [BusController::class, 'editBusDetails']);
        Route::delete('/operator/delete_bus_details/{id}', [BusController::class, 'deleteBusDetails']);

        //route related routes
        Route::post('/operator/input_routes', [RouteController::class, 'inputRoute']);

        //bus schedule routes
        Route::post('/operator/input_schedule', [BusScheduleController::class, 'inputBusSchedule']);
        Route::put('/operator/edit_schedule/{id}', [BusScheduleController::class, 'editBusSchedule']);
        Route::delete('/operator/input_routes/{id}', [BusScheduleController::class, 'deleteBusSchedule']);
    });




    //admin routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/users/all', [AdminUserProfileController::class, 'getAllUsers']); 
        Route::post('/logout', [AuthController::class, 'logOut'])->name('logout');
        Route::put('/admin/edit_user_profile/{id}', [AdminUserProfileController::class, 'editUserInfo']);
    });

});


