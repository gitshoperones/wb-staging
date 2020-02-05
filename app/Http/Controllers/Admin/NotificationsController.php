<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\User;
use App\Notifications\CustomNotification;
use App\Helpers\MultipleEmails;
use Notification;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = DatabaseNotification::with('notifiable')
                            ->whereType('App\\Notifications\\CustomNotification')
                            ->orderBy('created_at', 'DESC')
                            ->get();

        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $path = $request->file('csv_file');
        if ($request->emails != '') {
            $userEmails = explode(',', preg_replace('/\s+/', '', $request->emails));
        } else if ($path) {
            $userEmails = array_map('trim', file($path->getRealPath()));
        } else {
            return redirect()->route('notifications.index')->with('error', 'No receivers. Please add user emails or upload CSV file.');
        }
        
        $users = User::whereIn('email', $userEmails)->get();
        
        foreach ($users as $user) {
            // if ( ! $user->notificationSettings()->exists())
                $data = $request->except('_token', 'emails', 'csv_file') + ['sendMail' => true];
            // else
                // $data = $request->except('_token', 'emails', 'csv_file');

            $emails = ($user->account == "vendor") ? (new MultipleEmails)->getMultipleEmails($user) : $user->email;
            Notification::route('mail', $emails)->notify(new CustomNotification($data, 'email'));
            $user->notify(new CustomNotification($data, 'dashboard'));
        }
        
        return redirect()->route('notifications.index')->with('success_message', 'Custom notification has been sent successfully');
    }
}
