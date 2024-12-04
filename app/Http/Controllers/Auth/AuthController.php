<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Services\AuthService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

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
            Log::error('SIGNIN_ERROR', [
                'message' => $error->getMessage(),
                'file' => $error->getFile(),
                'line' => $error->getLine(),
                'trace' => $error->getTrace()
            ]);
            return response()->json(['error' => 'Internal error, please try again later'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
