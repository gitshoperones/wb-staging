<?php

namespace App\Http\Controllers;

use App\Repositories\FileRepo;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function destroy($fileId)
    {
        (new FileRepo)->destroy($fileId);

        if (request()->isJson() || request()->wantsJson()) {
            return response()->json();
        }

        return redirect()->back()->with('success', 'File was deleted successfully!');
    }
}
