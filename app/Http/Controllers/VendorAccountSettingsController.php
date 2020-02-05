<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateVendorAccountSettingsRequest;

class VendorAccountSettingsController extends Controller
{
    public function update(UpdateVendorAccountSettingsRequest $request)
    {
        $user = Auth::user();

        $user->update($request->only(['phone_number']));
        $user->vendorProfile()->update($request->only(['website']));

        return redirect()->back()->with('success_message', 'Updated successfully!');
    }
}
