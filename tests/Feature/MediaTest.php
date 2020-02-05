<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Media;
use App\Models\Couple;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MediaTest extends TestCase
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

    public function test_can_store_media()
    {
        $this->actingAs($this->coupleUser);

        $profileId = $this->coupleUser->coupleProfile()->id;

        Storage::fake('public');

        $response = $this->json('POST', '/media', [
            'meta_title' => 'Hello World',
            'meta_key' => 'gallery',
            'staticFilename' => true,
            'photo' => UploadedFile::fake()->image('test.jpg'),
        ]);

        $this->assertDatabaseHas('media', [
            'commentable_id' => $profileId,
            'commentable_type' => 'App\\Couple',
            'meta_key' => 'gallery',
            'meta_title' => 'Hello World',
            'meta_filename' => 'user-uploads/test.jpg'
        ]);

        Storage::disk('public')->assertExists('user-uploads/test.jpg');

        $response->assertStatus(200);
    }


    /*public function test_cannot_edit_other_couple_profile()
    {
        $otherCoupleProfile = factory(User::class)->states('couple')->create()->coupleProfile();

        $this->actingAs($this->coupleUser);

        $response = $this->json('GET', sprintf('couples/%s/edit', $otherCoupleProfile->id));

        $response->assertStatus(403);
    }

    public function test_can_update_couple_profile()
    {
        $this->actingAs($this->coupleUser);

        $profileId = $this->coupleUser->coupleProfile()->id;
        $location = factory(Location::class)->create();

        $response = $this->json('PATCH', sprintf('couples/%s/update', $profileId), [
            'title' => 'Hello World',
            'wedding_venue_id' => $location->id,
            'wedding_date' => 'july 1 6000'
        ]);

        $this->assertDatabaseHas('couples', [
            'title' => 'Hello World',
            'wedding_venue_id' => $location->id,
            'wedding_date' => '6000-07-01'
        ]);

        $response->assertStatus(200);
    }

    public function test_can_update_profile_cover_and_profile_avatar()
    {
        $this->actingAs($this->coupleUser);

        $profileId = $this->coupleUser->coupleProfile()->id;
        $location = factory(Location::class)->create();

        Storage::fake('public');

        $response = $this->json('PATCH', sprintf('couples/%s/update', $profileId), [
            'title' => 'Hello World',
            'wedding_venue_id' => $location->id,
            'wedding_date' => 'july 1 6000',
            'staticFilename' => true,
            'profile_avatar' => UploadedFile::fake()->image('couple_profile_avatar.jpg'),
            'profile_cover' => UploadedFile::fake()->image('couple_profile_cover.jpg'),
        ]);

        $this->assertDatabaseHas('media', [
            'commentable_id' => $profileId,
            'commentable_type' => 'App\\Couple',
            'meta_key' => 'profile_avatar',
            'meta_filename' => 'user-uploads/couple_profile_avatar.jpg'
        ]);

        $this->assertDatabaseHas('media', [
            'commentable_id' => $profileId,
            'commentable_type' => 'App\\Couple',
            'meta_key' => 'profile_cover',
            'meta_filename' => 'user-uploads/couple_profile_cover.jpg'
        ]);

        Storage::disk('public')->assertExists('user-uploads/couple_profile_avatar.jpg');
        Storage::disk('public')->assertExists('user-uploads/couple_profile_cover.jpg');

        $response->assertStatus(200);

        $this->json('PATCH', sprintf('couples/%s/update', $profileId), [
            'title' => 'Hello World',
            'wedding_venue_id' => $location->id,
            'wedding_date' => 'july 1 6000',
            'staticFilename' => true,
            'profile_avatar' => UploadedFile::fake()->image('couple_profile_avatar2.jpg'),
            'profile_cover' => UploadedFile::fake()->image('couple_profile_cover2.jpg'),
        ]);

        $this->assertDatabaseMissing('media', [
            'commentable_id' => $profileId,
            'commentable_type' => 'App\\Couple',
            'meta_key' => 'profile_avatar',
            'meta_filename' => 'user-uploads/couple_profile_avatar.jpg'
        ]);

        $this->assertDatabaseMissing('media', [
            'commentable_id' => $profileId,
            'commentable_type' => 'App\\Couple',
            'meta_key' => 'profile_cover',
            'meta_filename' => 'user-uploads/couple_profile_cover.jpg'
        ]);

        Storage::disk('public')->assertExists('user-uploads/couple_profile_avatar2.jpg');
        Storage::disk('public')->assertExists('user-uploads/couple_profile_cover2.jpg');

        $response->assertStatus(200);
    }

    public function test_cannot_update_other_couple_profile()
    {
        $otherCoupleProfile = factory(User::class)->states('couple')->create()->coupleProfile();

        $this->actingAs($this->coupleUser);

        $location = factory(Location::class)->create();

        $response = $this->json('PATCH', sprintf('couples/%s/update', $otherCoupleProfile->id), [
            'title' => 'Hello World',
            'wedding_venue_id' => $location->id,
            'wedding_date' => 'july 1 6000',
            'staticFilename' => true,
            'profile_avatar' => UploadedFile::fake()->image('profile_avatar.jpg'),
            'profile_cover' => UploadedFile::fake()->image('profile_cover.jpg'),
        ]);

        $response->assertStatus(403);
    }

    public function test_cannot_update_couple_profile_with_invalid_wedding_venue_id()
    {
        $this->actingAs($this->coupleUser);

        $response = $this->json('PATCH', sprintf('couples/%s/update', $this->coupleUser->coupleProfile()->id), [
            'title' => 'Hello World',
            'wedding_venue_id' => 101,
            'wedding_date' => 'july 1 6000',
            'staticFilename' => true,
            'profile_avatar' => UploadedFile::fake()->image('profile_avatar.jpg'),
            'profile_cover' => UploadedFile::fake()->image('profile_cover.jpg'),
        ]);

        $response->assertStatus(422);
    }*/
}
