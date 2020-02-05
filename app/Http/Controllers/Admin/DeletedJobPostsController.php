<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Search\JobPost\JobPostSearchManager;
use App\Models\JobPost;

class DeletedJobPostsController extends Controller
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
            $jobPosts = JobPostSearchManager::keywordSearch(request()->search, true);
        else
            $jobPosts = JobPostSearchManager::applyFilters($filters, $eagerLoads)->onlyTrashed()->paginate(20);

        return view('admin.job-posts.trashed', compact('jobPosts'));
    }

    public function restore($id)
    {
        $jobPost = JobPost::withTrashed()->find($id)->restore();

        return back()->with('success_message', "Restored Job Post successfully");
    }
}
