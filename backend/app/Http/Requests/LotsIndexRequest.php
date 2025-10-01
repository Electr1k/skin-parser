<?php

namespace App\Http\Requests;

use App\Enums\LotsSortable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LotsIndexRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'is_rare' => ['bail', 'boolean'],
            'sort_by' => ['string', Rule::enum(LotsSortable::class)],
            'skin_id' => ['string', 'exists:skin_settings,id'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
