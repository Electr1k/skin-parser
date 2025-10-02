<?php

namespace App\Enums;

use App\Enums\Traits\EnumValues;

enum LotsSortable: string
{
    use EnumValues;

    case DATE = 'date';
    case FLOAT = 'float';
    case PRICE = 'price';
}
