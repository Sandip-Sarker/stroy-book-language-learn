<?php

use App\Http\Controllers\API\Song\LanguageController;
use App\Http\Controllers\API\Song\SongController;
use App\Http\Controllers\API\Subscription\SubscriptionController;
use App\Http\Controllers\API\User\QuizController;
use App\Http\Controllers\API\User\ContactusController;
use App\Http\Controllers\API\Auth\RegistrationController;
use App\Http\Controllers\API\Auth\VerifyOtpController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\Profile\ProfileUpdateController;
use App\Http\Controllers\API\DynamicPage\DynamicPageController;
use App\Http\Controllers\API\Auth\ResetPasswordController;
use App\Http\Controllers\API\Subscription\PlanController;
use App\Http\Controllers\API\Paypal\DonationController;
use App\Http\Controllers\API\Song\FunFactController;
use Illuminate\Support\Facades\Route;

// Dynamic Pages routes
Route::get('/page/{id}', [DynamicPageController::class, 'page']);

Route::get('paypal/subscription/success', [SubscriptionController::class, 'paypalSuccess']);
Route::get('paypal/one-time/success', [SubscriptionController::class, 'oneTimeSuccess']);
Route::get('paypal/subscription/cancel', [SubscriptionController::class, 'paypalCancel']);

Route::get('/paypal-donate/success', [DonationController::class, 'paypalDonateSuccess']);
Route::get('/paypal-donate/cancel', [DonationController::class, 'paypalDonateCancel']);


Route::middleware('guest')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/registration', [RegistrationController::class, 'register']);
    Route::post('/resend-otp', [VerifyOtpController::class, 'resendOtp']);
    // Route::post('/verify-register-otp', [VerifyOtpController::class, 'verifyOtp']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
    Route::post('/verify-forgot-otp', [VerifyOtpController::class, 'verifyForgotOtp']);
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword']);

    // Language Route
    Route::get('/language', [LanguageController::class, 'language']);
    // Song Route
    Route::get('/song-category', [SongController::class, 'songCategory']);
    Route::get('/song', [SongController::class, 'song']);
    Route::get('/song/details/{id}', [SongController::class, 'songDetails']);

    // Subscription Plan
    Route::get('/plans', [PlanController::class, 'plan']);

    // fun fact route
    Route::get('/fun-fact', [FunFactController::class, 'allFunFact']);
    Route::get('/fun-fact/details/{id}', [FunFactController::class, 'funFactDetails']);

});


Route::middleware(['auth:sanctum', 'CheckTokenExpiry'])->group(function () {

    Route::post('/logout', [LogoutController::class, 'logout']);

    // Qiz Route
    Route::post('/user/submit-quiz', [QuizController::class, 'userSubmitQiz']);

    // contact Route
    Route::post('/contact-submit', [ContactUsController::class, 'contactSubmit']);

    // Profile Route
    Route::get('/user-dashboard', [ProfileUpdateController::class, 'userDashboard']);

    // Subscribe user to a plan
    Route::post('/paypal/subscription/create', [SubscriptionController::class, 'create']);
    Route::post('/paypal/subscription/cancel', [SubscriptionController::class, 'cancelSubscription']);
    // Donation Route
    Route::post('/paypal-donate', [DonationController::class, 'paypalDonate']);


    Route::post('/profile-update', [ProfileUpdateController::class, 'update']);


//    Route::post('/change-password', [ProfileUpdateController::class, 'changePassword']);
//    Route::delete('/profile-delete', [ProfileUpdateController::class, 'profileDelete']);

    // Notification Route
//    Route::get('/notifications', [NotificationController::class, 'getNotification']);

    //    Route::post('/notification-setting', [NotificationController::class, 'notificationSetting']);
});
