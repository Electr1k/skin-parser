<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin JsonResource
 * @property string $icon_url
 * @property int $listing_count
 * @property string $market_hash_name
 * @property string $market_name
 * @property string $market_type
 * @property float $min_price
 * @property int $search_score
 */
class SkinResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'icon_url' => $this->icon_url,
            'listing_count' => $this->listing_count,
            'market_hash_name' => $this->market_hash_name,
            'market_name' => $this->market_name,
            'market_type' => $this->market_type,
            'min_price' => $this->min_price,
            'search_score' => $this->search_score,
        ];
    }
}
