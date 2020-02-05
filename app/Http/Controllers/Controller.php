<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Couple;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Barryvdh\Debugbar\Controllers\BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function shareEditFlag($flag = 'editOn')
    {
        return View::share([
            'editing' => $flag,
        ]);
    }

    public function shareProfileGallery($profile)
    {
        return View::share([
            'gallery' => Media::whereCommentableId($profile->id)
                ->whereCommentableType(get_class($profile))
                ->where('meta_key', 'gallery')
                ->orderBy('sorting_order')
                ->get()
        ]);
    }

    public function shareProfileFeatured($profile)
    {
        return View::share([
            'featured' => Media::whereCommentableId($profile->id)
                ->whereCommentableType(get_class($profile))
                ->where('meta_key', 'LIKE', 'featured%')
                ->orderBy('sorting_order')
                ->get()
        ]);
    }
}
