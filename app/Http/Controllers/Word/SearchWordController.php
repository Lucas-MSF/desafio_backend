<?php

namespace App\Http\Controllers\Word;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Services\SearchWordService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class SearchWordController extends Controller
{
    public function __construct(private readonly SearchWordService $service) {}

    /**
     * Search Word
     *
     * Endpoint para buscar os dados de uma palavra.
     * @group Words
     * @response 500 {"message": "Internal error, please try again later"}
     * @responseFile 200 storage/responseApi/Word/SearchWord.json
     */
    public function __invoke(string $word): JsonResponse
    {
        try {
            $response = $this->service->search($word);
            return response()->json($response, Response::HTTP_OK);
        } catch (BadRequestException) {
            return response()->json(['error' => 'word not found!'], Response::HTTP_BAD_REQUEST);
        } catch (Exception $error) {
            Log::error('SEARCH_WORD_ERROR', [
                'message' => $error->getMessage(),
                'file' => $error->getFile(),
                'line' => $error->getLine(),
                'trace' => $error->getTrace()
            ]);
            return response()->json(['error' => 'Internal error, please try again later'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
