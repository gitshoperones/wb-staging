<?php

namespace Tests\Feature\JobQuote;

use App\Models\User;
use App\Models\Event;
use App\Models\JobPost;
use App\Models\JobQuote;
use Tests\TestCase;
use App\Models\JobCategory;
use App\Models\JobTimeRequirement;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResponseTest extends TestCase
{
    use RefreshDatabase;

    private $coupleUser;
    private $vendorUser;
    private $jobPost;

    public function setup()
    {
        parent::setup();
        Mail::fake();
        $this->coupleUser = factory(User::class)->states('couple')->create();
        $this->vendorUser = factory(User::class)->states('vendor')->create();
        $this->jobPost = factory(JobPost::class)->create([
            'user_id' => $this->coupleUser->id,
            'job_category_id' => factory(JobCategory::class)->create()->id,
            'event_id' => factory(Event::class)->create()->id,
            'job_time_requirement_id' => factory(JobTimeRequirement::class)->create()->id,
        ]);
    }

    public function test_couple_accept_job_quote()
    {
        Notification::fake();

        $this->actingAs($this->vendorUser);
        $this->json('POST', '/dashboard/job-quotes', [
            'job_post_id' => $this->jobPost->id,
            'specs' => [],
            'milestones' => [],
            'additional_files' => [],
            'status' => 'pending response'
        ]);

        $this->actingAs($this->coupleUser);
        $this->json('PATCH', sprintf('/dashboard/job-quotes/%s/response', JobQuote::first()->id), [
            'status' => 'declined'
        ]);
        $this->assertTrue(true);
    }
}
