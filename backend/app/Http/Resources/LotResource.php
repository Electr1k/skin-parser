<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin JsonResource
 * @property string $icon
 * @property string $market_name
 * @property float $float
 * @property float $price
 * @property Carbon|null $founded_at
 * @property bool $is_rare
 */
class LotResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'icon' => $this->icon,
            'market_name' => $this->market_name,
            'float' => $this->float,
            'price' => $this->price,
            'found_at' => $this->founded_at,
            'stickers' => [],
            'is_rare' => $this->is_rare
        ];
    }
}
