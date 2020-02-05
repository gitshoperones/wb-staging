<?php

namespace App\Http\Controllers\Auth;

use App\Mail\NewUserSignup;
use Illuminate\Http\Request;
use App\Repositories\UserRepo;
use App\Events\NewUserSignedUp;
use App\Helpers\ActivationCode;
use App\Mail\EmailVerification;
use Illuminate\Validation\Rule;
use App\Repositories\CoupleRepo;
use App\Repositories\VendorRepo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\NewsLetterSubscription;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\PageSetting;
use Jenssegers\Agent\Agent;
use App\Helpers\MailChimp;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $pageSettings = PageSetting::fromPage('Sign up')->get();

        $agent = new Agent();
        if(request()->type == 'vendor') {
            session(['_old_input.account' => 'vendor']);
        } elseif(request()->type == 'couple') {
            session(['_old_input.account' => 'couple']);
        } else {
            session(['_old_input.account' => '']);
        }
        return view('auth.register', compact('pageSettings', 'agent'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $agent = new Agent();

        if ($agent->isMobile()) {
            $validations = [
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|max:100',
                'account' => ['required', Rule::in(['vendor', 'couple'])],
                'accept_tc' => 'required',
            ];

            $customErrorMessages = [
                'accept_tc.*' => 'Please confirm that you accept the Terms and Conditions and Privacy Policy.',
            ];
        } else {
            $validations = [
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|confirmed|string|min:6|max:100',
                'account' => ['required', Rule::in(['vendor', 'couple'])],
                'accept_tc' => 'required',
            ];

            $customErrorMessages = [
                'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
                'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact hello@wedbooker.com.',
                'accept_tc.*' => 'Please confirm that you accept the Terms and Conditions and Privacy Policy.',
            ];
    
            if (config('app.env') === 'production') {
                $validations['g-recaptcha-response'] = 'required|captcha';
            }
        }

        return Validator::make($data, $validations, $customErrorMessages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $list_id = ($data['account'] == 'couple') ? env('MAILCHIMP_LIST_COUPLE', '6f3b22af8f') : env('MAILCHIMP_LIST_BUSINESS', '2206f03c63');
        $tag_name = ($data['account'] == 'couple') ? 'Couple Signed Up' : 'Business Signed Up';
        
        // ADDING THE USER TO MAILCHIMP
        $url = "https://us16.api.mailchimp.com/3.0/lists/$list_id/members/";
        $data_ml = array(
            'email_address' => $data['email'],
            'status'        => 'subscribed'
        );
        (new MailChimp)->mailchimp_request($url, $data_ml);

        // ADDING TAG TO THE USER IN MAILCHIMP
        (new MailChimp)->manageTag($data['account'], $data['email'], $tag_name, 'active');
        
        if (isset($data['subscribe'])) {
            NewsLetterSubscription::firstOrCreate(['email' => $data['email']]);
        }else {
            $email = md5($data['email']);
            $url_update = "https://us16.api.mailchimp.com/3.0/lists/$list_id/members/$email";
            $data_ml['status'] = 'unsubscribed';
    
            (new MailChimp)->mailchimp_request($url_update, $data_ml, 'patch');
        }

        $user = (new UserRepo)->create($data);

        if ($data['account'] === 'couple') {
            (new CoupleRepo)->create(['user_id' => $user->id]);
        }

        if ($data['account'] === 'vendor') {
            (new VendorRepo)->create(['user_id' => $user->id]);
        }

        event(new NewUserSignedUp($user));

        return $user;
    }
}
