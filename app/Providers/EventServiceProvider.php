<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Notifications\Events\NotificationSent' => [
            'App\Listeners\ClearCachedNotifications',
        ],
        'App\Events\CoupleSentPayment' => [
            'App\Listeners\UpdateJobQuoteMileStoneStatus',
            'App\Listeners\UpdateInvoiceStatus',
            'App\Listeners\SendPaymentNotification',
        ],
        'App\Events\NewUserSignedUp' => [
            'App\Listeners\SendAfterSignupEmailVerification',
            'App\Listeners\SendAfterSignupNotifications',
            'App\Listeners\NotifyAdminAfterUserSignup',
        ],
        'App\Events\NewJobPosted' => [
            'App\Listeners\NotifyAdminForNewJobPost',
        ],
        'App\Events\NewJobApproved' => [
            'App\Listeners\NotifyAdminForNewJobApproved',
            'App\Listeners\NotifyVendorsForNewJobApproved',
        ],
        'App\Events\CoupleSubmittedNewReview' => [
            'App\Listeners\NotifyVendorForNewReview',
        ],
        'App\Events\NewJobQuote' => [
            'App\Listeners\NotifyAdminNewJobQuote',
        ],
        'App\Events\AdminConfirmedBooking' => [
            'App\Listeners\NotifyAdminConfirmedBooking',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
