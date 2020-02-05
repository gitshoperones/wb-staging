<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Repositories\FileRepo;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTCRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\PageSetting;

class TermsAndConditionsController extends Controller
{
    public function index()
    {
        $pageSettings = PageSetting::fromPage('Terms & conditions')->get();

        return view('terms-and-conditions.index', compact('pageSettings'));
    }

    public function store(StoreTCRequest $request)
    {
        with(new FileRepo)->store(Auth::user()->id, $request->tc_file, 'tc');

        return redirect()->back()->with('success_message', 'TC file uploaded successfully!');
    }

    public function destroy($id)
    {
        $file = File::where('user_id', Auth::user()->id)->where('id', $id)
            ->where('meta_key', 'tc')->firstOrFail();

        Storage::delete($file->meta_filename);

        $file->delete();

        return response()->json(['success' => 'TC file deleted successfully!'], 200);
    }
}
