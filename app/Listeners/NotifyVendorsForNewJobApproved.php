<?php

namespace App\Listeners;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Category;
use App\Notifications\NewJobPosted;
use Illuminate\Queue\InteractsWithQueue;
use App\Search\Vendor\VendorSearchManager;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\NewJobApproved;
use App\Helpers\NotificationContent;
use Session;

class NotifyVendorsForNewJobApproved
{
    public $jobPost;
    public $couple;
    public $jobCategory;
    public $jobDetails;

    /**
     * Handle the event.
     *
     * @param  NewJobApproved  $event
     * @return void
     */
    public function handle(NewJobApproved $event)
    {
        $this->jobPost = $event->jobPost;
        $this->couple = $this->jobPost->userProfile;
        $this->jobCategory = $this->jobPost->category->name;
        $this->jobDetails = [
            'couple' => $this->couple->title,
            'category' => $this->jobPost->category->name,
            'location' => implode(',', $this->jobPost->locations->pluck('name')->toArray()),
            'date' => $this->jobPost->event_date,
            'flexibleDate' => $this->jobPost->is_flexible,
            'budget' => $this->jobPost->budget,
            'event' => $this->jobPost->event->name
        ];

        $alertSpecificVendors = $event->alertSpecificVendorIds;
        $relatedVendors = $this->getRelatedVendorIds($this->jobPost);
        $favoriteVendors = $this->jobPost->user->favoriteVendors()->pluck('vendor_id')->toArray();

        if ($alertSpecificVendors[0] != null) {
            $this->sendToSpecificVendors($alertSpecificVendors);

            $v_invite = $this->jobPost->is_invite;
            if($v_invite) {
                if (count($favoriteVendors) > 0) {
                    $favoriteVendors = array_diff($favoriteVendors, $alertSpecificVendors);
                    $favoriteVendors = array_intersect($favoriteVendors, $relatedVendors);
                    $this->sendToFavouritedVendors($favoriteVendors);
                }
    
                if (count($relatedVendors) > 0) {
                    $relatedVendors = array_diff($relatedVendors, $alertSpecificVendors, $favoriteVendors);
                    $this->sendToRelatedVendors($relatedVendors);
                }
            }
        }else {
            if (count($favoriteVendors) > 0) {
                $favoriteVendors = array_diff($favoriteVendors, $alertSpecificVendors);
                $favoriteVendors = array_intersect($favoriteVendors, $relatedVendors);
                $this->sendToFavouritedVendors($favoriteVendors);
            }

            if (count($relatedVendors) > 0) {
                $relatedVendors = array_diff($relatedVendors, $alertSpecificVendors, $favoriteVendors);
                $this->sendToRelatedVendorsNoSpecific($relatedVendors);
            }
        }
    }

    public function sendToSpecificVendors($alertSpecificVendors)
    {
        $title = $body = $buttonTxt = '';
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('New Job Request - Single', 'vendor');

        foreach ($dashboard_notifications as $dashboard_notification) {
            $title = str_replace('[couple_title]', ucwords(strtolower(isset($this->couple->title) ? $this->couple->title : '')), $dashboard_notification->subject);
            $body = $dashboard_notification->body;
            $buttonTxt = $dashboard_notification->button;
        }

        $vendorIds = Vendor::whereIn('id', $alertSpecificVendors)->pluck('user_id')->toArray();
        $users = User::whereIn('id', $vendorIds)->get();

        foreach ($users as $user) {
            $user->notify(new NewJobPosted([
                'title' => $title,
                'body' => $body,
                'jobDetails' => $this->jobDetails,
                'btnLink' => url(sprintf('/dashboard/job-posts/%s', $this->jobPost->id)),
                'btnTxt' => $buttonTxt,
                'jobPostId' => $this->jobPost->id,
            ], $user));
        }
    }

