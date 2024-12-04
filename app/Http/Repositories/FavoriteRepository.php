<?php

namespace App\Http\Repositories;

use App\Models\Favorite;

class FavoriteRepository
{
    public function __construct(private readonly Favorite $model)
    {
    }

    public function create(array $data): Favorite
    {
        return $this->model->create($data);
    }

    public function findByUserIdAndWordId(int $userId, int $wordId): ?Favorite
    {
        return $this->model->where('user_id', $userId)->where('word_id', $wordId)->first();
    }

}
