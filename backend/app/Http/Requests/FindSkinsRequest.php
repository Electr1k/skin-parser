<?php

namespace App\Http\Requests;


class FindSkinsRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'query' => ['required', 'string', 'min:1', 'max:255'],
        ];
    }
}
