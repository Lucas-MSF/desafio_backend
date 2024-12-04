<?php

namespace App\Http\Controllers\User;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Services\FavoriteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class FavoriteController extends Controller
{
    public function __construct(private readonly FavoriteService $service)
    {
    }

    public function favorite(string $word): HttpResponse|JsonResponse
    {
        try {
            $this->service->favorite($word);
            return response()->noContent();
        } catch (BadRequestException) {
            return response()->json(['error' => 'word already favorited'], Response::HTTP_BAD_REQUEST);
        } catch (Exception $error) {
            Log::error('FAVORITE_ERROR', [
                'message' => $error->getMessage(),
                'file' => $error->getFile(),
                'line' => $error->getLine(),
                'trace' => $error->getTrace()
            ]);
            return response()->json(['error' => 'Internal error, please try again later'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function unfavorite(string $word)
    {
        try {
            $this->service->unfavorite($word);
            return response()->noContent();
        } catch (BadRequestException) {
            return response()->json(['error' => 'word already unfavorited'], Response::HTTP_BAD_REQUEST);
        } catch (Exception $error) {
            Log::error('FAVORITE_ERROR', [
                'message' => $error->getMessage(),
                'file' => $error->getFile(),
                'line' => $error->getLine(),
                'trace' => $error->getTrace()
            ]);
            return response()->json(['error' => 'Internal error, please try again later'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
