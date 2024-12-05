<?php

namespace App\Http\Repositories;

use App\Models\History;
use Illuminate\Database\Eloquent\Collection;

class HistoryRepository
{
    public function __construct(private readonly History $model) {}

    public function create(array $data): History
    {
        return $this->model->create($data);
    }

    public function getAll(int $userId): Collection
    {
        return $this->model->query()->where('user_id', $userId)->get();
    }
}
