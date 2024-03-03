<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegionResource;
use App\Http\Resources\TownshipResource;
use App\Services\DeliveryService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    use ApiResponse;

    private DeliveryService $deliveryService;

    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    public function getRegions()
    {
        $regions = $this->deliveryService->getRegions();
        return $this->success("Get regions successful", RegionResource::collection($regions));
    }

    public function getTownships($id)
    {
        $townships = $this->deliveryService->getTownships($id);
        return $this->success("Get townships successful", TownshipResource::collection($townships));
    }
}
