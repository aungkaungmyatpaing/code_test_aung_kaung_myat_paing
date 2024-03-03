<?php

namespace App\Services;

use App\Models\Region;
use Illuminate\Database\Eloquent\Collection;

class DeliveryService
{
    public function getRegions(): Collection
    {
        $regions = Region::all();
        return $regions;
    }

    public function getTownships($regionId): Collection
    {
        $region = Region::findOrFail($regionId);
        return $region->townships;
    }
}
