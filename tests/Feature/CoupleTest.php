<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Media;
use App\Models\Couple;
use App\Models\Expertise;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CoupleTest extends TestCase
{
    use RefreshDatabase;

    private $coupleUser;

    public function setup()
    {
        parent::setup();
        Mail::fake();
        $db = app()->make('db');
        $db->getSchemaBuilder()->enableForeignKeyConstraints();
        $this->coupleUser = factory(User::class)->states('couple')->create();
        factory(Couple::class)->create(['userA_id' => $this->coupleUser->id]);
    }

    public function test_can_edit_couple_profile()
    {
        $coupleProfile = $this->coupleUser->coupleProfile();

        $this->actingAs($this->coupleUser);

        $response = $this->json('GET', sprintf('couples/%s/edit', $coupleProfile->id));

        $response->assertStatus(200);
    }

    public function test_cannot_edit_other_couple_profile()
    {
        $otherCouple = factory(User::class)->states('couple')->create();

        $this->actingAs($otherCouple);

        $response = $this->json('GET', sprintf('couples/%s/edit', $this->coupleUser->coupleProfile()->id));

        $response->assertStatus(403);
    }

    public function test_can_update_couple_profile()
    {
        $this->actingAs($this->coupleUser);

        $profileId = $this->coupleUser->coupleProfile()->id;

        $response = $this->json('PATCH', sprintf('couples/%s', $profileId), [
            'title' => 'Hello World',
        ]);

        $this->assertDatabaseHas('couples', [
            'id' => $profileId,
            'title' => 'Hello World',
        ]);

        $response->assertStatus(200);
    }

    public function test_cannot_update_other_couple_profile()
    {
        $otherUser = factory(User::class)->states('couple')->create();

        $this->actingAs($otherUser);

        $response = $this->json('PATCH', sprintf('couples/%s', $this->coupleUser->coupleProfile()->id), [
            'title' => 'Hello World',
        ]);

        $response->assertStatus(403);
    }
}
