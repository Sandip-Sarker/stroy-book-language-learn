<?php

use App\Http\Controllers\Web\Backend\Settings\MailSettingController;
use App\Http\Controllers\Web\Backend\Settings\ProfileController;
use App\Http\Controllers\Web\Backend\Settings\PageSettingController;
use Illuminate\Support\Facades\Route;

//! Route for Profile Settings
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.setting');
Route::patch('/update-profile', [ProfileController::class, 'UpdateProfile'])->name('update.profile');
Route::put('/update-profile-password', [ProfileController::class, 'UpdatePassword'])->name('update.Password');
Route::post('/update-profile-picture', [ProfileController::class, 'UpdateProfilePicture'])->name('update.profile.picture');

//! Route for Mail Settings
Route::get('/mail-setting', [MailSettingController::class, 'index'])->name('mail.setting');
Route::patch('/mail-setting', [MailSettingController::class, 'update'])->name('mail.update');

//! Route for Page Settings
Route::get('/page-setting', [PageSettingController::class, 'index'])->name('page.setting');
Route::get('/page-setting-create', [PageSettingController::class, 'create'])->name('page.setting.create');
Route::post('/page-setting-store', [PageSettingController::class, 'store'])->name('page.setting.store');
Route::get('/page-setting-edit/{id}', [PageSettingController::class, 'edit'])->name('page.setting.edit');
Route::post('/page-setting-update/{id}', [PageSettingController::class, 'update'])->name('page.setting.update');
Route::delete('/page-setting-delete/{id}', [PageSettingController::class, 'destroy'])->name('page.setting.delete');
Route::get('/page-setting/status/{id}', [PageSettingController::class, 'status'])->name('page.setting.status');



