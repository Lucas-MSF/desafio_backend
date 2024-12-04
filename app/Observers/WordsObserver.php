<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class WordsObserver
{
    /**
     * Handle the Word "created" event.
     */
    public function created(): void
    {
        Cache::tags(['/api/entries/en'])->flush();
    }
}
