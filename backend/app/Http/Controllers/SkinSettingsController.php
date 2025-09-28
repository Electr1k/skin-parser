<?php

namespace App\Http\Controllers;

use App\Http\Requests\FindSkinsRequest;
use App\Http\Requests\SkinSettingsIndexRequest;
use App\Http\Requests\SkinSettingsListRequest;
use App\Http\Resources\SkinSettingsResource;
use App\Http\Resources\SkinResource;
use App\Repository\SkinSettings\SkinSettingsRepository;
use App\UseCases\FetchSkinSettingsPaginated\DataInput as PaginatedDataInput;
use App\UseCases\FetchSkinSettingsPaginated\Handler as PaginatedHandler;
use App\UseCases\FindSkins\DataInput as FindSkinsDataInput;
use App\UseCases\FindSkins\Handler as FindSkinsHandler;
use App\UseCases\FetchSkinSettings\DataInput as ListDataInput;
use App\UseCases\FetchSkinSettings\Handler as ListHandler;
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
}
