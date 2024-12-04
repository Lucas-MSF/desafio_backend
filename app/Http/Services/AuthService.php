<?php

namespace App\Http\Services;

use Illuminate\Validation\UnauthorizedException;

class AuthService
{
    public function login(array $data): array
    {
        $token = $this->validateLogin($data['email'], $data['password']);
        $user = auth()->user();
        return [
            'id' => $user->getKey(),
            'name' => $user->name,
            'token' => $token
        ];
    }

    private function validateLogin(string $email, string $password): string
    {
        if (! $token = auth()->attempt([
            'email' => $email,
            'password' => $password,
        ])) {
            throw new UnauthorizedException();
        }

        return $token;
    }

    public function logout(): array {}
}
