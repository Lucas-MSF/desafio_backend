<?php

namespace App\Observers;

use App\Models\Word;
use Illuminate\Support\Facades\Cache;

class WordsObserver
{
    public function created(Word $word): void
    {
        Cache::forget('request_user_'.auth()->id() .'_api_entries_en');
        Cache::forget('request_user_'.auth()->id() .'_api_entries_en_' . $word->word);
    }
}
