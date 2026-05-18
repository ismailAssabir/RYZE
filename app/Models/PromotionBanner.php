<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionBanner extends Model
{
    protected $fillable = ['title', 'subtitle', 'image', 'button_label', 'button_url', 'starts_at', 'ends_at', 'is_active'];
    protected $casts = ['starts_at' => 'datetime', 'ends_at' => 'datetime', 'is_active' => 'boolean'];
}
