<?php

namespace App\Http\Services;

use App\Http\Repositories\HistoryRepository;
use App\Http\Repositories\WordRepository;
use App\Models\Word;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class WordsService
{
    public function __construct(
        private readonly DictionaryApiService $dictionaryApiService,
        private readonly HistoryRepository $historyRepository,
        private readonly WordRepository $wordRepository
    )
    {
    }

    public function getAll(array $filters): array
    {
        $queryResponse = $this->wordRepository->getAll($filters['search'] ?? null, $filters['limit'] ?? 15);

        $results = $queryResponse->items();
        $words = collect($results)->pluck('word')->values();
        $totalPages = ceil($queryResponse->total()/$queryResponse->perPage());
        return [
            'results' => $words,
            'totalDocs' => $queryResponse->total(),
            'page' => $queryResponse->currentPage(),
            'totalPages' => $totalPages,
            'hasNext' => $queryResponse->currentPage() < $totalPages ? true : false,
            'hasPrev' => $queryResponse->currentPage() > 1 ? true : false
        ];
    }
}
