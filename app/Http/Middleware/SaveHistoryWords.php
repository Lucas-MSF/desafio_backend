<?php

namespace App\Http\Middleware;

use App\Http\Repositories\HistoryRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SaveHistoryWords
{
    public function __construct(private readonly HistoryRepository $historyRepository) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->historyRepository->create([
            'word' => $request->route('word'),
            'user_id' => auth()->id(),
        ]);
        return $next($request);
    }
}
