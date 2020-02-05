<?php

namespace App\Listeners;

use App\Models\JobQuoteMilestone;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateJobQuoteMileStoneStatus
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $milestones = JobQuoteMilestone::whereIn('id', $event->payment->milestone_ids)->get();

        foreach ($milestones as $milestone) {
            $milestone->update(['paid' => 1]);
        }
    }
}
