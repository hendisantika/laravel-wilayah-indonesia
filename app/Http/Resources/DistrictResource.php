<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistrictResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'regency_code' => $this->regency_code,
            'name' => $this->name,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'area' => $this->area,
            'population' => $this->population,
            'regency' => new RegencyResource($this->whenLoaded('regency')),
            'villages_count' => $this->whenCounted('villages'),
            'villages' => VillageResource::collection($this->whenLoaded('villages')),
        ];
    }
}
