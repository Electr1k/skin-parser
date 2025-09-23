<?php

namespace App\Enums;

use App\Enums\Traits\EnumValues;

enum Extremum: string
{
    use EnumValues;

    case MIN = 'MIN';

    case MAX = 'MAX';
}
