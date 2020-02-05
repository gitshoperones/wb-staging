<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ParentAccountPasswordResetRequest;
use App\Helpers\NotificationContent;

class ParentAccountsController extends Controller
{
    public function index()
    {
        $parentAccounts = User::where('account', 'parent')->with('vendorProfile')->paginate(10);

        return view('admin.parent-accounts.index', compact('parentAccounts'));
    }

    public function create()
    {
        return view('admin.parent-accounts.create');
    }

    public function edit($id)
    {
        $user = User::whereId($id)->whereAccount('parent')->with('vendorProfile')->firstOrFail();

        return view('admin.parent-accounts.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$request->user_id,
            'business_name' => 'required'
        ]);

        $user = User::whereId($request->user_id)->whereAccount('parent')->firstOrFail();

        $user->update(['email' => $request->email]);
        $user->vendorProfile()->update(['business_name' => $request->business_name]);

        return redirect()->back()->with('success_message', 'Parent account updated successfully!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'business_name' => 'required',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => str_random(5),
            'account' => 'parent',
            'status' => 1
        ]);

        $user->vendorProfile()->create(['business_name' => $request->business_name]);

        $token = app('auth.password.broker')->createToken($user);
        
        $email_notification = (new NotificationContent)->getEmailContent('Parent Account Created', 'parent');
        Mail::to($user->email)->send(new ParentAccountPasswordResetRequest($token, $request->business_name, $email_notification));

        return redirect()->back()->with('success_message', 'Parent account created successfully!');
    }

    public function destroy($id)
    {
        User::whereId($id)->whereAccount('parent')->delete();

        return redirect()->back()->with('success_message', 'deleted successufully!');
    }

    public function addChildAccounts($parentVendorId)
    {
        $parentVendor = Vendor::whereId($parentVendorId)->with(['user', 'childVendors'])->firstOrFail();

        $q = Vendor::where('id', '<>', $parentVendorId)->doesnthave('parentVendor')
            ->whereHas('user', function ($q) {
                $q->where('account', 'vendor');
            })->with('user');

        if (request('search')) {
            $q = $q->where('business_name', 'like', '%'.request('search').'%')
                ->orWhereHas('user', function ($q) {
                    $q->where('email', 'like', '%'.request('search').'%');
                });
        }

        $availableChildVendors = $q->paginate(10);

        return view('admin.parent-accounts.add-child-accounts', compact('parentVendor', 'availableChildVendors'));
    }

    public function viewChildAccounts($parentVendorId)
    {
        $parentVendor = Vendor::whereId($parentVendorId)->with([
            'user', 'childVendors' => function ($q) {
                $q->with('childVendorProfile');
            }
        ])->firstOrFail();

        return view('admin.parent-accounts.child-accounts', compact('parentVendor'));
    }

    public function removeParentChildAccount($parentVendorId, $childVendorId)
    {
        Vendor::whereId($parentVendorId)->firstOrFail()->childVendors()->where('child_vendor_id', $childVendorId)->delete();

        return redirect()->back()->with('success_message', 'Child vendor removed successufully!');
    }

    public function saveParentChildAccount($parentVendorId, $childVendorId)
    {
        Vendor::whereId($childVendorId)->doesnthave('parentVendor')->firstOrFail();

        Vendor::whereId($parentVendorId)->firstOrFail()->childVendors()->create(['child_vendor_id' => $childVendorId]);

        return redirect()->back()->with('success_message', 'Child vendor added successufully!');
    }
}
