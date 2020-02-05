<?php
namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Vendor;
use App\Models\UserNotes;
use App\Models\Fee;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use App\Models\UserReference;
use App\Models\LocationVendor;
use App\Models\ExpertiseVendor;
use App\Models\UserActivationCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\NewsLetterSubscription;
use Illuminate\Support\Facades\Storage;
use App\Notifications\GenericNotification;
use App\Notifications\AccountEvaluationResult;
use App\Helpers\MultipleEmails;
use App\Helpers\MailChimp;
use App\Helpers\NotificationContent;
use Notification;

class StatusUpdateController extends Controller
{
    public function pendingUser($id)
    {
        $user = $this->saveStatus($id, "Pending status approve", 0);
        
        (new MailChimp)->manageTag($user->account, $user->email, 'Active', 'inactive');
        
        return redirect()->back();
    }

    public function deactivateUser($id, Request $request)
    {
        $user = $this->saveStatus($id, $request->deactivate, 3);
        
        (new MailChimp)->manageTag($user->account, $user->email, 'Active', 'inactive');

        return redirect()->back();
    }

    public function denyUser($id, Request $request)
    {
        $user = $this->saveStatus($id, $request->deny, 3);
        
        (new MailChimp)->manageTag($user->account, $user->email, 'Active', 'inactive');

        return redirect()->back();
    }

    public function archive($id, Request $request)
    {
        $user = $this->saveStatus($id, $request->reason, 3);

        (new MailChimp)->manageTag($user->account, $user->email, 'Active', 'inactive');

        return redirect()->back();
    }

    public function approveEmailToPending($id, Request $request)
    {
        $user = $this->saveStatus($id, $request->approve, 0);

        $vendorNotifyEmails = (new MultipleEmails)->getMultipleEmails($user);
        $email_notification = (new NotificationContent)->getEmailContent('Account Pending', 'vendor');
        Mail::to($vendorNotifyEmails)->send(new WelcomeEmail($user, $email_notification));
        
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('Account Pending', 'vendor');
        foreach ($dashboard_notifications as $dashboard_notification) {
            $dashboard_notification->button_link = sprintf('/vendors/%s/edit', $user->vendorProfile->id);
            $user->notify(new GenericNotification([
                'title' => $dashboard_notification->subject,
                'body' => $dashboard_notification->body,
                'btnLink' => $dashboard_notification->button_link,
                'btnTxt' => $dashboard_notification->button
            ]));
        }

        (new MailChimp)->manageTag($user->account, $user->email, 'Active', 'inactive');

        return redirect()->back();
    }

    public function activateCoupleAccount($id, Request $request)
    {
        $user = $this->saveStatus($id, $request->approve, 1);
        $email_notification = (new NotificationContent)->getEmailContent('Email Verified', 'couple');

        Mail::to($user->email)->send(new WelcomeEmail($user, $email_notification));

        return redirect()->back();
    }

    public function approveCoupleAccount($id, Request $request)
    {
        $user = $this->saveStatus($id, $request->approve, 1);

        return redirect()->back();
    }

    public function saveVendorDetails($id, Request $request)
    {
        $vendor = Vendor::where('user_id', $id)->firstOrFail();
        $vendor->onboarding = 1;
        $vendor->save();
        $vendorUser = $vendor->user;

        $user = $this->saveStatus($id, $request->approve, 1);

        // send email notification
        $vendorNotifyEmails = (new MultipleEmails)->getMultipleEmails($user);
        $email_notification = (new NotificationContent)->getEmailContent('Account Approved', 'vendor');
        Notification::route('mail', $vendorNotifyEmails)->notify(new AccountEvaluationResult($user, $email_notification));

        $dashboard_notifications = (new NotificationContent)->getNotificationContent('Account Approved', 'vendor');
        foreach ($dashboard_notifications as $dashboard_notification) {
            $vendorUser->notify(new GenericNotification([
                'title' => $dashboard_notification->subject,
                'body' => $dashboard_notification->body,
                'btnLink' => $dashboard_notification->button_link,
                'btnTxt' => $dashboard_notification->button
            ]));
        }

        UserActivationCode::where('user_id', $vendorUser->id)->delete();

        if (!$vendor->fee()->first()) {
            $fee = Fee::where('type', 'default')->where('status', 1)->first();
    
            $vendor->fee()->create(['fee_id' => $fee->id]);
        }
        

        (new MailChimp)->manageTag($user->account, $user->email, 'Active', 'active');

        return redirect()->back();
    }

    private function saveStatus($id, $notes, $stat)
    {
        $approved = User::where('id', $id)->update(['status' => $stat]);

        UserNotes::create([
            'user_id' => $id,
            'description' => $notes,
            'account_id' => Auth::user()->id
        ]);

        $user = User::where('id', $id)->firstOrFail();

        if ($stat === 2) {
            NewsLetterSubscription::whereEmail($user->email)->delete();
        }

        return $user;
    }
}
