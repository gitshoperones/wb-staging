<?php

namespace App\Http\Controllers;

use App\Models\Couple;
use App\Models\Category;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCoupleOnboardingRequest;
use App\Helpers\MailChimp;

class CoupleOnboardingController extends Controller
{
    public function store(StoreCoupleOnboardingRequest $request)
    {
        $user = Auth::user();

        $user->update([
            'lname' => $request->userA_lname,
            'fname' => $request->userA_fname,
            'phone_number' => $request->phone_number,
            // 'dob' => Carbon::createFromFormat('Y-m-d', $request->dob)->toDateTimeString(),
        ]);

        $couple = Couple::where('userA_id', $user->id)->firstOrFail();
        $services = ($request->categories) ? Category::whereIn('name', $request->categories)->pluck('id')->toArray() : null;

        $couple->update([
            'title' => sprintf('%s & %s', $user->fname, $request->userB_fname),
            'partner_firstname' => $request->userB_fname,
            'partner_surname' => $request->userB_lname,
            'services' => ($services) ? json_encode($services) : $services,
            'onboarding' => 1,
        ]);

        // UPDATE FIRST AND LAST NAME ON MAILCHIMP
        $list_id = env('MAILCHIMP_LIST_COUPLE', '6f3b22af8f');
        $email = md5($user->email);
        
        $url = "https://us16.api.mailchimp.com/3.0/lists/$list_id/members/";
        $url_update = "https://us16.api.mailchimp.com/3.0/lists/$list_id/members/$email";
        $data = array(
            'email_address' => $user->email,
            'status'        => ($user->newsletter) ? 'subscribed' : 'unsubscribed',
            'merge_fields'  => array(
                'FNAME'       => $request->userA_fname,
                'LNAME' => $request->userA_lname,
            ),
        );

        (new MailChimp)->mailchimp_request($url, $data);
        (new MailChimp)->mailchimp_request($url_update, $data, 'patch');

        return redirect('/dashboard');
    }
}
