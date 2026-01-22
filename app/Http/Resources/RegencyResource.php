<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegencyResource extends JsonResource
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
            'province_code' => $this->province_code,
            'name' => $this->name,
            'ibukota' => $this->ibukota,
            'type' => $this->type,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'elevation' => $this->elevation,
            'timezone' => $this->timezone,
            'area' => $this->area,
            'population' => $this->population,
            'boundaries' => $this->boundaries,
            'status' => $this->status,
            'province' => new ProvinceResource($this->whenLoaded('province')),
            'districts_count' => $this->whenCounted('districts'),
            'districts' => DistrictResource::collection($this->whenLoaded('districts')),
            'islands_count' => $this->whenCounted('islands'),
            'islands' => IslandResource::collection($this->whenLoaded('islands')),
        ];
    }
}
