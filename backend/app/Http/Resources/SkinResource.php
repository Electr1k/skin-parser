<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin JsonResource
 * @property string $icon
 * @property string $name
 * @property float $price
 */
class SkinResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'icon' => $this->icon,
            'name' => $this->name,
            'price' => round($this->price, 2),
        ];
    }
}
