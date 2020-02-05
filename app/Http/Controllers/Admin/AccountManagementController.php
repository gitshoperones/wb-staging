<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\UserRepo;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminAccountPasswordResetRequest;
use App\Helpers\NotificationContent;
use App\Mail\SuperAdminAccountPasswordResetRequest;

class AccountManagementController extends Controller
{
    public function index()
    {
        $userDetails = User::whereIn('account', array('admin', 'manager'))
        ->paginate(env('APP_PAGINATION', 15));
        return view('admin.management.lists', compact('userDetails'));
    }

    public function update($id, Request $request)
    {
        if ($request->email) {
            User::where('id', $id)
            ->update([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'account' => $request->account,
            'phone_number' => $request->phone_number]);
        }

        $user = User::whereId($id)->with('latestNote')->firstOrFail();
        return view('admin.management.update', compact('user'));
    }

    public function create()
    {
        return view('admin.management.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'lname' => 'required',
            'fname' => 'required',
            'account' => ['required', Rule::in(['admin'])],
        ]);

        $user = User::create([
            'email' => $request->email,
            'lname' => $request->lname,
            'fname' => $request->fname,
            'password' => bin2hex("password"),
            'account' => $request->account,
            'status' => 0
        ]);
        
        $token = app('auth.password.broker')->createToken($user);

        $email_notification = (new NotificationContent)->getEmailContent('New Admin User', 'admin');

        Mail::to($user->email)->send(new AdminAccountPasswordResetRequest($token, $email_notification));
        
        $email_notification = (new NotificationContent)->getEmailContent('New Admin User', 'super_admin');
        Mail::to(config('mail.from.address'))->send(new SuperAdminAccountPasswordResetRequest($user, $token, $email_notification));

        return redirect()->back()->with('success_message', $request->account.' account created successfully!');
    }

    public function destroy($id)
    {
        User::whereId($id)->whereIn('account', ['admin', 'manager'])->where('id', '<>', Auth::id())
            ->firstOrFail()->delete();

        return redirect()->back()->with('success_message', 'User deleted successfully!');
    }
}
