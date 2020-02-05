<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fee;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorFee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class VendorFeesController extends Controller
{
    public function show($id)
    {
        $vendor = Vendor::whereId($id)->with('fee')->first();

        $fees = Fee::where('status', 1)->get();

        return view('admin.fees.vendor', compact('vendor', 'fees'));
    }

    public function update(Request $request)
    {
        $fee = Fee::whereId($request->feeId)->firstOrFail();

        VendorFee::updateOrCreate(['vendor_id' => $request->vendorId], ['fee_id' => $fee->id]);

        $fee->update(['status' => 1]);

        return redirect()->back()->with('success_message', 'Vendor Fee updated successfully!');
    }
}
