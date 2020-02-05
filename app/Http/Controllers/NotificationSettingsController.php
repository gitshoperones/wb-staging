<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorEmail;

class NotificationSettingsController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        /*
        $request->validate([
            'notification' => [
                'required', Rule::in([
                    'immediate', 'once daily', 'twice daily',
                ])
            ],
        ]);
        */
        
        if($user->account == "vendor") {
            $request->validate(['email.*' => 'nullable|email|distinct'],
            [
                'email.*.distinct' => 'Email addresses must not be the same',
                'email.*' => 'Must be a valid email address.',
            ]);

            $emails = $user->emails->pluck('email');
            
            foreach ($request->email as $key => $email) {
                $oldEmail = isset($emails[$key]) ? $emails[$key] : null ;

                if($email) {
                    VendorEmail::updateOrCreate(
                        ['user_id' => $user->id, 'email' => $oldEmail],
                        [
                            'email' => $email,
                        ]
                    );
                }else {
                    optional(VendorEmail::where(['user_id' => $user->id, 'email' => $oldEmail])->first())->delete();
                }
            }
        }

        $user->notificationSettings()->updateOrCreate(
            ['user_id' => $user->id, 'meta_key' => 'all'],
            ['meta_key' => 'all', 'meta_value' => 'immediate']
            // ['meta_key' => 'all', 'meta_value' => $request->notification]
        );

        return redirect()->back()->with('success_message', 'Updated successfully!');
    }
}
