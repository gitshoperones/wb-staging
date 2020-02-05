<?php

namespace App\Console\Commands;

use App\Models\Offer;
use App\Models\Vendor;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Notifications\OfferExpirationReminder as OfferExpirationNotification;
use App\Helpers\MultipleEmails;
use App\Helpers\NotificationContent;
use Notification;

class OfferExpirationReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wedbooker:offerExpirationReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify businesses with expiring Job Offers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $expiredOffers = Offer::whereDate('end_date', Carbon::yesterday()->toDateString())
            ->where(function($q){
                $q->where('heading', '<>', null)
                    ->orWhere('description', '<>', null);
            })
            ->with(['user'])->get(['vendor_id']);
            
        $email_notification = (new NotificationContent)->getEmailContent('Offer Expired', 'vendor');
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('Offer Expired', 'vendor');

        foreach ($expiredOffers as $vendors) {
            $emails = ($vendors->vendor->user->account == "vendor") ? (new MultipleEmails)->getMultipleEmails($vendors->vendor->user) : $vendors->vendor->user->email;
            
            Notification::route('mail', $emails)->notify(new OfferExpirationNotification(
                [
                    'title' => $email_notification->subject,
                    'body' => $email_notification->body,
                    'btnLink' => sprintf('/vendors/%s/edit?', $vendors->vendor->id),
                    'btnTxt' => $email_notification->button
                ],
                $vendors->vendor->user,
                $email_notification,
                $vendors->vendor->id,
                'email'
            ));

            foreach($dashboard_notifications as $dashboard_notification) {
                $data = [
                    'title' => $dashboard_notification->subject,
                    'body' => $dashboard_notification->body,
                    'btnLink' => sprintf('/vendors/%s/edit?', $vendors->vendor->id),
                    'btnTxt' => $dashboard_notification->button
                ];

                $vendors->vendor->user->notify(new OfferExpirationNotification(
                    $data,
                    $vendors->vendor->user,
                    $email_notification,
                    $vendors->vendor->id,
                    'dashboard'
                ));
            }
        }
    }
}
