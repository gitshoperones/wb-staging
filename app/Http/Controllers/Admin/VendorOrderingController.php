<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VendorOrderingController extends Controller
{
    public function index(Request $request)
    {
        $q = User::where('account', 'vendor');
        $search = $request->q;

        if ($search) {
            $q->where('email', 'like', '%'.$search.'%')
            ->orWhereHas('vendorProfile', function ($q) use ($search) {
                $q->where('business_name', 'like', '%'.$search.'%');
            });
        }

        $vendors = $q->with('vendorProfile')->paginate(50);

        return view('admin.usermanagement.vendor-ordering', compact('vendors'));
    }

    public function update(Request $request, $id)
    {
        $vendor = Vendor::where('user_id', $id)->firstOrFail(['id', 'rank']);
        $vendor->rank = $request->rank;
        $vendor->save();

        return response()->json();
    }

    public function massUpdate(Request $request)
    {
        $path = $request->file('csv_file')->getRealPath();
        $csvData = array_map('str_getcsv', file($path));
        $csvData = array_splice($csvData, 1);

        foreach ($csvData as $item) {
            Vendor::whereId($item[0])->update(['rank' => $item[1]]);
        }

        return redirect()->back()->with('success_message', 'Vendor order updated Successfully');
    }
}
