<?php

namespace App\Http\Services;

use App\Helpers\MountDataResponse;
use App\Http\Repositories\HistoryRepository;

class GetHistoryService
{
    public function __construct(
        private readonly HistoryRepository $historyRepository,
    )
    {
    }

    public function getAll(int $userId): array
    {
        $queryResponse = $this->historyRepository->getAll($userId);

        $results = $queryResponse->items();
        $history = collect($results)->map(fn($result) => [
            'word'  => $result->word,
            'added' => $result->created_at->toDateTimeString(),
        ])->toArray();
        return MountDataResponse::mountData($history, $queryResponse);
    }
}
