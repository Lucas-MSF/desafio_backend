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

    public function getAll(?string $searchFilter): Collection
    {
        $query = $this->model->query()
            ->when(
                $searchFilter,
                fn($query) => $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($searchFilter) . '%'])
            );

        return $query->get();
    }
}