    public function sendToFavouritedVendors($favoriteVendors)
    {
        $title = '';
        $body = '';
        $btnTxt = '';
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('New Job Post - Favourite', 'vendor');
        foreach ($dashboard_notifications as $dashboard_notification) {
            $title = $dashboard_notification->subject = str_replace('[couple_title]', ucwords(strtolower(isset($this->couple->title) ? $this->couple->title : '')), $dashboard_notification->subject);
            $body = $dashboard_notification->body = str_replace('[couple_title]', ucwords(strtolower(isset($this->couple->title) ? $this->couple->title : '')), $dashboard_notification->body);
            $btnTxt = $dashboard_notification->button;
        }

        $vendorIds = Vendor::whereIn('id', $favoriteVendors)->pluck('user_id')->toArray();
        $users = User::whereIn('id', $vendorIds)->get();

        foreach ($users as $user) {
            $user->notify(new NewJobPosted([
                'title' => $title,
                'body' => $body,
                'jobDetails' => $this->jobDetails,
                'btnLink' => url(sprintf('/dashboard/job-posts/%s', $this->jobPost->id)),
                // 'btnTxt' => 'View Job',
                'btnTxt' => $btnTxt,
                'jobPostId' => $this->jobPost->id,
            ], $user));
        }
    }

    public function sendToRelatedVendors($relatedVendors)
    {
        $title = '';
        $body = '';
        $btnTxt = '';
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('New Job Request - Multiple', 'vendor');
        foreach ($dashboard_notifications as $dashboard_notification) {
            $title = $dashboard_notification->subject = str_replace('[couple_title]', ucwords(strtolower(isset($this->couple->title) ? $this->couple->title : '')), $dashboard_notification->subject);
            $body = $dashboard_notification->body = str_replace('[couple_title]', ucwords(strtolower(isset($this->couple->title) ? $this->couple->title : '')), $dashboard_notification->body);
            $body = $dashboard_notification->body = str_replace('[category]', ucwords(strtolower(isset($this->jobCategory) ? $this->jobCategory : '')), $dashboard_notification->body);
            $btnTxt = $dashboard_notification->button;
        }

        $vendorIds = Vendor::whereIn('id', $relatedVendors)->pluck('user_id')->toArray();
        $users = User::whereIn('id', $vendorIds)->get();

        foreach ($users as $user) {
            $user->notify(new NewJobPosted([
                'title' => $title,
                'body' => $body,
                'jobDetails' => $this->jobDetails,
                'btnLink' => url(sprintf('/dashboard/job-posts/%s', $this->jobPost->id)),
                'btnTxt' => $btnTxt,
                'jobPostId' => $this->jobPost->id,
            ], $user));
        }
    }

    public function sendToRelatedVendorsNoSpecific($relatedVendors)
    {
        $title = '';
        $body = '';
        $btnTxt = '';
        $dashboard_notifications = (new NotificationContent)->getNotificationContent('New Job Approved', 'vendor');
        foreach ($dashboard_notifications as $dashboard_notification) {
            $title = $dashboard_notification->subject = str_replace('[couple_title]', ucwords(strtolower(isset($this->couple->title) ? $this->couple->title : '')), $dashboard_notification->subject);
            $body = $dashboard_notification->body = str_replace('[couple_title]', ucwords(strtolower(isset($this->couple->title) ? $this->couple->title : '')), $dashboard_notification->body);
            $body = $dashboard_notification->body = str_replace('[category]', ucwords(strtolower(isset($this->jobCategory) ? $this->jobCategory : '')), $dashboard_notification->body);
            $btnTxt = $dashboard_notification->button;
        }

        $vendorIds = Vendor::whereIn('id', $relatedVendors)->pluck('user_id')->toArray();
        $users = User::whereIn('id', $vendorIds)->get();

        foreach ($users as $user) {
            $user->notify(new NewJobPosted([
                'title' => $title,
                'body' => $body,
                'jobDetails' => $this->jobDetails,
                'btnLink' => url(sprintf('/dashboard/job-posts/%s', $this->jobPost->id)),
                'btnTxt' => $btnTxt,
                'jobPostId' => $this->jobPost->id,
            ], $user));
        }
    }

    public function getRelatedVendorIds($jobPost)
    {
        $category = Category::where('id', $this->jobPost->category_id)->firstOrFail(['name']);
        $locations = $this->jobPost->locations()->pluck('name')->toArray();
        $filters = ['expertise' => [$category->name], 'locations' => $locations];

        if ($category->name === 'Venues') {
            $filters['venue_capacity'] = $this->jobPost->number_of_guests;
        }

        return VendorSearchManager::applyFilters($filters)->pluck('id')->toArray();
    }
}
