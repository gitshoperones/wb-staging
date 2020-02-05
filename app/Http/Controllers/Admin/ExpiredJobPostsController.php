<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Search\JobPost\JobPostSearchManager;
use App\Models\JobPost;
use Illuminate\Support\Carbon;

class ExpiredJobPostsController extends Controller
{
    public function index()
    {
        $filters = request()->all();
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
                $q->addSelect(['id', 'job_post_id']);
            },
            'propertyTypes'
        ];

        if (request()->search)
            $jobPosts = JobPostSearchManager::keywordSearch(request()->search, 2);
        else
            $jobPosts = JobPostSearchManager::applyFilters($filters, $eagerLoads)->where('status', '4')->paginate(20);

        return view('admin.job-posts.expired', compact('jobPosts'));
    }
}
