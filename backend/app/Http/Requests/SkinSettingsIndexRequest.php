<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkinSettingsIndexRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'query' => ['nullable', 'string', 'min:1', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
