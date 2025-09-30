<?php

namespace App\Http\Requests;

use App\Enums\Extremum;
use Illuminate\Validation\Rule;

class SkinSettingsStoreRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'market_hash_name' => ['required', 'bail', 'string', 'min:10', 'max:255'],
            'market_name' => ['required', 'bail', 'string', 'min:10', 'max:255'],
            'icon' => ['nullable', 'bail', 'string', 'min:10', 'max:255'],
            'extremum' => ['required', 'bail', 'string', Rule::enum(Extremum::class)],
            'float_limit' => ['required', 'bail', 'numeric', 'min:0', 'max:1'],
            'max_price' => ['required', 'bail', 'numeric', 'min:0', 'max:100000'],
            'is_active' => ['bail', 'boolean'],
        ];
    }
}
