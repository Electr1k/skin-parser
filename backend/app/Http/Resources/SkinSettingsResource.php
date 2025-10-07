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
            'id' => $this->id,
            'market_hash_name' => $this->market_hash_name,
            'market_name' => $this->market_name,
            'icon' => $this->icon,
            'extremum' => $this->extremum->value,
            'float_limit' => $this->float_limit,
            'max_price' => $this->max_price,
            'is_active' => $this->is_active,
            'price' => 0.01
        ];
    }
}
