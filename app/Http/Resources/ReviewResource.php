<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request): array
    {
        return ['id' => $this->id, 'rating' => $this->rating, 'title' => $this->title, 'comment' => $this->comment, 'user' => $this->user?->name, 'created_at' => $this->created_at?->toDateString()];
    }
}
