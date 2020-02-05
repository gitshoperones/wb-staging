<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Media;
use App\Models\Vendor;
use App\Models\Location;
use App\Models\Expertise;
use Tests\TestCase;
use App\JobCategory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VendorTest extends TestCase
{
    use RefreshDatabase;

    private $vendorUser;

    public function setup()
    {
        parent::setup();
        Mail::fake();
        $this->vendorUser = factory(User::class)->states('vendor')->create();
        factory(Vendor::class)->create(['user_id' => $this->vendorUser->id]);
    }

    public function test_can_edit_vendor_profile()
    {
        $vendorProfile = $this->vendorUser->vendorProfile;

        $this->actingAs($this->vendorUser);

        $response = $this->json('GET', sprintf('vendors/%s/edit', $vendorProfile->id));

        $response->assertStatus(200);
    }

    public function test_cannot_edit_other_vendor_profile()
    {
        $otherUser = factory(User::class)->states('vendor')->create();

        $this->actingAs($otherUser);

        $response = $this->json('GET', sprintf('vendors/%s/edit', $this->vendorUser->vendorProfile->id));

        $response->assertStatus(403);
    }

    public function test_can_update_vendor_profile()
    {
        $this->actingAs($this->vendorUser);

        $profileId = $this->vendorUser->vendorProfile->id;

        $response = $this->json('PATCH', sprintf('vendors/%s', $profileId), [
            'business_name' => 'Hello World',
        ]);

        $this->assertDatabaseHas('vendors', [
            'business_name' => 'Hello World',
        ]);

        $response->assertStatus(200);
    }

    public function test_cannot_update_other_vendor_profile()
    {
        $otherUser = factory(User::class)->states('vendor')->create();

        $this->actingAs($otherUser);

        $response = $this->json('PATCH', sprintf('vendors/%s', $this->vendorUser->vendorProfile->id), [
            'business_name' => 'Hello World',
        ]);

        $response->assertStatus(403);
    }
}
