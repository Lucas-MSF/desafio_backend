<?php

namespace App\Http\Repositories;

use App\Models\Word;

class WordRepository
{
    public function __construct(private readonly Word $model)
    {
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
