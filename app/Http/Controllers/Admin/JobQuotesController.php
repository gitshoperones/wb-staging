<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobQuote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobQuotesController extends Controller
{
    public function index()
    {
        $jobQuotes = JobQuote::with([
            'user' => function ($q) {
                $q->addSelect(['id'])->with([
                    'vendorProfile' => function ($q) {
                        $q->addSelect(['id', 'user_id', 'business_name', 'profile_avatar']);
                    }
                ]);
            },
            'jobPost'
        ])->whereIn('status', [0,1,2,4,5])
        ->select([
            'id', 'user_id', 'job_post_id', 'message', 'specs', 'total', 'duration',
            'tc_file_id', 'confirmed_dates', 'apply_gst', 'locked', 'status',
        ])->orderBy('id', 'desc')->paginate(20);

        return view('admin.job-quotes.index', compact('jobQuotes'));
    }

    public function show($jobPostId)
    {
        $jobQuotes = JobQuote::where('job_post_id', $jobPostId)->with([
            'user' => function ($q) {
                $q->addSelect(['id'])->with([
                    'vendorProfile' => function ($q) {
                        $q->addSelect(['id', 'user_id', 'business_name', 'profile_avatar']);
                    }
                ]);
            },
        ])->get([
            'id', 'user_id', 'job_post_id', 'message', 'specs', 'total', 'duration',
            'tc_file_id', 'confirmed_dates', 'apply_gst', 'locked', 'status',
        ]);

        return view('admin.job-quotes.show', compact('jobQuotes'));
    }

    public function destroy(JobQuote $job_quote)
    {
        $job_quote->delete();

        return back()->with('success_message', 'Successfully Deleted Job Quote');
    }
}
