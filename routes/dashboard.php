<?php
    Route::prefix('/dashboard')->group(function () {
        Route::get('/', 'Dashboard\DashboardController@index');

        Route::get('/job-post-template/{id}', 'Dashboard\JobPostTemplatesController@show');

        Route::post('/refund/{invoiceId}', 'Dashboard\RefundsController@store');

        Route::get('/job-posts/extend-expiration/{id}', 'Dashboard\JobPostsController@extendExpiration');
        Route::get('/job-posts/draft', 'Dashboard\DraftJobPostsController@index');
        Route::get('/job-posts/live', 'Dashboard\LiveJobPostsController@index');
        Route::post('/messages/delete', 'Dashboard\MessagesController@deleteConvoMessage');
        Route::resource('/messages', 'Dashboard\MessagesController');
        Route::post('/message-new', 'Dashboard\MessagesController@messageNew');
        Route::resource('/job-posts', 'Dashboard\JobPostsController');
        Route::resource('/saved-jobs', 'Dashboard\SavedJobsController');
        Route::resource('/job-quotes', 'Dashboard\JobQuotesController');
        Route::resource('/favorite-vendors', 'Dashboard\FavoriteVendorsController');
        Route::get('/invoices-and-payments', 'Dashboard\InvoicesAndPaymentsController@index');
        Route::post('/send-payment-reminder/{invoiceId}', 'Dashboard\SendPaymentReminderController@store');

        Route::get('/job-posts/{jobPostId}/quotes', 'Dashboard\QuotesPerJobPostController@index');
        Route::get('/sent-quotes', 'Dashboard\SentQuotesController@index');
        Route::get('/draft-quotes', 'Dashboard\DraftQuotesController@index');
        Route::get('/reviews', 'Dashboard\ReviewsController@index');
        Route::get('/confirmed-bookings', 'ConfirmedBookingsController@index');
        Route::get('/received-quotes', 'Dashboard\ReceivedQuotesController@index');
        Route::get('/notifications', 'Dashboard\NotificationsController@index');
        Route::patch('/notifications/{id}', 'Dashboard\NotificationsController@update');
        Route::post('/markAll', 'Dashboard\NotificationsController@markAll');
        Route::get('/verify-business', 'Dashboard\BusinessVerificationController@index');
        Route::post('/verify-business', 'Dashboard\BusinessVerificationController@store');

        Route::patch('update-couple-avatar', 'CoupleAccountSettingsController@updateAvatar');

        Route::post('/request-vendor-review', 'VendorReviewsController@requestReview');
        Route::post('/submit-review', 'VendorReviewsController@submitReview');

        Route::patch('/job-quotes/{jobQuoteId}/withdraw', 'Dashboard\WithdrawJobQuoteController@update');
    });

    Route::resource('users', 'UsersController');
    Route::resource('payments', 'PaymentsController');
    Route::get('payments/thanks', 'PaymentsController@show');

    Route::get('/invoice/{invoice}/pdf', 'PdfInvoiceGeneratorController@create');

    Route::post('payment-gateway-auth-token', 'PaymentGatewayAuthTokenController@store');
    Route::patch('/job-quotes/{jobQuote}/response', 'JobQuoteResponseController@update');

    Route::patch('conversation/{id}/mark-as-read', 'MarkConversationAsReadController@update');

    Route::delete('terms-and-conditions/{id}', 'TermsAndConditionsController@destroy');
    Route::post('terms-and-conditions', 'TermsAndConditionsController@store');

    Route::post('vendor-payment-settings', 'VendorPaymentSettingsController@store');

    Route::patch('vendor-account-settings', 'VendorAccountSettingsController@update');
    Route::patch('couple-account-settings', 'CoupleAccountSettingsController@update');

    Route::patch('notification-settings', 'NotificationSettingsController@update');

    Route::get('/user-settings/{setting?}', 'UserSettingsController@index');
