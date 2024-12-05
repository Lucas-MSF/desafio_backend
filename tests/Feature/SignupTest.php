<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SignupTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->make();
    }

    public function test_error_required_data(): void
    {
        $response = $this->postJson('/api/auth/signup', []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonFragment([
                'errors' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.']
                ]
            ]);
    }

    public function test_success(): void
    {
        $response = $this->postJson('/api/auth/signup', [
            'email' => $this->user->email,
            'name' => $this->user->name,
            'password' => 'password'
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'name',
                'token'
            ]);
    }
}
