<?php

namespace App\Http\Requests;

use App\Enums\Extremum;
use Illuminate\Validation\Rule;

class SkinSettingsUpdateRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'market_hash_name' => ['bail', 'string', 'min:10', 'max:255'],
            'market_name' => ['bail', 'string', 'min:10', 'max:255'],
            'icon' => ['nullable', 'bail', 'string', 'min:10', 'max:255'],
            'extremum' => ['bail', 'string', Rule::enum(Extremum::class)],
            'float_limit' => ['bail', 'numeric', 'min:0', 'max:1'],
            'max_price' => ['bail', 'numeric', 'min:0', 'max:100000'],
            'is_active' => ['bail', 'boolean'],
        ];
    }
}
