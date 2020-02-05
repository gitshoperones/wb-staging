<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\DeleteAccountRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\NewsLetterSubscription;
use App\Http\Requests\UpdateUserRequest;
use App\Helpers\NotificationContent;

class UsersController extends Controller
{
    public function update(UpdateUserRequest $request)
    {
        $user = Auth::user();
        
        $user->update($request->only([ 'fname', 'lname', 'email']));

        if ($request->password) {
            $user->update(['password' => $request->password]);
        }

        return redirect()->back()->with('success_message', 'Updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->id != $id) {
            abort(403);
        }

        NewsLetterSubscription::whereEmail($user->email)->delete();

        $email_notification = (new NotificationContent)->getEmailContent('Delete Account Request', 'admin');
        
        Mail::to(config('mail.from.address'))->send(
            new DeleteAccountRequest(
                $user,
                ['details' => $request->details, 'reason' => $request->reason],
                $email_notification
            )
        );

        return redirect()->back()->with('success', true);
    }
}
