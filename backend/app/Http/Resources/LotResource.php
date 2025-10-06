<?php

namespace App\Http\Resources;

use App\Models\Lot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Lot
 * @property array<int, array{slot: int, stickerId: int, name: string, icon: string, price: float}> $stickers
 * @property string $icon
 * @property float $stickers_price
 * @property string $market_name
 * @property Carbon|null $founded_at
 * @property bool $is_rare_float
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
            'page' => $this->page,
            'found_at' => $this->founded_at,
            'stickers' => StickerOnSkinResource::collection($this->stickers),
            'stickers_price' => $this->stickers_price,
            'is_rare_float' => $this->is_rare_float,
            'inspect_link' => $this->inspect_link,
            'steam_link' => "https://steamcommunity.com/market/listings/730/$this->skin_id#buylisting|$this->m|730|2|$this->a",
        ];
    }
}
