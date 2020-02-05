<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Search\JobPost\JobPostSearchManager;

class LiveJobPostsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if (!$user || $user->isDoneOnboarding() !== true) {
            return redirect('/dashboard');
        }

        $filters = request()->all() + ['user' => Auth::user()->id];
        $eagerLoads = $eagerLoads = [
            'userProfile' => function ($q) {
                $q->addSelect(['id', 'userA_id', 'userB_id', 'title', 'profile_avatar']);
            },
            'category' => function ($q) {
                $q->addSelect(['id', 'template', 'name']);
            },
            'event' => function ($q) {
                $q->addSelect(['events.id', 'name']);
            },
            'locations' => function ($q) {
                $q->addSelect(['locations.id', 'state', 'abbr', 'name']);
            },
            'quotes' => function ($q) {
                $q->addSelect(['id', 'job_post_id'])->where('status', '<>', 0);
            },
            'propertyTypes'
        ];

        $jobPosts = JobPostSearchManager::applyFilters($filters, $eagerLoads)->whereIn('status', [1, 5])->paginate(10);

        return view('dashboard.couple.live-job-posts', compact('jobPosts'));
    }
}
