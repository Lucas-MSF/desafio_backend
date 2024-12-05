<?php

namespace App\Http\Requests\Word;

use Illuminate\Foundation\Http\FormRequest;

class GetWordsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => ['filled', 'string'],
            'limit' => ['filled', 'integer']
        ];
    }

    public function queryParameters(): array
    {
        return [
            'search' => [
                'description' => 'Palavra q deseja buscar.',
                'example'     => 'Fire'
            ],
            'limit' => [
                'description' => 'Define o limite de palavras que vai ser retornado de volta.',
                'example'     => 5
            ]
        ];
    }
}
