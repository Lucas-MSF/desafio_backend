<?php

namespace App\Http\Repositories;

use App\Models\Word;
use Illuminate\Pagination\LengthAwarePaginator;

class WordRepository
{
    public function __construct(private readonly Word $model) {}

    public function getAll(?string $searchFilter, int $limit): LengthAwarePaginator
    {
        $query = $this->model->query()
            ->when(
                $searchFilter,
                fn($query) => $query->whereRaw('LOWER(word) LIKE ?', ['%' . strtolower($searchFilter) . '%'])
            )->orderBy('word', 'asc');

        return $query->paginate($limit);
    }

    public function create(array $data): Word
    {
        return $this->model->create($data);
    }

    public function findByWord(string $word): ?Word
    {
        return $this->model->query()->where('word', $word)->first();
    }
}
