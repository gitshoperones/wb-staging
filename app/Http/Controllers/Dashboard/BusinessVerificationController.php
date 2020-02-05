<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Vendor;
use App\Repositories\FileRepo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBusinessVerificationRequest;

class BusinessVerificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->status !== 'pending') {
            abort(404);
        }

        $abn = $user->vendorProfile->abn;

        return view('dashboard.vendor.business-verification', compact('abn'));
    }

    public function store(StoreBusinessVerificationRequest $request)
    {
        if ($request->abn) {
            $vendor = Vendor::where('user_id', Auth::user()->id)->firstOrFail();
            $vendor->abn = $request->abn;
            $vendor->update();
        }

        $fileRepo = new FileRepo;

        if ($request->verification_photo) {
            $fileRepo->store(
                Auth::user()->id,
                $request->verification_photo,
                'verification_file'
            );
        }

        if ($request->verification_document) {
            $fileRepo->store(
                Auth::user()->id,
                $request->verification_document,
                'verification_file'
            );
        }

        return redirect()->back()->with('success_notification', true);
    }
}
