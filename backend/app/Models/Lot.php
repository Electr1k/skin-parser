<?php

namespace App\Models;

use App\Builders\Lot\LotBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Лот скина в стиме
 * @property integer $a - PK
 * @property integer $d
 * @property integer $m
 * @property string $skin_id - Идентификатор скина из настроек
 * @property float|null $price - Цена
 * @property float|null $float - Float
 * @property array|null $stickers - Стикеры
 * @property array|null $keychains - Стикеры
 * @property integer $page - Номер страницы, на которой находился лот
 * @property string|null $custom_name - Наймтег
 * @property string $price_dirty - Цена до нормализации
 * @property string $inspect_link - Ссылка на осмотр
 *
 * @property SkinSettings $skinSettings
 * @property Collection<LotHistory> $lotHistory
 * @method static LotBuilder query()
 *
 * @property Collection<Sticker> $stickerModels
 * @property float $stickersPrice
 */
class Lot extends Model
{
    use HasCustomBuilder;

    protected $primaryKey = 'a';
    public $incrementing = false;
    protected $guarded = [];

    protected $casts = [
        'stickers' => 'array',
        'keychains' => 'array',
        'price' => 'float'
    ];


    public function skinSettings(): BelongsTo
    {
        return $this->belongsTo(SkinSettings::class, 'skin_id', 'name');
    }

    public function history(): HasMany
    {
        return $this->hasMany(LotHistory::class, 'lot_id', 'a');
    }

    // TODO: рефакторинг
    /** @return Collection<Sticker> */
    public function stickerModels(): Collection
    {
        return Sticker::query()
            ->with('price')
            ->whereIn('stickers.id', array_column($this->stickers ?? [], 'stickerId'))
            ->get();
    }

    public function stickersPrice(): float
    {
        return Sticker::query()
            ->join('prices', 'prices.name', '=', 'stickers.name')
            ->whereIn('stickers.id', array_column($this->stickers ?? [], 'stickerId'))
            ->rawValue('SUM(coalesce(last_24h, last_7d, last_30d, last_90d, last_ever, 0))') ?? 0;
    }

    /** @return Collection<Sticker> */
    public function keychainsModels(): Collection
    {
        return Keychain::query()
            ->with('price')
            ->whereIn('keychains.id', array_column($this->keychains ?? [], 'sticker_id'))
            ->get();
    }

    public function keychainsPrice(): float
    {
        return Keychain::query()
            ->join('prices', 'prices.name', '=', 'keychains.name')
            ->whereIn('keychains.id', array_column($this->keychains ?? [], 'sticker_id'))
            ->rawValue('SUM(coalesce(last_24h, last_7d, last_30d, last_90d, last_ever, 0))') ?? 0;
    }
}
