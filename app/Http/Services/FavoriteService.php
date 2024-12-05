<?php

namespace App\Http\Services;

use App\Models\Word;
use App\Models\Favorite;
use App\Helpers\MountDataResponse;
use App\Http\Repositories\WordRepository;
use App\Http\Repositories\FavoriteRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class FavoriteService
{
    public function __construct(
        private readonly WordRepository $wordRepository,
        private readonly FavoriteRepository $favoriteRepository,
    ) {}

    public function favorite(string $word): void
    {
        $wordData = $this->findWordData($word);
        $userData = auth()->user();

        $favoriteData = $this->findDataByUserAndWord($userData->getKey(), $wordData->getKey());
        throw_if(
            !is_null($favoriteData),
            new BadRequestException()
        );

        $this->favoriteRepository->create([
            'word_id' => $wordData->getKey(),
            'user_id' => $userData->getKey(),
        ]);
    }

    private function findWordData(string $word): ?Word
    {
        return $this->wordRepository->findByWord($word);
    }

    private function findDataByUserAndWord(int $userId, int $wordId): ?Favorite
    {
        return $this->favoriteRepository->findByUserIdAndWordId($userId, $wordId);
    }

    public function unfavorite(string $word): void
    {
        $wordData = $this->findWordData($word);
        $userData = auth()->user();

        $favoriteData = $this->findDataByUserAndWord($userData->getKey(), $wordData->getKey());
        throw_if(
            is_null($favoriteData),
            new BadRequestException()
        );

        $favoriteData->delete();
    }

    public function getAll(int $userId): array
    {
        $queryResponse = $this->favoriteRepository->getAll($userId);

        $results = $queryResponse->items();
        $favorites = collect($results)->map(fn($result) => [
            'word'  => $result->word->word,
            'added' => $result->created_at->toDateTimeString(),
        ])->toArray();
        return MountDataResponse::mountData($favorites, $queryResponse);
    }
}
