<?php

namespace App\Observers;

use App\Models\Word;
use Illuminate\Support\Facades\Cache;

class WordsObserver
{
    public function creating(Word $word): void
    {
        Cache::tags(['endpoint_api_entries_en', 'endpoint_api_entries_en_' . $word->word])->flush();
    }
}
