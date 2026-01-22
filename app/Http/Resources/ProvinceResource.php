<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProvinceResource extends JsonResource
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
            'name' => $this->name,
            'ibukota' => $this->ibukota,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'elevation' => $this->elevation,
            'timezone' => $this->timezone,
            'area' => $this->area,
            'population' => $this->population,
            'boundaries' => $this->boundaries,
            'status' => $this->status,
            'regencies_count' => $this->whenCounted('regencies'),
            'regencies' => RegencyResource::collection($this->whenLoaded('regencies')),
        ];
    }
}
