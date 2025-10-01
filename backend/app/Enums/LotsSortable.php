<?php

namespace App\Enums;

use App\Enums\Traits\EnumValues;

enum LotsSortable: string
{
    use EnumValues;

    case DATE = 'lots.created_at';
    case FLOAT = 'float';
    case PRICE = 'price';
}
