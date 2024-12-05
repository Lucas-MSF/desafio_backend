<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class FavoriteObserver
{
    public function created(): void
    {
        Cache::forget('request_user_'.auth()->id() .'_api_user_me_favorite');

    }

    public function deleted(): void
    {
        Cache::forget('request_user_'.auth()->id() .'_api_user_me_favorite');
    }
}
