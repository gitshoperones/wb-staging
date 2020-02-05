<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\FileRepo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminUploadUserFileRequest;

class UploadUserFilesController extends Controller
{
    public function store(AdminUploadUserFileRequest $request)
    {
        if (Auth::user()->id === $request->userId) {
            abort(403);
        }

        (new FileRepo)->store(
            $request->userId,
            $request->user_file,
            'admin_uploaded_user_file'
        );

        return redirect()->back()->with('success_message', 'File uploaded successfully!');
    }
}
