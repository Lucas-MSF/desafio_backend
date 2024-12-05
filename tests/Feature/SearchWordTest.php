<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use App\Models\Word;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class SearchWordTest extends TestCase
{
    use RefreshDatabase;

    private $word;
    private $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->word = Word::factory()->create(['word' => 'hello']);
        $user = User::factory()->create();
        $this->token = JWTAuth::fromUser($user);
    }

    public function test_success(): void
    {
        Http::fake([
            'https://api.dictionaryapi.dev/api/v2/entries/en/hello' => Http::response([
                'word' => 'hello',
                'phonetics' => [
                    [
                        'text' => '/həˈləʊ/',
                        'audio' => 'https://audio.example.com/hello.mp3'
                    ]
                ],
                'meanings' => [
                    [
                        'partOfSpeech' => 'interjection',
                        'definitions' => [
                            [
                                'definition' => 'Used as a greeting or to begin a conversation.',
                                'example' => 'Hello, how are you?'
                            ]
                        ]
                    ]
                ]
            ], Response::HTTP_OK)
        ]);

        $response = $this->withToken($this->token)
            ->getJson('/api/entries/en/' . $this->word->word);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
                'word' => 'hello',
            ]);
    }
}
