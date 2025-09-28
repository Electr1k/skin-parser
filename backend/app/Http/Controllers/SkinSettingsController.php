<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkinSettingsIndexRequest;
use App\Http\Requests\SkinSettingsListRequest;
use App\Http\Resources\SkinSettingsResource;
use App\Repository\SkinSettings\SkinSettingsRepository;
use App\UseCases\FetchSkinSettingsPaginated\DataInput as PaginatedDataInput;
use App\UseCases\FetchSkinSettingsPaginated\Handler as PaginatedHandler;
use App\UseCases\FetchSkinSettings\DataInput as ListDataInput;
use App\UseCases\FetchSkinSettings\Handler as ListHandler;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SkinSettingsController extends Controller
{
    public function __construct(protected readonly SkinSettingsRepository $skinSettingsRepository){}


    public function index(PaginatedHandler $handler, SkinSettingsIndexRequest $request): AnonymousResourceCollection
    {
        $collection = $handler->handle(PaginatedDataInput::from($request->validated()));
        return SkinSettingsResource::collection($collection);
    }

    public function list(ListHandler $handler, SkinSettingsListRequest $request): AnonymousResourceCollection
    {
        $collection = $handler->handle(ListDataInput::from($request->validated()));
        return SkinSettingsResource::collection($collection);
    }
}
