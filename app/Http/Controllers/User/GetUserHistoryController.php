<?php

namespace App\Http\Controllers\User;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Services\GetHistoryService;
use Symfony\Component\HttpFoundation\Response;

class GetUserHistoryController extends Controller
{
    public function __construct(private readonly GetHistoryService $service) {}

    /**
     * Get History
     *
     * Endpoint para listar o historico de palavras pesquisadas.
     * @group History
     * @response 500 {"message": "Internal error, please try again later"}
     * @responseFile 200 storage/responseApi/User/GetHistory.json
     */
    public function __invoke(): JsonResponse
    {
        try {
            $response = $this->service->getAll(auth()->id());
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $error) {
            Log::error('GET_USER_HISTORY_ERROR', [
                'message' => $error->getMessage(),
                'file' => $error->getFile(),
                'line' => $error->getLine(),
                'trace' => $error->getTrace()
            ]);
            return response()->json(['error' => 'Internal error, please try again later'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
