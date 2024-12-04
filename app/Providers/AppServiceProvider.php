<?php

namespace App\Providers;

use App\Models\Word;
use App\Observers\WordsObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Word::observe(WordsObserver::class);
    }
}
