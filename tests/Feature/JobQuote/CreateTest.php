<?php

namespace Tests\Feature\JobQuote;

use App\Models\File;
use App\Models\User;
use App\Models\Event;
use App\Models\Couple;
use App\Models\Vendor;
use App\Models\JobPost;
use App\Models\JobQuote;
use Tests\TestCase;
use App\Models\JobCategory;
use App\Models\JobTimeRequirement;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use App\Notifications\JobQuoteReceived;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    private $vendorUser;
    private $jobPost;

    public function setup()
    {
        parent::setup();
        Mail::fake();
        $this->vendorUser = factory(User::class)->states('vendor')->create();
        factory(Vendor::class)->create(['user_id' => $this->vendorUser->id]);
        $this->jobPost = factory(JobPost::class)->create([
            'user_id' => factory(User::class)->states('couple')->create()->id,
            'job_category_id' => factory(JobCategory::class)->create()->id,
            'event_id' => factory(Event::class)->create()->id,
            'job_time_requirement_id' => factory(JobTimeRequirement::class)->create()->id,
        ]);
        Storage::fake('public');
    }

    public function test_couple_cannot_create_job_quote()
    {
        $user = factory(User::class)->states('couple')->create();
        factory(Couple::class)->create(['userA_id' => $user->id]);
        $this->actingAs($user);
        $response = $this->get(sprintf('/dashboard/job-quotes/create?job_post_id=%s', $this->jobPost->id));
        $response->assertStatus(403);
    }

    public function test_couple_user_cannot_store_job_quote()
    {
        $user = factory(User::class)->states('couple')->create();
        $this->actingAs($user);
        $response = $this->json('POST', '/dashboard/job-quotes', [
            'job_post_id' => $this->jobPost->id,
            'status' => 'pending'
        ]);
        $response->assertStatus(403);
    }

    public function test_cannot_create_job_quote_without_job_post()
    {
        $this->actingAs($this->vendorUser);
        $response = $this->get('/dashboard/job-quotes/create');
        $response->assertStatus(404);
    }

    public function test_cannot_create_job_quote_when_job_post_is_not_in_live_status()
    {
        $this->actingAs($this->vendorUser);
        $notLiveJobPost = factory(JobPost::class)->create([
            'user_id' => factory(User::class)->states('couple')->create()->id,
            'job_category_id' => factory(JobCategory::class)->create()->id,
            'event_id' => factory(Event::class)->create()->id,
            'job_time_requirement_id' => factory(JobTimeRequirement::class)->create()->id,
            'status' => 'draft'
        ]);

        $response = $this->get(sprintf('/dashboard/job-quotes/create?job_post_id=%s', $notLiveJobPost->id));
        $response->assertStatus(404);
    }

    public function test_vendor_can_create_job_quote()
    {
        Notification::fake();

        $this->actingAs($this->vendorUser);
        $response = $this->json('POST', '/dashboard/job-quotes', [
            'job_post_id' => $this->jobPost->id,
            'specs' => $this->rawSpecs(),
            'milestones' => $this->composeMilestones(),
            'desc' => 'hello world',
            'message' => 'test message',
            'duration' => 'july 1, 2019',
            'tc' => 'new',
            'tc_file' => UploadedFile::fake()->image('tc.pdf'),
            'additional_files' => [
                UploadedFile::fake()->image('test1.pdf'),
                UploadedFile::fake()->image('test2.pdf')
            ],
            'status' => 1
        ]);

        $this->assertJobQuoteWasStored();

        $jobQuote = JobQuote::where('job_post_id', $this->jobPost->id)->first(['id', 'tc_file_id']);

        $response->assertStatus(302);
    }

    public function assertNotificationSent()
    {
        Notification::assertSentTo(
            $this->jobPost->user,
            JobQuoteReceived::class
        );
    }

    public function assertHasTc($jobQuote)
    {
        $this->assertDatabaseHas('files', [
            'id' => $jobQuote->tc_file_id,
            'meta_key' => 'tc'
        ]);
    }

    public function assertJobQuoteWasStored()
    {
        $this->assertDatabaseHas('job_quotes', [
            'job_post_id' => $this->jobPost->id,
            'specs' => json_encode($this->composeSpecs()),
            'message' => 'test message',
            'duration' => '2019-07-01',
            'status' => 1,
        ]);
    }

    public function rawSpecs()
    {
        return array(
            'costs' => [100, 200, 30.56],
            'titles' => ['title 1', 'title 2', 'title 3'],
            'notes' => ['note 1', 'note 2', 'note 3']
        );
    }

    private function composeSpecs()
    {
        $data = $this->rawSpecs();

        $titles = $data['titles'];
        $costs = $data['costs'];
        $specs = [];

        foreach ($titles as $key => $title) {
            if ($title || $costs[$key] || $notes[$key]) {
                $specs[] = [
                    'title' => $title,
                    'cost' => isset($costs[$key]) ? $costs[$key] : null,
                ];
            }
        }

        return $specs;
    }

    public function composeMilestones()
    {
        return array(
            'percents' => [30, 20, 50],
            'due_dates' => ['july 1, 2018', 'august 2, 2018', 'september 5, 2018'],
            'descs' => ['desc 1', 'desc 2', 'desc 3']
        );
    }
}
