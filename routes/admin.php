<?php

    Route::prefix('/admin')->group(function () {
        Route::resource('/pages', 'Admin\PagesController');
        Route::get('/businesses/reviews', 'Admin\BusinessesReviewsController@index');
        Route::get('/businesses/{vendorId}/reviews', 'Admin\BusinessesReviewsController@show');
        Route::delete('/businesses/{vendorId}/reviews/{id}', 'Admin\BusinessesReviewsController@destroy');
        Route::get('/businesses/{vendorId}/reviews/{id}', 'Admin\BusinessesReviewsController@showReview');
        Route::get('/pages/{id}/page-settings', 'Admin\PageSettingsController@index');
        Route::post('/pages/{id}/page-settings', 'Admin\PageSettingsController@store');
        Route::get('/pages/{id}/page-settings/create', 'Admin\PageSettingsController@create');
        Route::get('/pages/{pageId}/page-settings/{pageSetting}/edit', 'Admin\PageSettingsController@edit');
        Route::patch('/page-settings/{pageSetting}', 'Admin\PageSettingsController@update');
        Route::delete('/page-settings/{pageSetting}', 'Admin\PageSettingsController@destroy');
        Route::patch('/page-settings/{page}/order', 'Admin\PageSettingsController@updateOrder');
        Route::get('/vendors/ordering', 'Admin\VendorOrderingController@index');
        Route::patch('/vendors/ordering', 'Admin\VendorOrderingController@massUpdate');
        Route::patch('/vendors/ordering/{id}', 'Admin\VendorOrderingController@update');
        Route::get('/generate-note', 'Admin\UserManagementController@generatenote');

        //notification
        Route::get('/automated-notifications', 'Admin\AutomatedNotificationController@index');
        Route::get('/automated-notifications/{id}/edit', 'Admin\AutomatedNotificationController@edit');
        Route::patch('/automated-notifications/{id}/update', 'Admin\AutomatedNotificationController@update');
        Route::post('/automated-notifications/order', 'Admin\AutomatedNotificationController@updateOrder');
        Route::post('/automated-notifications-filter', 'Admin\AutomatedNotificationController@filterBy');

        Route::get('/emails', 'Admin\EmailNotificationsController@index');
        Route::get('/emails/{id}/edit', 'Admin\EmailNotificationsController@edit');
        Route::post('/emails/{id}/update', 'Admin\EmailNotificationsController@update');

        Route::get('/email-templates', 'Admin\EmailTemplatesController@index');
        Route::get('/email-templates/{id}/edit', 'Admin\EmailTemplatesController@edit');
        Route::post('/email-templates/{id}/update', 'Admin\EmailTemplatesController@update');

        Route::get('/dashboard-notifications', 'Admin\DashboardNotificationController@index');
        Route::get('/dashboard-notifications/{id}/edit', 'Admin\DashboardNotificationController@edit');
        Route::post('/dashboard-notifications/{id}/update', 'Admin\DashboardNotificationController@update');
        //end notification
        
        Route::get('/', 'Admin\AdminDashboardController@index');
        Route::get('/admin_notification/{id}', 'Admin\AdminDashboardController@show');
        Route::put('/admin_notification/{id}', 'Admin\AdminDashboardController@update');
        Route::get('/assign-template-category', 'Admin\AssignTemplateCategoryController@create');
        Route::patch('/assign-template-category', 'Admin\AssignTemplateCategoryController@update');
        Route::resource('job-post-templates', 'Admin\JobPostTemplatesController');
        Route::get('/fees/vendor/{id}', 'Admin\VendorFeesController@show');
        Route::patch('/fees/vendor', 'Admin\VendorFeesController@update');
        Route::resource('fees', 'Admin\FeesController');
        Route::resource('parent-accounts', 'Admin\ParentAccountsController');
        Route::get(
            'parent-accounts/{parentVendorId}/save-child-accounts/{childVendorId}',
            'Admin\ParentAccountsController@saveParentChildAccount'
        );
        Route::get(
            'parent-accounts/{parentVendorId}/view-child-accounts',
            'Admin\ParentAccountsController@viewChildAccounts'
        );
        Route::get(
            'parent-accounts/{parentVendorId}/remove-child-accounts/{childVendorId}',
            'Admin\ParentAccountsController@removeParentChildAccount'
        );
        Route::get('parent-accounts/{parentVendorId}/add-child-accounts', 'Admin\ParentAccountsController@addChildAccounts');
        Route::get('parent-accounts/{id}/view-child-accounts', 'Admin\ParentAccountsController@viewChildAccounts');

        //Management
        Route::get('/management', 'Admin\ManagementController@index');
        Route::resource('categories', 'Admin\CategoriesController');
        Route::get('/job-posts', 'Admin\JobPostsController@index');
        Route::get('/job-quotes', 'Admin\JobQuotesController@index');
        Route::get('/job-quotes/{id}', 'Admin\JobQuotesController@show');
        Route::delete('job-quotes/{job_quote}', 'Admin\JobQuotesController@destroy');
        Route::get('/confirmed-bookings', 'Admin\ConfirmedBookingsController@index');
        Route::patch('/confirmed-bookings/{invoice}/cancel', 'Admin\ConfirmedBookingsController@cancel');
        Route::patch('/confirmed-bookings/{invoice}/refund', 'Admin\ConfirmedBookingsController@refund');
        Route::get('/expired-jobs', 'Admin\ExpiredJobPostsController@index');
        Route::get('/deleted-job-posts', 'Admin\DeletedJobPostsController@index');
        Route::resource('/pending-job-posts', 'Admin\PendingJobPostsController')->only(['index', 'show', 'update', 'destroy']);
        Route::post('/restore-job-posts/{id}', 'Admin\DeletedJobPostsController@restore');
        Route::get('export-job-posts/{type}', 'Admin\ExportController@exportJobManagementRecords');
        Route::get('export-job-quotes', 'Admin\ExportController@exportJobQuoteRecords');
        Route::get('export-confirmed-bookings', 'Admin\ExportController@exportConfirmedBookingsRecords');

        //USER MANAGEMENT
        Route::post('/note/{id}', 'Admin\UserManagementController@saveNote');
        Route::post('/reference/{id}', 'Admin\UserManagementController@saveReference');
        Route::get('/delete-user/{id}/{route}', 'Admin\UserManagementController@deleteUser');

        Route::get('/couple/{type}', 'Admin\UserManagementController@coupleUsers');
        Route::post('/couple/{type?}', 'Admin\UserManagementController@coupleUsers');
        Route::get('/vendors/{type?}', 'Admin\UserManagementController@vendorUsers');
        Route::post('/vendors/{type?}', 'Admin\UserManagementController@vendorUsers');

        Route::get('/newsletter/{id}/{type?}', 'Admin\UserManagementController@newsletterUpdate');

        Route::get('/vendor/{id}', 'Admin\UserManagementController@businessDetails');
        Route::get('/vendor/{id}/{view}', 'Admin\UserManagementController@businessDetails');
        Route::get('/parent/{id}', 'Admin\UserManagementController@businessDetails');
        Route::get('/parent/{id}/{view}', 'Admin\UserManagementController@businessDetails');
        Route::get('/business/{id}', 'Admin\UserManagementController@businessDetails');
        Route::get('/business/{id}/{view}', 'Admin\UserManagementController@businessDetails');
        Route::get('/couple/{id}', 'Admin\UserManagementController@vendorDetails');
        Route::get('/couple/{id}/{view}', 'Admin\UserManagementController@vendorDetails');

        Route::get('/verify-user/{id}', 'Admin\UserManagementController@verifyUser');


        Route::post('/pending', 'Admin\UserManagementController@searchDetails');

        Route::post('/update-user/{id}', 'Admin\UserManagementController@updateUser');

        Route::get('/pending-user/{id}', 'Admin\StatusUpdateController@pendingUser');
        Route::post('/deny/{id}', 'Admin\StatusUpdateController@denyUser');
        Route::post('/archive/{id}', 'Admin\StatusUpdateController@archive');
        Route::post('/deactivate/{id}', 'Admin\StatusUpdateController@deactivateUser');
        Route::post('/approve/{id}', 'Admin\StatusUpdateController@saveVendorDetails');
        Route::post('/approve-couple/{id}', 'Admin\StatusUpdateController@approveCoupleAccount');
        Route::post('/approve-email/{id}', 'Admin\StatusUpdateController@approveEmailToPending');
        Route::post('/activate-couple-account/{id}', 'Admin\StatusUpdateController@activateCoupleAccount');

        Route::post('/store', 'Admin\UserManagementController@store');
        Route::get('/export-users/{accountType}', 'Admin\ExportController@exportUser');
        Route::post('/upload-user-files/{userId}', 'Admin\UploadUserFilesController@store');

        Route::get('/accounts', 'Admin\AccountManagementController@index');
        Route::post('/accounts', 'Admin\AccountManagementController@store');
        Route::delete('/accounts/{id}', 'Admin\AccountManagementController@destroy');
        Route::get('/accounts/create', 'Admin\AccountManagementController@create');
        Route::get('/account/add', 'Admin\AccountManagementController@add');
        Route::get('/update/{id}', 'Admin\AccountManagementController@update');
        Route::post('/update/{id}', 'Admin\AccountManagementController@update');

        // Route::patch('/users/{id}/archive', 'Admin\ArchiveUsersController@update');

        Route::get('contact-us/{filter?}', 'Admin\ContactUsController@index');
        Route::resource('contact-us', 'Admin\ContactUsController')->only('update', 'destroy');
        Route::get('export-contact-us', 'Admin\ExportController@exportContactUsRecords');

        Route::resource('refund-request', 'Admin\RefundRecordController')
            ->parameters(['refund-request' => 'refundRecord'])
            ->only('index', 'update', 'destroy');
        Route::get('export-refund-requests', 'Admin\ExportController@exportRefundRequestRecords');

        Route::get('/database-backup', 'Admin\DatabaseBackupController@create');
        Route::post('/database-backup', 'Admin\DatabaseBackupController@store');

        Route::resource('notifications', 'Admin\NotificationsController');
    });
