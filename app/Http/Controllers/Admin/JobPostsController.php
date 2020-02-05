<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Search\JobPost\JobPostSearchManager;

class JobPostsController extends Controller
{
    public function index(Request $request)
    {
        $filters = ['status' => 1];

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

        if ($request->search)
            $jobPosts = JobPostSearchManager::keywordSearch($request->search);
        else
            $jobPosts = JobPostSearchManager::applyFilters($filters, $eagerLoads)->paginate(10);

        return view('admin.job-posts.index', compact('jobPosts'));
    }

    public function destroy($id)
    {
        $jobPost = JobPost::whereId($id)->where('user_id', Auth::id())
            ->where('status', '<>', 2)
            ->with(['category', 'quotes' => function ($q) {
                $q->addSelect(['id', 'user_id', 'job_post_id']);
            }])->firstOrFail(['id', 'category_id']);

        $vendors = User::whereIn('id', $jobPost->quotes->pluck('user_id'))->get(['id', 'email']);

        if ($vendors) {
            Notification::send($vendors, new JobPostDeleted([
                'title' => sprintf(
                    '%s cancelled their %s job',
                    ucwords(strtolower(Auth::user()->coupleProfile()->title)),
                    $jobPost->category->name
                ),
                'body' => 'They are no longer looking for this service so your quote has been cancelled.',
            ]));
        }

        $jobPost->delete();

        return redirect()->back()->with('success_message', 'Your job has now been deleted.');
    }
}
