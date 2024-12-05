<?php

namespace App\Http\Controllers\User;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class GetUserProfileController extends Controller
{
    public function __construct(private readonly UserService $service) {}

    public function __invoke(): JsonResponse
    {
        try {
            $response = $this->service->getUser(auth()->id());
            return response()->json($response, Response::HTTP_OK);
        } catch (Exception $error) {
            Log::error('GET_USER_PROFILE_ERROR', [
                'message' => $error->getMessage(),
                'file' => $error->getFile(),
                'line' => $error->getLine(),
                'trace' => $error->getTrace()
            ]);
            return response()->json(['error' => 'Internal error, please try again later'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
