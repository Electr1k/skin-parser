<?php

namespace App\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;

class LotPagination extends LengthAwarePaginator
{
    protected int $rareCount;

    public function __construct($items, $total, $perPage, $currentPage = null, array $options = [], int $rareCount = 0)
    {
        parent::__construct($items, $total, $perPage, $currentPage, $options);
        $this->rareCount = $rareCount;
    }

    public function rareCount(): int
    {
        return $this->rareCount;
    }

    public function meta(): array
    {
        return [
            'total' => $this->total(),
            'count' => $this->count(),
            'per_page' => $this->perPage(),
            'current_page' => $this->currentPage(),
            'total_pages' => $this->lastPage(),
            'rare_count' => $this->rareCount(),
        ];
    }
}
