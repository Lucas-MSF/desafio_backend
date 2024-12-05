<?php

namespace App\Http\Services;

use App\Helpers\MountDataResponse;
use App\Http\Repositories\WordRepository;

class WordsService
{
    public function __construct(
        private readonly WordRepository $wordRepository
    )
    {
    }

    public function getAll(array $filters): array
    {
        $queryResponse = $this->wordRepository->getAll($filters['search'] ?? null, $filters['limit'] ?? 15);

        $results = $queryResponse->items();
        $words = collect($results)->pluck('word')->values()->toArray();
        return MountDataResponse::mountData($words, $queryResponse);
    }
}
