<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommodityPriceResource;
use App\Services\CommodityPriceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CommodityPriceController extends Controller
{
    public function __construct(private readonly CommodityPriceService $commodityPriceService) {}

    public function index(): AnonymousResourceCollection
    {
        return CommodityPriceResource::collection(
            $this->commodityPriceService->listActive(),
        );
    }

    public function show(string $slug): CommodityPriceResource|JsonResponse
    {
        $commodity = $this->commodityPriceService->findBySlug($slug);

        if (! $commodity) {
            return response()->json([
                'message' => 'Komoditas tidak ditemukan.',
            ], 404);
        }

        return new CommodityPriceResource($commodity);
    }
}
