<?php

namespace App\Events;

use App\Models\JobPost;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewJobPosted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $jobPost;
    public $alertSpecificVendorIds;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(JobPost $jobPost, $alertSpecificVendorIds = null)
    {
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
            'propertyTypes'
        ];

        $this->jobPost = JobPost::whereId($jobPost->id)->with($eagerLoads)->first();
        $this->alertSpecificVendorIds = [$alertSpecificVendorIds];
    }
}
