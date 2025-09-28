<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkinSettingsListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'query' => ['nullable', 'string', 'min:1', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
