<?php

namespace App\Http\Requests;

use App\Enums\Extremum;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SkinSettingsStoreRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'bail', 'string', 'min:8', 'max:255'],
            'max_price' => ['required', 'bail', 'numeric', 'min:0', 'max:100000'],
            'is_active' => ['bail', 'boolean'],
            'float_limit' => ['nullable', 'bail', 'numeric', 'min:0', 'max:1', 'required_with:extremum'],
            'extremum' => ['nullable', 'bail', 'string', Rule::enum(Extremum::class), 'required_with:float_limit'],
            'min_stickers_price' => ['nullable', 'bail', 'numeric', 'min:0', 'max:1000000'],
            'min_keychains_price' => ['nullable', 'bail', 'numeric', 'min:0', 'max:1000000'],
        ];
    }

    /**
     * @throws ValidationException
     */
    public function passedValidation(): void
    {
        if (empty($this->get('float_limit'))
            && empty($this->get('min_stickers_price'))
            && empty($this->get('min_keychains_price'))
        ){
            $fields = ['float_limit', 'min_stickers_price', 'min_keychains_price'];
            $message = 'At least one field from: ' . implode(', ', $fields) . ', must not be empty';

            $messages = [];
            foreach ($fields as $field) {
                $messages[$field] = [$message];
            }

            throw ValidationException::withMessages($messages);
        }
    }
}
