<?php

namespace App\Http\Repositories;

use App\Models\Word;
use Illuminate\Support\Facades\Cache;

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
        return Cache::remember('word_' . $word, now()->addMonth(), function () use ($word) {
            return $this->model->query()->where('word', $word)->first();
        });
    }

}
