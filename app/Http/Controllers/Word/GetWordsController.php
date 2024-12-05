<?php

namespace App\Http\Controllers\Word;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Services\WordsService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Word\GetWordsRequest;
use Symfony\Component\HttpFoundation\Response;

class GetWordsController extends Controller
{
    public function __construct(private readonly WordsService $wordsService) {}

    /**
     * Get Words
     *
     * Endpoint para listar as palavras disponiveis.
     * @group Words
     * @response 500 {"message": "Internal error, please try again later"}
     * @responseFile 200 storage/responseApi/Word/GetWords.json
     */
    public function __invoke(GetWordsRequest $request): JsonResponse
    {
        try {
            $response = $this->wordsService->getAll($request->validated());
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $error) {
            Log::error('GET_WORDS_ERROR', [
                'message' => $error->getMessage(),
                'file' => $error->getFile(),
                'line' => $error->getLine(),
                'trace' => $error->getTrace()
            ]);
            return response()->json(['error' => 'Internal error, please try again later'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
