<?php

namespace App\Http\Controllers;

use App\Http\Requests\FindSkinsRequest;
use App\Http\Requests\SkinSettingsIndexRequest;
use App\Http\Requests\SkinSettingsListRequest;
use App\Http\Requests\SkinSettingsStoreRequest;
use App\Http\Requests\SkinSettingsUpdateRequest;
use App\Http\Resources\SkinSettingsResource;
use App\Http\Resources\SkinResource;
use App\Models\SkinSettings;
use App\Repository\SkinSettings\SkinSettingsRepository;
use App\UseCases\FetchSkinsSettingsPaginated\DataInput as PaginatedDataInput;
use App\UseCases\FetchSkinsSettingsPaginated\Handler as PaginatedHandler;
use App\UseCases\FindSkins\DataInput as FindSkinsDataInput;
use App\UseCases\FindSkins\Handler as FindSkinsHandler;
use App\UseCases\FetchSkinsSettings\DataInput as ListDataInput;
use App\UseCases\FetchSkinsSettings\Handler as ListHandler;
use App\UseCases\StoreSkinSettings\DataInput as StoreDataInput;
use App\UseCases\StoreSkinSettings\Handler as StoreHandler;
use App\UseCases\UpdateSkinSettings\DataInput as UpdateDataInput;
use App\UseCases\UpdateSkinSettings\Handler as UpdateHandler;
use Illuminate\Http\JsonResponse;
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

    public function findSkins(FindSkinsHandler $handler, FindSkinsRequest $request): AnonymousResourceCollection|JsonResponse
    {
        try {
            $collection = $handler->handle(FindSkinsDataInput::from($request->validated()));
            return SkinResource::collection($collection);
        }
        catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function store(StoreHandler $handler, SkinSettingsStoreRequest $request): SkinSettingsResource
    {
        $skinSetting = $handler->handle(StoreDataInput::from($request->validated()));

        return new SkinSettingsResource($skinSetting);
    }

    public function update(SkinSettings $skinSettings, UpdateHandler $handler, SkinSettingsUpdateRequest $request): SkinSettingsResource
    {
        $handler->handle(UpdateDataInput::from([...$skinSettings->toArray(), ...$request->validated()]));

        return new SkinSettingsResource($skinSettings->fresh());
    }
}
