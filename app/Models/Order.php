<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'number', 'status', 'payment_status', 'payment_method',
        'subtotal', 'tax', 'shipping', 'discount', 'total', 'coupon_code',
        'shipping_address', 'billing_address', 'notes', 'paid_at', 'shipped_at', 'delivered_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2', 'tax' => 'decimal:2', 'shipping' => 'decimal:2',
        'discount' => 'decimal:2', 'total' => 'decimal:2',
        'shipping_address' => 'array', 'billing_address' => 'array',
        'paid_at' => 'datetime', 'shipped_at' => 'datetime', 'delivered_at' => 'datetime',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(OrderItem::class); }
    public function payment() { return $this->hasOne(Payment::class); }
}
