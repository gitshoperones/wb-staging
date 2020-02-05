<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreSavedJobRequest;
use App\Search\SavedJob\SavedJobSearchManager;

class SavedJobsController extends Controller
{
    public function index()
    {
        $filters = request()->all();
        $eagerLoads =['jobPost' => function ($q) {
            $q->with([
                'event',
                'category',
                'locations',
                'propertyTypes',
                'userProfile:id,userA_id,title,profile_avatar',
            ]);
        }];

        $savedJobs = SavedJobSearchManager::applyFilters($filters, $eagerLoads)
            ->paginate(10);

        return view('dashboard.vendor.saved-jobs', compact('savedJobs'));
    }

    public function store(StoreSavedJobRequest $request)
    {
        Auth::user()->savedJobs()->create([
            'job_post_id' => $request->job_post_id
        ]);

        return response()->json();
    }

    public function destroy($id)
    {
        Auth::user()->savedJobs()->where('job_post_id', $id)->delete();

        return response()->json();
    }
}
