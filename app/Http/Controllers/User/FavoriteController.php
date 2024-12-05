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
    public function __construct(private readonly FavoriteService $service) {}

    /**
     * Favorite word
     *
     * Endpoint para favoritar uma palavra.
     * @group Favorite
     * @response 204
     * @response 400 {"message": "word already favorite"}
     * @response 500 {"message": "Internal error, please try again later"}
     */
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

    /**
     * Unfavorite word
     *
     * Endpoint para desfavoritar uma palavra.
     * @group Favorite
     * @response 204
     * @response 400 {"message": "word already unfavorited"}
     * @response 500 {"message": "Internal error, please try again later"}
     */
    public function unfavorite(string $word): HttpResponse|JsonResponse
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

    /**
     * Get all favorites words
     *
     * Endpoint para listar as palavras favoritadas.
     * @group Favorite
     * @response 500 {"message": "Internal error, please try again later"}
     * @responseFile 200 storage/responseApi/User/GetAllFavorites.json
     */
    public function getFavorites(): JsonResponse
    {
        try {
            $response = $this->service->getAll(auth()->id());
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $error) {
            Log::error('GET_USER_FAVORITES_ERROR', [
                'message' => $error->getMessage(),
                'file' => $error->getFile(),
                'line' => $error->getLine(),
                'trace' => $error->getTrace()
            ]);
            return response()->json(['error' => 'Internal error, please try again later'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
