<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SigninTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_invalid_data(): void
    {
        $response = $this->postJson('/api/auth/signin', [
            'email' => 'email@email.com',
            'password' => 'password'
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonFragment(['message' => 'The selected email is invalid.']);
    }

    public function test_incorrect_password(): void
    {
        $response = $this->postJson('/api/auth/signin', [
            'email' => $this->user->email,
            'password' => 'wrong_password'
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJsonFragment(['error' => 'User and/or password invalid']);
    }

    public function test_success(): void
    {
        $response = $this->postJson('/api/auth/signin', [
            'email' => $this->user->email,
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
