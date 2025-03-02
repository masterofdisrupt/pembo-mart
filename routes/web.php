<?php

use App\Http\Controllers\Backend\V1\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\V1\AdminController;
use App\Http\Controllers\Backend\V1\AgentController;
use App\Http\Controllers\Backend\V1\EmailController;
use App\Http\Controllers\Backend\V1\UserTimeController;
use App\Http\Controllers\Backend\V1\NotificationController;




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
    Route::post('checkemail', [AdminController::class, 'checkEmail'])->name('check.email');


    Route::get('admin/email/compose', [EmailController::class, 'email_compose']);
    Route::post('admin/email/post', [EmailController::class, 'email_store']);
    Route::get('admin/email/sent', [EmailController::class, 'email_sent'])->name('email.send');
    Route::delete('admin/email_sent', [EmailController::class, 'sent_delete'])->name('sent.delete');
    Route::get('admin/email/read/{id}', [EmailController::class, 'email_read'])->name('email.read');
    Route::get('admin/email/read_delete/{id}', [EmailController::class, 'read_delete'])->name('read.delete');

    // User Week Start
    Route::get('admin/week', [UserTimeController::class, 'week_list'])->name('week.list');
    Route::get('admin/week/add', [UserTimeController::class, 'week_add'])->name('week.add');
    Route::post('admin/week/add', [UserTimeController::class, 'week_store'])->name('week.add.store');
    Route::get('admin/week/edit/{id}', [UserTimeController::class, 'week_edit'])->name('week.edit');
    Route::post('admin/week/edit/{id}', [UserTimeController::class, 'week_update'])->name('week.edit.update');
    Route::get('admin/week/delete/{id}', [UserTimeController::class, 'week_delete'])->name('week.delete');

    // User Week End

    // Week Time Start
    Route::get('admin/week_time', [UserTimeController::class, 'week_time_list'])->name('week.time.list');
    Route::get('admin/week_time/add', [UserTimeController::class, 'week_time_add'])->name('week.time.add');
    Route::post('admin/week_time/add', [UserTimeController::class, 'week_time_store'])->name('week.time.add.store');
    Route::get('admin/week_time/edit/{id}', [UserTimeController::class, 'week_time_edit'])->name('week.time.edit');
    Route::post('admin/week_time/edit/{id}', [UserTimeController::class, 'week_time_update'])->name('week.time.edit.update');
    Route::get('admin/week_time/delete/{id}', [UserTimeController::class, 'week_time_delete'])->name('week.time.delete');
// Week Time End

// Schedule Start
    Route::get('admin/schedule', [UserTimeController::class, 'admin_schedule'])->name('admin.schedule');
    Route::post('admin/schedule', [UserTimeController::class, 'admin_schedule_update'])->name('admin.schedule.update');
    // Schedule End

    // Notification Start
    Route::get('admin/notification', [NotificationController::class, 'notification_index'])->name('notification');
    Route::post('admin/notification_send', [NotificationController::class, 'notification_send'])->name('notification.send');
    // Notification End


    // Personal profile edit
    Route::get('admin/my_profile', [AdminController::class, 'my_profile'])->name('admin.my.profile');
    Route::post('admin/my_profile/update', [AdminController::class, 'my_profile_update'])->name('admin.my.profile.update');


});


Route::group(['middleware' => 'agent'], function () {
    Route::get('agent/dashboard', [DashboardController::class, 'dashboard'])->name('agent.dashboard');

    Route::get('agent/email/inbox', [AgentController::class, 'agent_email_inbox'])->name('agent.email.inbox');

});

Route::group(['middleware' => 'user'], function () {

});




