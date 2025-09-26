<?php

namespace App\Repository\Interfaces;

use Illuminate\Support\Collection;

interface SkinSettingsInterface
{
    public function getActive(): Collection;
}
