<?php

namespace App\Http\Services;

use App\Http\Repositories\HistoryRepository;
use App\Http\Repositories\WordRepository;
use App\Models\Word;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class SearchWordService
{
    public function __construct(
        private readonly DictionaryApiService $dictionaryApiService,
        private readonly HistoryRepository $historyRepository,
        private readonly WordRepository $wordRepository
    )
    {
    }

    public function search(string $word): array
    {
        $wordData = $this->findWord($word);

        $response = $this->dictionaryApiService->request($wordData->word);
        return $response;
    }

    private function findWord(string $word): ?Word
    {
        $wordData = $this->wordRepository->findByWord($word);
        throw_if(
            is_null($wordData),
            new BadRequestException()
        );
        return $wordData;
    }
}
