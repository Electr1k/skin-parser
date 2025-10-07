<?php

namespace App\Http\Resources;

use App\Models\SkinSettings;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin SkinSettings
 */
class SkinSettingsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'ru_name' => $this->skin->ru_name,
            'max_price' => $this->max_price,
            'price' => $this->price->price,
            'is_active' => $this->is_active,
            'float_limit' => $this->float_limit,
            'extremum' => $this->extremum?->value,
            'min_stickers_price' => $this->min_stickers_price,
            'min_keychains_price' => $this->min_keychains_price,
            'icon' => $this->skin->icon,
        ];
    }
}
