<?php

use App\Http\Controllers\Web\Backend\Song\LanguageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Backend\User\UserController;
use App\Http\Controllers\Web\Backend\Home\DashboardController;
use App\Http\Controllers\Web\Backend\Song\ArtistController;
use App\Http\Controllers\Web\Backend\Song\SongCategoryController;
use App\Http\Controllers\Web\Backend\Song\SongController;
use App\Http\Controllers\Web\Backend\Song\LyricsController;
use App\Http\Controllers\Web\Backend\Song\VocabularyController;
use App\Http\Controllers\Web\Backend\Qiz\QizController;
use App\Http\Controllers\Web\Backend\Subscription\PlanController;
use App\Http\Controllers\Web\Backend\Subscription\PlanFeatureController;
use App\Http\Controllers\Web\Backend\User\UserSubscriptionController;
use App\Http\Controllers\Web\Backend\Song\AchievementController;
use App\Http\Controllers\Web\Backend\User\UserDonationController;
use App\Http\Controllers\Web\Backend\Home\FunFactController;
use App\Http\Controllers\Web\Backend\Contact\ContactUsController;

// Route for Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Route for FunFact
Route::get('/fun-fact', [FunFactController::class, 'index'])->name('fun-fact.index');
Route::get('/fun-fact/create', [FunFactController::class, 'create'])->name('fun-fact.create');
Route::post('/fun-fact/store', [FunFactController::class, 'store'])->name('fun-fact.store');
Route::get('/fun-fact/edit/{id}', [FunFactController::class, 'edit'])->name('fun-fact.edit');
Route::patch('/fun-fact/update/{id}', [FunFactController::class, 'update'])->name('fun-fact.update');
Route::delete('/fun-fact/destroy/{id}', [FunFactController::class, 'destroy'])->name('fun-fact.destroy');


