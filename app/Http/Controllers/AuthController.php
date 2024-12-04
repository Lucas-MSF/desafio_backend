<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthRequest;
use App\Http\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $service) {}

    public function __invoke(AuthRequest $request): JsonResponse
    {
        try {
            $response = $this->service->login($request->validated());

            return response()->json($response, Response::HTTP_OK);
        } catch (BadRequestException) {
            return response()->json(['error' => 'User or password not send'], Response::HTTP_BAD_REQUEST);
        } catch (UnauthorizedException) {
            return response()->json(['error' => 'User and/or password invalid'], Response::HTTP_UNAUTHORIZED);
        } catch (Exception $error) {
            Log::error('LOGIN_ERROR', [
                'message' => $error->getMessage(),
                'file' => $error->getFile(),
                'line' => $error->getLine(),
                'trace' => $error->getTrace()
            ]);
            return response()->json(['error' => 'Internal error, please try again later'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
