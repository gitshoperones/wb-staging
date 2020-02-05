<?php

namespace App\Http\Controllers;

use App\Repositories\MediaRepo;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePackagesRequest;
use App\Models\Package;

class PackagesController extends Controller
{
    public function store(StorePackagesRequest $request)
    {
        if (Auth::user()->account === 'couple') {
            $profile = Auth::user()->coupleProfile();
        } elseif (Auth::user()->account === 'vendor') {
            $profile = Auth::user()->vendorProfile;
        } else {
            $profile = Auth::user();
        }

        $media = (new MediaRepo)->store($request->all(), $request->package_document, $profile);
        $media->fileUrl = $media->getFileUrl();

        $package = new Package;
        $package->vendor_id = $profile->id;
        $package->media_id = $media->id;
        $package->filename = $request->filename;
        $package->package_path = $media->meta_filename;
        $package->save();

        return response()->json($package);
    }

    public function destroy($mediaId)
    {
        (new MediaRepo)->destroy($mediaId);

        return response()->json();
    }
}
