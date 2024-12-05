<?php

namespace App\Http\Repositories;

use App\Models\Favorite;
use Illuminate\Pagination\LengthAwarePaginator;

class FavoriteRepository
{
    public function __construct(private readonly Favorite $model) {}

    public function create(array $data): Favorite
    {
        return $this->model->create($data);
    }

    public function findByUserIdAndWordId(int $userId, int $wordId): ?Favorite
    {
        return $this->model->where('user_id', $userId)->where('word_id', $wordId)->first();
    }

    public function getAll(int $userId): LengthAwarePaginator
    {
        return $this->model->query()
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }
}
