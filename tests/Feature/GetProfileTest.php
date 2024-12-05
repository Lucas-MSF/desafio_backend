<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetProfileTest extends TestCase
{
    use RefreshDatabase;

    private $token;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $this->token = JWTAuth::fromUser($user);
    }

    public function test_success(): void
    {
        $response = $this->withToken($this->token)
            ->getJson('/api/user/me');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'name',
                'email',
            ]);
    }
}
