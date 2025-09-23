<?php

namespace App\Enums\Traits;

trait EnumValues
{
    /**
     * @return array<string|int>
     */
    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }
}
