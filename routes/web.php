<?php

use App\Http\Controllers\Backend\V1\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\V1\AdminController;
use App\Http\Controllers\Backend\V1\AgentController;
use App\Http\Controllers\Backend\V1\EmailController;




Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login');
Route::post('/login', [AuthController::class, 'authLogin'])->name('login');

Route::get('forgot', [AuthController::class, 'forgot'])->name('forgot');
Route::post('forgot', [AuthController::class, 'forgotPassword']);
Route::get('reset/{token}', [AuthController::class, 'reset']);
Route::post('reset/{token}', [AuthController::class, 'postReset']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('set_new_password/{token}', [AuthController::class, 'set_new_password'])->name('show.set.new.password');
Route::post('set_new_password/{token}', [AuthController::class, 'new_password_store'])->name('set.new.password');





Route::group(['middleware' => 'admin'], function () {
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('admin_profile/update', [AdminController::class, 'profile_update']);
    Route::get('admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('admin/users/view/{id}', [AdminController::class, 'view_users'])->name('admin.users.view');

    Route::get('admin/users/add', [AdminController::class, 'admin_add_users'])->name('admin.add.users');
    Route::post('admin/users/add', [AdminController::class, 'add_users_store'])->name('add.users.store');
    Route::get('admin/users/edit/{id}', [AdminController::class, 'admin_users_edit'])->name('admin.users.edit');
    Route::post('admin/users/edit/{id}', [AdminController::class, 'admin_users_edit_store'])->name('admin.users.edit.store');
    Route::get('admin/users/delete/{id}', [AdminController::class, 'admin_users_delete'])->name('admin.users.delete');
    // Single user name update
    Route::post('admin/users/update', [AdminController::class, 'admin_users_update'])->name('admin.users.update');
    Route::get('admin/users/changeStatus', [AdminController::class, 'admin_users_changeStatus'])->name('admin.users.change.status');



    Route::get('admin/email/compose', [EmailController::class, 'email_compose']);
    Route::post('admin/email/post', [EmailController::class, 'email_store']);
    Route::get('admin/email/sent', [EmailController::class, 'email_sent'])->name('email.send');
    Route::delete('admin/email_sent', [EmailController::class, 'sent_delete'])->name('sent.delete');
    Route::get('admin/email/read/{id}', [EmailController::class, 'email_read'])->name('email.read');
    Route::get('admin/email/read_delete/{id}', [EmailController::class, 'read_delete'])->name('read.delete');

    // Personal profile edit
    Route::get('admin/my_profile', [AdminController::class, 'my_profile'])->name('admin.my.profile');
    Route::post('admin/my_profile/update', [AdminController::class, 'my_profile_update'])->name('admin.my.profile.update');


});


Route::group(['middleware' => 'agent'], function () {
    Route::get('agent/dashboard', [DashboardController::class, 'dashboard'])->name('agent.dashboard');

});

Route::group(['middleware' => 'user'], function () {

});




