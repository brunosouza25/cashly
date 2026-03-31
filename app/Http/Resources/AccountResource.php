<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,

            'balance' => (float) $this->resource->balance,
            'currency' => $this->resource->currency,

            'status' => [
                'value' => $this->resource->status->value,
                'label' => $this->resource->status->label(),
            ],

            'type' => new AccountTypeResource($this->whenLoaded('accountType')),

            'created_at' => $this->resource->created_at?->toIso8601String(),
            'updated_at' => $this->resource->updated_at?->toIso8601String(),
        ];
    }
}
