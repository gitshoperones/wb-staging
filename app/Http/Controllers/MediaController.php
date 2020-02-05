<?php

namespace App\Http\Controllers;

use App\Repositories\MediaRepo;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreMediaRequest;

class MediaController extends Controller
{
    public function store(StoreMediaRequest $request)
    {
        if (Auth::user()->account === 'couple') {
            $profile = Auth::user()->coupleProfile();
        } elseif (Auth::user()->account === 'vendor') {
            $profile = Auth::user()->vendorProfile;
        } else {
            $profile = Auth::user();
        }

        $media = (new MediaRepo)->store($request->all(), $request->photo, $profile);
        $media->fileUrl = $media->getFileUrl();

        if ($request->isJson() || $request->wantsJson()) {
            return response()->json($media);
        }

        return redirect()->back()->with('success', 'Photo was uploaded successfully!');
    }

    public function destroy($mediaId)
    {
        (new MediaRepo)->destroy($mediaId);

        if (request()->isJson() || request()->wantsJson()) {
            return response()->json();
        }

        return redirect()->back()->with('success', 'Photo was deleted successfully!');
    }
}
