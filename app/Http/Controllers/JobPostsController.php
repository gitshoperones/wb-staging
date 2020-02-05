<?php

namespace App\Http\Controllers;

use App\Repositories\JobPostRepo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreJobPostRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use App\Models\NewsLetterSubscription;
use App\Repositories\CoupleRepo;
use App\Repositories\UserRepo;
use App\Events\NewUserSignedUp;
use Session;
use App\Models\PageSetting;
use Jenssegers\Agent\Agent;
use App\Helpers\MailChimp;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class JobPostsController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        return redirect('/');
    }

    public function create()
    {

        if(Auth::check()) {
            return redirect('/dashboard/' . request()->path() . "?" . request()->getQueryString());
        }

        $pageSettings = PageSetting::fromPage('Sign up')->get();
        $agent = new Agent();
        
        return view('job-posts.guest.create', compact('pageSettings', 'agent'));
    }

    public function isLoggin(Request $request)
    {
        if (empty($request->emailLog) || empty($request->passwordLog) ) {
            return response()->json([
                'message' => 'Please input email or passwrod.',
                'is_found' => null
            ]);
        }

        $user = User::where('email', $request->emailLog)->first();
        if (!empty($user)) {
            if (Hash::check($request->passwordLog, $user->password)) {
                return response()->json([
                    'is_found' => true,
                    'message' => 'account exists',
                ]);
            } else {
                return response()->json([
                    'is_found' => false,
                    'message' => 'Your Email or Password is incorrect',
                ]);
            }
        } else {
            return response()->json([
                'is_found' => false,
                'message' => 'Your email or password is incorrect',
            ]);
        }
    }

    public function store(StoreJobPostRequest $request)
    {
        if($request->identifier == 'login') {
            //login
            $email = $request->emailLog;
            $password = $request->passwordLog;

            if(Auth::attempt(['email' => $email, 'password' => $password])) {
                if(Auth::user()->account == 'couple') {
                    (new JobPostRepo)->create($request->all());
                    return redirect('/dashboard');
                } else {
                    Session::flash('error', 'Job posting is only available for couples.');
                    return redirect('/dashboard');
                }
            } else {
                Session::flash('error', 'These credentials do not match our records.');
                return redirect()->back()->withInput($request->except('password', 'passwordLog'));
            }
        } elseif($request->identifier == 'registration') {
            $this->register($request);
            
            (new JobPostRepo)->create($request->all());

            return redirect('/dashboard');
        }
       
    }

    public function show($request)
    {
        return redirect('/');
    }

    public function validator(array $data)
    {
        $agent = new Agent();

        if($agent->isMobile()) {
            $validations = [
                // 'fname' => 'required|string|max:255',
                // 'lname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|max:100',
                'account' => ['required', Rule::in(['vendor', 'couple'])],
                'accept_tc' => 'required',
            ];

            $customErrorMessages = [
                // 'fname.required' => 'The first name field is required.',
                // 'lname.required' => 'The last name field is required.',
                'accept_tc.*' => 'Please confirm that you accept the Terms and Conditions and Privacy Policy.',
            ];
        } else {
            $validations = [
                // 'fname' => 'required|string|max:255',
                // 'lname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|confirmed|string|min:6|max:100',
                'account' => ['required', Rule::in(['vendor', 'couple'])],
                'accept_tc' => 'required',
            ];

            $customErrorMessages = [
                // 'fname.required' => 'The first name field is required.',
                // 'lname.required' => 'The last name field is required.',
                'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
                'g-recaptcha-response.captcha' => 'Captcha error! try again later or contact hello@wedbooker.com.',
                'accept_tc.*' => 'Please confirm that you accept the Terms and Conditions and Privacy Policy.',
            ];
    
            if(config('app.env') === 'production') {
                $validations['g-recaptcha-response'] = 'required|captcha';
            }
        }

        return Validator::make($data, $validations, $customErrorMessages);
    }

    public function createUser(array $data)
    {
        unset($data['status']);

        if(request('subscribe') === 'on') {
            NewsLetterSubscription::firstOrCreate(['email' => request('email')]);
            
            $list_id = env('MAILCHIMP_LIST_COUPLE', '6f3b22af8f');
            
            // ADDING THE USER TO MAILCHIMP
            $url = "https://us16.api.mailchimp.com/3.0/lists/$list_id/members/";
            $data_ml = array(
                'email_address' => request('email'),
                'status'        => 'subscribed'
            );
            (new MailChimp)->mailchimp_request($url, $data_ml);

            // ADDING TAG TO THE USER IN MAILCHIMP
            (new MailChimp)->manageTag('couple', request('email'), 'Couple Signed Up', 'active');
        }

        $user = (new UserRepo)->create($data);


        if($data['account'] === 'couple') {
            (new CoupleRepo)->create(['user_id' => $user->id]);
        }

        event(new NewUserSignedUp($user));

        return $user;
    }

    public function register($request) {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->createUser($request->all())));

        $this->guard()->login($user);

        return true;
    }

    public function guard()
    {
        return Auth::guard();
    }
    
}
