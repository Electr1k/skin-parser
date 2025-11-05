<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin array{slot: int, sticker_id: int, name: string, icon: string, price: float, wear: string|null}
 */
class StickerOnSkinResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'slot' => $this['slot'],
            'sticker_id' => $this['sticker_id'],
            'wear' => round($this['wear'] ?? 0., 2),
            'name' => $this['name'],
            'icon' => $this['icon'],
            'price' => round($this['price'], 2),
            'link' => 'https://steamcommunity.com/market/listings/730/'.rawurlencode($this['name']),
        ];
    }
}
