<?php

namespace App\Http\Controllers\Dashboard;

use Chat;
use App\Models\Invoice;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Notifications\PaymentReminder;
use App\Helpers\NotificationContent;

class SendPaymentReminderController extends Controller
{
    public function store($invoiceId)
    {
        $invoice = Auth::user()->vendorProfile->invoices()->with([
            'jobQuote' => function ($q) {
                $q->addSelect(['id', 'job_post_id'])->with([
                    'jobPost' => function ($q) {
                        $q->addSelect(['id', 'user_id'])->with(['user']);
                    }
                ]);
            }
        ])->whereId($invoiceId)->firstOrFail();

        $coupleUser = $invoice->jobQuote->jobPost->user;
        $coupleProfile = $coupleUser->coupleProfile();

        $email_notification = (new NotificationContent)->getEmailContent('Payment Reminder', 'couple');
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('Payment Reminder', 'couple');
        
        $email_notification->subject = str_replace('[business_name]', ucwords(strtolower(isset(Auth::user()->vendorProfile->business_name) ? Auth::user()->vendorProfile->business_name : '')), $email_notification->subject);
        $email_notification->body = str_replace('[business_name]', ucwords(strtolower(isset(Auth::user()->vendorProfile->business_name) ? Auth::user()->vendorProfile->business_name : '')), $email_notification->body);
        $email_notification->body = str_replace('[couple_title]', ucwords(strtolower(isset($coupleProfile->title) ? $coupleProfile->title : '')), $email_notification->body);

        $coupleUser->notify(new PaymentReminder([
            'title' => $email_notification->subject,
            'body' => $email_notification->body,
            'btnLink' => url(sprintf('payments/create?invoice_id=%s', $invoiceId)),
            'btnTxt' => $email_notification->button
        ], $coupleUser, 'email'));

        foreach($dashboard_notifications as $dashboard_notification) {
            $dashboard_notification->subject = str_replace('[business_name]', ucwords(strtolower(isset(Auth::user()->vendorProfile->business_name) ? Auth::user()->vendorProfile->business_name : '')), $dashboard_notification->subject);
            $dashboard_notification->body = str_replace('[business_name]', ucwords(strtolower(isset(Auth::user()->vendorProfile->business_name) ? Auth::user()->vendorProfile->business_name : '')), $dashboard_notification->body);
            $dashboard_notification->body = str_replace('[couple_title]', ucwords(strtolower(isset($coupleProfile->title) ? $coupleProfile->title : '')), $dashboard_notification->body);
            
            $coupleUser->notify(new PaymentReminder([
                'title' => $dashboard_notification->subject,
                'body' => $dashboard_notification->body,
                'btnLink' => url(sprintf('payments/create?invoice_id=%s', $invoice->id)),
                'btnTxt' => $dashboard_notification->button
            ], $coupleUser, 'dashboard'));
        }
        
        $this->sendMessage($coupleUser, $dashboard_notification->body);

        return redirect()->back()->with('modal_message', sprintf('Payment reminder sent to %s!', $coupleProfile->title));
    }

    public function sendMessage($coupleUser, $msg)
    {
        $conversation = Chat::getConversationBetween(Auth::id(), $coupleUser->id);

        if (!$conversation) {
            $participants = [Auth::user()->id, $coupleUser->id];
            $conversation = Chat::createConversation($participants);
        }

        Chat::conversations($conversation)->for(Auth::user())->readAll();

        $message = Chat::message($msg)
            ->from(Auth::user())
            ->to($conversation)
            ->send();

        $this->clearUsersCachedMessagesCount($conversation->users);

        return broadcast(new MessageSent($message, $conversation->id))->toOthers();
    }

    public function clearUsersCachedMessagesCount($users)
    {
        foreach ($users as $user) {
            if ($user->id !== Auth::user()->id) {
                Cache::forget(sprintf('cached-messages-count-%s', $user->id));
            }
        }
    }
}
