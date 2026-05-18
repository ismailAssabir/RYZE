<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $fillable = ['product_id', 'color', 'hex_code'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

