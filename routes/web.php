<?php

use App\Http\Controllers\Backend\V1\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\V1\AdminController;
use App\Http\Controllers\Backend\V1\AgentController;




Route::get('login', [AuthController::class, 'showLogin']);
Route::post('login', [AuthController::class, 'authLogin'])->name('login');

Route::get('forgot', [AuthController::class, 'forgot']);
Route::post('forgot', [AuthController::class, 'forgotPassword']);
Route::get('reset/{token}', [AuthController::class, 'reset']);
Route::post('reset/{token}', [AuthController::class, 'postReset']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');




Route::group(['middleware' => 'admin'], function () {
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/profile', [AdminController::class, 'admin_profile'])->name('admin.profile');
    Route::post('admin_profile/update', [AdminController::class, 'update']);
    Route::get('admin/users', [AdminController::class, 'admin_users']);


});


Route::group(['middleware' => 'agent'], function () {
    Route::get('agent/dashboard', [DashboardController::class, 'dashboard'])->name('agent.dashboard');

});

Route::group(['middleware' => 'user'], function () {

});




