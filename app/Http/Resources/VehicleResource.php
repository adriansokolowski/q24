<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'model' => $this->model,
            'manufacturer' => $this->manufacturer,
            'costInCredits' => $this->cost_in_credits,
            'length' => $this->length,
            'maxAtmospheringSpeed' => $this->max_atmosphering_speed,
            'crew' => $this->crew,
            'passengers' => $this->passengers,
            'cargoCapacity' => $this->cargo_capacity,
            'consumables' => $this->consumables,
            'vehicleClass' => $this->vehicle_class,
            'created' => $this->created,
            'edited' => $this->edited
        ];
    }
}
