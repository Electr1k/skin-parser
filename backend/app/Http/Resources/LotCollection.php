<?php

namespace App\Http\Resources;

use App\Pagination\LotPagination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @mixin LotPagination */
class LotCollection extends ResourceCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource);
        self::withoutWrapping();
    }

    public function toArray(Request $request): array
    {
        return [
            'data' => LotResource::collection($this->collection),
            'meta' => $this->meta()
        ];
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json($this->toArray($request));
    }
}
