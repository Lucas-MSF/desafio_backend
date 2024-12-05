<?php

namespace Tests\Feature;

use App\Models\Favorite;
use Tests\TestCase;
use App\Models\Word;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteWordTest extends TestCase
{
    use RefreshDatabase;

    private $favorite;
    private $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->favorite = Favorite::factory()->create();
        $this->token = JWTAuth::fromUser($this->favorite->user);
    }

    public function test_error_word_alredy_favorite(): void
    {
        $response = $this->withToken($this->token)
            ->postJson('/api/entries/en/' . $this->favorite->word->word . '/favorite');

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonFragment([
                'error' => 'word already favorited'
            ]);
    }

    public function test_success(): void
    {
        $word = Word::factory()->create();
        $response = $this->withToken($this->token)
            ->postJson('/api/entries/en/' . $word->word . '/favorite');

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
