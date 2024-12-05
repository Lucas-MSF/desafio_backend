<?php

namespace App\Http\Repositories;

use App\Models\History;
use Illuminate\Pagination\LengthAwarePaginator;

class HistoryRepository
{
    public function __construct(private readonly History $model) {}

    public function create(array $data): History
    {
        return $this->model->create($data);
    }

    public function getAll(int $userId): LengthAwarePaginator
    {
        return $this->model->query()
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }
}
