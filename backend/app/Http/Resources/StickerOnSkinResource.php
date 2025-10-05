<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin array{slot: int, stickerId: int, name: string, icon: string, price: float}
 */
class StickerOnSkinResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'slot' => $this['slot'],
            'sticker_id' => $this['stickerId'],
            'name' => $this['name'],
            'icon' => $this['icon'],
            'price' => $this['price'],
        ];
    }
}
