<?php

namespace App\Events;

use App\Models\VendorReview;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CoupleSubmittedNewReview
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $vendorReview;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(VendorReview $vendorReview)
    {
        $this->vendorReview = $vendorReview;
    }
}
