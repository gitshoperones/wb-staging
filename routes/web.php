<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/register', function () {
    abort(404);
});

Route::get('/vendors/{vendor}', 'VendorsController@show');
Route::resource('/job-posts', 'JobPostsController');
Route::post('/is-loggin', 'JobPostsController@isLoggin')->name('is-loggin');
Route::get('/job-post-template/{id}', 'JobPostTemplatesController@show');
Route::post('/news-letter-subscriptions/unsubscribe', 'NewsLetterSubscriptionsController@unsubscribe');
Route::post('/news-letter-subscriptions/subscribe', 'NewsLetterSubscriptionsController@subscribe');

Route::middleware('throttle:60,1')->group(function () {
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    Route::get('/logout', 'Auth\LoginController@logout');
    Route::get('/sign-up', 'Auth\RegisterController@showRegistrationForm');
    Route::get('/suppliers-and-venues', 'VendorsController@index');
    Route::post('/verify-email/resend', 'EmailVerificationController@store');
    Route::get('/verify-email/{code}', 'EmailVerificationController@index');
    Route::get('/vendor-review/{code}', 'VendorReviewsController@create');
    Route::post('/vendor-review', 'VendorReviewsController@store');
});

Route::middleware(['web', 'auth', 'throttle:60,1'])->group(function () {
    Route::patch('/vendors/{vendor}', 'VendorsController@update');
    Route::get('/vendors/{vendor}/edit', 'VendorsController@edit');

    Route::post('/vendor-onboarding', 'VendorOnboardingController@store');
    Route::post('/couple-onboarding', 'CoupleOnboardingController@store');

    Route::get('/impersonation/leave', 'Admin\ImpersonationController@leave');
    Route::get('/impersonation/{id}', 'Admin\ImpersonationController@impersonate');

    Route::resource('media', 'MediaController');
    Route::resource('file', 'FileController');
    Route::resource('package', 'PackagesController');

    Route::delete('user-card-accounts/{id}', 'UserCardAccountsController@destroy');

    Route::get('/sign-up/{account}/MSnsIKU90hNmIKe', function () {
        return view('analytics.index');
    })->name('analytics');

    Route::get('/business-settings', 'UserBusinessSettingsController@edit');
    Route::patch('/business-settings', 'UserBusinessSettingsController@update');
});

Route::get('faqs', 'PagesController@faqs');
Route::get('about-us', 'PagesController@aboutUs');
Route::get('fees', 'PagesController@fees');
Route::get('list-your-business', 'PagesController@listYourBusiness');
Route::get('contact-us', 'ContactUsController@index');
Route::post('contact-us/send', 'ContactUsController@store');
Route::get('how-it-works', 'PagesController@howItWorks');
Route::get('how-it-works-businesses', 'PagesController@howItWorksBusinesses');
Route::get('privacy-policy', 'PagesController@privacyPolicy');
Route::get('review-policy', 'PagesController@reviewPolicy');
Route::get('content-policy', 'PagesController@contentPolicy');
Route::get('terms-and-conditions', 'TermsAndConditionsController@index');
Route::get('community-guidelines', 'PagesController@communityGuidelines');
Route::get('planning-checklist', 'PagesController@checklist');
Route::post('planning-checklist', 'PagesController@subscribe');
