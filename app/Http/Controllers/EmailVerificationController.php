<?php

namespace App\Http\Controllers;

use App\Helpers\ActivationCode;
use App\Mail\EmailVerification;
use App\Mail\WelcomeEmail;
use App\Models\UserActivationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Helpers\NotificationContent;

class EmailVerificationController extends Controller
{
    public function index($code)
    {
        Auth::logout();

        $activation = UserActivationCode::whereCode($code)->firstOrFail();
        $user = $activation->user;

        if ($user->account === 'vendor') {
            $user->status = 'pending';
        } else {
            $user->status = 'active';
        }

        $user->update();
        $activation->delete();

        Auth::login($user);

        $email_notification = (new NotificationContent)->getEmailContent('Email Verified', ($user->account === 'vendor') ? 'vendor' : 'couple');

        Mail::to($user->email)->send(new WelcomeEmail($user, $email_notification));

        return redirect()->route('analytics', $user->account);
    }

    public function store()
    {
        $user = Auth::user();
        $activation = $user->activationCode;

        if (!$activation) {
            $activation = (new ActivationCode)->create()->assignTo($user);
        }

        $email_notification = (new NotificationContent)->getEmailContent('New User Sign Up', 'vendor,couple');

        Mail::to($user->email)->send(new EmailVerification($activation->code, $user, $email_notification));

        return redirect()->back()->with('success_message', 'Verification Email Sent.');
    }
}
