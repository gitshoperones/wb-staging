<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAuthTest extends TestCase
{
    use RefreshDatabase;

    public function setup()
    {
        parent::setup();
        Mail::fake();
    }

    public function test_has_user_registration_route_and_form()
    {
        $response = $this->json('GET', '/sign-up');
        $response->assertStatus(200);
        $this->assertGuest();
    }

    public function test_can_register_new_vendor_user_type()
    {
        $response = $this->json('POST', '/register', $this->formInput(['account' => 'vendor']));

        $this->assertDatabaseHas('users', ['email' => 'johnDoe@gmail.com', 'account' => 'vendor']);
        $this->assertGuest();
    }

    public function test_can_register_new_couple_user_type()
    {
        $response = $this->json('POST', '/register', $this->formInput(['account' => 'couple', 'email' => 'janeDoe@gmail.com']));

        $this->assertDatabaseHas('users', ['email' => 'janeDoe@gmail.com', 'status' => 4, 'account' => 'couple']);
        $this->assertGuest();
    }

    public function test_can_create_couple_profile_after_couple_registration()
    {
        $response = $this->json('POST', '/register', $this->formInput(['account' => 'couple', 'email' => 'janeDoe@gmail.com']));
        $user = User::where('email', 'janeDoe@gmail.com')->first(['id']);

        $this->assertDatabaseHas('couples', ['userA_id' => $user->id]);

        $this->assertGuest();
    }

    public function test_can_create_vendor_profile_after_vendor_registration()
    {
        $response = $this->json('POST', '/register', $this->formInput(['account' => 'vendor', 'email' => 'janeDoe@gmail.com']));
        $user = User::where('email', 'janeDoe@gmail.com')->first(['id']);

        $this->assertDatabaseHas('vendors', ['user_id' => $user->id]);

        $this->assertGuest();
    }

    public function test_email_is_required()
    {
        $response = $this->json('POST', '/register', $this->formInput(['email' => '']));
        $response->assertStatus(422)->assertJson([
            'errors' => [
                "email" => [
                    "The email field is required."
                ]
            ]
        ]);
    }

    public function test_email_is_invalid()
    {
        $response = $this->json('POST', '/register', $this->formInput(['email' => 'helloworld']));
        $response->assertStatus(422)->assertJson([
            'errors' => [
                "email" => [
                    "The email must be a valid email address."
                ]
            ]
        ]);
    }

    public function test_password_is_required()
    {
        $response = $this->json('POST', '/register', $this->formInput(['password' => '']));
        $response->assertStatus(422)->assertJson([
            'errors' => [
                "password" => [
                    "The password field is required."
                ]
            ]
        ]);
    }

    public function test_password_confirmation_does_not_match()
    {
        $response = $this->json('POST', '/register', $this->formInput(['password_confirmation' => 'abcdefg']));
        $response->assertStatus(422)->assertJson([
            'errors' => [
                "password" => [
                    "The password confirmation does not match."
                ]
            ]
        ]);
    }

    public function test_account_is_required()
    {
        $response = $this->json('POST', '/register', $this->formInput(['account' => '']));
        $response->assertStatus(422)->assertJson([
            'errors' => [
                "account" => [
                    "The account field is required."
                ]
            ]
        ]);
    }

    public function test_password_min_6_character()
    {
        $response = $this->json('POST', '/register', $this->formInput([
            'password' => '34343', 'password_confirmation' => '34343'
        ]));
        $response->assertStatus(422)->assertJson([
            'errors' => [
                "password" => [
                    "The password must be at least 6 characters."
                ]
            ]
        ]);
    }

    public function test_account_is_invalid()
    {
        $response = $this->json('POST', '/register', $this->formInput(['account' => 'super-user']));
        $response->assertStatus(422)->assertJson([
            'errors' => [
                "account" => [
                    "The selected account is invalid."
                ]
            ]
        ]);
    }

    public function test_has_user_login_route_and_form()
    {
        $response = $this->json('GET', '/login');

        $response->assertStatus(200);
    }

    public function test_user_can_login()
    {
        $user = factory(User::class)->states('vendor')->create(['password' => 'helloworld']);

        $response = $this->json('POST', '/login', [
            'email' => $user->email,
            'password' => 'helloworld',
        ]);

        $response->assertStatus(302)->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_user_login()
    {
        $user = factory(User::class)->states('vendor')->create(['password' => bcrypt('helloworld')]);

        $response = $this->json('POST', '/login', [
            'email' => $user->email,
            'password' => 'test',
        ]);

        $response->assertStatus(422)->assertJson([
            'errors' => [
                "email" => [
                    "These credentials do not match our records."
                ]
            ]
        ]);

        $this->assertInvalidCredentials([
            'username' => $user->email,
            'password' => 'test',
        ]);
    }

    public function formInput($overrides = [])
    {
        return array_merge([
            'email' => 'johnDoe@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'account' => 'vendor',
            'accept_tc' => true,
        ], $overrides);
    }
}
