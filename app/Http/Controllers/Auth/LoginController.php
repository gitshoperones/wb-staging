<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\PageSetting;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    protected $maxAttempts = 2;
    protected $decayMinutes = 1;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    
    public function showLoginForm()
    {
        $pageSettings = PageSetting::fromPage('Login')->get();

        return view('auth.login', compact('pageSettings'));
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/login');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->status === 'archived') {
            $this->guard()->logout();
            $request->session()->invalidate();
            abort(
                403,
                'Your wedBooker account is no longer active. Please contact hello@wedbooker.com if you\'d like to setup your account again.'
            );
        } elseif ($user->status === 'rejected') {
            $this->guard()->logout();
            $request->session()->invalidate();
            abort(403, 'Your account is inactive. Contact hello@wedbooker.com for more information.');
        }
        if ($user->account === 'admin') {
            return redirect('/admin');
        }elseif ($user->account === 'parent') {
            return redirect('/dashboard');
        }

        $user->touch();

        return redirect()->intended($this->redirectTo);
    }
}
