<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin array{slot: int, sticker_id: int, name: string, icon: string, price: float, wear: string|null, pattern: int}
 */
class KeychainOnSkinResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'slot' => $this['slot'],
            'sticker_id' => $this['sticker_id'],
            'wear' => round($this['wear'] ?? 0, 2),
            'name' => $this['name'] ?? null,
            'icon' => $this['icon'] ?? null,
            'price' => round($this['price'] ?? 0., 2),
            'pattern' => $this['pattern'] ?? null,
        ];
    }
}
