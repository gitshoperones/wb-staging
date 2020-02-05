<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use Illuminate\Console\Command;
use App\Notifications\PaymentReminder;
use App\Helpers\NotificationContent;

class BalanceDueReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wedbooker:balanceDueReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind couples to pay balance 2 days ahead of due date.';

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
        $invoices = Invoice::where('status', 0)->whereDate('next_payment_date', now()->addDays(2)->format('Y-m-d'))
            ->with([
                'vendor' => function ($q) {
                    $q->addSelect(['id', 'user_id', 'business_name']);
                },
                'couple' => function ($q) {
                    $q->addSelect(['id', 'userA_id', 'userB_id', 'title']);
                },
                'jobQuote' => function ($q) {
                    $q->with(['jobPost' => function ($q) {
                        $q->with(['user', 'category']);
                    }]);
                }
            ])->get();

        $email_notification = (new NotificationContent)->getEmailContent('Balance Due Reminder', 'couple');
       
        foreach ($invoices as $invoice) {
            $couple = $invoice->jobQuote->jobPost->user;
            $email_notification_subject = str_replace('[business_name]', ucwords(strtolower(isset($invoice->vendor->business_name) ? $invoice->vendor->business_name : '')), $email_notification->subject);
            $email_notification_body = str_replace('[business_name]', ucwords(strtolower(isset($invoice->vendor->business_name) ? $invoice->vendor->business_name : '')), $email_notification->body);
            $email_notification_body = str_replace('[category_name]', isset($invoice->jobQuote->jobPost->category->name) ? $invoice->jobQuote->jobPost->category->name : '', $email_notification_body);
            
            $couple->notify(new PaymentReminder([
                'title' => $email_notification_subject,
                'body' => $email_notification_body,
                'btnLink' => url(sprintf('payments/create?invoice_id=%s', $invoice->id)),
                'btnTxt' => $email_notification->button
            ], $couple, 'email'));
        }

        $dashboard_notifications = (new NotificationContent)->getNotificationContent('Balance Due Reminder', 'couple');
       
        foreach ($invoices as $invoice) {
            foreach($dashboard_notifications as $dashboard_notification) {
                $couple = $invoice->jobQuote->jobPost->user;
                $dashboard_notification_subject = str_replace('[business_name]', ucwords(strtolower(isset($invoice->vendor->business_name) ? $invoice->vendor->business_name : '')), $dashboard_notification->subject);
                $dashboard_notification_body = str_replace('[business_name]', ucwords(strtolower(isset($invoice->vendor->business_name) ? $invoice->vendor->business_name : '')), $dashboard_notification->body);
                $dashboard_notification_body = str_replace('[category_name]', isset($invoice->jobQuote->jobPost->category->name) ? $invoice->jobQuote->jobPost->category->name : '', $dashboard_notification_body);
                
                $couple->notify(new PaymentReminder([
                    'title' => $dashboard_notification_subject,
                    'body' => $dashboard_notification_body,
                    'btnLink' => url(sprintf('payments/create?invoice_id=%s', $invoice->id)),
                    'btnTxt' => $dashboard_notification->button
                ], $couple, 'dashboard'));
            }
        }
    }
}
