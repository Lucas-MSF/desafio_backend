<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class HistoryObserver
{
    /**
     * Handle the History "created" event.
     */
    public function created(): void
    {
        Cache::forget('request_user_'.auth()->id() .'_api_user_me_history');
    }
}
