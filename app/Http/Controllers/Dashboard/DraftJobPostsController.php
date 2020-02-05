<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Search\JobPost\JobPostSearchManager;

class DraftJobPostsController extends Controller
{
    public function index()
    {
        $filters = request()->all() + ['user' => Auth::user()->id, 'status' => 0];
        $eagerLoads = ['userProfile', 'category', 'event', 'locations', 'propertyTypes','quotes'];
        $jobPosts = JobPostSearchManager::applyFilters($filters, $eagerLoads)->paginate(10);

        return view('dashboard.couple.draft-job-posts', compact('jobPosts'));
    }
}