// Route for Users
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::patch('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
Route::post('/user/bulk-delete', [UserController::class, 'bulkDelete'])->name('user.bulkDelete');


// Route for Achievement
Route::get('/achievement', [AchievementController::class, 'index'])->name('achievement.index');
Route::post('/achievement/store', [AchievementController::class, 'store'])->name('achievement.store');
Route::get('/achievement/edit/{id}', [AchievementController::class, 'edit'])->name('achievement.edit');
Route::Put('/achievement/update/{id}', [AchievementController::class, 'update'])->name('achievement.update');
Route::delete('/achievement/destroy/{id}', [AchievementController::class, 'destroy'])->name('achievement.destroy');
Route::post('/achievement-bulk-delete', [AchievementController::class, 'bulkDelete'])->name('achievement.bulkDelete');

// Route for language
Route::get('/language', [LanguageController::class, 'index'])->name('language.index');
Route::post('/language/store', [LanguageController::class, 'store'])->name('language.store');
Route::get('/language/edit/{id}', [LanguageController::class, 'edit'])->name('language.edit');
Route::Put('/language/update/{id}', [LanguageController::class, 'update'])->name('language.update');
Route::delete('/language/destroy/{id}', [LanguageController::class, 'destroy'])->name('language.destroy');
Route::post('/language-bulk-delete', [LanguageController::class, 'bulkDelete'])->name('language.bulkDelete');

// Route for Artist
Route::get('/artist', [ArtistController::class, 'index'])->name('artist.index');
Route::post('/artist/store', [ArtistController::class, 'store'])->name('artist.store');
Route::get('/artist/edit/{id}', [ArtistController::class, 'edit'])->name('artist.edit');
Route::Put('/artist/update/{id}', [ArtistController::class, 'update'])->name('artist.update');
Route::delete('/artist/destroy/{id}', [ArtistController::class, 'destroy'])->name('artist.destroy');
Route::post('/artist-bulk-delete', [ArtistController::class, 'bulkDelete'])->name('artist.bulkDelete');

// Route for Song Category
Route::get('/song/category', [SongCategoryController::class, 'index'])->name('song.category.index');
Route::post('/song/category/store', [SongCategoryController::class, 'store'])->name('song.category.store');
Route::get('/song/category/edit/{id}', [SongCategoryController::class, 'edit'])->name('song.category.edit');
Route::Put('/song/category/update/{id}', [SongCategoryController::class, 'update'])->name('song.category.update');
Route::delete('/song/category/destroy/{id}', [SongCategoryController::class, 'destroy'])->name('song.category.destroy');
Route::post('/song/category-bulk-delete', [SongCategoryController::class, 'bulkDelete'])->name('song.category.bulkDelete');

// Route for Song
Route::get('/song', [SongController::class, 'index'])->name('song.index');
Route::get('/song/create', [SongController::class, 'create'])->name('song.create');
Route::post('/song/store', [SongController::class, 'store'])->name('song.store');
Route::get('/song/edit/{id}', [SongController::class, 'edit'])->name('song.edit');
Route::get('/song/show/{id}', [SongController::class, 'show'])->name('song.show');
Route::post('/song/update/{id}', [SongController::class, 'update'])->name('song.update');
Route::delete('/song/destroy/{id}', [SongController::class, 'destroy'])->name('song.destroy');
Route::post('/song/bulk-delete', [SongController::class, 'bulkDelete'])->name('song.bulkDelete');
Route::get('/song/status/{id}', [SongController::class, 'status'])->name('song.status');
Route::get('/song/exclusive/{id}', [SongController::class, 'exclusive'])->name('song.exclusive');

// Route for Lyrics
Route::get('/lyrics/create/{id}', [LyricsController::class, 'createUpdate'])->name('lyrics.create.update');
Route::post('/lyrics/update/{id}', [LyricsController::class, 'update'])->name('lyrics.update');

// Route for Vocabulary
Route::get('/vocabulary/create/{id}', [VocabularyController::class, 'create'])->name('vocabulary.create');
Route::post('/vocabulary/create-update/{id}', [VocabularyController::class, 'createUpdate'])->name('vocabulary.create.update');


// Route for QIZ
Route::get('/qiz', [QizController::class, 'index'])->name('qiz.index');
Route::get('/qiz/edit/{id}', [QizController::class, 'edit'])->name('qiz.edit');
Route::get('/qiz/show/{id}', [QizController::class, 'show'])->name('qiz.show');
Route::Put('/qiz/update/{id}', [QizController::class, 'update'])->name('qiz.update');

// Route for Plan
Route::get('/plan', [PlanController::class, 'index'])->name('plan.index');
Route::post('/plan/store', [PlanController::class, 'store'])->name('plan.store');
Route::get('/plan/edit/{id}', [PlanController::class, 'edit'])->name('plan.edit');
Route::post('/plan/update/{id}', [PlanController::class, 'update'])->name('plan.update');
Route::delete('/plan/destroy/{id}', [PlanController::class, 'destroy'])->name('plan.destroy');

// Route for Plan Feature
Route::get('/plan-feature', [PlanFeatureController::class, 'index'])->name('plan.feature.index');
Route::post('/plan-feature/store', [PlanFeatureController::class, 'store'])->name('plan.feature.store');
Route::get('/plan-feature/edit/{id}', [PlanFeatureController::class, 'edit'])->name('plan.feature.edit');
Route::post('/plan-feature/update/{id}', [PlanFeatureController::class, 'update'])->name('plan.feature.update');
Route::delete('/plan-feature/destroy/{id}', [PlanFeatureController::class, 'destroy'])->name('plan.feature.destroy');

// user subscription route
Route::get('/user-subscription', [UserSubscriptionController::class, 'index'])->name('user.subscription.index');
Route::get('/user-subscription/destroy/{id}', [UserSubscriptionController::class, 'destroy'])->name('user.subscription.destroy');
Route::post('/user-subscription/bulk-delete', [UserSubscriptionController::class, 'bulkDelete'])->name('user.subscription.bulk.delete');

// user donation route
Route::get('/user-donation', [UserDonationController::class, 'index'])->name('user.donation.index');
Route::get('/user-donation/destroy/{id}', [UserDonationController::class, 'destroy'])->name('user.donation.destroy');

// Route for Faq
// Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
// Route::get('/faq/create', [FaqController::class, 'create'])->name('faq.create');
// Route::post('/faq/store', [FaqController::class, 'store'])->name('faq.store');
// Route::get('/faq/edit/{id}', [FaqController::class, 'edit'])->name('faq.edit');
// Route::patch('/faq/update/{id}', [FaqController::class, 'update'])->name('faq.update');
// Route::delete('/faq/destroy/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');
// Route::get('/faq/status/{id}', [FaqController::class, 'status'])->name('faq.status');

// Route for Contact Us
Route::get('/contact', [ContactUsController::class, 'index'])->name('contact.index');
Route::delete('/contact/destroy/{id}', [ContactUsController::class, 'destroy'])->name('contact.destroy');
Route::post('/contact/bulk-delete', [ContactUsController::class, 'bulkDelete'])->name('contact.bulkDelete');



Route::get('/contact-email', function () {
    return view('mail.contact');
});
