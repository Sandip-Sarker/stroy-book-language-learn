<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// routes/web.php
Route::get('/test-paypal-plans', function () {
    $provider = new \Srmklive\PayPal\Services\PayPal;
    $provider->setApiCredentials(config('paypal'));
    $provider->getAccessToken();

    $plans = $provider->listPlans();
    dd($plans);
});


Route::get('/test-subscription/{id}', function ($id) {
    $provider = new \Srmklive\PayPal\Services\PayPal;
    $provider->setApiCredentials(config('paypal'));
    $provider->getAccessToken();

    $details = $provider->showSubscriptionDetails($id);
    dd($details);
});

Route::get('/payment-success', function () {
    return view('backend.layouts.payment-success');
})->name('payment-success');

require __DIR__.'/auth.php';
