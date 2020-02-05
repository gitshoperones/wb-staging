<?php

namespace Tests\Feature\JobPost;

use App\Models\User;
use App\Models\Event;
use App\Models\Couple;
use App\Models\Vendor;
use App\Models\JobPost;
use App\Models\Category;
use App\Models\Location;
use Tests\TestCase;
use App\Models\PropertyType;
use App\Models\PropertyFeature;
use App\Models\JobTimeRequirement;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    private $coupleUser;

    public function setup()
    {
        parent::setup();
        Mail::fake();
        $this->coupleUser = factory(User::class)->states('couple')->create();
        factory(Couple::class)->create(['userA_id' => $this->coupleUser->id]);
    }

    /*public function test_vendor_user_cannot_create_job_post()
    {
        $user = factory(User::class)->states('vendor')->create();
        factory(Vendor::class)->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->get('/dashboard/job-posts/create');

        $response->assertStatus(403);
    }

    public function test_vendor_user_cannot_store_job_post()
    {
        $user = factory(User::class)->states('vendor')->create();
        factory(Vendor::class)->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $location = factory(Location::class)->create();
        $category = factory(Category::class)->create();
        $event = factory(Event::class)->create();
        $response = $this->json('POST', '/dashboard/job-posts', [
            'category_id' => $category->id,
            'event_id' => $event->id,
            'status' => 1
        ]);

        $response->assertStatus(403);
    }

    public function test_couple_user_can_create_job_post()
    {
        $this->actingAs($this->coupleUser);

        $response = $this->get('/dashboard/job-posts/create');

        $response->assertStatus(200);
    }*/

    public function test_couple_user_can_store_job_post()
    {
        $this->actingAs($this->coupleUser);

        $locations = factory(Location::class, 3)->create();
        $category = factory(category::class)->create();
        $event = factory(Event::class)->create();
        $expertises = factory(Category::class, 3)->create();
        $propertyTypes = factory(PropertyType::class, 3)->create();
        $jobTimeRequirement = factory(JobTimeRequirement::class)->create();

        $response = $this->json('POST', '/dashboard/job-posts', [
            'category_id' => $category->id,
            'event_id' => $event->id,
            'event_date' => 'july 1, 6000',
            'budget' => 50000,
            'other_requirements' => [1, 2],
            'shipping_address' => [
                'street' => '150 Main St.',
                'suburb' => 'awesome suburb',
                'state' => 'awesome state',
                'post_code' => 6000,
            ],
            'job_time_requirement_id' => $jobTimeRequirement->id,
            'required_address' => 'test address',
            'completion_date' => 'march 1 2090',
            'number_of_guests' => 50,
            'specifics' => 'hello world',
            'status' => 1,
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('job_posts', [
            'user_id' => $this->coupleUser->id,
            'category_id' => $category->id,
            'event_id' => $event->id,
            'event_date' => '6000-07-01',
            'budget' => 50000,
            'shipping_address' => json_encode([
                'street' => '150 Main St.',
                'suburb' => 'awesome suburb',
                'state' => 'awesome state',
                'post_code' => 6000,
            ]),
            'job_time_requirement_id' => $jobTimeRequirement->id,
            'required_address' => 'test address',
            'completion_date' => '2090-03-01',
            'number_of_guests' => 50,
            'specifics' => 'hello world',
            'status' => 1
        ]);

        $response->assertStatus(302);
    }
}
