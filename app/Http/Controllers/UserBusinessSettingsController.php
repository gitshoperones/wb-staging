<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\VendorEmail;

class UserBusinessSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['isParent']);
    }

    public function edit()
    {
        $user = Auth::user();
        $email = optional($user->emails->first())->email;

        return view('business-settings.edit', compact('email'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if($request->existing_password) {

            $request->validate([
                'password' => 'required|confirmed|min:6|max:255',
                'existing_password' => [function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        return $fail('Existing password is invalid.');
                    }
                }]
            ]);
    
            $user->fill(['password' => $request->password])->save();
        }

        if($request->email) {
            $request->validate([
                'email' => 'required|email'
            ]);

            VendorEmail::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'email' => $request->email,
                ]
            );
        }else {
            VendorEmail::where('user_id', $user->id)->delete();
        }

        return redirect()->back()->with('success_message', 'Settings successfully changed.');
    }
}
