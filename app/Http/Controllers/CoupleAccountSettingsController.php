<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\CoupleRepo;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateCoupleAvatarRequest;
use App\Http\Requests\UpdateCoupleAccountSettingsRequest;

class CoupleAccountSettingsController extends Controller
{
    public function update(UpdateCoupleAccountSettingsRequest $request)
    {
        $myself = Auth::user();
        $ourCoupleAccount = $myself->coupleProfile();

        $myself->update([
            'email' => $request->your_email,
            'fname' => $request->your_firstname,
            'lname' => $request->your_lastname,
            'phone_number' => $request->phone_number
        ]);

        $ourCoupleAccount->update([
            'partner_firstname' => $request->partner_firstname,
            'partner_surname' => $request->partner_lastname,
            'title' => "$request->your_firstname & $request->partner_firstname",
        ]);

        if ($request->password) {
            $myself->update(['password' => $request->password]);
        }

        return redirect()->back()->with('success_message', 'Updated successfully!');
    }

    public function updateAvatar(UpdateCoupleAvatarRequest $request)
    {
        Auth::user()->unreadNotifications()->where('type', 'App\Notifications\SetupCoupleAvatarReminder')
            ->update(['read_at' => now()]);
        (new CoupleRepo)->updateProfileAvatar($request->profile_avatar, Auth::user()->coupleProfile());

        return response()->json();
    }
}
