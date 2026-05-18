<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return ['id' => $this->id, 'number' => $this->number, 'status' => $this->status, 'payment_status' => $this->payment_status, 'total' => $this->total, 'items' => $this->items];
    }
}
