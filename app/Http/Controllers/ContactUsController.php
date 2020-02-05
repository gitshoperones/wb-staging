<?php

namespace App\Http\Controllers;

use App\Mail\ContactUs;
use App\Models\ContactUsRecord;
use Illuminate\Http\Request;
use App\Models\NewsLetterSubscription;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactUsRequest;
use App\Models\PageSetting;
use App\Helpers\NotificationContent;

class ContactUsController extends Controller
{
    public function index()
    {
        $pageSettings = PageSetting::fromPage('Contact us')->get();

        return view('contact-us.index', compact('pageSettings'));
    }

    public function store(ContactUsRequest $request)
    {
        if ($request->subscribe === 'on') {
            NewsLetterSubscription::firstOrCreate(['email' => $request->email]);
        }

        ContactUsRecord::create([
            'email' => $request->email,
            'message' => $request->message,
            'details' => [
                'name' => $request->name,
                'phone' => $request->phone,
                'source' => $request->source,
                'reason' => $request->reason,
            ],
        ]);

        $email_notification = (new NotificationContent)->getEmailContent('Contact Form', 'admin');

        Mail::to(config('mail.from.address'))->send(new ContactUs($request->all(), $email_notification));

        return redirect()->back()->with('success', true);
    }
}
