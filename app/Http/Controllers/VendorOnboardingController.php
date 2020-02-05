<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vendor;
use Illuminate\Support\Str;
use App\Mail\RequestForReview;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\SetupVendorReview;
use App\Http\Requests\VendorOnboardingRequest;
use App\Helpers\NotificationContent;
use App\Helpers\MailChimp;

class VendorOnboardingController extends Controller
{
    public function store(VendorOnboardingRequest $request)
    {
        $user = Auth::user();

        $user->update([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'phone_number' => $request->phone_number,
        ]);

        $vendor = Vendor::where('user_id', $user->id)->first();
        $vendor->update($request->all() + ['onboarding' => 1]);

        if ($request->couple1_email) {
            $review = $vendor->reviews()->create([
                'code' => Str::random(10).time(),
                'reviewer_email' => $request->couple1_email,
                'reviewer_name' => $request->couple1_name,
            ]);
            Mail::to($request->couple1_email)->send(new RequestForReview($review, $vendor));
        }

        if ($request->couple2_email) {
            $review = $vendor->reviews()->create([
                'code' => Str::random(10).time(),
                'reviewer_email' => $request->couple2_email,
                'reviewer_name' => $request->couple2_name,
            ]);
            Mail::to($request->couple2_email)->send(new RequestForReview($review, $vendor));
        }

        if (!$request->couple1_email && !$request->couple2_email) {
            $dashboard_notifications = (new NotificationContent)->getNotificationContent('Email Verified - Review', 'vendor');
            foreach($dashboard_notifications as $dashboard_notification) {
                Auth::user()->notify(new SetupVendorReview([
                    'title' => $dashboard_notification->subject,
                    'body' => $dashboard_notification->body,
                    'btnText' => $dashboard_notification->button,
                ]));
            }
        }

        // UPDATE FIRST AND LAST NAME ON MAILCHIMP
        $list_id = env('MAILCHIMP_LIST_BUSINESS', '2206f03c63');
        $email = md5($user->email);
        
        $url = "https://us16.api.mailchimp.com/3.0/lists/$list_id/members/";
        $url_update = "https://us16.api.mailchimp.com/3.0/lists/$list_id/members/$email";
        $data = array(
            'email_address' => $user->email,
            'status'        => ($user->newsletter) ? 'subscribed' : 'unsubscribed',
            'merge_fields'  => array(
                'FNAME'       => $request->fname,
                'LNAME' => $request->lname,
                'BNAME' => $request->business_name
            ),
        );

        (new MailChimp)->mailchimp_request($url, $data);
        (new MailChimp)->mailchimp_request($url_update, $data, 'patch');

        return redirect(sprintf('vendors/%s/edit?status=pending', $vendor->id));
    }
}
