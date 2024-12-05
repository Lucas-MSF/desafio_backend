<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'name' => [
                'description' => 'Nome do Usuario.',
                'example'     => 'Joao'
            ],
            'email' => [
                'description' => 'E-mail para login.',
                'example'     => 'joao@email.com'
            ],
            'password' => [
                'description' => 'Senha para login.',
                'example'     => '********'
            ]
        ];
    }
}
