<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Vendor;
use App\Models\Category;
use App\Models\FavoriteVendor;
use App\Notifications\NewJobPosted;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Search\Vendor\VendorSearchManager;
use App\Http\Requests\StoreFavoriteVendorRequest;
use App\Search\FavoriteVendor\FavoriteVendorSearchManager;
use App\Models\PageSetting;
use App\Helpers\NotificationContent;

class FavoriteVendorsController extends Controller
{
    public function index()
    {
        $filters = request()->all() + ['user_id' => Auth::id()];
        $eagerLoads = ['vendorProfile'];
        $favoriteVendors = FavoriteVendorSearchManager::applyFilters(
            $filters,
            $eagerLoads
        )->paginate(10);

        $pageSettings = PageSetting::fromPage('Browse suppliers & venues')->get();

        return view('dashboard.couple.favorite-vendors', compact('favoriteVendors', 'pageSettings'));
    }

    public function store(StoreFavoriteVendorRequest $request)
    {
        Auth::user()->favoriteVendors()->create([
            'vendor_id' => $request->vendor_id
        ]);
        $vendor = Vendor::whereId($request->vendor_id)->with([
            'user',
        ])->firstOrFail();

        $vendorLocations = $vendor->locations->pluck('name')->toArray();
        $vendorExpertises = $vendor->expertise->pluck('name')->toArray();

        $openJobPosts = Auth::user()->jobPosts()->where('status', 1)
            ->with(['category', 'locations'])->get();

        foreach ($openJobPosts as $jobPost) {
            $relatedVendorIds = $this->getRelatedVendorIds($jobPost);
            if (in_array($vendor->id, $relatedVendorIds)) {
                $this->notifyVendor($vendor, $jobPost);
            }
        }

        return response()->json();
    }

    public function getRelatedVendorIds($jobPost)
    {
        $category = Category::where('id', $jobPost->category_id)->firstOrFail(['name']);
        $locations = $jobPost->locations()->pluck('name')->toArray();
        $filters = ['expertise' => [$category->name], 'locations' => $locations];

        if ($category->name === 'Venues') {
            $filters['venue_capacity'] = $jobPost->number_of_guests;
        }

        return VendorSearchManager::applyFilters($filters)->pluck('id')->toArray();
    }

    public function notifyVendor($vendor, $jobPost)
    {
        $title = '';
        $body = '';
        $btnTxt = '';
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('New Favourite', 'vendor');
        foreach ($dashboard_notifications as $dashboard_notification) {
            $title = $dashboard_notification->subject = str_replace('[couple_title]', ucwords(strtolower(isset($jobPost->user->coupleA->title) ? $jobPost->user->coupleA->title : '')), $dashboard_notification->subject);
            $body = $dashboard_notification->body = str_replace('[couple_title]', ucwords(strtolower(isset($jobPost->user->coupleA->title) ? $jobPost->user->coupleA->title : '')), $dashboard_notification->body);
            $body = $dashboard_notification->body = str_replace('[category]', ucwords(strtolower(isset($jobPost->category->name) ? $jobPost->category->name : '')), $dashboard_notification->body);
            $btnTxt = $dashboard_notification->button;
        }

        $jobDetails = [
            'couple' => $jobPost->user->coupleA->title,
            'category' => $jobPost->category->name,
            'location' => implode(',', $jobPost->locations->pluck('name')->toArray()),
            'date' => $jobPost->event_date,
            'flexibleDate' => $jobPost->is_flexible,
            'budget' => $jobPost->budget,
            'event' => $jobPost->event->name
        ];

        $vendor->user->notify(new NewJobPosted([
            'title' => $title,
            'body' => $body,
            'jobDetails' => $jobDetails,
            'btnLink' => url(sprintf('/dashboard/job-posts/%s', $jobPost->id)),
            'btnTxt' => $btnTxt,
            'jobPostId' => $jobPost->id,
        ], $vendor->user));
    }

    public function destroy($id)
    {
        Auth::user()->favoriteVendors()->where('vendor_id', $id)->delete();

        return response()->json();
    }
}
