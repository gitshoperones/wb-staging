<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Search\JobPost\JobPostSearchManager;
use App\Models\JobPost;
use App\Events\NewJobApproved;
use App\Models\Category;

class PendingJobPostsController extends Controller
{
    public function index()
    {
        $filters = ['status' => 5];

        $eagerLoads = [
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
            $jobPosts = JobPostSearchManager::keywordSearch(request()->search, 3);
        else
            $jobPosts = JobPostSearchManager::applyFilters($filters, $eagerLoads)->paginate(10);

        return view('admin.job-posts.pending', compact('jobPosts'));
    }

    public function show($id)
    {
        $jobPost = JobPost::whereId($id)->first();

        $types = [];
        $template = Category::whereId($jobPost->category_id)->firstOrFail()->jobPostTemplates()->first();
        $types['hasTemplate'] = $template ? null : 1 ;
        $types['approx'] = $template ? $template->approxDisplay : null;
        $template = $template ? json_decode($template->fields) : null;

        if(count((array) $template) > 0) {
            foreach ($template as $value) {
                if($value->type == 'time') {
                    $types['time'] = $value->jtext;
                }else if($value->type == 'property') {
                    $types['property'] = $value->jtext;
                }else if($value->type == 'other') {
                    $types['other'] = $value->jtext;
                }else if($value->type == 'website') {
                    $types['website'] = $value->jtext;
                }else if($value->type == 'address') {
                    $types['address'] = $value->jtext;
                }
            }
        }

        return view('admin.job-posts.view-pending', compact('jobPost', 'types'));
    }

    public function update($id)
    {
        $jobPost = JobPost::whereId($id)->first();
        event(new NewJobApproved($jobPost, $jobPost->vendor_id));
        $jobPost->status = 1;
        $jobPost->update();
    }

    public function destroy($id)
    {
        $jobPost = JobPost::whereId($id)->first();
        $jobPost->delete();
    }
}
