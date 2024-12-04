<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class DictionaryApiService
{
    const BASE_URL = 'https://api.dictionaryapi.dev/api/v2/entries/en/';

    public function request(string $word): array
    {
        $cacheKey = 'dictionary_' . $word;

        return Cache::remember($cacheKey, now()->addMonth(), function () use ($word) {
            $response = Http::baseUrl(self::BASE_URL)->get($word);
            throw_if(
                !$response->successful(),
                new Exception()
            );
            return $response->json();
        });
    }
}
