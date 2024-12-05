<?php

namespace Tests\Feature;


use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class HomeTest extends TestCase
{

    public function test_success_to_access_home(): void
    {
        $response = $this->getJson('/api/');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Fullstack Challenge 🏅 - Dictionary']);
    }
}
