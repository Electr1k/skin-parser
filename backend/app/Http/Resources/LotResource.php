<?php

namespace App\Http\Resources;

use App\Models\Lot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Lot
 * @property array<int, array{slot: int, sticker_id: int, wear: float|null, name: string, icon: string, price: float}> $stickers
 * @property array<int, array{slot: int, sticker_id: int, wear: float|null, name: string, icon: string, price: float, pattern: integer}> $keychains
 * @property string $icon
 * @property float $stickers_price
 * @property float $keychains_price
 * @property string $ru_name
 * @property Carbon|null $founded_at
 * @property bool $is_rare_float
 */
class LotResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'icon' => $this->icon,
            'name' => $this->ru_name,
            'float' => $this->float,
            'price' => $this->price,
            'page' => $this->page,
            'found_at' => $this->founded_at,
            'stickers' => $this->stickers ? StickerOnSkinResource::collection($this->stickers) : [],
            'keychains' => $this->stickers ? KeychainOnSkinResource::collection($this->keychains) : [],
            'stickers_price' => round($this->stickers_price, 2),
            'keychains_price' => round($this->keychains_price, 2),
            'is_rare_float' => $this->is_rare_float,
            'inspect_link' => $this->inspect_link,
            'steam_link' => "https://steamcommunity.com/market/listings/730/$this->skin_id#buylisting|$this->m|730|2|$this->a",
        ];
    }
}
