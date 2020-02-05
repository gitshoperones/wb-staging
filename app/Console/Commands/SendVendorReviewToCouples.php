<?php

namespace App\Console\Commands;

use App\Models\JobQuote;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Mail\AddVendorReviewEmail;
use Illuminate\Support\Facades\Mail;
use App\Notifications\AddVendorReview;
use App\Helpers\NotificationContent;

class SendVendorReviewToCouples extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wedbooker:sendVendorReviewToCouples';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send vendor review to couples 7 days after their event date.';

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

        $jobQuotes = JobQuote::whereStatus(3)
        ->with([
            'user' => function ($q) {
                $q->addSelect(['id', 'email'])->with(
                    [
                    'vendorProfile' => function ($q) {
                        return $q->addSelect(['id', 'user_id', 'business_name']);
                    }]
                );
            },
            'jobPost' => function ($q) {
                $q->addSelect(['id', 'user_id', 'event_date'])->with(
                    [
                    'user' => function ($q) {
                        return $q->addSelect(['id', 'email'])->with(['coupleA', 'coupleB']);
                    }]
                );
            }])
        ->whereHas('jobPost', function ($q) {
            $date = Carbon::today()->subDays(7)->format('Y-m-d');
            $q->where('event_date', $date);
        })->get();

        foreach ($jobQuotes as $jobQuote) {
            if ($jobQuote->jobPost->user->coupleA) {
                $couple = $jobQuote->jobPost->user->coupleA;
            } else {
                $couple = $jobQuote->jobPost->user->coupleB;
            }

            $review = $jobQuote->user->vendorProfile->reviews()->create([
                'code' => Str::random(10).time(),
                'reviewer_email' => $jobQuote->jobPost->user->email,
                'reviewer_name' => $couple->title,
            ]);

            $email_notification = (new NotificationContent)->getEmailContent('Send Vendor Review To Couples', 'couple');

            Mail::to($jobQuote->jobPost->user)->send(new AddVendorReviewEmail(
                [
                    'coupleTitle' => $couple->title,
                    'vendorTitle' => $jobQuote->user->vendorProfile->business_name,
                    'jobQuoteId' => $jobQuote->id,
                    'code' => $review->code,
                ],
                $email_notification
            )); // couple - email notif

            $dashboard_notifications = (new NotificationContent)->getNotificationContent('Send Vendor Review To Couples', 'couple');
            foreach($dashboard_notifications as $dashboard_notification) {
                $jobQuote->jobPost->user->notify(new AddVendorReview([
                    'title' => sprintf('How do you rate %s?', $jobQuote->user->vendorProfile->business_name),
                    'body' => $dashboard_notification->body,
                    'btnTxt' => $dashboard_notification->button,
                    'jobQuoteId' => $jobQuote->id,
                    'code' => $review->code,
                ])); // couple - dashboard notif
            }
        }
    }
}
