<?php

namespace Tests\Feature\JobPost;

use App\Models\User;
use App\Models\Event;
use App\Models\Couple;
use App\Models\JobPost;
use App\Models\Location;
use Tests\TestCase;
use App\Models\JobCategory;
use App\Models\PropertyType;
use App\Models\JobTimeRequirement;
use App\Models\OtherJobRequirement;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    private $coupleUser;
    private $jobPost;

    public function setup()
    {
        parent::setup();
        Mail::fake();
        $this->coupleUser = factory(User::class)->states('couple')->create();
        factory(Couple::class)->create(['userA_id' => $this->coupleUser->id]);
        $this->jobPost = factory(JobPost::class)->create([
            'user_id' => $this->coupleUser->id,
            'job_category_id' => factory(JobCategory::class)->create()->id,
            'event_id' => factory(Event::class)->create()->id,
            'job_time_requirement_id' => factory(JobTimeRequirement::class)->create()->id,
        ]);
    }

    public function test_couple_can_edit_their_own_job_post()
    {
        $this->actingAs($this->coupleUser);
        $response = $this->json('GET', sprintf('/dashboard/job-posts/%s/edit', $this->jobPost->id));

        $response->assertStatus(200);
    }

    public function test_couple_cannot_edit_job_post_created_by_other_user()
    {
        $this->actingAs($this->coupleUser);
        $otherUser = factory(User::class)->states('couple')->create();
        $otherJobPost = factory(JobPost::class)->create(['user_id' => $otherUser->id]);

        $response = $this->json('GET', sprintf('/dashboard/job-posts/%s/edit', $otherJobPost->id));

        $response->assertStatus(403);
    }

    public function test_can_update_job_post_category_and_event_type()
    {
        $this->actingAs($this->coupleUser);
        $category = factory(JobCategory::class)->create();
        $event = factory(Event::class)->create();

        $response = $this->json('PATCH', sprintf('/dashboard/job-posts/%s', $this->jobPost->id), [
            'job_category_id' => $category->id,
            'event_id' => $event->id,
        ]);

        $this->assertDatabaseHas('job_posts', [
            'id' => $this->jobPost->id,
            'job_category_id' => $category->id,
            'event_id' => $event->id,
        ]);
    }

    public function test_can_update_job_post_event_date()
    {
        $this->actingAs($this->coupleUser);
        $response = $this->json(
            'PATCH',
            sprintf('/dashboard/job-posts/%s', $this->jobPost->id),
            $this->addRequiredFields() + ['event_date' => 'september 1 6000']
        );

        $this->assertDatabaseHas('job_posts', [
            'id' => $this->jobPost->id,
            'event_date' => '6000-09-01',
        ]);
    }

    public function test_can_update_job_post_required_address()
    {
        $this->actingAs($this->coupleUser);

        $response = $this->json(
            'PATCH',
            sprintf('/dashboard/job-posts/%s', $this->jobPost->id),
            $this->addRequiredFields() + ['required_address' => 'hello world']
        );

        $this->assertDatabaseHas('job_posts', [
            'id' => $this->jobPost->id,
            'required_address' => 'hello world',
        ]);
    }

    public function test_can_update_job_post_completion_date()
    {
        $this->actingAs($this->coupleUser);
        $response = $this->json(
            'PATCH',
            sprintf('/dashboard/job-posts/%s', $this->jobPost->id),
            $this->addRequiredFields() + ['completion_date' => 'January 29, 2090']
        );

        $this->assertDatabaseHas('job_posts', [
            'id' => $this->jobPost->id,
            'completion_date' => '2090-01-29',
        ]);
    }

    public function test_can_update_job_post_number_of_guests()
    {
        $this->actingAs($this->coupleUser);
        $response = $this->json(
            'PATCH',
            sprintf('/dashboard/job-posts/%s', $this->jobPost->id),
            $this->addRequiredFields() + ['number_of_guests' => 50]
        );

        $this->assertDatabaseHas('job_posts', [
            'id' => $this->jobPost->id,
            'number_of_guests' => 50,
        ]);
    }

    public function test_can_update_job_post_specifics()
    {
        $this->actingAs($this->coupleUser);
        $response = $this->json(
            'PATCH',
            sprintf('/dashboard/job-posts/%s', $this->jobPost->id),
            $this->addRequiredFields() + ['specifics' => 'the quick brown fox.']
        );

        $this->assertDatabaseHas('job_posts', [
            'id' => $this->jobPost->id,
            'specifics' => 'the quick brown fox.',
        ]);
    }

    public function test_can_update_job_post_budget()
    {
        $this->actingAs($this->coupleUser);
        $response = $this->json(
            'PATCH',
            sprintf('/dashboard/job-posts/%s', $this->jobPost->id),
            $this->addRequiredFields() + ['budget' => 100]
        );

        $this->assertDatabaseHas('job_posts', [
            'id' => $this->jobPost->id,
            'budget' => 100,
        ]);
    }

    public function test_can_update_job_post_shipping_address()
    {
        $this->actingAs($this->coupleUser);
        $response = $this->json(
            'PATCH',
            sprintf('/dashboard/job-posts/%s', $this->jobPost->id),
            $this->addRequiredFields() + ['shipping_address' => [
                'street' => 'A Lopez St.',
                'suburb' => 'awesome suburb 2',
                'state' => 'awesome state 2',
                'post_code' => 2000,
            ]]
        );

        $this->assertDatabaseHas('job_posts', [
            'id' => $this->jobPost->id,
            'shipping_address' => json_encode([
                'street' => 'A Lopez St.',
                'suburb' => 'awesome suburb 2',
                'state' => 'awesome state 2',
                'post_code' => 2000,
            ])
        ]);
    }

    public function test_can_update_job_post_status()
    {
        $this->actingAs($this->coupleUser);
        $jobPost = factory(JobPost::class)->create([
            'user_id' => $this->coupleUser->id,
            'status' => 0,
        ]);

        $response = $this->json(
            'PATCH',
            sprintf('/dashboard/job-posts/%s', $jobPost->id),
            $this->addRequiredFields() + ['status' => 1]
        );

        $this->assertDatabaseHas('job_posts', [
            'id' => $jobPost->id,
            'status' => 1
        ]);
    }

    private function addRequiredFields()
    {
        $category = factory(JobCategory::class)->create();
        $event = factory(Event::class)->create();

        return [
            'event_id' => $event->id,
            'job_category_id' => $category->id,
        ];
    }
}
