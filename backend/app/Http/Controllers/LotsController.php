<?php

namespace App\Http\Controllers;

use App\Http\Requests\LotsIndexRequest;
use App\Http\Resources\LotResource;
use App\Repository\SkinSettings\SkinSettingsRepository;
use App\UseCases\FetchLotsPaginated\DataInput as PaginatedDataInput;
use App\UseCases\FetchLotsPaginated\Handler as PaginatedHandler;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LotsController extends Controller
{
    public function __construct(protected readonly SkinSettingsRepository $skinSettingsRepository){}


    public function index(PaginatedHandler $handler, LotsIndexRequest $request): AnonymousResourceCollection
    {
        $collection = $handler->handle(PaginatedDataInput::from($request->validated()));
        return LotResource::collection($collection);
    }

}
